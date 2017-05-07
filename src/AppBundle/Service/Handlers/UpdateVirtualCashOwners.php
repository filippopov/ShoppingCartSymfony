<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.5.2017 г.
 * Time: 13:47
 */

namespace AppBundle\Service\Handlers;


use AppBundle\Entity\User;
use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class UpdateVirtualCashOwners implements HandlerInterface
{
    private $ownerMoney = [];

    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        if (! empty($this->ownerMoney)) {
            foreach ($this->ownerMoney as $userId => $priceAndQuantity) {
                $price = (float) isset($priceAndQuantity['price']) ? $priceAndQuantity['price'] : 0;
                $quantity = (int) isset($priceAndQuantity['quantity']) ? $priceAndQuantity['quantity'] : 0;

                $virtualCash = $price * $quantity;

                /**
                 * @var User $user
                 */
                $user = $event->em->getRepository(User::class)->find($userId);
                if ($user) {
                    $cash = $user->getVirtualCash();
                    $cash += $virtualCash;
                    $user->setVirtualCash($cash);

                    $eventManager = $event->manager->getManager();
                    $eventManager->persist($user);
                    $eventManager->flush();
                }
            }
        }
    }

    /**
     * @param array $ownerMoney
     */
    public function setOwnerMoney(array $ownerMoney)
    {
        $this->ownerMoney = $ownerMoney;
    }
}