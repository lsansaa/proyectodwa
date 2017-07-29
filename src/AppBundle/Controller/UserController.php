<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:06
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Persona;
use AppBundle\Form\PersonaType;
use AppBundle\Repository\PersonaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller {

    /**
     * @Route("/register", name="user_registration")
     *
     */
    public function registrarUsuario(Request $request,UserPasswordEncoderInterface $encoder){

        //(1) Se crea el form
        $user = new Persona();
        $form = $this->createForm(PersonaType::class , $user);
        //(2) Handle submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) codificar password)
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setisActive(true);
            // 4) guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

}