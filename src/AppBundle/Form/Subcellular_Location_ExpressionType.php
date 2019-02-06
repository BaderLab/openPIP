<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Subcellular_Location_ExpressionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ensembl_id')->add('aggresome')->add('cell_junctions')->add('centrosome')->add('cytokinetic_bridge')->add('cytoplasmic_bodies')->add('cytosol')->add('endoplasmic_reticulum')->add('endosomes')->add('focal_adhesion_sites')->add('golgi_apparatus')->add('intermediate_filaments')->add('lipid_droplets')->add('lysosomes')->add('microtubule_ends')->add('microtubule_organizing_center')->add('microtubules')->add('midbody')->add('midbody_ring')->add('mitochondria')->add('mitotic_spindle')->add('nuclear_bodies')->add('nuclear_membrane')->add('nuclear_speckles')->add('nucleoli')->add('nucleoli_fibrillar_center')->add('nucleoplasm')->add('nucleus')->add('peroxisomes')->add('plasma_membrane')->add('rods_and_rings')->add('vesicles')->add('protein')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subcellular_Location_Expression'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_subcellular_location_expression';
    }


}
