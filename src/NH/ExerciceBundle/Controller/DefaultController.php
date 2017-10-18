<?php

namespace NH\ExerciceBundle\Controller;

use NH\ExerciceBundle\Entity\Task;
use NH\ExerciceBundle\NHExerciceBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        return $this->render('NHExerciceBundle:Default:index.html.twig');
        $task = $this->getDoctrine()->getRepository('NHExerciceBundle:Task')->findAll();
        return $this->render('NHExerciceBundle:Default:valid.html.twig', array('tasks' => $task));
    }

    public function formulaireAction(Request $request)
    {
        $task = new Task();
//        $task->setTask('écrire');
        $task->setDate(new \DateTime('today'));

//on utilise la méthode javascript createformbuilder
        $form = $this->createFormBuilder($task)

            //méthodes add pour chaque champ
            ->add('image', FileType::class, array('label' => "image"))
            ->add('titre', TextType::class, array('label' => "titre"))
            ->add('task', TextareaType::class, array('label' => "article"))
            ->add('date', DateType::class, array('label' => "date"))
            ->add('save', SubmitType::class, array('label' => "Creer un article"))
            ->getForm();

//on doit interroger la requête et savoir si on est en post
        //auquel cas on récupère le formulaire
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
//si le formulaire est soumis on fait appel à doctrine et à entitymangaer
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //em=entitymanager
                $em->persist($task);
                //on balance dans la base de données
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');
                return $this->redirectToRoute('nh_exercice_homepage', array(
                    'id' => $task->getId()));
            }
        }
//        if ($form->isSubmitted() && $form->isValid()) {
//            $task = $form->getData();
//
//            return $this->redirectToRoute('');
        return $this->render('NHExerciceBundle:Default:formulaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


  /*  public function retourAction($id)
    {
        return $this->render('NHExerciceBundle:Default:retour.html.twig');
    }*/

