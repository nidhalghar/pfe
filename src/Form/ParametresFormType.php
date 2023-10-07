<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Parametres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ParametresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('loisires')
            ->add('Cv', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'mapped' => false,
                
            ])
            
            ->add('facebook')
            ->add('photo', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'mapped' => false,
                
            ])
          
            ->add('twitter')
            ->add('linkidin')
            ->add('linkPublic')
            ->add('git')
            ->add('paragraphe', TextareaType::class, [
                'label' => 'Paragraphe',
                'required' => true,
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametres::class,
        ]);
    }
}
