<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.5.2017 г.
 * Time: 9:46
 */

namespace AppBundle\Service;


use AppBundle\Entity\Product;
use AppBundle\Entity\Promotions;
use AppBundle\Service\Contracts\PromotionInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class PromotionsService implements PromotionInterface
{
    private $managerRegistry;
    private $entityManager;

    public function __construct(ManagerRegistry $managerRegistry, EntityManager $entityManager)
    {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $entityManager;
    }

    public function add(Promotions $promotion)
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($promotion);
        $entityManager->flush();
    }

    public function remove(Promotions $promotion)
    {
        $entityManager = $this->managerRegistry->getManager();
        $productId = $promotion->getProductId();
        if ($productId) {
            $this->setProductPromotionPriceToZero($productId);
        }

        $fullPromotion = $promotion->getFullPromotion();

        if ($fullPromotion) {
            $this->setAllProductsPromotionPriceToZero();
        }

        $categoryId = $promotion->getCategoryId();

        if ($categoryId) {
            $this->setAllProductsFromOneCategoryPromotionPriceToZero($categoryId);
        }

        $entityManager->remove($promotion);
        $entityManager->flush();
    }

    public function refreshPromotions()
    {
        /** @var Promotions[] $allPromotions */
        $allPromotions = $this->entityManager->getRepository(Promotions::class)->findAll();
        $dateTimeNow = new \DateTime('now');

        foreach ($allPromotions as $promotion) {
            $promotionEndTime = $promotion->getDateTo();
            $promotionEndTime = new \DateTime($promotionEndTime->format('Y-m-d H:i:s'));

            if ($promotionEndTime < $dateTimeNow) {
                $this->remove($promotion);
            }
        }
    }

    public function setPromotions()
    {
        /** @var Promotions[] $allPromotions */
        $allPromotions = $this->entityManager->getRepository(Promotions::class)->findAll();
        $dateTimeNow = new \DateTime('now');

        foreach ($allPromotions as $promotion) {
            $promotionStartTime = $promotion->getDateFrom();
            $promotionStartTime = new \DateTime($promotionStartTime->format('Y-m-d H:i:s'));
            if ($promotionStartTime <= $dateTimeNow) {

                $productId = $promotion->getProductId();
                $percentages = $promotion->getPercentages();

                if ($productId) {
                    $this->promotionByProduct($productId, $percentages);
                }

                $fullPromotion = $promotion->getFullPromotion();

                if ($fullPromotion) {
                    $this->promotionForAllProducts($percentages);
                }

                $categoryId = $promotion->getCategoryId();

                if ($categoryId) {
                    $this->promotionByCategory($categoryId, $percentages);
                }
            }
        }

    }

    private function promotionByProduct($productId, $percentages)
    {
        $product = $this->entityManager->getRepository(Product::class)->find($productId);
        $productPrice = $product->getPrice();
        $promotionPrice = (float) $productPrice / 100 * $percentages;
        $promotionPrice = $productPrice - $promotionPrice;
        $promotionPrice = number_format((float) $promotionPrice, 2);
        $oldPromotion = $product->getPromotionPrice();

        if ((float) $oldPromotion) {

            if ($promotionPrice < (float) $oldPromotion) {
                $product->setPromotionPrice($promotionPrice);

                $entityManager = $this->managerRegistry->getManager();
                $entityManager->persist($product);
                $entityManager->flush();
            }
        } else {
            $product->setPromotionPrice($promotionPrice);

            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        }
    }

    private function promotionForAllProducts($percentages)
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        foreach ($products as $product) {
            $productId = $product->getId();
            $this->promotionByProduct($productId, $percentages);
        }
    }

    private function promotionByCategory($categoryId, $percentages)
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy(['category' => $categoryId]);

        foreach ($products as $product) {
            $productId = $product->getId();
            $this->promotionByProduct($productId, $percentages);
        }
    }


    private function setProductPromotionPriceToZero($productId)
    {
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if ($product) {
            $product->setPromotionPrice(0.00);
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        }
    }

    private function setAllProductsPromotionPriceToZero()
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        foreach ($products as $product) {
            $productId = $product->getId();

            if ($productId) {
                $this->setProductPromotionPriceToZero($productId);
            }
        }
    }

    private function setAllProductsFromOneCategoryPromotionPriceToZero($categoryId)
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy(['category' => $categoryId]);

        foreach ($products as $product) {
            $productId = $product->getId();

            if ($productId) {
                $this->setProductPromotionPriceToZero($productId);
            }
        }
    }
}