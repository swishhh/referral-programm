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

    /** Validate referral code
     * @param $code
     * @return bool
     * @throws ValidateCode
     */
    public function validateCode($code)
    {
        if($code && preg_match($this->_pattern, $code) && $this->length($code)) {
            return true;
        }
        throw new ValidateCode(__('Invalid code'));
    }

    /** Check code length
     * @param $code
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function length($code, $min = 3, $max = 20)
    {
        $len = strlen($code);
        return $len >= $min && $len <= $max;
    }
}
