<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Entity\Interaction_Category;
use AppBundle\Form\Interaction_CategoryType;
use AppBundle\Entity\Admin_Settings;

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
            ->add('url', 'text', array('label' => 'Url', 'attr' => array('style' => "width: 300px;")))
            ->add('version', 'text', array('label' => 'Version', 'attr' => array('style' => "width: 300px;")))
            // ->add('home_page', 'textarea', array('label' => 'Home Page', 'attr' => array('class' => 'tinymce', 'style' => "height: 400px;")))
            
            ->add('mission_title', 'text', array('label' => 'Top Section Title', 'attr' => array('style' => "width: 200px;")))
            ->add('mission_text', 'textarea', array('label' => 'Top SectionText', 'attr' => array('class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('method_title', 'text', array('label' => 'Bottom Section Title', 'attr' => array('style' => "width: 200px;")))
            ->add('method_text', 'textarea', array('label' => 'Bottom Section Text', 'attr' => array('class' => 'tinymce', 'style' => "height: 400px;")))

            ->add('about', 'textarea', array('attr' => array('label' => 'About', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('faq', 'textarea', array('attr' => array('label' => 'FAQ', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('contact', 'textarea', array('attr' => array('label' => 'Contact', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('download', 'textarea', array('attr' => array('label' => 'Downloads', 'class' => 'tinymce', 'style' => "height: 400px;")))
            ->add('footer', 'textarea', array('attr' => array('label' => 'Footer', 'class' => 'tinymce', 'style' => "height: 160px;")))
            ->add('main_color_scheme', TextType::class, array('label' => 'Main Color Scheme', 'attr' => array('class' => 'spectrum main_color_scheme')))
            ->add('header_color_scheme', TextType::class, array('label' => 'Header Color Scheme', 'attr' => array('class' => 'header_color_scheme')))
            ->add('logo_color_scheme', TextType::class, array('label' => 'Logo Color Scheme', 'attr' => array('class' => 'logo_color_scheme')))
            ->add('button_color_scheme', TextType::class, array('label' => 'Button Color Scheme', 'attr' => array('class' => 'button_color_scheme')))
            ->add('query_node_color', TextType::class, array('label' => 'Query Node Color', 'attr' => array('class' => 'query_node_color')))
            ->add('interactor_node_color', TextType::class, array('label' => 'Interactor Node Color', 'attr' => array('class' => 'interactor_node_color')))
            

            
            ->add('example_1', 'text', array('label' => 'Example 1', 'attr' => array('style' => "width: 140px;") ))
            ->add('example_2', 'text', array('label' => 'Example 2', 'attr' => array('style' => "width: 140px;") ))
            ->add('example_3', 'text', array('label' => 'Example 3', 'attr' => array('style' => "width: 140px;") ))
            ->add('interaction_categories', CollectionType::class, array(
            		'entry_type' => Interaction_CategoryType::class
            ));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Admin_Settings::class,
        ));
    }
}

/*
->add('published_edge_color', TextType::class, array('label' => 'Published Edge Color', 'attr' => array('class' => 'published_edge_color')))
->add('validated_edge_color', TextType::class, array('label' => 'Validated Edge Color', 'attr' => array('class' => 'validated_edge_color')))
->add('verified_edge_color', TextType::class, array('label' => 'Verified Edge Color', 'attr' => array('class' => 'verified_edge_color')))
->add('literature_edge_color', TextType::class, array('label' => 'Literature Edge Color', 'attr' => array('class' => 'literature_edge_color')))
*/








