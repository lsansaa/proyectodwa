<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectoTrabajador
 *
 * @ORM\Table(name="proyecto_trabajador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoTrabajadorRepository")
 */
class ProyectoTrabajador
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
     * One ProyectoTrabajador has One Persona
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_trabajador", referencedColumnName="rut")
     */
    private $rut_trabajador;


    /**
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumn(name="id_proyecto", referencedColumnName="id")
     */
    private $id_proyecto;

    /**
     * @return mixed
     */
    public function getRutTrabajador()
    {
        return $this->rut_trabajador;
    }

    /**
     * @param mixed $rut_trabajador
     */
    public function setRutTrabajador($rut_trabajador)
    {
        $this->rut_trabajador = $rut_trabajador;
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
     * @return mixed
     */
    public function getIdProyecto()
    {
        return $this->id_proyecto;
    }

    /**
     * @param mixed $id_proyecto
     */
    public function setIdProyecto($id_proyecto)
    {
        $this->id_proyecto = $id_proyecto;
    }

}

