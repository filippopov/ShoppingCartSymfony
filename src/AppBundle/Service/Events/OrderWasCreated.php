<?php

namespace AppBundle\Service\Events;

use AppBundle\Entity\Orders;
use AppBundle\Service\Basket;
use AppBundle\Service\Events\Event;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;



class OrderWasCreated extends Event
{
    /**
     * @var Orders
     */
    public $order;

    /**
     * @var Basket
     */
    public $basket;

    /**
     * @var ManagerRegistry
     */
    public $manager;

    /**
     * @var EntityManager
     */
    public $em;

    public function  __construct(ManagerRegistry $manager, Basket $basket, EntityManager $em)
    {
        $this->manager = $manager;
        $this->basket = $basket;
        $this->em = $em;
    }

    public function setOrder(Orders $order)
    {
        $this->order = $order;
    }
}
