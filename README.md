# SymfonyWorld Winter Edition 2021


This project is a demo from the presentation of Hugo Monteiro at SymfonyWorld Winter edition 2021: 

["Decoupling your application using Symfony Messenger and events"](https://live.symfony.com/2021-world-winter/schedule#session-606)


## Setup the application

```
composer install

bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load

// create a customer, car and reservation and cancel it
bin/console app:rentcar:simulation -vvv

// get domain events from the database (from the stored_event table) and push to the transport (outbox) - infinite loop
bin/console app:domain:events:publish -vvv

// consume domain events in another handler using the transport
bin/console messenger:consume async
```

_Note: The transport configured is the doctrine one, so the sqlite database will be used by default._

## Run unit tests

```
bin/phpunit -c phpunit.xml.dist
```

## What should you expect? 

- Domain events in a table "stored_event" after executing the "simulation" command
- Aggregate roots in their tables (e.g. customer, reservation, etc)

## Work in progress

- API with all the handler actions and API tests
- Create more tests to cover all invariants
