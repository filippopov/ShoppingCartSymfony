<?php


namespace AppBundle\Service\Handlers;


use AppBundle\Entity\Product;
use AppBundle\Service\Basket;
use AppBundle\Service\Contracts\HandlerInterface;
use AppBundle\Service\Events\OrderWasCreated;

class UpdateStock implements HandlerInterface
{
    /**
     * @param OrderWasCreated $event
     */
    public function handle($event)
    {
        /**
         * @var Product[] $allProducts
         */
        $allProducts = $event->basket->all();
        $eventManager = $event->manager->getManager();

        foreach($allProducts as $product) {
            // Set up a decrement query for each product based on the quantity
            $stock = $product->getStock();
            $stock -= $product->getQuantity();
            $product->setStock($stock);
            $eventManager->persist($product);
        }

        $eventManager->flush();
    }
}
