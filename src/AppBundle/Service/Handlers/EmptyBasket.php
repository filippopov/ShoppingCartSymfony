<?php


namespace AppBundle\Service\Handlers;

use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class EmptyBasket implements HandlerInterface
{
    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        $event->basket->clear();
    }
}
