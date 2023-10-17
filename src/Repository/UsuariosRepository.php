<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

class UsuariosRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function login($nombre, $password): Usuario
    {

        $query = $this->getEntityManager()->createQuery("SELECT a1 FROM App\Entity\Usuario a1 WHERE BINARY(a1.nombre) = :nombre AND BINARY(a1.password) = :password")->setParameters(new ArrayCollection([new Parameter('nombre', $nombre), new Parameter('password', $password)]));

        return $query->execute()[0];
    }

}