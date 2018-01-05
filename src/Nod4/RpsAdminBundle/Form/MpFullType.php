<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MpFullType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partName',null,array(
                'read_only' => true,
                'label' =>false,
                'data' => 'Слайдер'
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
        ;
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
