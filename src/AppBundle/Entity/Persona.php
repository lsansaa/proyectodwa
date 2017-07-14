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
     * @ORM\Column(name="apellido_paterno", type="string", length=255, nullable=true)
     */
    private $apellido_paterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_materno", type="string", length=255, nullable=true)
     */
    private $apellido_materno;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    /**TODO: usar encoder con bcrypt y agregar trigger
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @return string
     */
    public function getApellidoMaterno(): string
    {
        return $this->apellido_materno;
    }

    /**
     * @param string $apellido_materno
     */
    public function setApellidoMaterno(string $apellido_materno)
    {
        $this->apellido_materno = $apellido_materno;
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
    public function getApellidoPaterno(): string
    {
        return $this->apellido_paterno;
    }

    /**
     * @param string $apellido_paterno
     */
    public function setApellidoPaterno(string $apellido_paterno)
    {
        $this->apellido_paterno = $apellido_paterno;
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

