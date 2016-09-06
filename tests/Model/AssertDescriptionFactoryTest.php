<?php
namespace ivol\tests\Model;

use ivol\Model\AssertDescription;
use ivol\Model\AssertDescriptionFactory;
use ivol\tests\Helper\CustomAssert;

class AssertDescriptionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AssertDescriptionFactory */
    private $sut;

    protected function setUp()
    {
        $this->sut = new AssertDescriptionFactory();
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

    public function testCreateFromXmlReturnsAsserts()
    {
        $actual = $this->sut->createFromXml(file_get_contents(realpath(__DIR__ . '/../Data/example.xml')));

        $this->assertCount(3, $actual);
        $this->assertEquals(new AssertDescription('\PHPUnit_Framework_Assert', 'assertEquals', array(4,4)), $actual[0]);
        $this->assertEquals(new AssertDescription('ivol\Assert', 'assertServiceAvailable', array('http://www.google.com', 200)), $actual[1]);
        $this->assertEquals(new AssertDescription(CustomAssert::__CLASS, 'assertInCustomClass', array()), $actual[2]);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot parse xml element
     */
    public function testCreateFromXmlFailsOnInvalidXml()
    {
        $this->sut->createFromXml(file_get_contents(realpath(__DIR__ . '/../Data/example_invalid.xml')));
    }
}