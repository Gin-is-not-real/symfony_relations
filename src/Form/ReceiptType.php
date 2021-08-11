<?php

namespace App\Form;

use App\Entity\Receipt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path')
            ->add('product')
            ->add('file', FileType::class, ['mapped' => false])
            // ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $listener)
            // {
            //     $filename = $listener->getData();
            //     if(!isset($filename['file']) || !$filename['file']) {
            //         exit;
            //     }
            // })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Receipt::class,
        ]);
    }
}
