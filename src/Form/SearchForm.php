<?php

namespace App\Form;

use App\Entity\ArticleStock;
use App\Entity\Genre;
use App\Form\Type\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keywords',TextType::class, [
                'label' => false,
                'required' => false,

                'attr' => [
                    'placeholder' =>'Rechercher'
                ]
        ])
        ->add('range',SearchType::class, [
            'label' => 'Nombre de résultats',
            'required' => false,

        ])
            ->add('submit',SubmitType::class)

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}