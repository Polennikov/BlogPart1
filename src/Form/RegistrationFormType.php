<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NameUser', TextType::class, array(
                'label' => 'Имя'
            ))
            ->add('email', EmailType::class,
                array(
                    'label' => 'Email',
                ))
            ->add('AddresUser', TextType::class, array(
                'label' => 'Адрес'
            ))
            ->add('PhoneUser', TextType::class, array(
                'label' => 'Номер телефона',
                'constraints' => [
                    new Regex([
                        'pattern' => "/^\+7\d{10}$/",
                        'message' => 'Некорректные данные. Введите номер телефона в формате +7**********',
                    ]),
                ]
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Согласие с обработкой персональных данных.',
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ваш пароль должен состоять из {{ limit }} символов.',
                        // max length allowed by Symfony for security reasons
                        'max' => 100,
                    ]),
                    new Regex([
                        'pattern' => "/[0-9][a-z][A-Z]/i",
                        'message' => 'Пароль должен содержать цифры, латинские заглавные и строчные буквы',
                    ]),
                ],
                'first_options' => [
                    'label' => 'Пароль',
                ],
                'second_options' => [
                    'label' => 'Повторите пароль',
                ],
                'invalid_message' => 'Пароли не совпадают.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
