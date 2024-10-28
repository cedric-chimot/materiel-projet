<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Materiel>
 */
class MaterielRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Materiel::class);
        $this->entityManager = $entityManager;
    }

    /**
    * @param int $id L'id du matériel
    * @return Materiel|null Retourne le matériel correspondant à l'id ou null s'il n'existe pas
    */
    public function findById($id): ?Materiel
    {
        return $this->find($id);
    }

    /**
    * @return Materiel Retourne la iste des matériels avec une quantité > 0
    */
    public function findByQty()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.quantite > 0')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @param Materiel $materiel Décrémente la quantité d'un matériel
    */
    public function decrementQty(Materiel $materiel)
    {
        if ($materiel->getQuantite() > 0) {
            $materiel->setQuantite($materiel->getQuantite() - 1);
            $this->entityManager->flush();
        }
    }

}
