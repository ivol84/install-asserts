<?php
namespace ivol\tests\Model;

use ivol\Model\AssertDescription;
use ivol\Model\AssertFactory;
use ivol\tests\Helper\CustomAssert;

class AssertFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AssertFactory */
    private $sut;

    protected function setUp()
    {
        $this->sut = new AssertFactory();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot build assertation
     */
    public function testCreateThrowsExceptionOnInvalidAssert()
    {
        $this->sut->create(array('notExistingAssert'=> array(4,4)));
    }

    public function testCreateOnPhpUnitAssert()
    {
        $actual = $this->sut->create(array('assertEquals'=> array(4,4)));

        $this->assertEquals(new AssertDescription('\PHPUnit_Framework_Assert', 'assertEquals', array(4,4)), $actual);
    }

    public function testCreateOnIvolsAssert()
    {
        $actual = $this->sut->create(array('assertResourceExists'=> array(__FILE__)));

        $this->assertEquals(new AssertDescription('ivol\Assert', 'assertResourceExists', array(__FILE__)), $actual);
    }

    public function testCreateOnCustomAssert()
    {
        $actual = $this->sut->create(array(CustomAssert::__CLASS . '::assertInCustomClass'=> array()));

        $this->assertEquals(new AssertDescription(CustomAssert::__CLASS, 'assertInCustomClass', array()), $actual);
    }


}