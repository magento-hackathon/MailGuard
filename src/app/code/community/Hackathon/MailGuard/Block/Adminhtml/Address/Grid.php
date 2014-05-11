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
                'header' => $this->__('ID'),
                'header_export' => 'id',
                'align' =>'right',
                'width' => '50px',
                'index' => 'address_id'
            )
        );

        $this->addColumn('mailaddress',
            array(
                'header' => $this->__('Mail Address'),
                'header_export' => 'mailaddress',
                'index' => 'mailaddress'
            )
        );

        $this->addColumn('type',
            array(
                'header'=> $this->__('Type'),
                'header_export' => 'type',
                'index' => 'type',
                'type'  => 'options',
                'options' => Mage::getSingleton('hackathon_mailguard/system_config_source_type')->getOptionArray(),
            )
        );

        $this->addExportType('*/*/exportCsv', Mage::helper('hackathon_mailguard')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('hackathon_mailguard')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('hackathon_mailguard_address_id');
        $this->getMassactionBlock()->setFormFieldName('address_id');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('hackathon_mailguard')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete', array('_current'=>true)),
            'confirm' => Mage::helper('hackathon_mailguard')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('address_id' => $row->getId()));
    }
}
