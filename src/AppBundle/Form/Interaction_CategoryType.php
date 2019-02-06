<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Interaction_Category;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Interaction_CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('category_name')
        	->add('order')
        	->add('color_scheme')
        	->add('description', TextareaType::class, array(
        			'attr' => array('style' => "min-height: 20px; height: 100px; width: 100%; resize: vertical;")));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Interaction_Category::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_interaction_category';
    }


}
