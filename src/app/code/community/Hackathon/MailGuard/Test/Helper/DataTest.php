<?php
/**
 * Created by Andreas Penz.
 * Date: 11.05.14
 * Time: 13:14
 */

class Hackathon_MailGuard_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{

    public function testConstants()
    {
        $this->assertEquals( Hackathon_MailGuard_Helper_Data::TYPE_WHITELIST, 0 );
        $this->assertEquals( Hackathon_MailGuard_Helper_Data::TYPE_BLACKLIST, 1 );
    }

}