<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'name'])
            ->add('status', ChoiceType::class, ['choices' => ['En stock' => 1 , 'Indisponible' => 0]])
            ->add('autor', TextType::class, ['label' => 'autor'])
            ->add('resume', TextType::class, ['label' => 'resume'])
            ->add('date', DateType::class, ['label' => 'date'])
            ->add('category', EntityType::class, 
            [
                'class' => Category::class,
                'choice_label' => 'categoryName',
            ])
            ->add('Envoyer', SubmitType::class, 
            [
                'attr' => 
                [
                    'label' => 'Envoyer'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
        [
            'data_class' => Book::class,
        ]);
    }
}