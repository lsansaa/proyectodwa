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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     *
     * Many Feed has One Persona
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_usuario", referencedColumnName="rut")
     */
    private $rut_usuario;

    /**
     *
     * Many Feed has One Archivo
     * @ORM\ManyToOne(targetEntity="Archivo")
     * @ORM\JoinColumn(name="id_archivo", referencedColumnName="id")
     */
    private $id_archivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     *
     */
    private $fecha;

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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getRutUsuario()
    {
        return $this->rut_usuario;
    }

    /**
     * @param string $rut_usuario
     */
    public function setRutUsuario($rut_usuario)
    {
        $this->rut_usuario = $rut_usuario;
    }

    /**
     * @return string
     */
    public function getIdArchivo()
    {
        return $this->id_archivo;
    }

    /**
     * @param string $id_archivo
     */
    public function setIdArchivo($id_archivo)
    {
        $this->id_archivo = $id_archivo;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /* @ORM\PrePersist
    */

    public function onPrePersist()
    {
        $this->fecha = new \DateTime("now");
    }


}

