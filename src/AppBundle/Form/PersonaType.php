<?php
/**
 * Created by PhpStorm.
 * User: Hal9000
 * Date: 15/07/17
 * Time: 14:25
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

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('rut', TextType::class, array(
                'attr' => ['pattern' => '[0-9\-\.kK]*']
            ))
            ->add('nombre', TextType::class, array(
                'attr' => ['pattern' => '[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]\s+*']
            ))
            ->add('apellido_paterno', TextType::class, array(
                'attr' => ['pattern' => '[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]\s+*']
            ))
            ->add('apellido_materno', TextType::class, array(
                'attr' => ['pattern' => '[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]\s+*']
            ))
            ->add('email', EmailType::class)

            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'     => array('label' => 'Contraseña'),
                'second_options'    => array('label' => 'Repita Contraseña')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Persona::class,
        ));
    }

}