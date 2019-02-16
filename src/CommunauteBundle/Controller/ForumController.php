<?php

namespace CommunauteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlantsBundle\Entity\Personne;
use CommunauteBundle\Entity\Theme;
use CommunauteBundle\Entity\Commentaire;
use Symfony\Component\Validator\Constraints\DateTime;

class ForumController extends Controller
{
    public  function accesthemesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
           if($request->getSession()->get('login') ){

               return $this->redirectToRoute('communaute_theme', array('user' => $request->getSession()->get('login')));

           }

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
                    return $this->redirectToRoute('communaute_theme', array('user' => $user->getPrenom()));

                }

                return $this->render('@Plants/template/inscription.html.twig');

            }


        }
        return $this->render('@Plants/template/inscription.html.twig');
    }

    public  function addthemeAction(Request $request,$user){
        $em = $this->getDoctrine()->getManager();
        $themes= $em->getRepository('CommunauteBundle:Theme')->findAll();
        $connector= $em->getRepository('PlantsBundle:Personne')->findOneBy(['prenom'=> $user]);
        $sesion =$request->getSession();
        $sesion->set('login', $connector->getPrenom());


        if ($request->getMethod() == "POST") {
            if($request->get("ajout")) {
                if (!empty($request->get("nom"))) {
                    $theme = new Theme();
                    $theme->setNom($request->get("nom"));
                    $theme->setDateCreation(new \DateTime("now"));
                    $theme->setCreateur($connector);
                    $theme->setVisites(0);
                    $theme->setVisites($theme->getVisites() + 1);
                    $em->persist($theme);
                    $em->flush();

                    return $this->redirectToRoute("communaute_affich_comment", array('idtheme' => $theme->getId()));
                }
            }

            else
                return  $this->render('@Communaute/template/listforum.html.twig',array('sujets'=>$themes));
        }

        return $this->render('@Communaute/template/listforum.html.twig',array('themes'=>$themes));
    }

    public function commentsAction($idtheme, Request $request){
        $em = $this->getDoctrine()->getManager();
        $sujet = $em->getRepository('CommunauteBundle:Theme')->find($idtheme);
        $comments = $em->getRepository('CommunauteBundle:Commentaire')->findBy(['theme' => $sujet]);
        $sujet->setVisites($sujet->getVisites()+1);
        if($this->redirectToRoute("communaute_affich_comment", array('idtheme' => $idtheme))){
            $sujet->setVisites($sujet->getVisites());
        }

        if ($request->isXmlHttpRequest()) {
            $connector= $em->getRepository('PlantsBundle:Personne')->findOneBy(['prenom'=> $request->getSession()->get('login')]);
            $comment = new Commentaire();
            $comment->setContenu($request->get('commentaire'));
            $comment->setTheme($sujet);
            $comment->setEditeur($connector);
            $comment->setDatePost(new \DateTime("now"));
            $em->persist($comment);
            $em->flush();


            $response = new Response(json_encode(array(
                'content' => $comment->getContenu(),
                'editeur' => $comment->getEditeur()->getPrenom()

            )));
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }

        return $this->render('@Communaute/template/comments.html.twig', array('comments' => $comments, 'them' => $sujet));
    }

    public  function supcomment($idcomment, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $comment = $em->getRepository('CommunauteBundle:Commentaire')->find($idcomment);
            $em->remove($comment);
            $em->flush();



            $response = new Response(json_encode(array(
                'content' => $comment->getContenu(),

            )));
             $response->headers->set('Content-Type', 'application/json');

            return $response;

        }
    }
}
