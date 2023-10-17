<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuariocurso
 *
 * @ORM\Table(name="UsuarioCurso", indexes={@ORM\Index(name="idUsuario", columns={"idUsuario"}), @ORM\Index(name="idCurso", columns={"idCurso"})})
 * @ORM\Entity
 */
class Usuariocurso
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUsuarioCurso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuariocurso;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nota", type="integer", nullable=true)
     */
    private $nota;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;

    /**
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCurso", referencedColumnName="idCurso")
     * })
     */
    private $idcurso;

    

    /**
     * Get the value of idusuariocurso
     */
    public function getIdusuariocurso(): int
    {
        return $this->idusuariocurso;
    }

    /**
     * Set the value of idusuariocurso
     */
    public function setIdusuariocurso(int $idusuariocurso): self
    {
        $this->idusuariocurso = $idusuariocurso;

        return $this;
    }

    /**
     * Get the value of nota
     */
    public function getNota(): ?int
    {
        return $this->nota;
    }

    /**
     * Set the value of nota
     */
    public function setNota(?int $nota): self
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario(): Usuario
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     */
    public function setIdusuario(Usuario $idusuario): void
    {
        $this->idusuario = $idusuario;
    }

    /**
     * Get the value of idcurso
     */
    public function getIdcurso(): Curso
    {
        return $this->idcurso;
    }

    /**
     * Set the value of idcurso
     */
    public function setIdcurso(Curso $idcurso): void
    {
        $this->idcurso = $idcurso;
    }
}
