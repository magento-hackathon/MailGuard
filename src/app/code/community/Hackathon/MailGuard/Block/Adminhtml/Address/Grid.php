<?php
class Hackathon_MailGuard_Block_Adminhtml_Address_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        // Set some defaults for our grid
        $this->setDefaultSort('address_id');
        $this->setId('hackathon_mailguard_address_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass()
    {
        return 'hackathon_mailguard/address_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('address_id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'address_id'
            )
        );

        $this->addColumn('mailaddress',
            array(
                'header'=> $this->__('Mail Address'),
                'index' => 'mailaddress'
            )
        );

        $this->addColumn('type',
            array(
                'header'=> $this->__('Type'),
                'index' => 'type',
                'type'  => 'options',
                'options' => Mage::getSingleton('hackathon_mailguard/system_config_source_type')->getOptionArray(),
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('address_id' => $row->getId()));
    }
}