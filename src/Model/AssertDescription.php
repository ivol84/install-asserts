<?php
namespace ivol\Model;

class AssertDescription
{
    /** @var string */
    private $assertClass;
    /** @var string */
    private $assertMethod;
    /** @var array */
    private $assertParams;

    /**
     * @param string $assertClass
     * @param string $assertMethod
     * @param array $assertParams
     */
    public function __construct($assertClass, $assertMethod, $assertParams)
    {
        $this->assertClass = $assertClass;
        $this->assertMethod = $assertMethod;
        $this->assertParams = $assertParams;
    }

    /**
     * @return string
     */
    public function getAssertClass()
    {
        return $this->assertClass;
    }

    /**
     * @return string
     */
    public function getAssertMethod()
    {
        return $this->assertMethod;
    }

    /**
     * @return string
     */
    public function getAssertParams()
    {
        return $this->assertParams;
    }
}