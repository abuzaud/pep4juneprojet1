<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Form;


use App\Controller\Box\BoxRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BoxType
 * @package App\Form
 */
class BoxDescType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Nom', 'required' => true]
            ])
            ->add('budget', MoneyType::class, [
                'attr' => ['placeholder' => 'Budget', 'required' => true]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Description']
            ])
            ->add('reference', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'reference']
            ])
            ->add('submit', SubmitType::class, [
                    'label' => 'Valider'
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => BoxRequest::class
            ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'box_desc_edit';
    }
}