<?php
class Hackathon_MailGuard_Adminhtml_System_Hackathon_MailGuard_AddressController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('address_id')) {
            try {
                $model = Mage::getModel('hackathon_mailguard/address');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hackathon_mailguard')->__('The address has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('address_id' => $this->getRequest()->getParam('address_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the address  to delete.'));
        $this->_redirect('*/*/');
    }

    public function editAction()
    {
        $this->_initAction();

        $id  = $this->getRequest()->getParam('address_id');
        $model = Mage::getModel('hackathon_mailguard/address');

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This entry no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getMailaddress() : $this->__('New Address'));

        $data = Mage::getSingleton('adminhtml/session')->getHackathonMailguardAddressData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('hackathon_mailguard_address', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Address') : $this->__('New Address'), $id ? $this->__('Edit Address') : $this->__('New Address'))
            ->_addContent($this->getLayout()->createBlock('hackathon_mailguard/adminhtml_address_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    /**
     * Export customer grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'addresses.csv';
        $content    = $this->getLayout()->createBlock('hackathon_mailguard/adminhtml_address_grid')->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export customer grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'addresses.xml';
        $content    = $this->getLayout()->createBlock('hackathon_mailguard/adminhtml_address_grid')->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('address_id');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select address(es).'));
        } else {
            if (!empty($ids)) {
                try {
                    foreach ($ids as $id) {
                        $address = Mage::getSingleton('hackathon_mailguard/address')->load($id);
                        $address->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($ids))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('hackathon_mailguard/address');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The address has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this address.'));
            }

            Mage::getSingleton('adminhtml/session')->setBazData($postData);
            $this->_redirectReferer();
        }
    }

    /**
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system/hackathon_mailguard/address')
            ->_title($this->__('System'))->_title($this->__('Mail Guard'))->_title($this->__('Address'))
            ->_addBreadcrumb($this->__('System'), $this->__('System'))
            ->_addBreadcrumb($this->__('Mail Guard'), $this->__('Mail Guard'))
            ->_addBreadcrumb($this->__('Address'), $this->__('Address'));

        return $this;
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/hackathon_mailguard/address');
    }
}
