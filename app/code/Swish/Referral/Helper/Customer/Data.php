<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 21:15
 */

namespace Swish\Referral\Helper\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Exception;

class Data extends AbstractHelper
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->_customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /** Getting customer name by id
     * @param $referralId
     * @return bool|string
     */
    public function getCustomerName($referralId)
    {
        try {
            $customer = $this->_customerRepository->getById($referralId);
            if($customer) {
                $firstName = $customer->getFirstname();
                $lastName = $customer->getLastname();
                if($firstName && $lastName) {
                    return $firstName.' '.$lastName;
                }else {
                    $result = '';
                    $firstName ? $result .= $firstName : null;
                    $lastName ? $result .= $lastName : null;
                    return $result;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
