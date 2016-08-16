<?php
namespace ivol;

class ConfigurablePhpUnitTestTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigurablePhpUnitTest */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ConfigurablePhpUnitTest();
    }

    public function testOnAssertInPhpUnitNamespace() {
        $this->sut->addAssert(array('assertEquals'=> array(4,4)));

        $this->sut->testSystemConfiguration();
    }

    public function testOnAssertInIvolNamespace() {
        $this->sut->addAssert(array('assertResourceExists'=> array(__FILE__)));

        $this->sut->testSystemConfiguration();
    }

    public function testOnAssertOnCustomClassWithAssert() {
        $this->sut->addAssert(array('ivol\CustomAssert::assertInCustomClass'=> array()));

        $this->sut->testSystemConfiguration();

        $this->assertTrue(CustomAssert::$isCalled);
    }

    public function testOnAssertOnMultipleCalls() {
        $this->sut->addAssert(array('assertEquals'=> array(4,4)));
        $this->sut->addAssert(array('assertResourceExists'=> array(__FILE__)));
        $this->sut->addAssert(array('ivol\CustomAssert::assertInCustomClass'=> array()));
        $this->sut->addAssert(array('assertEquals'=> array(4,4)));

        $this->sut->testSystemConfiguration();

        $this->assertTrue(CustomAssert::$isCalled);
    }


}

class CustomAssert
{
    public static $isCalled = false;

    public static function assertInCustomClass()
    {
        self::$isCalled = true;
        return true;
    }
}