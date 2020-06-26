<?php
/**
 * Rating type.
 */

namespace App\Form;

use App\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RatingType.
 */
class RatingType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @see FormTypeExtensionInterface
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'value',
            RangeType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ]
        );
//        $builder->add(
//            'value',
//            TextareaType::class,
//            [
//                'label' => 'post',
//                'required' => true,
//                'attr' => ['max_length' => 5],
//            ]
//        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Rating::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'rating';
    }
}
