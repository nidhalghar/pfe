<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nomexperience')
            ->add('datededebut')
            ->add('datedefin')
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
            ]);
          
            
          
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
