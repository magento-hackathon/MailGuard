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

    public function testModuleDepends()
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

}