<?php


namespace AppBundle\Service\Handlers;


use AppBundle\Entity\Payments;
use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class RecordPassPayment implements HandlerInterface
{
    protected $transactionId = 'change this value when use app for validate card';

    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        $eventManager = $event->manager->getManager();
        $dateTime = new \DateTime();

        $payments = new Payments();
        $payments->setFailed(false);
        $payments->setOrderId($event->order);
        $payments->setTransactionId($this->transactionId);
        $payments->setCreatedAt($dateTime);
        $payments->setUpdatedAt($dateTime);

        $eventManager->persist($payments);
        $eventManager->flush();
    }
}
