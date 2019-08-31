<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 20:36
 */

namespace Swish\Referral\Model\ResourceModel\Relation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** Id field name
     * @var string
     */
    protected $_idFieldName = 'id';

    /** Event prefix
     * @var string
     */
    protected $_eventPrefix = 'referral_relations_collection';

    /** Event object
     * @var string
     */
    protected $_eventObject = 'referral_relations_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Swish\Referral\Model\Relation',
            'Swish\Referral\Model\ResourceModel\Relation');
    }
}
