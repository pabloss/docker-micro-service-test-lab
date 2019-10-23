<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\MicroService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('microService', FileType::class, [
                'label' => 'ZIP file',
                'mapped' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MicroService::class,
        ]);
    }
}
