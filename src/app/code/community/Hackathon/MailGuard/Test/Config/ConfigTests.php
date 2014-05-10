<?php
/**
 * Created by Andreas Penz.
 * Date: 10.05.14
 * Time: 16:40
 */

class Hackathon_MailGuard_Test_Config_ConfigTests extends EcomDev_PHPUnit_Test_Case_Config
{

    public function testCodePool()
    {
        $this->assertModuleCodePool('community');
    }

    public function testModuleVersion()
    {
        $this->assertModuleVersion('0.0.1');
    }

    public function testModuleDependencies()
    {
        $this->assertModuleDepends('Mage_Core');
    }

    public function testEventObserversDefined()
    {

        $this->assertEventObserverDefined(
            'global',
            'email_send_before',
            'hackathon_mailguard/observer',
            'emailSendBefore'
        );

        $this->assertEventObserverDefined(
            'global',
            'email_template_send_before',
            'hackathon_mailguard/observer',
            'emailSendBefore'
        );

        $this->assertEventObserverDefined(
            'global',
            'email_send_after',
            'hackathon_mailguard/observer',
            'emailSendAfter'
        );

        $this->assertEventObserverDefined(
            'global',
            'email_template_send_after',
            'hackathon_mailguard/observer',
            'emailSendAfter'
        );

    }

    public function testBlockAliases()
    {
        $this->assertBlockAlias(
            'hackathon_mailguard/adminhtml_address',
            'Hackathon_MailGuard_Block_Adminhtml_Address'
        );

        $this->assertBlockAlias(
            'hackathon_mailguard/adminhtml_address_edit',
            'Hackathon_MailGuard_Block_Adminhtml_Address_Edit'
        );

        $this->assertBlockAlias(
            'hackathon_mailguard/adminhtml_address_grid',
            'Hackathon_MailGuard_Block_Adminhtml_Address_Grid'
        );

        $this->assertBlockAlias(
            'hackathon_mailguard/adminhtml_address_edit_form',
            'Hackathon_MailGuard_Block_Adminhtml_Address_Edit_Form'
        );
    }

    public function testModelAliases()
    {
        $this->assertModelAlias(
            'hackathon_mailguard/observer',
            'Hackathon_MailGuard_Model_Observer'
        );

        $this->assertModelAlias(
            'hackathon_mailguard/mailguard',
            'Hackathon_MailGuard_Model_Mailguard'
        );

        $this->assertModelAlias(
            'hackathon_mailguard/address',
            'Hackathon_MailGuard_Model_Address'
        );

        $this->assertModelAlias(
            'hackathon_mailguard/system_config_source_type',
            'Hackathon_MailGuard_Model_System_Config_Source_Type'
        );

        $this->assertModelAlias(
            'hackathon_mailguard/core_email',
            'Hackathon_MailGuard_Model_Core_Email'
        );

        $this->assertModelAlias(
            'hackathon_mailguard/core_email_template',
            'Hackathon_MailGuard_Model_Core_Email_Template'
        );

    }

    public function testResourceModelAliases()
    {
        $this->assertResourceModelAlias(
            'hackathon_mailguard_resource/address',
            'Hackathon_MailGuard_Model_Resource_Address'
        );

        $this->assertResourceModelAlias(
            'hackathon_mailguard_resource/address_collection',
            'Hackathon_MailGuard_Model_Resource_Address_Collection'
        );
    }

    public function testHelperAliases()
    {
        $this->assertHelperAlias(
            'hackathon_mailguard',
            'Hackathon_MailGuard_Helper_Data'
        );
    }

    public function testLayoutFileDefinition()
    {
        $this->assertLayoutFileDefined(
            'adminhtml',
            'hackathon_mailguard/hackathon_mailguard.xml',
            'hackathon_mailguard'
        );
    }

    public function testLayoutFileExists()
    {
        $this->assertLayoutFileExists(
            'adminhtml',
            'hackathon_mailguard/hackathon_mailguard.xml'
        );
    }



}