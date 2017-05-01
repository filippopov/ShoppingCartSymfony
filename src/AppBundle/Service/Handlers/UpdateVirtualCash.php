<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 1.5.2017 г.
 * Time: 17:34
 */

namespace AppBundle\Service\Handlers;


use AppBundle\Entity\User;
use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class UpdateVirtualCash implements HandlerInterface
{
    /**
     * @var User $user
     */
    private $user;

    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        $virtualCash = $this->user->getVirtualCash();
        $subTotalAll = $event->basket->subTotalAll();
        $virtualCash -= $subTotalAll;
        $this->user->setVirtualCash($virtualCash);

        $eventManager = $event->manager->getManager();
        $eventManager->persist($this->user);
        $eventManager->flush();
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}