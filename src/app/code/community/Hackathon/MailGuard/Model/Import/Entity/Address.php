<?php

/**
 * Class Hackathon_MailGuard_Model_Import_Entity_Address
 */
class Hackathon_MailGuard_Model_Import_Entity_Address extends Mage_ImportExport_Model_Import_Entity_Abstract
{
    /**
     * @var string
     */
    const COL_ADDRESS_ID = 'address_id';

    /**
     * @var string
     */
    const COL_MAILADDRESS = 'mailaddress';

    /**
     * @var string
     */
    const COL_TYPE = 'type';

    /**
     * Address entity DB table name.
     *
     * @var string
     */
    protected $_entityTable = null;

    /**
     * Array of ids of existing addresses
     *
     * @var array
     */
    protected $_oldAddresses = array();

    /**
     * Delete addresses.
     *
     * @return Hackathon_MailGuard_Model_Import_Entity_Address
     */
    protected function _deleteAddresses()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $idToDelete = array();

            foreach ($bunch as $rowNum => $rowData) {
                if ($this->validateRow($rowData, $rowNum)) {
                    $idToDelete[] = $rowData[self::COL_ADDRESS_ID];
                }
            }
            if ($idToDelete) {
                $this->_connection->query(
                    $this->_connection->quoteInto(
                        "DELETE FROM `{$this->_entityTable}` WHERE `address_id` IN (?)", $idToDelete
                    )
                );
            }
        }
        return $this;
    }

    /**
     * Import data rows.
     *
     * @abstract
     * @return boolean
     */
    protected function _importData()
    {
        if (Mage_ImportExport_Model_Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            $this->_deleteAddresses();
        } else {
            $this->_saveAddresses();
        }
        return true;
    }


    /**
     * @return Hackathon_MailGuard_Model_Import_Entity_Address
     *
     */
    protected function _initAddresses()
    {
        $this->_oldAddresses = Mage::getResourceModel('hackathon_mailguard/address_collection')->getAllIds();
        return $this;
    }

    /**
     * Update and insert data in entity table.
     *
     * @param array $entityRowsIn Row for insert
     * @param array $entityRowsUp Row for update
     * @return Hackathon_MailGuard_Model_Import_Entity_Address
     */
    protected function _saveAddressEntity(array $entityRowsIn, array $entityRowsUp)
    {
        if ($entityRowsIn) {
            $this->_connection->insertMultiple($this->_entityTable, $entityRowsIn);
        }
        if ($entityRowsUp) {
            $this->_connection->insertOnDuplicate(
                $this->_entityTable,
                $entityRowsUp,
                array(self::COL_MAILADDRESS, self::COL_TYPE)
            );
        }
        return $this;
    }

    /**
     * Save addresses.
     *
     * @return Hackathon_MailGuard_Model_Import_Entity_Address
     */
    protected function _saveAddresses()
    {
        $nextEntityId = Mage::getResourceHelper('importexport')->getNextAutoincrement($this->_entityTable);

        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $entityRowsIn = array();
            $entityRowsUp = array();

            foreach ($bunch as $rowNum => $rowData) {
                if (!$this->validateRow($rowData, $rowNum)) {
                    continue;
                }

                $entityRow = array(
                    'mailaddress' => $rowData[self::COL_MAILADDRESS],
                    'type' => $rowData[self::COL_TYPE]
                );

                if (empty($rowData[self::COL_ADDRESS_ID]) || !in_array($rowData[self::COL_ADDRESS_ID], $this->_oldAddresses)) {
                    $entityRow['address_id'] = $nextEntityId++;
                    $entityRowsIn[] = $entityRow;
                } else {
                    $entityRow['address_id'] = $rowData[self::COL_ADDRESS_ID];
                    $entityRowsUp[] = $entityRow;
                }
            }

            $this->_saveAddressEntity($entityRowsIn, $entityRowsUp);
        }
        return $this;
    }

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_connection = Mage::getSingleton('core/resource')->getConnection('write');
        $this->_entityTable = Mage::getModel('hackathon_mailguard/address')->getResource()->getEntityTable();

        $this->_initAddresses();

    }

    /**
     * EAV entity type code getter.
     *
     * @abstract
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'hackathon_mailguard_address';
    }

    /**
     * Validate data row.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return boolean
     */
    public function validateRow(array $rowData, $rowNum)
    {
        // empty($rowData[self::COL_MAILADDRESS]) => darf nicht true sein
        // $rowData[self::COL_TYPE] => muss einem Wert aus den Options entsprechen
        return true;
    }
}

