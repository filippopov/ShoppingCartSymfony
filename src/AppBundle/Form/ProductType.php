<?php

namespace AppBundle\Form;

use AppBundle\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $options['entity_manager'];

        /**
         * @var Categories[] $allCategories
         */
        $allCategories = $em->getRepository(Categories::class)->findBy([],['name' => 'asc']);
        $allCategoriesArr = [];
        $allCategoriesArr[' -Please select- '] = '';

        foreach ($allCategories as $category) {
            $allCategoriesArr[$category->getName()] = $category->getId();
        }

        $isSecondHandArr = [];
        $isSecondHandArr[' -Please select- '] = '';
        $isSecondHandArr['No'] = 0;
        $isSecondHandArr['Yes'] = 1;


        $builder
            ->add('title', TextType::class, ['required' => false])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('price', MoneyType::class, ['required' => false])
            ->add('image', FileType::class, [
                'data_class' => null,
                'required' => false,
            ])
            ->add('stock', IntegerType::class, ['required' => false])
            ->add('isSecondHand', ChoiceType::class, [
                'choices' => $isSecondHandArr,
                'required' => false,
                'preferred_choices' => [' -Please select- ']
            ])
            ->add('category', ChoiceType::class, [
                'choices' => $allCategoriesArr,
                'required' => false,
                'preferred_choices' => [' -Please select- ']

            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));

        $resolver->setRequired('entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
