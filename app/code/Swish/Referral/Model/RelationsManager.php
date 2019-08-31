<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 20:38
 */

namespace Swish\Referral\Model;

use Swish\Referral\Api\RelationsInterface;
use Magento\Customer\Model\Session;
use Swish\Referral\Model\ResourceModel\Relation\Collection;
use Swish\Referral\Model\ResourceModel\Relation\CollectionFactory;

class RelationsManager implements RelationsInterface
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var CollectionFactory
     */
    protected $_collection;

    public function __construct(
        Session $session,
        CollectionFactory $collection
    )
    {
        $this->_collection = $collection;
        $this->_session = $session;
    }

    /** Get customer referrals collection
     * @inheritDoc
     */
    public function getReferrals()
    {
        $customerId = $this->getCustomerId();
        return $customerId ? $this->getRelations($customerId) : false;
    }

    /**
     * @inheritDoc
     */
    public function removeRelation($customerId, $referralId)
    {
        $collection = $this->_getCollection();
        $collection->addFieldToFilter(self::FIELD_NAME_CUSTOMER_ID, $customerId);
        $collection->addFieldToFilter(self::FIELD_NAME_CUSTOMER_ID, $referralId);
        $collection->walk('delete');
        return $this;
    }

    /** Customer referrals collection
     * @param $customerId
     * @return Collection
     */
    public function getRelations($customerId)
    {
        $collection = $this->_getCollection();
        return $collection->addFieldToFilter(self::FIELD_NAME_CUSTOMER_ID, $customerId);
    }

    /** Collection new object
     * @return Collection
     */
    private function _getCollection()
    {
        return $this->_collection->create();
    }

    /** Current customer id
     * @return bool|string
     */
    protected function getCustomerId()
    {
        $customer = $this->_session->getCustomer();
        return $customer ? $customer->getId() : false;
    }
}
