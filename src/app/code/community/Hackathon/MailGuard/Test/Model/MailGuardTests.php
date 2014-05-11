<?php
/**
 * Created by Andreas Penz.
 * Date: 10.05.14
 * Time: 18:21
 */

class Hackathon_MailGuard_Test_Model_MailGuardTests extends EcomDev_PHPUnit_Test_Case
{

    public function testGetDomainFromEmailRegex()
    {
        $email = 'example@example.com';
        preg_match('/@(.*)$/', $email, $matches);
        $this->assertEquals( $matches[0], '@example.com');
    }

}