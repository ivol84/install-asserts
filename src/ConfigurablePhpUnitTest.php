<?php
namespace ivol;

class ConfigurablePhpUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array('assert1'=>array(param1, ..), 'assert2'=>array(..))
     */
    private $asserts = [];

    public function testSystemConfiguration()
    {
        foreach ($this->asserts as $assert) {
            $assertClass = '';
            $methods = array_keys($assert);
            $assertMethod = $methods[0];
            $assertParams = $assert[$assertMethod];
            $classAndMethod = preg_split('/::/', $assertMethod);
            if (count($classAndMethod) == 2 && is_callable($classAndMethod[0], $classAndMethod[1])) {
                $assertClass = $classAndMethod[0];
                $assertMethod = $classAndMethod[1];
            } elseif (is_callable(array('\PHPUnit_Framework_Assert', $assertMethod))) {
                $assertClass = '\PHPUnit_Framework_Assert';
            } elseif (is_callable('ivol\Assert', $assertMethod)) {
                $assertClass = 'ivol\Assert';
            } else {
                $this->fail('Cannot find correct assert');
            }
            call_user_func_array(array($assertClass, $assertMethod), $assertParams);
        }
    }

    public function addAssert($assert)
    {
        $this->asserts[] = $assert;
    }
}