<?php
namespace ivol\Constraint;

class ResourceExistsConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @param string $resourceURI
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function matches($other)
    {
        return file_exists($other);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'is exists';
    }
}