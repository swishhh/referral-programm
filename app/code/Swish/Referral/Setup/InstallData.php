<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 02:00
 */

namespace Swish\Referral\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Swish\Referral\Api\RelationsInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        /** @var $eavSetup EavSetup */
        $eavSetup->addAttribute(
            Customer::ENTITY,
            RelationsInterface::CUSTOMER_ATTRIBUTE_CODE,
            [
                'type' => 'varchar',
                'label' => 'Referral Code',
                'input' => 'select',
                'required' => false,
                'visible' => false,
                'user_defined' => false,
                'position' => 100,
                'system' => 0,
            ]
        );
    }
}
