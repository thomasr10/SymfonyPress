<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findAll(): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->orderBy('a.id', 'ASC')
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findArticleBySlug($slug): ?Article
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.slug = :slug')
               ->setParameter('slug', $slug)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

       public function findAllByCategory($category): array
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.category = :category')
               ->setParameter('category', $category)
               ->getQuery()
               ->getResult()
           ;
       }

       public function findAllByUser($user): array
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.user = :user')
               ->setParameter('user', $user)
               ->getQuery()
               ->getResult()
           ;
       }
}
