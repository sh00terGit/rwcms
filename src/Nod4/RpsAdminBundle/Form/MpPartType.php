<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MpPartType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id','hidden')
            ->add('partName','hidden',array(
                'read_only' => true,
                'label' =>false,
            ))
            ->add('status',null,array(
                'label' => 'Включить'
            ))
            //->add('priority')
            ->add('auto',null,array(
                'label' => 'Автоматический вывод '
            ))
            ->add('partContents','collection',array(
                'label' => 'Содержимое',
                'type' => new MpContentType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'delete_empty' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'empty_data' => null,
                    'attr' => array(
                        'class' => 'images-collection',
                    )
                )
            )
            ->add('save', 'submit', array(
                'label' => 'Сохранить слайдер',
                'attr' => array(
                    'class' => 'js_btn_submit btn btn-primary form-control'
                )));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\MpPart'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'MPPartType';
    }
}
