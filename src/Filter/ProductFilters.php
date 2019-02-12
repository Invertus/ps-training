<?php

namespace Invertus\PsTraining\Filter;

use PrestaShop\PrestaShop\Core\Search\Filters;

/**
 * Class ProductFilter proves default filters for our products grid
 */
final class ProductFilters extends Filters
{
    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_product',
            'sortOrder' => 'desc',
            'filters' => [],
        ];
    }
}

