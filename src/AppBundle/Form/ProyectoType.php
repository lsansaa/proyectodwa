<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 17-07-2017
 * Time: 19:54
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProyectoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder->add('nombre',TextType::class)
                ->add('fecha_inicio',DateType::class)
                ->add('fecha_termino',DateType::class)
                ->getForm();


    }

}