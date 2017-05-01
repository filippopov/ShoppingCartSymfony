<?php


namespace AppBundle\Service\Handlers;


use AppBundle\Entity\Payments;
use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class RecordFailPayment implements HandlerInterface
{
    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        $eventManager = $event->manager->getManager();
        $dateTime = new \DateTime();

        $payments = new Payments();
        $payments->setFailed(true);
        $payments->setOrderId($event->order);
        $payments->setCreatedAt($dateTime);
        $payments->setUpdatedAt($dateTime);

        $eventManager->persist($payments);
        $eventManager->flush();
    }
}
