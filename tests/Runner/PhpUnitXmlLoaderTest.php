<?php
namespace ivol\tests\Runner;

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertDescription;
use ivol\Runner\PhpUnitXmlLoader;
use ivol\tests\Helper\CustomAssert;

class PhpUnitXmlLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  PhpUnitXmlLoader */
    private $sut;

    protected function setUp()
    {
        $this->sut = new PhpUnitXmlLoader();
    }

    public function testLoadFillAsserts()
    {
        $actual = $this->sut->load('', realpath(__DIR__ . '/../Data/example.xml'));

        $this->assertInstanceOf('\ReflectionClass', $actual);
        $this->assertEquals(ConfigurablePhpUnitTest::__CLASS, $actual->name);
        $asserts = ConfigurablePhpUnitTest::getAsserts();
        $this->assertCount(3, $asserts);
        $this->assertEquals(new AssertDescription('\PHPUnit_Framework_Assert', 'assertEquals', array(4,4)), $asserts[0]);
        $this->assertEquals(new AssertDescription('ivol\Assert', 'assertServiceAvailable', array('http://www.google.com', 200)), $asserts[1]);
        $this->assertEquals(new AssertDescription(CustomAssert::__CLASS, 'assertInCustomClass', array()), $asserts[2]);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot parse xml element
     */
    public function testLoadFailsOnInvalidXml()
    {
        $this->sut->load('', realpath(__DIR__ . '/../Data/example_invalid.xml'));
    }

}