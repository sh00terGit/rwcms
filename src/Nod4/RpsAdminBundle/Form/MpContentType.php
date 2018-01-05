<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MpContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contentId','entity',array(
                'class' => 'Nod4\RpsAdminBundle\Entity\Content',
                'label' => 'Информация',
                'choice_label' => 'fname',
                'expanded' => false,
                'placeholder' => '',
                'required' => false,
                'empty_data'  => null,
                'attr' => array(
                  /* 'disabled' => true*/
                )
            ))
            /*->add('categoryId','entity',array(
                'class' => 'Nod4\RpsAdminBundle\Entity\Category',
                'label' => 'Категория',
                'choice_label' => 'fname',
                'expanded' => false,
                'placeholder' => '',
                'required' => false,
                'empty_data'  => null,
                'attr' => array(
                   /* 'disabled' => true
                )

            )) */
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\MpContent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'MPContentType';
    }
}
