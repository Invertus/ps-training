<?php

class PsSymfonyTraining extends ModuleCore
{
    public function __construct()
    {
        $this->name = 'pssymfonytraining';
        $this->version = '1.0.0';
        $this->author = 'invertus';

        parent::__construct();

        $this->displayName = $this->trans('PS Symfony Training module');
    }
}
