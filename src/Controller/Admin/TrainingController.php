<?php

namespace Invertus\PsTraining\Controller\Admin;

use Invertus\PsTraining\Filter\ProductFilters;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrainingController extends Controller
{
    public function index(ProductFilters $filters)
    {
        $presenter = $this->get('prestashop.core.grid.presenter.grid_presenter');
        $productGrid = $this->get('invertus.ps_training.grid.product_grid_factory')->getGrid($filters);

        return $this->render('@Modules/pstraining/views/Admin/Training/index.html.twig', [
            'productGrid' => $presenter->present($productGrid),
        ]);
    }
}
