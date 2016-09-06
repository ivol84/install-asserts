<?php
namespace ivol\tests;

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertDescriptionFactory;
use ivol\tests\Helper\CustomAssert;

class ConfigurablePhpUnitTestTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigurablePhpUnitTest */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ConfigurablePhpUnitTest();
    }

    public function testOnAssertOnMultipleCalls()
    {
        $factory = new AssertDescriptionFactory();
        ConfigurablePhpUnitTest::addAssert($factory->create(array('assertEquals'=> array(4,4))));
        ConfigurablePhpUnitTest::addAssert($factory->create(array('assertResourceExists'=> array(__FILE__))));
        ConfigurablePhpUnitTest::addAssert($factory->create(array(
            CustomAssert::__CLASS . '::assertInCustomClass'=> array())));
        ConfigurablePhpUnitTest::addAssert($factory->create(array('assertEquals'=> array(4,4))));

        $this->sut->testSystemConfiguration();

        $this->assertTrue(CustomAssert::$isCalled);
    }
}

