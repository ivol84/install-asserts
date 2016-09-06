<?php
namespace ivol\tests\Runner;

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertDescription;
use ivol\Model\AssertDescriptionFactory;
use ivol\Model\XmlNotFoundException;
use ivol\Runner\PhpUnitXmlLoader;
use ivol\tests\Helper\CustomAssert;

class PhpUnitXmlLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $factory;
    /** @var  \PhpUnitXmlLoader */
    private $sut;

    protected function setUp()
    {
        $this->sut = new \PhpUnitXmlLoader();
        $this->factory = $this->getMock(AssertDescriptionFactory::__CLASS);
        $this->sut->setFactory($this->factory);
        ConfigurablePhpUnitTest::clearAsserts();
    }

    public function testLoadFillAsserts()
    {
        $expectedAsserts = [
            new AssertDescription('\PHPUnit_Framework_Assert', 'assertEquals', array(4,4)),
            new AssertDescription('ivol\Assert', 'assertServiceAvailable', array('http://www.google.com', 200)),
            new AssertDescription(CustomAssert::__CLASS, 'assertInCustomClass', array())
        ];
        $this->factory->expects($this->once())->method('createFromXml')->will($this->returnValue($expectedAsserts));

        $actual = $this->sut->load('', __DIR__ . '/Data/example.xml');

        $this->assertInstanceOf('\ReflectionClass', $actual);
        $this->assertEquals(ConfigurablePhpUnitTest::__CLASS, $actual->name);
        $actualAsserts = ConfigurablePhpUnitTest::getAsserts();
        $this->assertCount(3, $actualAsserts);
        $this->assertEquals($expectedAsserts, $actualAsserts);
    }

    public function testLoadFailsOnMissedXml()
    {
        try {
            $this->sut->load('', 'example_missed.xml');
        } catch (XmlNotFoundException $e) {
            $this->assertEquals('Cannot read xml example_missed.xml', $e->getMessage());
            return;
        }
        $this->fail('Expect exception.');
    }

    public function testLoadOnXmlNotFoundByPhpUnit()
    {
        try {
            $this->sut->load('example_missed.xml', '');
        } catch (XmlNotFoundException $e) {
            $this->assertEquals('Cannot read xml example_missed.xml', $e->getMessage());
            return;
        }
        $this->fail('Expect exception.');
    }
}