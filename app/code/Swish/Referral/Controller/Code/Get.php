<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 16:22
 */

namespace Swish\Referral\Controller\Code;

use Swish\Referral\Api\ReferralCodeInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Swish\Referral\Exception\EmptyCode;

class Get extends Action
{
    /**
     * @var ReferralCodeInterface
     */
    protected $_referralCode;

    /**
     * @var JsonFactory
     */
    protected $_jsonFactory;

    public function __construct(
        Context $context,
        ReferralCodeInterface $referralCode,
        JsonFactory $jsonFactory
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_referralCode = $referralCode;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = $this->_jsonFactory->create();
        try {
            $result = [
                'code' => $this->_referralCode->get(),
                'message' => ''
            ];
        } catch (EmptyCode $e) {
            $result = [
                'code' => false,
                'message' => __('You don\'t have a referral code')
            ];
        }
        return $response->setData($result);
    }
}
