<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 17:24
 */

namespace Swish\Referral\Controller\Code;

use Swish\Referral\Api\ReferralCodeInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Swish\Referral\Exception\ValidateCode;

class Apply extends Action
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
        $this->_referralCode = $referralCode;
        $this->_jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = $this->_jsonFactory->create();
        try {
            $this->_referralCode->set($this->getRequest()->getParam('code'));
            $result = [
                'success' => true
            ];
        } catch (ValidateCode $e) {
            $result = [
                'success' => false
            ];
        }
        return $response->setData($result);
    }
}
