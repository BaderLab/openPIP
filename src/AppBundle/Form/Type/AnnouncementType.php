<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnnouncementType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('announcement')
		->add('dueDate', null, array('widget' => 'single_text'))
		->add('save', SubmitType::class)
		;
	}
}




?>