<?php

namespace PlantsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlantsBundle\Entity\Personne;

class UserController extends Controller
{
    public  function adduserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == "POST") {
            if ($request->get("choix")=="inscription"){
                $personne = new Personne();
                $personne->setNom($request->get("nom"));
                $personne->setPrenom($request->get("prenom"));
                $personne->setEmail($request->get("email"));
                $personne->setPassword($request->get("password"));
                $personne->setNumTel($request->get("numtel"));
                $personne->setAddresse($request->get("adresse"));
                $personne->setRole("client");
                $em->persist($personne);
                $em->flush();

                $sesion =$request->getSession();
                $sesion->set('login', $personne->getPrenom());
                return $this->redirectToRoute('communaute_theme', array('user' => $personne->getPrenom()));

            }

            if ($request->get("choix")=="connexion"){
                $user= $em->getRepository('PlantsBundle:Personne')->findOneBy(['email'=> $request->get("email"),'password'=> $request->get("password")]);
                if($user){
                    $sesion =$request->getSession();
                    $sesion->set('login', $user->getPrenom());
                    return $this->redirectToRoute('plants_homepage');

                }

                return $this->render('@Plants/template/inscription.html.twig');

            }


        }
        return $this->render('@Plants/template/inscription.html.twig');
    }

    public  function logoutAction(Request $request)
    {
        $session = $request->getSession();

        $session->invalidate();
        return $this->redirectToRoute("plants_homepage");
    }
}
