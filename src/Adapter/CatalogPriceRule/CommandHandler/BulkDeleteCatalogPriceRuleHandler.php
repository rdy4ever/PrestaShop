<?php
/**
 * 2007-2019 PrestaShop and Contributors
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
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\PrestaShop\Adapter\CatalogPriceRule\CommandHandler;

use PrestaShop\PrestaShop\Adapter\CatalogPriceRule\AbstractCatalogPriceRuleHandler;
use PrestaShop\PrestaShop\Core\Domain\CatalogPriceRule\Command\BulkDeleteCatalogPriceRuleCommand;
use PrestaShop\PrestaShop\Core\Domain\CatalogPriceRule\CommandHandler\BulkDeleteCatalogPriceRuleHandlerInterface;
use PrestaShop\PrestaShop\Core\Domain\CatalogPriceRule\Exception\DeleteCatalogPriceRuleException;

/**
 * Deletes catalog prices rules in bulk action using legacy object model
 */
final class BulkDeleteCatalogPriceRuleHandler extends AbstractCatalogPriceRuleHandler implements BulkDeleteCatalogPriceRuleHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(BulkDeleteCatalogPriceRuleCommand $command)
    {
        foreach ($catalogPriceRuleId = $command->getCatalogPriceRuleIds() as $catalogPriceRuleId) {
            $specificPriceRule = $this->getSpecificPriceRule($catalogPriceRuleId);

            if (null === $this->deleteSpecificPriceRule($specificPriceRule)) {
                throw new DeleteCatalogPriceRuleException(
                    sprintf('Cannot delete SpecificPriceRule object with id "%s".', $catalogPriceRuleId->getValue()),
                    DeleteCatalogPriceRuleException::FAILED_BULK_DELETE
                );
            }
        }
    }
}
