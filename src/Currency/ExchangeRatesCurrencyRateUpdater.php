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

namespace Invertus\PsTraining\Currency;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Implementation of currency rate updater using https://api.exchangeratesapi.io rates
 */
final class ExchangeRatesCurrencyRateUpdater implements CurrencyRateUpdaterInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->client = $guzzleClient;
    }

    /**
     * @param string $isoCode
     *
     * @return float New currency rate
     *
     * @throws RateNotFoundException If rate by currency is not found
     */
    public function update($isoCode)
    {
        $defaultShopCurrency = 'EUR';

        $response = $this->client->get('/latest', [
            'query' => [
                'base' => $defaultShopCurrency,
            ],
        ]);

        $rates = json_decode($response->getBody(), true);

        if (!isset($rates['rates'][$isoCode])) {
            throw new RateNotFoundException(sprintf('Rate for currency "%s" was not found', $isoCode));
        }

        // do actual update
        // ...

        return $rates['rates'][$isoCode];
    }
}
