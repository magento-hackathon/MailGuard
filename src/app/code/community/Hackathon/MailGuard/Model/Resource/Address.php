<?php

class Hackathon_MailGuard_Model_Resource_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @var string
     */
    const COL_MAILADDRESS = 'mailaddress';

    /**
     * @var string
     */
    const COL_TYPE = 'type';

    /**
     * Errors in import process
     *
     * @var array
     */
    protected $_importColumnMapping        = array();

    /**
     * Count of imported entries
     *
     * @var int
     */
    protected $_importedRows        = 0;

    /**
     * Errors in import process
     *
     * @var array
     */
    protected $_importErrors        = array();

    /**
     * Array of unique address list keys to protect from duplicates
     *
     * @var array
     */
    protected $_importUniqueHash    = array();

    protected function _construct()
    {
        $this->_init('hackathon_mailguard/address', 'address_id');
    }

    /**
     * Validate row for import and return address list array or false
     * Error will be add to _importErrors array
     *
     * @param array $row
     * @param int $rowNumber
     * @return array|false
     */
    protected function _getImportRow($row, $rowNumber = 0)
    {
        // validate row
        if (count($row) < 2) {
            $this->_importErrors[] = Mage::helper('hackathon_mailguard')->__('Invalid Address format in the Row #%s', $rowNumber);
            return false;
        }

        // strip whitespace from the beginning and end of each row
        foreach ($row as $k => $v) {
            $row[$k] = trim($v);
        }

        $mailAddress = $row[$this->_importColumnMapping[self::COL_MAILADDRESS]];
        $type = $row[$this->_importColumnMapping[self::COL_TYPE]];

        // protect from duplicate
        $hash = sprintf("%s-%s", $mailAddress, $type);
        if (isset($this->_importUniqueHash[$hash])) {
            $this->_importErrors[] = Mage::helper('hackathon_mailguard')->__('Duplicate Row #%s (Mail Address "%s", Type "%s").', $rowNumber, $mailAddress, $type);
            return false;
        }
        $this->_importUniqueHash[$hash] = true;

        return array(
            $mailAddress,
            $type
        );
    }

    /**
     * Save import data batch
     *
     * @param array $data
     * @return Hackathon_MailGuard_Model_Resource_Address
     */
    protected function _saveImportData(array $data)
    {
        if (!empty($data)) {
            $columns = array(self::COL_MAILADDRESS, self::COL_TYPE);
            $this->_getWriteAdapter()->insertArray($this->getMainTable(), $columns, $data);
            $this->_importedRows += count($data);
        }

        return $this;
    }

    /**
     * Upload address list file and import data from it
     *
     * @param Varien_Object $object
     * @throws Mage_Core_Exception
     * @return Hackathon_MailGuard_Model_Resource_Address
     */
    public function uploadAndImport(Varien_Object $object)
    {
        if (empty($_FILES['groups']['tmp_name']['csv_file_upload']['fields']['address_list']['value'])) {
            return $this;
        }

        $csvFile = $_FILES['groups']['tmp_name']['csv_file_upload']['fields']['address_list']['value'];

        $this->_importColumnMapping = array();
        $this->_importErrors = array();
        $this->_importUniqueHash = array();
        $this->_importedRows = 0;

        $io = new Varien_Io_File();
        $info = pathinfo($csvFile);
        $io->open(array('path' => $info['dirname']));
        $io->streamOpen($info['basename'], 'r');

        // check and skip headers
        $headers = $io->streamReadCsv();
        if ($headers === false || count($headers) < 2) {
            $io->streamClose();
            Mage::throwException(Mage::helper('hackathon_mailguard')->__('Invalid Address List File Format'));
        }

        if (($this->_importColumnMapping[self::COL_MAILADDRESS] = array_search(self::COL_MAILADDRESS, $headers)) === false) {
            Mage::throwException(Mage::helper('hackathon_mailguard')->__('Column "' . self::COL_MAILADDRESS . '" not found.'));
        }

        if (($this->_importColumnMapping[self::COL_TYPE] = array_search(self::COL_TYPE, $headers)) === false) {
            Mage::throwException(Mage::helper('hackathon_mailguard')->__('Column "' . self::COL_TYPE . '" not found.'));
        }

        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $rowNumber = 1;
            $importData = array();

            $condition = array();
            $adapter->delete($this->getMainTable(), $condition);

            while (false !== ($csvLine = $io->streamReadCsv())) {
                $rowNumber++;

                if (empty($csvLine)) {
                    continue;
                }

                $row = $this->_getImportRow($csvLine, $rowNumber);
                if ($row !== false) {
                    $importData[] = $row;
                }

                if (count($importData) == 5000) {
                    $this->_saveImportData($importData);
                    $importData = array();
                }
            }
            $this->_saveImportData($importData);
            $io->streamClose();
        } catch (Mage_Core_Exception $e) {
            $adapter->rollback();
            $io->streamClose();
            Mage::throwException($e->getMessage());
        } catch (Exception $e) {
            $adapter->rollback();
            $io->streamClose();
            Mage::logException($e);
            Mage::throwException(Mage::helper('hackathon_mailguard')->__('An error occurred while import the address list.'));
        }

        $adapter->commit();

        if ($this->_importErrors) {
            $error = Mage::helper('hackathon_mailguard')->__('File has not been imported. See the following list of errors: %s', implode(" \n", $this->_importErrors));
            Mage::throwException($error);
        }

        return $this;
    }

}
