<?php

use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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

    public function hookActionLanguageGridDefinitionModifier(array $params)
    {
        /** @var \PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface $definition */
        $definition = $params['definition'];

        $definition->getColumns()
            ->remove('id_lang')
            ->addAfter(
                'date_format_full',
                (new DataColumn('locale'))
                    ->setName('LOCALE')
                    ->setOptions([
                        'field' => 'locale',
                    ])
            )
        ;

        $definition->getFilters()
            ->remove('id_lang')
            ->add((new Filter('locale', TextType::class))
                ->setAssociatedColumn('locale')
                ->setTypeOptions([
                    'attr' => [
                        'placeholder' => 'SEARCH ISO CODE',
                    ],
                ])
            )
        ;
    }
}
