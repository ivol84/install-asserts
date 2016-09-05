<?php

class PhpUnitXmlLoader implements PHPUnit_Runner_TestSuiteLoader
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
        $xml = new \Sabre\Xml\Service();
        $result  = $xml->parse($suiteClassFile);

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