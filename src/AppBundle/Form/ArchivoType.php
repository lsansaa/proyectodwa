<?php
/**
 * Created by PhpStorm.
 * User: Hal9000
 * Date: 20/07/17
 * Time: 20:51
 */

namespace AppBundle\Form;

use AppBundle\Entity\Archivo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){



        $builder
            ->add('nombre', TextType::class)
            ->add('datos', FileType::class)
            ->add('estado', ChoiceType::class, array(
                'choices'=> array(
                    'Seleccione un tipo de usuario' => null,
                    'Borrador' => 'BORRADOR',
                    'Publicado' => 'PUBLICADO'
                )
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Archivo::class,
        ));
    }

}