<?php
namespace ivol\Model;

class AssertFactory
{
    /**
     * @param $assert
     */
    public function create($assert)
    {
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
            // TODO: Add custom exception
            throw new \RuntimeException('Cannot build assertation');
        }
        return new AssertDescription($assertClass, $assertMethod, $assertParams);
    }
}