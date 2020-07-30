<?php

namespace Xertigo\MyMeasurements\Model\ResourceModel;
 
class CustomShirt extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table 
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('xertigo_mymeasurements_customshirt', 'xertigo_mymeasurements_customshirt_id');
    }
}