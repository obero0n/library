<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'name'])
            ->add('status', CheckboxType::class, ['label' => 'status'])
            ->add('autor', TextType::class, ['label' => 'autor'])
            ->add('resume', TextType::class, ['label' => 'resume'])
            ->add('date', DateType::class, ['label' => 'date'])
            ->add('category', ChoiceType::class, ['label' => 'category'])
            ->add('user', TextType::class, ['label' => 'user'])
            ->add('Envoyer', SubmitType::class, ['attr' => ['label' => 'Envoyer']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
