<?php
/**
 * Form Comments and Ratings.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CommentRatingForm.
 */
class CommentRatingForm extends AbstractType
{
    /**
     * Builds the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'value',
            RatingType::class,
            [
                'label' => false,
            ]
        );
        $builder->add(
            'text',
            CommentType::class,
            [
                'label' => false,
            ]
        );
    }
}
