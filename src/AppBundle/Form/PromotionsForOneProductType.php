<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionsForOneProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $options['entity_manager'];
        /** @var User $user */
        $user = $options['user'];


        if ($user) {
            /**
             * @var Product[] $allProducts
             */
            $allProducts = $em->getRepository(Product::class)->findBy(['user' => $user->getId()],['title' => 'asc']);
        } else {
            /**
             * @var Product[] $allProducts
             */
            $allProducts = $em->getRepository(Product::class)->findBy([],['title' => 'asc']);
        }

        $allProductsArr = [];
        $allProductsArr[' -Please select- '] = '';

        foreach ($allProducts as $product) {
            $allProductsArr[$product->getTitle()] = $product->getId();
        }

        $percentages = [];
        $percentages[' -Please select- '] = '';
        for ($i = 1; $i <= 100; $i++) {
            $percentages[$i] = $i;
        }

        $builder->add('promotionName', TextType::class, ['required' => false])
            ->add('product', ChoiceType::class, [
                'choices' => $allProductsArr,
                'required' => false,
                'preferred_choices' => [' -Please select- ']
            ])
            ->add('percentages', ChoiceType::class, [
                'choices' => $percentages,
                'preferred_choices' => [' -Please select- '],
                'required' => false
            ])
            ->add('dateFrom', DateType::class)
            ->add('dateTo', DateType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Promotions'
        ));

        $resolver->setRequired('entity_manager');
        $resolver->setRequired('user');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_promotions';
    }
}