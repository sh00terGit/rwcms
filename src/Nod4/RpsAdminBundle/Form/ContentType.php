<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname',null,array(
                'label' => 'Полное наименование'
    ))
            ->add('sname',null,array(
                'label' => 'Короткое наименование'
            ))
            ->add('dateCreate', 'date', array(
                'widget' => 'single_text',
                'label' => 'Дата публикации',
                'html5' => false,
                'attr' => array(
                    'placeholder' => 'Выберите дату',
                    'class' => 'date'),
              //  'label' => false,

            ))
            ->add('ftext','textarea',array(
                'label' => 'Текст'
            ))
            ->add('category','entity',array(
                'class' => 'Nod4\RpsAdminBundle\Entity\Category',
                'choice_label' => 'fname',
                'label' => 'Категория'
            ))
            ->add('save', 'submit', array(
                'label' => 'Сохранить',
                'attr' => array(
                    'class' => 'js_btn_submit btn btn-primary form-control'
                )));
        ;
        $builder->add('images', 'collection', array(
            'type' => new ContentImageType(),
            'label' => 'Изображения',
            'allow_add' => true,
            'cascade_validation' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'prototype' => true,
            'by_reference' => false,
            'empty_data' => null,
            'attr' => array(
                'class' => 'images-collection',
            ),
            'options' => array('label' => false),
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\Content'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nod4_rpsadminbundle_content';
    }
}
