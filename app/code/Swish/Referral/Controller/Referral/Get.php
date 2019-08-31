<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 20:31
 */

namespace Swish\Referral\Controller\Referral;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\Action;
use Swish\Referral\Api\RelationsInterface;
use Swish\Referral\Model\Relation;

class Get extends Action
{
    /**
     * @var JsonFactory
     */
    protected $_jsonFactory;

    /**
     * @var RelationsInterface
     */
    protected $_relationsManager;

    public function __construct(
        Context $context,
        RelationsInterface $relationsManager,
        JsonFactory $jsonFactory
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_relationsManager = $relationsManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = $this->_jsonFactory->create();
        $result = [
            'items' => $this->getRelations()
        ];
        return $response->setData($result);
    }

    /** Get relations for current customer
     * @return array
     */
    public function getRelations()
    {
        $collection = $this->_relationsManager->getReferrals();
        if($collection && $collection->getSize()) {
            $result = [];
            /** @var  $item Relation */
            foreach ($collection->getItems() as $item) {
                $result[] = [
                    'id' => $item->getData(RelationsInterface::FIELD_NAME_REFERRAL_ID),
                    'name' => $item->getReferralName(),
                    'reward' => $item->getData(RelationsInterface::FIELD_NAME_REFERRAL_REWARD)
                ];
            }
            return $result;
        }
        return [];
    }
}
