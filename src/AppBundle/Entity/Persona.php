<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 */
class Persona
{
    /**
     * @var string
     *
     * @ORM\Column(name="rut", type="string")
     * @ORM\Id
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_p", type="string", length=255, nullable=true)
     */
    private $apellido_p;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_m", type="string", length=255, nullable=true)
     */
    private $apellido_m;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @return string
     */
    public function getApellidoM(): string
    {
        return $this->apellido_m;
    }

    /**
     * @param string $apellido_m
     */
    public function setApellidoM(string $apellido_m)
    {
        $this->apellido_m = $apellido_m;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get Rut
     *
     * @return string
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * @return string
     */
    public function getApellidoP(): string
    {
        return $this->apellido_p;
    }

    /**
     * @param string $apellido_p
     */
    public function setApellidoP(string $apellido_p)
    {
        $this->apellido_p = $apellido_p;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}

