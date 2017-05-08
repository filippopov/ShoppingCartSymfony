<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Promotions
 *
 * @ORM\Table(name="promotions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionsRepository")
 */
class Promotions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="promotion")
     */
    private $product;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="date_from", type="datetime")
     */
    private $dateFrom;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="date_to", type="datetime")
     */
    private $dateTo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categories", inversedBy="promotion")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="promotion")
     */
    private $user;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="promotion_name", type="string", length=255, unique=true)
     */
    private $promotionName;

    /**
     * @ORM\Column(name="full_promotion", type="smallint", nullable=true)
     */
    private $fullPromotion;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="percentages", type="integer")
     */
    private $percentages;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return Promotions
     */
    public function setProduct($productId)
    {
        $this->product = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Promotions
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Promotions
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Promotions
     */
    public function setCategory($categoryId)
    {
        $this->category = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Promotions
     */
    public function setUserId($userId)
    {
        $this->user = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPromotionName()
    {
        return $this->promotionName;
    }

    /**
     * @param string $promotionName
     */
    public function setPromotionName($promotionName)
    {
        $this->promotionName = $promotionName;
    }

    /**
     * @return int
     */
    public function getFullPromotion()
    {
        return $this->fullPromotion;
    }

    /**
     * @param int $fullPromotion
     */
    public function setFullPromotion($fullPromotion)
    {
        $this->fullPromotion = $fullPromotion;
    }

    /**
     * @return mixed
     */
    public function getPercentages()
    {
        return $this->percentages;
    }

    /**
     * @param mixed $percentages
     */
    public function setPercentages($percentages)
    {
        $this->percentages = $percentages;
    }
}

