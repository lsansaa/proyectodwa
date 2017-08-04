<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 27-07-2017
 * Time: 13:46
 */

namespace AppBundle\Form;

use AppBundle\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProyectoTrabajadorType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){


    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('pts' => null));

    }

}