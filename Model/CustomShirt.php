<?php
namespace Xertigo\MyMeasurements\Model;
use Magento\Framework\Exception\LocalizedException as CoreException;
class CustomShirt extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'xertigo_mymeasurements_customshirt';
	
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Xertigo\MyMeasurements\Model\ResourceModel\CustomShirt');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}