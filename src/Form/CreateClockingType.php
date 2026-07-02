<?php
namespace App\Form;

use App\Entity\Clocking;
use App\Entity\Project;
use App\Entity\User;
// Use string FQCN for entry_type to avoid static import of a missing class
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\ClockingItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateClockingType extends
    AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     *
     * @return void
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) : void {

        $builder->add('clockingUser', EntityType::class, [
            'class'        => User::class,
            'choice_label' => static function(
                ?User $choice
            ) : ?string {
                return $choice === null
                    ? null
                    : $choice->getLastName() . ' ' . $choice->getFirstName() . ' (' . $choice->getMatricule() . ')';
            },
            'label' => 'entity.Clocking.clockingUser',
        ]);
        $builder->add('date', DateType::class, [
            'label' => 'Date',
            'widget' => 'single_text',
        ]);
        $builder->add('clockingItems', CollectionType::class, [
                'entry_type' => CreateClockingItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ]);
        $builder->add('submit', SubmitType::class, [
            'label' => 'Créer',
        ]);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults(
            [
                'data_class' => Clocking::class,
            ]
        );
    }
}
