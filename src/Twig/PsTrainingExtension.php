<?php

namespace Invertus\PsTraining\Twig;

use Twig\Extension\AbstractExtension;

/**
 * Registers custom Twig functions
 */
class PsTrainingExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ps_training', function () {
                return 'PS TRAINING';
            }),
        ];
    }
}
