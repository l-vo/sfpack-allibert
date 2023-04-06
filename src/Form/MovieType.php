<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('poster', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [new Image()]
            ])
            ->add('country', CountryType::class)
            ->add('releasedAt', DateType::class, ['widget' => 'single_text', 'input' => 'datetime_immutable'])
            ->add('price', NumberType::class, ['scale' => 2])
            ->add('genre', EntityType::class, ['class' => Genre::class, 'choice_label' => 'name', 'multiple' => true])
        ;

        $builder->get('price')->addModelTransformer(new class implements DataTransformerInterface {
            public function transform(mixed $value): ?float
            {
                if ($value === null) {
                    return null;
                }

                return $value / 100;
            }

            public function reverseTransform(mixed $value): ?int
            {
                if ($value === null) {
                    return null;
                }

                return $value * 100;
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
