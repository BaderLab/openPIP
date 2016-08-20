<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Admin_SettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title', 'attr' => array('style' => "width: 500px;") ))
            ->add('short_title', 'text', array('label' => 'Short Title', 'attr' => array('style' => "width: 200px;")))
            ->add('home_page', 'textarea', array('label' => 'Home Page', 'attr' => array('class' => 'tinymce')))
            ->add('about', 'textarea', array('attr' => array('label' => 'About', 'class' => 'tinymce')))
            ->add('color_scheme', TextType::class, array('label' => 'Color Scheme', 'attr' => array('class' => 'spectrum')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin_Settings'
        ));
    }
}
