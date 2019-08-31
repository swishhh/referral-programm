<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 20:32
 */

namespace Swish\Referral\Model;

use Swish\Referral\Api\RelationsInterface;
use Swish\Referral\Helper\Customer\Data;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Phrase;

class Relation extends AbstractModel implements IdentityInterface
{
    /**
     * Cache tag constant
     */
    const CACHE_TAG = RelationsInterface::TABLE_NAME;

    /**
     * @var string
     */
    protected $_cacheTag = RelationsInterface::TABLE_NAME;

    /**
     * @var string
     */
    protected $_eventPrefix = RelationsInterface::TABLE_NAME;

    /**
     * @var Data
     */
    protected $_customerHelper;

    public function __construct(
        Data $customerHelper,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->_customerHelper = $customerHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Swish\Referral\Model\ResourceModel\Relation');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }

    /**
     * @return Phrase|string
     */
    public function getReferralName()
    {
        $referralId = @$this->getData(RelationsInterface::FIELD_NAME_REFERRAL_ID);
        $name = $referralId ? $this->_customerHelper->getCustomerName($referralId) : false;
        return $name ? $name : __('Referral has no name');
    }
}
