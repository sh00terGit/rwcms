<?php

namespace Nod4\RpsAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class SectionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fname',null,array(
                'label'=> 'Название'
            ))
            ->add('sname',null,array(
                'label'=> 'Короткое название',
                'required' => false
            ))
            ->add('typeOutput','choice',array(
                'label'=> 'Тип вывода',
                'choices'  => array(
                    "full" =>'Всю категорию',
                    "enum" => 'Определенную информацию' ,
                ),
                'empty_value' => 'Выберите..',
                'empty_data'  => null,
                'required' => true,
                'choices_as_values' => false,
            ))
            ->add('category','entity',array(
                'class' => 'Nod4\RpsAdminBundle\Entity\Category',
                'label' => 'Категория',
                'choice_label' => 'fname',
                'expanded' => false,
                'placeholder' => '',
                'required' => false,
                'empty_data'  => null,
                'attr' => array(
                    'disabled' => true
                )

            ))
            ->add('content','entity',array(
                'class' => 'Nod4\RpsAdminBundle\Entity\Content',
                'label' => 'Информация',
                'choice_label' => 'fname',
                'expanded' => false,
                'placeholder' => '',
                'required' => false,
                'empty_data'  => null,
                'attr' => array(
                    'disabled' => true
                )
            ))
            /*->add('parent','hidden',array(
                'data' => isset($options['data']) ? $options['data']->getParent() : null ,
            ))*/


            ->add('save', 'submit', array(
                'label' => 'Сохранить',
                'attr' => array(
                    'class' => 'js_btn_submit btn btn-primary form-control'
                )));


        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            array($this, 'onPreSubmit')
        );
    }


    /**
     * Если указана категория и инфа то считаем что указана только инфа....
     *
     * @param FormEvent $event
     *
     */
    public function onPreSubmit(FormEvent $event)
    {
        $section = $event->getData();
        $category = isset($section['category'])  ? $section['category'] : null ;
        $content = isset($section['content'])  ? $section['content'] : null ;
        if ($category != null and $content != null) {
            unset($section['category']);
            $event->setData($section);
        }

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nod4\RpsAdminBundle\Entity\Section'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sectionForm';
    }
}
