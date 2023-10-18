<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 *
 * @ORM\Table(name="Curso")
 * @ORM\Entity(repositoryClass="App\Repository\CursosRepository")
 */
class Curso
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCurso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcurso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    public function __construct(?string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of idcurso
     */
    public function getIdcurso(): int
    {
        return $this->idcurso;
    }

    /**
     * Set the value of idcurso
     */
    public function setIdcurso(int $idcurso): self
    {
        $this->idcurso = $idcurso;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}
