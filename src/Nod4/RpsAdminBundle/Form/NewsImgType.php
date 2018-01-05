<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsImgType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file', array( 
                'image_path' => 'webPath',
                'label' => false,
                'required' => false,
                'attr' =>array('class'=> 'input-file js_file_check btn btn-primary btn-file'
                    )));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\NewsImg'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'NewsImageType';
    }
    

}
