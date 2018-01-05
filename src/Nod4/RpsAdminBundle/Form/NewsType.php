<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', null, array(
                    'label' => 'Название',
                    'attr' => array(
                        'placeholder' => 'Введите название статьи')))
                ->add('text', 'textarea', array(
                    'label' => false,
                    'attr' => array(
                        'id' => 'textarea')))
                ->add('date', 'date', array(
                    'widget' => 'single_text',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'attr' => array(
                        'placeholder' => 'Выберите дату'),
                    'label' => false
                ))
                ->add('save', 'submit', array(
                    'label' => 'Сохранить',
                    'attr' => array(
                        'class' => 'js_btn_submit btn btn-primary form-control'
        )));


        $builder->add('images', 'collection', array(
            'type' => new NewsImgType(),
            'label' => 'Изображения',
             'allow_add' => true,
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
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'news';
    }

}
