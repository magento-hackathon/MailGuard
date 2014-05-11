<?php
/**
 * Created by Andreas Penz.
 * Date: 10.05.14
 * Time: 18:21
 */

class Hackathon_MailGuard_Test_Model_MailGuardTests extends EcomDev_PHPUnit_Test_Case
{

    /**
     * check regex in getDomainFromEmail()
     * @test
     */
    public function testGetDomainFromEmailRegex()
    {
        $email = 'example@example.com';
        preg_match('/@(.*)$/', $email, $matches);
        $this->assertEquals( $matches[0], '@example.com');
    }

    /**
     * check filtering in checkAddresses()
     * @test
     * @loadFixture
     */
    public function testEmailCollectionFiltering()
    {

        $emailCollection = Mage::getModel('hackathon_mailguard/address')
            ->getCollection()
            ->addFieldToFilter(
                'mailaddress',
                array(
                    'like' => '%@example.com%'
                )
            )
            ->addFieldToFilter(
                'type',
                Mage::getStoreConfig('hackathon_mailguard/settings/type')
            );


        $this->assertGreaterThan(
            0,
            $emailCollection->getSize()
        );

    }

}