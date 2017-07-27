<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class SearchType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('identifier', TextareaType::class, array(
					'label' => false,
					'attr' => array('style' => "min-height: 20px; height: 100px; width: 100%; resize: vertical;")
					
			))                   
            ->add('query_query', CheckboxType::class, array(
                    'label' => 'Query-Query',
                    'required' => false,
                    'attr' => array('value' => 'query_query')))
                                       
            ->add('min_interaction_score', TextType::class, array(

                    'attr' => array('class' => 'hidden', 'value' => 0, 'style' => "width: 240px;")))
            ;

            
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{

	}
}

?>