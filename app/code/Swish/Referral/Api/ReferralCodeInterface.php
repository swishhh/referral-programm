<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 01:13
 */

namespace Swish\Referral\Api;

use Swish\Referral\Exception\EmptyCode;
use Swish\Referral\Exception\ValidateCode;

interface ReferralCodeInterface
{
    /** Get current customer's referral code
     * @return string
     * @throws EmptyCode
     */
    public function get();

    /** Get current customer's referral code
     * @param string $code
     * @return self
     * @throws ValidateCode
     */
    public function set($code);

    /** Random code generation
     * @return string
     */
    public function generate();

    public function remove();
}
