<?php

namespace Invertus\PsTraining\Language;

use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use PrestaShop\PrestaShop\Core\Language\LanguageActivatorInterface;

final class DecoratingLanguageActivator implements LanguageActivatorInterface
{
    /**
     * @var LanguageActivatorInterface
     */
    private $activator;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(LanguageActivatorInterface $activator, ConfigurationInterface $configuration)
    {
        $this->activator = $activator;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function enable($langId)
    {
        $this->activator->enable($langId);
    }

    /**
     * {@inheritdoc}
     */
    public function disable($langId)
    {
        $this->activator->disable($langId);

        $this->configuration->set('PS_TRAINING_SHOP_MOTTO', '');
    }
}
