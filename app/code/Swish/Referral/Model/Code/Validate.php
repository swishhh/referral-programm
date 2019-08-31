<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 19:27
 */

namespace Swish\Referral\Model\Code;

use Swish\Referral\Exception\ValidateCode;

class Validate
{
    /**
     * @var string
     */
    protected $_pattern = '/^[a-zA-Z0-9]+$/ui';

    /**
     * @param $code
     * @return bool
     * @throws ValidateCode
     */
    public function validateCode($code)
    {
        if($code && preg_match($this->_pattern, $code)) {
            return true;
        }
        throw new ValidateCode(__('Invalid code'));
    }
}
