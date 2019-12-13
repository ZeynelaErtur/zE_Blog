<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class BlogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('excerpt')
            ->add('body')
            ->add('status', ChoiceType::class, [
                'placeholder' => 'Choose the status',
                'choices' => [
                    'Active' => true,
                    'Passive' => false
                ]
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Blog'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_blog_form_type';
    }
}
