<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 03:03
 */

namespace Swish\Referral\Block\Customer\Account;

use Magento\Framework\View\Element\Template;

class Content extends Template
{
    protected $_template = 'Swish_Referral::customer/account/content.phtml';

    public function __construct(
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }
}
