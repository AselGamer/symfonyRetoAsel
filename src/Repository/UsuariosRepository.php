<?php

namespace App\Repository;

use App\Entity\Curso;
use App\Entity\Usuario;
use App\Entity\Usuariocurso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\Expr\Join;

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

    public function getCursosUsuarioLevel(int $id, int $admin)
    {
        $qb = $this->getEntityManager()->getRepository(Curso::class)->createQueryBuilder('C1');


        if($admin == 0)
        {
            $query = $this->getEntityManager()->createQuery('SELECT c.nombre AS nombreCurso , u.nombre, cu.nota, cu.idusuariocurso FROM App\Entity\Usuariocurso cu JOIN cu.idcurso c JOIN cu.idusuario u WHERE u.idusuario = :id')->setParameter('id', $id);
            /*
            $qb
            ->select('c.nombre, cu.nota')
            ->from(Curso::class, 'c')
            ->innerJoin(Usuariocurso::class, 'cu', 'ON', 'cu.idcurso = c.idcurso')
            ->innerJoin(Usuario::class, 'u', 'ON', 'u.idusuario = cu.idusuario')
            ->where('u.idusuario = :id_usuario')
            ->setParameter('id_usuario', $id)
            ->getQuery();
            */
        } else
        {
            $query =
            $qb
            ->select('c')
            ->from('Curso', 'c')
            ->getQuery();
        }
        

        return $query->execute();
    }

}