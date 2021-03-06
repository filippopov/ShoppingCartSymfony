<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.5.2017 г.
 * Time: 23:02
 */

namespace AppBundle\Service;


use AppBundle\Entity\Categories;
use AppBundle\Entity\Product;
use AppBundle\Entity\Promotions;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Pagination
{
    private $manager;
    private $limit;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getAllProducts($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Product::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllPromotions($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Promotions::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllProductsEditor($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Product::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.user is null')
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllPromotionsEditor($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Promotions::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.user is null')
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllProductsUser($currentPage = 1, $userId)
    {
        $repository = $this->manager->getRepository(Product::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.user = :userId')
            ->orderBy('p.id', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllPromotionsUser($currentPage = 1, $userId)
    {
        $repository = $this->manager->getRepository(Promotions::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.user = :userId')
            ->orderBy('p.id', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllNotDeletedProducts($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Product::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.deletedAt is null')
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllNotDeletedProductsByCategory($category = 0, $currentPage = 1)
    {
        $repository = $this->manager->getRepository(Product::class);
        // Create our query
        $query = $repository->createQueryBuilder('p')
            ->where('p.deletedAt is null AND p.category = :category')
            ->setParameter(':category', $category)
            ->orderBy('p.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllCategories($currentPage = 1)
    {
        $repository = $this->manager->getRepository(Categories::class);
        // Create our query
        $query = $repository->createQueryBuilder('c')
            ->orderBy('c.id', 'asc')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllUsers($currentPage = 1)
    {
        $repository = $this->manager->getRepository(User::class);

        $query = $repository->createQueryBuilder('u')
            ->orderBy('u.id', 'asc')
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    private function paginate($dql, $page = 1)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($this->getLimit() * ($page - 1)) // Offset
            ->setMaxResults($this->getLimit()); // Limit

        return $paginator;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}