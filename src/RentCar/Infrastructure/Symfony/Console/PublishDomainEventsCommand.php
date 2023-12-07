<?php


namespace App\RentCar\Infrastructure\Symfony\Console;


use App\RentCar\Domain\Common\StoredEventRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:domain:events:publish',
    description: 'publish domain events to the transport',
)]
final class PublishDomainEventsCommand extends Command implements SignalableCommandInterface 
{
    private const DEFAULT_BATCH_SIZE = 10;
    private const WAIT_SECONDS = 2;

    private StoredEventRepository $storedEventRepository;
    private SerializerInterface $serializer;
    private MessageBusInterface $eventBus;
    
    private bool $shouldStop = false;

    public function __construct(
        StoredEventRepository $storedEventRepository,
        SerializerInterface $serializer,
        MessageBusInterface $eventBus
    ) {
        parent::__construct();

        $this->storedEventRepository = $storedEventRepository;
        $this->serializer = $serializer;
        $this->eventBus = $eventBus;
    }

    protected function configure()
    {
        $this
            ->addArgument('batchSize', InputArgument::OPTIONAL, 'batch size', self::DEFAULT_BATCH_SIZE);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $batchSize = $input->getArgument('batchSize');
        
        while (true) {
            if ($this->shouldStop) {
                break;
            }
            
            $storedEvents = $this->storedEventRepository->nextUnpublishEvents($batchSize);
            foreach ($storedEvents as $storedEvent) {
                $domainEvent = $this->serializer->deserialize($storedEvent->getEventBody(), $storedEvent->getTypeName(), 'json');

                $this->eventBus->dispatch($domainEvent);
                $storedEvent->markAsPublished();

                $this->storedEventRepository->save($storedEvent);
            }

            sleep(self::WAIT_SECONDS);
        }
        
        return self::SUCCESS;
    }

    public function getSubscribedSignals(): array
    {
        return [
            SIGINT,
            SIGTERM,
        ];
    }

    public function handleSignal(int $signal, false|int $previousExitCode = 0): int|false
    {
        $this->shouldStop = true;

        return false;
    }
}