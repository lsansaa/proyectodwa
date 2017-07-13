<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="feed")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FeedRepository")
 */
class Feed
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="rut_usuario", type="string", length=255, nullable=true)
     * One Archivo has One Persona
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_usuario", referencedColumnName="rut")
     */
    private $rut_usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="id_archivo", type="string", length=255, nullable=true)
     * One Feed has One Archivo
     * @ORM\OneToOne(targetEntity="Archivo")
     * @ORM\JoinColumn(name="id_archivo", referencedColumnName="id")
     */
    private $id_archivo;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getRutUsuario(): string
    {
        return $this->rut_usuario;
    }

    /**
     * @param string $rut_usuario
     */
    public function setRutUsuario(string $rut_usuario)
    {
        $this->rut_usuario = $rut_usuario;
    }

    /**
     * @return string
     */
    public function getIdArchivo(): string
    {
        return $this->id_archivo;
    }

    /**
     * @param string $id_archivo
     */
    public function setIdArchivo(string $id_archivo)
    {
        $this->id_archivo = $id_archivo;
    }


}

