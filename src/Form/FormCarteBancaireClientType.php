<?php

namespace App\Form;

use App\Entity\CarteBancaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCarteBancaireClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroCarte')
            ->add('numeroCompte')
            ->add('titulaire')
            ->add('dateExpiration')
            ->add('typeMoyen')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarteBancaire::class,
        ]);
    }
}
