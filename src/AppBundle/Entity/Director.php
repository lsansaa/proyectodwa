<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Director
 *
 * @ORM\Table(name="director")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DirectorRepository")
 */
class Director
{
    /**
     * @var string
     *
     * @ORM\Column(name="rut_persona", type="string")
     * @ORM\Id
     * One Proyecto has One Persona
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="rut_persona", referencedColumnName="rut")
     */
    private $rut_persona;


    /**
     * Get id
     *
     * @return string
     */
    public function getRut()
    {
        return $this->rut_persona;
    }

    /**
     * @param string $rut
     */
    public function setRut(string $rut)
    {
        $this->rut_persona = $rut;
    }
}

