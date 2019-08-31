<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 01:29
 */

namespace Swish\Referral\Model;

use Swish\Referral\Api\ReferralCodeInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Customer;
use Swish\Referral\Api\RelationsInterface;
use Swish\Referral\Exception\EmptyCode;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use Exception;
use Swish\Referral\Exception\ValidateCode;
use Swish\Referral\Model\Code\Validate;

class ReferralCode implements ReferralCodeInterface
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var Validate
     */
    protected $_validate;

    public function __construct(
        Session $session,
        Validate $validate
    )
    {
        $this->_validate = $validate;
        $this->_session = $session;
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        $customer = $this->_session->getCustomer();
        return $customer ? $this->getReferralCode($customer) : false;
    }

    /** Loading customer's code
     * @param Customer $customer
     * @return mixed
     * @throws EmptyCode
     */
    protected function getReferralCode(Customer $customer)
    {
        $code = $customer->getData(RelationsInterface::CUSTOMER_ATTRIBUTE_CODE);
        if(!$code) {
            throw new EmptyCode(__('Customer do not have a referral code'));
        }
        return $code;
    }

    /**
     * @inheritDoc
     */
    public function set($code)
    {
        if($this->_validate->validateCode($code)) {
            $customer = $this->_session->getCustomer();
            $customer ? $this->setReferralCode($customer, $code) : null;
        }
        return $this;
    }

    /**
     * @param Customer $customer
     * @param $code
     */
    protected function setReferralCode(Customer $customer, $code)
    {
        try {
            $dataModel = $customer->getDataModel();
            $dataModel->setCustomAttribute(RelationsInterface::CUSTOMER_ATTRIBUTE_CODE, $code);
            $customer->updateData($dataModel);
            $resource = $customer->getResource();
            /** @var $resource CustomerResource */
            $resource->saveAttribute($customer, RelationsInterface::CUSTOMER_ATTRIBUTE_CODE);
        } catch (Exception $e) {
            null;
        }
    }
    /**
     * @inheritDoc
     */
    public function generate()
    {
        return $this->generateCode();
    }

    /** Random code generation
     * @param int $length
     * @return string
     */
    protected function generateCode($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @inheritDoc
     */
    public function remove()
    {
        // TODO: Implement remove() method.
    }
}
