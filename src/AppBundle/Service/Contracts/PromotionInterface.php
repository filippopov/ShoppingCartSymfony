<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.5.2017 г.
 * Time: 9:39
 */

namespace AppBundle\Service\Contracts;


use AppBundle\Entity\Promotions;

interface PromotionInterface
{
    public function add(Promotions $promotion);
    public function remove(Promotions $promotion);
    public function refreshPromotions();
    public function setPromotions();
//    public function promotionByProduct($productId, $percentages);
//    public function promotionForAllProducts();
//    public function promotionByCategory();
//    public function promotionForUsers();
}