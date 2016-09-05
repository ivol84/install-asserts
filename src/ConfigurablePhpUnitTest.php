<?php
namespace ivol;

use ivol\Model\AssertDescription;

class ConfigurablePhpUnitTest extends \PHPUnit_Framework_TestCase
{
    const __CLASS = __CLASS__;
    /**
     * @var AssertDescription[]
     */
    private static $asserts = [];

    public function testSystemConfiguration()
    {
        /** @var AssertDescription $assert */
        foreach (self::$asserts as $assert) {
            call_user_func_array(array($assert->getAssertClass(), $assert->getAssertMethod()), $assert->getAssertParams());
        }
    }

    /**
     * @param AssertDescription $assert
     */
    public static function addAssert(AssertDescription $assert)
    {
        self::$asserts[] = $assert;
    }

    public static function clearAsserts()
    {
        self::$asserts = [];
    }
}