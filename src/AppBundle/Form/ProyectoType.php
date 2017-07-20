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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProyectoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $directores = $options['directores'];
        $representantes = $options['representantes'];

        $builder->add('nombre',TextType::class)
                ->add('fecha_inicio',DateType::class)
                ->add('fecha_termino',DateType::class)
                ->add('rut_director',ChoiceType::class,array('choices'=> array_combine($directores,$directores)))
                ->add('rut_representante', ChoiceType::class, array('choices'=> array_combine($representantes,$representantes)))
                ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('directores' => null, 'representantes' =>null));

    }

}