<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Country;

class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',null,array(
            'required'=>true
        ))
        ->add('surname',null,array(
            'required'=>true
        ))
        ->add('telephone',null,array(
            'required'=>true
        ))
        ->add('address',null,array(
            'required'=>true
        ))
        ->add('country',EntityType::class, array(
            'placeholder'=>'Choose an Option',
            'class' => Country::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
        ))
        ->add('city',null,array(
            'required'=>true
        ))
        ->add('cp',null,array(
            'required'=>true
        ))
        ->add('complement',null,array('required'=>false));
        //->add('user');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Address'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_address';
    }


}
