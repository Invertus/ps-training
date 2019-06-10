<?php

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;

class PsTraining extends Module
{
    public function __construct()
    {
        $this->name = 'pstraining';
        $this->version = '1.0.0';
        $this->author = 'invertus';
        $this->need_instance = false;

        parent::__construct();

        $this->displayName = $this->trans('PrestaShop Training module', [], 'Modules.Pstraining.Admin');
    }

    public function getContent()
    {
        Tools::redirectAdmin(SymfonyContainer::getInstance()->get('router')->generate('admin_ps_training_trainings_index'));
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionLanguageGridDefinitionModifier') &&
            $this->registerHook('actionLanguageGridQueryBuilderModifier') &&
            $this->registerHook('actionLanguageGridPresenterModifier') &&
            $this->registerHook('actionLanguageGridGridFilterFormModifier') &&
            $this->registerHook('actionLanguageGridGridDataModifier') &&

            $this->registerHook('actionGeneralPageForm') &&
            $this->registerHook('actionGeneralPageSave')
        ;
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function hookActionLanguageGridDefinitionModifier(array $params)
    {
        /** @var GridDefinitionInterface $definition */
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

    public function hookActionGeneralPageForm(array $params)
    {
        /** @var FormBuilder $formBuilder */
        $formBuilder = $params['form_builder'];

        $formBuilder->add('shop_motto', TextType::class, [
            'data' => $this->get('prestashop.adapter.legacy.configuration')->get('PS_TRAINING_SHOP_MOTTO'),
        ]);
    }

    public function hookActionGeneralPageSave(array $params)
    {
        $motto = $params['form_data']['shop_motto'];

        $this->get('prestashop.adapter.legacy.configuration')->set('PS_TRAINING_SHOP_MOTTO', $motto);
    }
}
