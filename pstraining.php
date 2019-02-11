<?php

class PsTraining extends Module
{
    public function __construct()
    {
        $this->name = 'pstraining';
        $this->version = '1.0.0';
        $this->author = 'invertus';
        $this->need_instance = false;

        parent::__construct();

        $this->displayName = $this->trans('PrestaShop Training module');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionLanguageGridDefinitionModifier') &&
            $this->registerHook('actionLanguageGridQueryBuilderModifier') &&
            $this->registerHook('actionLanguageGridPresenterModifier') &&
            $this->registerHook('actionLanguageGridGridFilterFormModifier') &&
            $this->registerHook('actionLanguageGridGridDataModifier')
        ;
    }
}
