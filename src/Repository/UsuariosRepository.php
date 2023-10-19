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

    public function getCursosUsuarioLevel(int $id)
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
        

        return $query->execute();
    }

    public function getAllUsuariosCursos()
    {
        $query = $this->getEntityManager()->createQuery('SELECT c.nombre AS nombreCurso, GROUP_CONCAT(u.nombre) AS usuarios, GROUP_CONCAT(cu.nota) AS notas FROM App\Entity\Usuariocurso cu JOIN cu.idcurso c JOIN cu.idusuario u GROUP BY c.nombre ORDER BY c.nombre');

        return $query->execute();
    }

    public function doesUserExist(Usuario $user)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a1 FROM App\Entity\Usuario a1 WHERE a1.idusuario = :idusuario")->setParameter('idusuario', $user->getIdusuario());

        return $query->execute();
    }

}