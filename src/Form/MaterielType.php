<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Tva;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    /**
     * Constructeur du formulaire
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix_ht', NumberType::class, [
                'label' => 'Prix HT',
            ])
            ->add('prix_ttc', NumberType::class, [
                'label' => 'Prix TTC',
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité',
            ])
            ->add('date_creation', null, [
                'widget' => 'single_text',
            ])
            ->add('tva', EntityType::class, [
                'class' => Tva::class,
                'choice_label' => 'valeur',
                'label' => 'TVA (%)',
            ])
        ;
    }

    /**
     * Définition des contraintes
     *
     * @param OptionsResolver $resolver
     * @return void
    */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
