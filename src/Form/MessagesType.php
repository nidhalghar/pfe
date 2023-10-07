<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre' , TextType::class, [
                "attr" => [
                    "class"=>"form-control"
                ]
            ])
            ->add('message',TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('recipient',EntityType::class,[
                "class" => User::class ,
                "choice_label" => "nom",
                "choice_label" => "prenom",
                "choice_label" => "image",
                "choice_label" => "email",
                "attr" => [
                    "class" => "form-control"
                ]
                ]);}
           
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
