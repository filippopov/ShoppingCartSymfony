<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.5.2017 г.
 * Time: 23:02
 */

namespace AppBundle\Service;


use AppBundle\Entity\Product;
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