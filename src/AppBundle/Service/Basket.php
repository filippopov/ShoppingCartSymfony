<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use AppBundle\Exceptions\QuantityExceededException;
use AppBundle\Service\Contracts\StorageInterface;
use Doctrine\ORM\EntityManager;


class Basket
{
    protected $storage;
    protected $manager;
    protected $stockCost;
    protected $checkStock;

    public function __construct(StorageInterface $storage, EntityManager $manager, CheckStock $checkStock)
    {
        $this->storage = $storage;
        $this->manager = $manager;
        $this->checkStock = $checkStock;
    }

    /**
    - Conditioning to check whether product exist into storage container and update current quantity
    - Update the storage container with new product and quantity specified
    **/
    public function add(Product $product, $quantity)
    {
        if ($this->has($product)) {
            $quantity = $this->get($product)['quantity'] + $quantity;
        }

        $this->update($product, $quantity);
    }

    /**
    - Conditioning to check whether a product of choice has stock available Else throw exception error
    - Conditioning if quantity of choice if equals 0 remove product from storage container
    - Add new product into storage container and add extra product info inlcluding product id and quantity
    **/
    public function update(Product $product, $quantity)
    {
        if ($product->getStock() < $quantity || $quantity < 0) {
            throw new QuantityExceededException('Quantity Exception');
        }

        if ((int)$quantity === 0) {
            $this->remove($product);
            return;
        }


        $this->storage->set($product->getId(), [
            'product_id' => (int) $product->getId(),
            'quantity' => (int) $quantity
        ]);
    }

    /**
    - Removes a certain product from storage container
    **/
    public function remove(Product $product)
    {
        $this->storage->unsetIndex($product->getId());
    }

    /**
    - Check if certain product exist into Storage container
    **/
    public function has(Product $product)
    {
        return $this->storage->exists($product->getId());
    }

    /**
    - Fetch a certain product into storage container
    **/
    public function get(Product $product)
    {
        return $this->storage->get($product->getId());
    }

    /**
    - Clear the storage container
    **/
    public function clear()
    {
        return $this->storage->clear();
    }

    /**
    - Returns all stored items into the basket by hitting through the product model
    **/
    public function all()
    {
        $ids = [];

        foreach($this->storage->all() as $product) {
            $ids[] = $product['product_id'];
        }

        $products = $this->manager->getRepository(Product::class)->findBy(['id' => $ids]);

        foreach($products as $product) {
            $product->setQuantity($this->storage->get($product->getId())['quantity']);
        }

        return $products;
    }

    /**
    - Count the number of items stored
    **/
    public function itemCount()
    {
        return $this->storage->count();
    }

    /**
    - Conditioning if item still has some stock left else continue looping and add populate grand cost
    - Returning item sub cost
    **/
    public function subTotal()
    {
        $total = 0;

        foreach($this->all() as $item) {
            $this->checkStock->setStock($item->getStock());
            if ($this->checkStock->outOfStock()) {
               continue;
            }

            if ((float) $item->getPromotionPrice()) {
                if ($item->getPromotionPrice() < $item->getPrice()) {
                    $price = $item->getPromotionPrice();
                } else {
                    $price = $item->getPrice();
                }

            } else {
                $price = $item->getPrice();
            }

            $total = $total + ($price * $item->getQuantity());
        }

        $this->stockCost =  (float) $total;

        return (float) $total;
    }

    public function subTotalAll($shippingCost = 5)
    {
        return (float) $this->subTotal() + $shippingCost;
    }

    /**
     - Getter property that returns stock total cost
    **/
    public function getStockCost()
    {
        return $this->stockCost;
    }

    public function refresh()
    {
        foreach($this->all() as $item) {
            $product = $this->manager->getRepository(Product::class)->find($item->getId());
            $this->checkStock->setStock($product->getStock());
            if (! $this->checkStock->hasStock($item->getQuantity())) {
                $this->update($item, $item->getStock());
            } else if ($this->checkStock->hasStock(1) && $item->getQuantity() === 0) {
                $this->update($item, 1);
            }
        }
    }
}
