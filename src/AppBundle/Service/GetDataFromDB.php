<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.5.2017 г.
 * Time: 12:20
 */

namespace AppBundle\Service;


use AppBundle\Entity\Categories;
use Doctrine\ORM\EntityManager;

class GetDataFromDB
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getAllCategories()
    {
        $categories = $this->manager->getRepository(Categories::class)->findBy([],['name' => 'asc']);

        return $categories;
    }
}