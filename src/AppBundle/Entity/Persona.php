<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 */
class Persona implements AdvancedUserInterface, \Serializable
{
    /**
     * @var string
     * @ORM\Column(name="rut", type="string", unique=true)
     * @Assert\NotBlank()
     * @ORM\Id
     */
    private $rut;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="apellido_paterno", type="string", length=255)
     */
    private $apellido_paterno;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="apellido_materno", type="string", length=255)
     */
    private $apellido_materno;
    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;
    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="rol", type="string", length=255, nullable=false)
     */
    private $rol;

    /**
     * @var isActive
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @param string $rol
     */
    public function setRol ($rol)
    {
        $this->rol = $rol;
    }

    /**
     * @return string
     */

    public function getApellidoMaterno()
    {
        return $this->apellido_materno;

    }

    /**
     * @param string $apellido_materno
     */
    public function setApellidoMaterno($apellido_materno)
    {
        $this->apellido_materno = $apellido_materno;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    /**
     * @param string $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
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
     * @param string $rut
     */
    public function setRut($rut)
    {
        $this->rut = $rut;
    }



    /**
     * @return string
     */
    public function getApellidoPaterno()
    {
        return $this->apellido_paterno;
    }

    /**
     * @param string $apellido_paterno
     */
    public function setApellidoPaterno($apellido_paterno)
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

    /**
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @return isActive
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string $rut
     */
    public function getId()
    {
        return $this->rut;
    }

    /**
     * @return string $rut
     */
    public function getUsername()
    {
        return $this->rut;
    }


    public function serialize()
    {
        return serialize(array(
            $this->rut,
            $this->password,
            $this->apellido_materno,
            $this->apellido_paterno,
            $this->email,
            $this->isActive,
            $this->rol,
            $this->nombre

        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->rut,
            $this->password,
            $this->apellido_materno,
            $this->apellido_paterno,
            $this->email,
            $this->isActive,
            $this->rol,
            $this->nombre
        )= unserialize($serialized);
    }

    public function getRoles()
    {
        return array($this->rol);
    }

    public function getSalt()
    {
        /** No needed
         */
        return null;
    }

    public function eraseCredentials()
    {
        /*Nothing*/
    }


    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->getisActive();
    }
}

