<?php
/**
 * Registration type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Entity\UserData;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class RegistrationFormType
 * @package App\Form
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstName',
            TextType::class,
            [
                'label' => 'label_firstName',
                'required' => true,
            ]
        );
        $builder->add(
            'lastName',
            TextType::class,
            [
                'label' => 'label_lastName',
                'required' => true,
            ]
        );
        $builder->add(
            'nick',
            TextType::class,
            [
                'label' => 'label_nick',
                'required' => true,
            ]
        );
        $builder->add(
            'user',
            UserType::class,
            [
                'label' => ' ',
                'required' => true,
            ]
        );
//            ->add('email',
//                EmailType::class,
//                [
//                    'label' => 'label.mail',
//                    'required' => true,
//                ]
//            )
//            ->add('plainPassword',
//                RepeatedType::class,
//                [
//                    'type' => PasswordType::class,
//                    'invalid_message' => 'The password fields must match.',
//                    'required' => true,
//                    // instead of being set onto the object directly,
//                    // this is read and encoded in the controller
//                    'mapped' => false,
//                    'first_options'  => ['label' => 'label.password'],
//                    'second_options' => ['label' => 'label.repeat_password'],
//                    'constraints' => [
//                        new NotBlank([
//                            'message' => 'Please enter a password',
//                        ]),
//                        new Length([
//                            'min' => 6,
//                            'minMessage' => 'Your password should be at least {{ limit }} characters',
//                            // max length allowed by Symfony for security reasons
//                            'max' => 4096,
//                        ]),
//                    ],
//                ]
//            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserData::class,
        ]);
    }
}
