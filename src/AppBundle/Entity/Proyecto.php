<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 */
class Proyecto
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechainicio", type="datetime")
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechatermino", type="datetime")
     */
    private $fechatermino;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *One Proyecto has One Director
     * @ORM\OneToOne(targetEntity="Director")
     * @ORM\JoinColumn(name="rut_director", referencedColumnName="rut_persona")
     */

    private $rut_director;

    /**
     *One Proyecto has One RepresentanteLegal
     * @ORM\OneToOne(targetEntity="RepresentanteLegal")
     * @ORM\JoinColumn(name="rut_representante", referencedColumnName="rut_persona")
     */
    private $rut_representante;

    /**
     * @return mixed
     */
    public function getRutRepresentante()
    {
        return $this->rut_representante;
    }

    /**
     * @param mixed $rut_representante
     */
    public function setRutRepresentante($rut_representante)
    {
        $this->rut_representante = $rut_representante;
    }

    /**
     * @return mixed
     */
    public function getRutDirector()
    {
        return $this->rut_director;
    }

    /**
     * @param mixed $rut_director
     */
    public function setRutDirector($rut_director)
    {
        $this->rut_director = $rut_director;
    }

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
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return Proyecto
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechatermino
     *
     * @param \DateTime $fechatermino
     *
     * @return Proyecto
     */
    public function setFechatermino($fechatermino)
    {
        $this->fechatermino = $fechatermino;

        return $this;
    }

    /**
     * Get fechatermino
     *
     * @return \DateTime
     */
    public function getFechatermino()
    {
        return $this->fechatermino;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Proyecto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
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
}

