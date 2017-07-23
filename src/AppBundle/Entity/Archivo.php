<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Archivo
 *
 * @ORM\Table(name="archivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArchivoRepository")
 */
class Archivo
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
     * @Assert\NotBlank(message="Por favor, ingrese un nombre para el archivo")
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var file
     * @Assert\NotBlank(message="Por favor, seleccione un archivo")
     * @Assert\File(
     *     maxSize="20M"
     * )
     * @ORM\Column(name="ruta", type="string")
     */
    private $ruta;

    /**
     * @var string
     * @Assert\NotBlank(message="Por favor, seleccione un estado para el archivo")

     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     *
     * Many Archivo has One Proyecto
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumn(name="id_proyecto", referencedColumnName="id")
     */
    private $id_proyecto;

    /**
     *
     * Many Archivo has One Persona
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_persona", referencedColumnName="rut")
     */
    private $rut_persona;

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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param string $ruta_archivo
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getIdProyecto()
    {
        return $this->id_proyecto;
    }

    /**
     * @param string $id_proyecto
     */
    public function setIdProyecto($id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }

    /**
     * @return string
     */
    public function getRutPersona()
    {
        return $this->rut_persona;
    }

    /**
     * @param string $rut_persona
     */
    public function setRutPersona($rut_persona)
    {
        $this->rut_persona = $rut_persona;
    }



}

