<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Menu>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * @return Menu[]
     */
    public function findAllForTwig(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.isVisible = true')
            ->orderBy('m.menuOrder')
            ->getQuery()
            ->getResult();
    }

    // public function getIndexQueryBuilder(string $field): QueryBuilder
    // {
    //     return $this->createQueryBuilder('m')
    //         ->where("m.$field IS NOT NULL OR (m.pageId IS NULL AND m.articleId IS NULL AND m.link IS NULL AND m.categoryId IS NULL)");
    // }
}
