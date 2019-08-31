<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 01:32
 */

namespace Swish\Referral\Api;

use Swish\Referral\Model\ResourceModel\Relation\Collection;

interface RelationsInterface
{
    /**
     * Table name
     */
    const TABLE_NAME = 'referral_program';

    /**
     * Entity id
     */
    const FIELD_NAME_ID = 'id';

    /**
     * Customer id
     */
    const FIELD_NAME_CUSTOMER_ID = 'customer_id';

    /**
     * Referral id
     */
    const FIELD_NAME_REFERRAL_ID = 'referral_id';

    /**
     * Referral id
     */
    const FIELD_NAME_REFERRAL_REWARD = 'reward';

    /**
     * Attribute code
     */
    const CUSTOMER_ATTRIBUTE_CODE = 'referral_code';

    /** Get customer referrals collection
     * @return bool|Collection
     */
    public function getReferrals();

    /** Remove relations between customer and referral
     * @param $customerId
     * @param $referralId
     * @return self
     */
    public function removeRelation($customerId, $referralId);
}
