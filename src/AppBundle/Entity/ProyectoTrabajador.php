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
     * @var string
     *
     * @ORM\Column(name="rut_trabajador", type="string")
     * One ProyectoTrabajador has One Persona
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_trabajador", referencedColumnName="rut_persona")
     */
    private $rut_trabajador;


    /**
     * @var int
     *
     * @ORM\Column(name="id_proyecto", type="integer")
     * One ProyectoTrabajador has One Proyecto
     * @ORM\OneToOne(targetEntity="Proyecto")
     * @ORM\JoinColumn(name="id_proyecto", referencedColumnName="id")
     */
    private $id_proyecto;

    /**
     * @return string
     */
    public function getRutTrabajador(): string
    {
        return $this->rut_trabajador;
    }

    /**
     * @param string $rut_trabajador
     */
    public function setRutTrabajador(string $rut_trabajador)
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
     * @return int
     */
    public function getIdProyecto(): int
    {
        return $this->id_proyecto;
    }

}

