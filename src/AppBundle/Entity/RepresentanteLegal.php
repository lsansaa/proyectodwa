<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RepresentanteLegal
 *
 * @ORM\Table(name="representante_legal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepresentanteLegalRepository")
 */
class RepresentanteLegal
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
}

