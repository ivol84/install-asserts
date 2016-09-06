<?php

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertDescriptionFactory;

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
        $factory = new AssertDescriptionFactory();
        $asserts = $factory->createFromXml(file_get_contents($suiteClassFile));
        foreach ($asserts as $assert) {
            ConfigurablePhpUnitTest::addAssert($assert);
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