<?php
namespace ivol\Runner;

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertFactory;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;

class PhpUnitXmlLoader implements \PHPUnit_Runner_TestSuiteLoader
{

    /**
     * @param string $suiteClassName
     * @param string $suiteClassFile
     *
     * @return ReflectionClass
     */
    public function load($suiteClassName, $suiteClassFile = '')
    {
        if (!$suiteClassFile) {
            $suiteClassFile = 'check_installation.xml';
        }
        $suiteClassName = \ivol\ConfigurablePhpUnitTest::__CLASS;
        $suiteClass = new \ReflectionClass($suiteClassName);
        $asserts = new \SimpleXMLElement(file_get_contents($suiteClassFile));
        if (!$asserts->assert) {
            return $suiteClass;
        }
        $factory = new AssertFactory();
        foreach ($asserts->assert as $assert) {
            if (!$assert->name) {
                // XXX: Add proper exception here
                throw new \RuntimeException("Cannot parse xml element");
            }
            $assertParams = $assert->params->param ? (array) $assert->params->param: [];
            ConfigurablePhpUnitTest::addAssert($factory->create(array((string) $assert->name => $assertParams)));
        }
        return $suiteClass;
    }

    /**
     * @param ReflectionClass $aClass
     *
     * @return ReflectionClass
     */
    public function reload(ReflectionClass $aClass)
    {
        return $aClass;
    }
}