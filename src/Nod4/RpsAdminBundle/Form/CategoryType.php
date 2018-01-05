<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname',null,array(
                'label' => 'Название'
            ))
            ->add('sname',null, array(
                'label' => 'Коротное название',
                'required' => false,
            ))
            ->add('description',null,array(
                'label' => 'Описание',
                'required' => false
            ))
            ->add('save', 'submit', array(
                'label' => 'Сохранить',
                'attr' => array(
                    'class' => 'js_btn_submit btn btn-primary form-control'
                )));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'category';
    }
}
