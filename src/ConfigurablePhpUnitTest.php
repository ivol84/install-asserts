<?php
namespace ivol;

class ConfigurablePhpUnitTest extends \PHPUnit_Framework_TestCase
{
    const __CLASS = __CLASS__;
    /**
     * @var array('assert1'=>array(param1, ..), 'assert2'=>array(..))
     */
    private static $asserts = [];

    public function testSystemConfiguration()
    {
        foreach (self::$asserts as $assert) {
            $assertClass = '';
            $methods = array_keys($assert);
            $assertMethod = array_pop($methods);
            $assertParams = $assert[$assertMethod];
            $classAndMethod = preg_split('/::/', $assertMethod);
            if (count($classAndMethod) == 2 && is_callable($classAndMethod[0], $classAndMethod[1])) {
                $assertClass = $classAndMethod[0];
                $assertMethod = $classAndMethod[1];
            } elseif (is_callable(array('\PHPUnit_Framework_Assert', $assertMethod))) {
                $assertClass = '\PHPUnit_Framework_Assert';
            } elseif (is_callable(array('ivol\Assert', $assertMethod))) {
                $assertClass = 'ivol\Assert';
            } else {
                $this->fail('Cannot find correct assert');
            }
            call_user_func_array(array($assertClass, $assertMethod), $assertParams);
        }
    }

    public static function addAssert($assert)
    {
        array_push(self::$asserts, $assert);
    }

    public static function clearAsserts()
    {
        self::$asserts = [];
    }
}