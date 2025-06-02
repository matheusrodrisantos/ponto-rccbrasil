<?php
namespace App\Event;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EventPublisher
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {}

    /**
     * Publica todos os eventos registrados na entidade
     * @param object $entity
     */
    public function publish(object $entity): void
    {
        if (!method_exists($entity, 'releaseEvents')) {
            return;
        }

        foreach ($entity->releaseEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}