<?php

namespace Invertus\PsTraining\Controller\Admin;

use Invertus\PsTraining\Filter\ProductFilters;
use Invertus\PsTraining\Form\Type\TrainingRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrainingController extends Controller
{
    public function index(ProductFilters $filters)
    {
        $presenter = $this->get('prestashop.core.grid.presenter.grid_presenter');
        $productGrid = $this->get('invertus.ps_training.grid.product_grid_factory')->getGrid($filters);

        return $this->render('@Modules/pstraining/views/Admin/Training/index.html.twig', [
            'productGrid' => $presenter->present($productGrid),
            'layoutHeaderToolbarBtn' => [
                'add' => [
                    'href' => $this->generateUrl('admin_ps_training_trainings_create'),
                    'desc' => 'Register training',
                    'icon' => 'add_circle_outline',
                ],
            ],
        ]);
    }

    public function create()
    {
        $form = $this->createForm(TrainingRegistrationType::class);

        return $this->render('@Modules/pstraining/views/Admin/Training/create.html.twig', [
            'layoutTitle' => 'Form example',
            'form' => $form->createView(),
        ]);
    }
}
