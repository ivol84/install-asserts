<?php

use ivol\ConfigurablePhpUnitTest;
use ivol\Model\AssertDescriptionFactory;

class PhpUnitXmlLoader implements \PHPUnit_Runner_TestSuiteLoader
{
    /** @var AssertDescriptionFactory */
    private $factory;

    public function __construct()
    {
        $this->setFactory(new AssertDescriptionFactory());
    }


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
        if (!file_exists($suiteClassFile)) {
            throw new RuntimeException("Cannot read xml $suiteClassFile");
        }
        $suiteClassName = \ivol\ConfigurablePhpUnitTest::__CLASS;
        $suiteClass = new \ReflectionClass($suiteClassName);
        $asserts = $this->factory->createFromXml(file_get_contents($suiteClassFile));
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

    /**
     * @param AssertDescriptionFactory $factory
     */
    public function setFactory(AssertDescriptionFactory $factory)
    {
        $this->factory = $factory;
    }
}