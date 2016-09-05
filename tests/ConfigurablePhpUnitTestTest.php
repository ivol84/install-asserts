<?php
namespace ivol\tests;

use ivol\ConfigurablePhpUnitTest;

class ConfigurablePhpUnitTestTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigurablePhpUnitTest */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ConfigurablePhpUnitTest();
    }

    public function testOnAssertInPhpUnitNamespace()
    {
        ConfigurablePhpUnitTest::addAssert(array('assertEquals'=> array(4,4)));

        $this->sut->testSystemConfiguration();
    }

    public function testOnAssertInIvolNamespace()
    {
        ConfigurablePhpUnitTest::addAssert(array('assertResourceExists'=> array(__FILE__)));

        $this->sut->testSystemConfiguration();
    }

    public function testOnAssertOnCustomClassWithAssert()
    {
        ConfigurablePhpUnitTest::addAssert(array(CustomAssert::__CLASS . '::assertInCustomClass'=> array()));

        $this->sut->testSystemConfiguration();

        $this->assertTrue(CustomAssert::$isCalled);
    }

    public function testOnAssertOnMultipleCalls()
    {
        ConfigurablePhpUnitTest::addAssert(array('assertEquals'=> array(4,4)));
        ConfigurablePhpUnitTest::addAssert(array('assertResourceExists'=> array(__FILE__)));
        ConfigurablePhpUnitTest::addAssert(array(CustomAssert::__CLASS . '::assertInCustomClass'=> array()));
        ConfigurablePhpUnitTest::addAssert(array('assertEquals'=> array(4,4)));

        $this->sut->testSystemConfiguration();

        $this->assertTrue(CustomAssert::$isCalled);
    }

    /**
     * @expectedException  \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Cannot find correct assert
     */
    public function testOnAssertNotFound()
    {
        ConfigurablePhpUnitTest::addAssert(array('notExistingAssert'=> array(4,4)));

        $this->sut->testSystemConfiguration();
    }

}

class CustomAssert
{
    const __CLASS = __CLASS__;
    public static $isCalled = false;

    public static function assertInCustomClass()
    {
        self::$isCalled = true;
        return true;
    }
}