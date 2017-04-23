<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 23.4.2017 г.
 * Time: 16:24
 */

namespace AppBundle\Service;


class CheckStock
{
    private $stock;

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function hasLowStock()
    {
        if ($this->outOfStock()){
            return false;
        }

        return (bool) ($this->stock <= 5);
    }


    public function outOfStock()
    {
        return $this->stock == 0;
    }


    public function inStock()
    {
        return $this->stock > 5;
    }


    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }
}