<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{

		public const PAGINATOR_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


	public function paginatedPosts($offset)
	{
		$query =  $this->createQueryBuilder('p')
            ->setFirstResult(0)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset);

		return new Paginator($query, $fetchJoinCollection = true);
	}

    public function searchByQuery(string $query)
    {
        return $this->createQueryBuilder('p')
                    ->where('p.title LIKE :query')
                    ->where('p.body LIKE :query')
                    ->setParameter('query', '%'. $query. '%')
                    ->orderBy('p.createdAt', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function getPostBody(string $post_id)
    {
        return $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($post_id)
            ->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
