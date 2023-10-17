<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity(repositoryClass="App\Repository\UsuariosRepository")
 */
class Usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=30, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Foto", type="blob", length=65535, nullable=true)
     */
    private $foto;

    /**
     * @var int
     *
     * @ORM\Column(name="Admin", type="integer", nullable=false)
     */
    private $admin = '0';

    public function __construct(?string $nombre, ?string $password)
    {
        $this->nombre = $nombre;
        $this->password = $password;
    }


    //Probablemente inutil
    public function createUserWithFoto(?string $nombre, ?string $password, ?int $foto)
    {
        $instance = new self($nombre, $password);
        $this->foto = $foto;
        return $instance;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario(): int
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     */
    public function setIdusuario(int $idusuario): void
    {
        $this->idusuario = $idusuario;
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
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of foto
     */
    public function getFoto(): ?string
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto(?string $foto): void
    {
        $this->foto = $foto;
    }

    /**
     * Get the value of admin
     */
    public function getAdmin(): int
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     */
    public function setAdmin(int $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
