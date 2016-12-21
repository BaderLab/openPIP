<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class DatasetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pubmed_id', TextType::class, array(
                'attr' => array('style' => "width: 240px;")))
            ->add('author', TextType::class, array(
                'attr' => array('style' => "width: 240px;")))
            ->add('year', DateType::class)
            ->add('interaction_status', ChoiceType::class, array(
                'choices' => array('published' => 'Published', 'validated' => "Validated", 'verified' => 'Verified', 'literature' => 'Literature' ),
                'attr' => array('style' => "width: 240px;"),
                'multiple' => false,))
            ->add('description', TextareaType::class, array(
                'attr' => array('style' => "width: 300px;")))
            ->add('number_of_interactions', TextType::class, array(
                'attr' => array('style' => "width: 240px;")))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dataset'
        ));
    }
}
