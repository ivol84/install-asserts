<?php
namespace ivol\Model;

class AssertDescriptionFactory
{
    /**
     * @param array $assert array('assertName' => array($assertParam1, $assertParam2, ..)
     * @return AssertDescription
     */
    public function create($assert)
    {
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

    /**
     * @param string $xml @see tests/Data/example.xml for format
     * @return AssertDescription[]
     */
    public function createFromXml($xml)
    {
        $asserts = [];
        $assertsXml = new \SimpleXMLElement($xml);
        if (!$assertsXml->assert) {
            return $asserts;
        }
        foreach ($assertsXml->assert as $assert) {
            if (!$assert->name) {
                // XXX: Add proper exception here
                throw new \RuntimeException("Cannot parse xml element");
            }
            $assertParams = $assert->params->param ? (array) $assert->params->param: [];
            $asserts[] = $this->create(array((string) $assert->name => $assertParams));
        }
        return $asserts;
    }
}