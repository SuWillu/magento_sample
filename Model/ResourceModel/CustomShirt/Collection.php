<?php

namespace Xertigo\MyMeasurements\Model\ResourceModel\CustomShirt;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
 
    /**
     * Define model and resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Xertigo\MyMeasurements\Model\CustomShirt', 'Xertigo\MyMeasurements\Model\ResourceModel\CustomShirt');
    }
}