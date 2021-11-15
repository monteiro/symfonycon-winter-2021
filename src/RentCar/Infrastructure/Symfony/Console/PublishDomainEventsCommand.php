<?php


namespace App\RentCar\Infrastructure\Symfony\Console;


use App\RentCar\Domain\Common\StoredEventRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class PublishDomainEventsCommand extends Command 
{
    private const DEFAULT_BATCH_SIZE = 10;
    
    protected static $defaultName = 'app:domain:events:publish';
    private StoredEventRepository $storedEventRepository;
    private SerializerInterface $serializer;
    private MessageBusInterface $eventBus;

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
            ->setDescription('publish domain events to the transport')
            ->addArgument('batchSize', InputArgument::OPTIONAL, 'batch size', self::DEFAULT_BATCH_SIZE);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batchSize = $input->getArgument('batchSize');
        
        do {
            $storedEvents = $this->storedEventRepository->nextUnpublishEvents($batchSize);
            foreach ($storedEvents as $storedEvent) {
                $domainEvent = $this->serializer->deserialize($storedEvent->getEventBody(), $storedEvent->getTypeName(), 'json');
                
                $this->eventBus->dispatch($domainEvent);
                $storedEvent->markAsPublished();
                
                $this->storedEventRepository->save($storedEvent);
            }
        } while(true);
    }
}