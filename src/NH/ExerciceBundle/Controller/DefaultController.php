<?php

namespace NH\ExerciceBundle\Controller;

use NH\ExerciceBundle\Entity\Task;
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
        return $this->render('NHExerciceBundle:Default:index.html.twig');
    }

    public function newAction(Request $request)
    {
        $task = new Task();
//        $task->setTask('écrire');
        $task->setDate(new \DateTime('today'));

        $form = $this->createFormBuilder($task)
            ->add('image', FileType::class, array('label' => "image"))
            ->add('titre', TextType::class, array('label' => "titre"))
            ->add('task', TextareaType::class, array('label' => "article"))
            ->add('date', DateType::class, array('label' => "date"))
            ->add('save', SubmitType::class, array('label' => "Creer un article"))
            ->getForm();

        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');
                return $this->redirectToRoute('nh_exercice_valid', array(
                    'id' => $task->getId()));
            }
        }
//        if ($form->isSubmitted() && $form->isValid()) {
//            $task = $form->getData();
//
//            return $this->redirectToRoute('');
        return $this->render('NHExerciceBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


  /*  public function retourAction($id)
    {
        return $this->render('NHExerciceBundle:Default:retour.html.twig');
    }*/

