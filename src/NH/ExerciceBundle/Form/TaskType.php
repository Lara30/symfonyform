<?php
namespace NH\ExerciceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use NH\ExerciceBundle\Entity\Task;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('image', FileType::class, array(
            'label' => "image", 'data_class' => null))
        ->add('titre', TextType::class, array(
            'label' => "titre"))
        ->add('task', TextareaType::class, array(
            'label' => "article"))
        ->add('date', DateType::class, array(
            'label' => "date"))

        ->add('save', SubmitType::class, array(
            'label' => "créer un article"))
            ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
                'data_class' => Task::class,
        ));
    }
}


