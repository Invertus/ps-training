<?php

namespace Invertus\PsTraining\Grid\Column;

use PrestaShop\PrestaShop\Core\Grid\Column\AbstractColumn;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StockColumn is our custom column that is responsible for "In stock" data
 */
final class StockColumn extends AbstractColumn
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'ps_training_stock';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired([
                'quantity_field',
            ])
            ->setDefaults([
                'with_quantity' => false,
            ])
            ->setAllowedTypes('with_quantity', 'bool')
            ->setAllowedTypes('quantity_field', 'string')
        ;
    }
}
