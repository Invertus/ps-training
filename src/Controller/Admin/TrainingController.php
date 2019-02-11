<?php

namespace Invertus\PsTraining\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrainingController extends Controller
{
    public function index()
    {
        return $this->render('@Modules/pstraining/views/Admin/Training/index.html.twig');
    }
}
