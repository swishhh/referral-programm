<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 20:34
 */

namespace Swish\Referral\Model\ResourceModel;

use Swish\Referral\Api\RelationsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Relation extends AbstractDb
{
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(RelationsInterface::TABLE_NAME, RelationsInterface::FIELD_NAME_ID);
    }
}
