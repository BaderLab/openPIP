<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tissue_ExpressionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uniprot_id')->add('adipose_subcutaneous')->add('adipose_visceral_omentum')->add('adrenal_gland')->add('artery_aorta')->add('artery_coronary')->add('artery_tibial')->add('brain_0')->add('brain_1')->add('brain_2')->add('breast_mammary_tissue')->add('colon_sigmoid')->add('colon_transverse')->add('esophagus_gastroesophageal_junction')->add('esophagus_mucosa')->add('esophagus_muscularis')->add('heart_atrial_appendage')->add('heart_left_ventricle')->add('kidney_cortex')->add('liver')->add('lung')->add('minor_salivary_gland')->add('muscle_skeletal')->add('nerve_tibial')->add('ovary')->add('pancreas')->add('pituitary')->add('prostate')->add('skin')->add('small_intestine_terminal_ileum')->add('spleen')->add('stomach')->add('testis')->add('thyroid')->add('uterus')->add('vagina')->add('whole_blood')->add('protein')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tissue_Expression'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tissue_expression';
    }


}
