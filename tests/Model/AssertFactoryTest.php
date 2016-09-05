<?php
namespace ivol\tests\Model;

use ivol\Model\AssertDescription;
use ivol\Model\AssertFactory;

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


}