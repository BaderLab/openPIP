<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class Admin_SettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title', 'attr' => array('style' => "width: 300px;") ))
            ->add('short_title', 'text', array('label' => 'Short Title', 'attr' => array('style' => "width: 200px;")))
            ->add('home_page', 'textarea', array('label' => 'Home Page', 'attr' => array('class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('about', 'textarea', array('attr' => array('label' => 'About', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('documentation', 'textarea', array('attr' => array('label' => 'Documentation', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('download', 'textarea', array('attr' => array('label' => 'Downloads', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('footer', 'textarea', array('attr' => array('label' => 'Footer', 'class' => 'tinymce', 'style' => "height: 160px;")))
            ->add('main_color_scheme', TextType::class, array('label' => 'Main Color Scheme', 'attr' => array('class' => 'spectrum main_color_scheme')))
            ->add('header_color_scheme', TextType::class, array('label' => 'Header Color Scheme', 'attr' => array('class' => 'header_color_scheme')))
            ->add('logo_color_scheme', TextType::class, array('label' => 'Logo Color Scheme', 'attr' => array('class' => 'logo_color_scheme')))
            ->add('button_color_scheme', TextType::class, array('label' => 'Button Color Scheme', 'attr' => array('class' => 'button_color_scheme')))

            ->add('example_1', 'text', array('label' => 'Example 1', 'attr' => array('style' => "width: 140px;") ))
            ->add('example_2', 'text', array('label' => 'Example 2', 'attr' => array('style' => "width: 140px;") ))
            ->add('example_3', 'text', array('label' => 'Example 3', 'attr' => array('style' => "width: 140px;") ))
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
