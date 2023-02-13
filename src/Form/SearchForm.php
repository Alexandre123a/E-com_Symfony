<?php

namespace App\Form;

use App\Entity\ArticleStock;
use App\Entity\Genre;
use App\Form\Type\SearchType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
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
        ->add('range',ChoiceType::class, [
            'label' => 'Nombre de lignes',
            'choices' => [
                'default'=>"autre",
                '1' => '1',
                '2' => '2',
                '3'=> '3',
                '4'=> '4',
                '5'=> '5',
                '10'=> '10',
                '50'=> '50',
                '100'=> '100',
                '250'=> '250',
            ],


        ])
            ->add('order', ChoiceType::class, [
                'label' => 'Trier Par :',
                'choices' => [
                    'Pertinence'=>"Default",
                    'Prix Croissant' => 'Price_ASC',
                    'Prix Décroissant' => 'Price_DESC',
                    'Nouveauté'=> 'New',
                ],
            ])
            /*
            ->add('Type',ChoiceType::class, [
                'label' => 'Type d\'articles',
                'choices' => [
                    'default'=>"autre",
                    '1' => '1',
                    '2' => '2',
                    '3'=> '3',
                    '4'=> '4',
                    '5'=> '5',
                    '10'=> '10',
                    '50'=> '50',
                    '100'=> '100',
                    '250'=> '250',
                ],*/



        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => SearchData::class,
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }
}