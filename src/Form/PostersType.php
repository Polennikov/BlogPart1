<?php

namespace App\Form;

use App\Entity\Posters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title_post', TextType::class, array(
                'label' => 'Заголовок поста:',
            ))
            ->add('text_post', TextareaType::class, array(
                'label' => 'Текст поста:',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posters::class,
        ]);
    }
}
