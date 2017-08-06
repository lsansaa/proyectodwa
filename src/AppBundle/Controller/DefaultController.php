<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Persona;
use Doctrine\DBAL\Driver\PDOException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Feed;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\PersonaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){
        return $this->render('public/main.html.twig');
    }
    /**
     * @Route("/registro", name="registration")
     */
    public function registrar(Request $request,UserPasswordEncoderInterface $encoder){

        //(1) Se crea el form
        $user = new Persona();
        $form = $this->createForm(PersonaType::class , $user);
        //(2) Handle submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personaRepository = $this->getDoctrine()
                ->getRepository(Persona::class);
            $noExistenUsuarios = $personaRepository->findAll();

            //obtener RUT
            $rut = $user->getRut();
            //eliminar puntos, guiones y espacios
            $rutLimpio = preg_replace('/[.-]/', '', $rut);
            $rutLimpio = str_replace(' ','', $rutLimpio);
            //guardar rut
            $user->setRut($rutLimpio);
            // 3) codificar password)
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setisActive(true);
            if(empty($noExistenUsuarios)){
                $user->setRol("ROLE_ADMIN");
            }else{
                $user->setRol("ROLE_USER");
            }
            try{
                // 4) guardar el usuario
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
            catch (\Exception $Exception){
                switch (get_class($Exception)){
                    case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':

                        return $this->render(
                            'public/registro.html.twig',
                            array(
                                'form' => $form->createView(),
                                'error'=> $Exception)
                        );
                        break;
                    default:
                        return $this->render(
                            'public/registro.html.twig',
                            array(
                                'form' => $form->createView(),
                                'error'=> $Exception)
                        );
                        break;
                }
            }
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirect('/');

        }

        return $this->render(
            'public/registro.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/index", name="index")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */

    public function welcomeAction(Request $request)
    {

        $persona = $this->getUser();

        $feed = new Feed();
        $form = $this->createFormBuilder($feed)->getForm();

        //Redirecciona si se cerró la sesión.

        if(strcmp($persona->getRol(),"ROLE_ADMIN") == 0){

            $proyectos = $this->getDoctrine()->getRepository(Proyecto::class)->findAll();
            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findAll();
            return $this->render('public/index.html.twig',array('feeds'=>$feeds,'form'=>$form->createView(),'proyectos'=>$proyectos));

        }

        if(strcmp($persona->getRol(),"ROLE_USER") == 0){

            $em = $this->getDoctrine()->getManager();

            $query1 = $em->createQuery('SELECT p FROM AppBundle:Proyecto p WHERE p.rut_director = :rut OR p.rut_representante = :rut')->setParameter('rut',$persona->getRut());
            $proyectos1 = $query1->getResult();

            $query2 = $em->createQuery('SELECT p FROM AppBundle:Proyecto p, AppBundle:ProyectoTrabajador pt WHERE pt.id_proyecto = p.id and pt.rut_trabajador = :rut')->setParameter('rut',$persona->getRut());
            $proyectos2 = $query2->getResult();

            $proyectos = array_merge($proyectos1,$proyectos2);

            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findBy(array('rut_usuario' => $persona->getRut()));
            return $this->render('public/index.html.twig',array('feeds'=>$feeds,'form'=>$form->createView(),'proyectos'=>$proyectos));

        }

    }


}
