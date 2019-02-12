<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\PsTraining\Command;

use Invertus\PsTraining\Currency\CurrencyRateUpdaterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class UpdateCurrencyRatioCommand extends Command
{
    protected static $defaultName = 'ps-training:update-currency-ratio';

    /**
     * @var CurrencyRateUpdaterInterface
     */
    private $currencyRateUpdater;

    public function __construct(CurrencyRateUpdaterInterface $currencyRateUpdater)
    {
        parent::__construct();

        $this->currencyRateUpdater = $currencyRateUpdater;
    }

    protected function configure()
    {
        $this
            ->setDescription('Updates currency rate in shop')
            ->setHelp('This command allows you to update currency rate in your shop')
            ->addArgument('currency_iso_code', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencyIsoCode = $input->getArgument('currency_iso_code');

        $newRate = $this->currencyRateUpdater->update($currencyIsoCode);

        $output->writeln(sprintf('New rate for currency "%s" is %s', $currencyIsoCode, $newRate));
    }
}
