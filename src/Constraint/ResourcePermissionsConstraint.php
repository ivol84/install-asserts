<?php
namespace ivol\Constraint;

use ivol\Common\PermissionFormatter;

class ResourcePermissionsConstraint extends \PHPUnit_Framework_Constraint
{
    /** @var string */
    private $resourceURI;

    /**
     * @param string $resourceURI
     */
    public function __construct($resourceURI)
    {
        parent::__construct();
        $this->resourceURI = $resourceURI;
    }


    protected function matches($other)
    {
        return $other === $this->getOctalResourcePermissions();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "is {$this->getOctalResourcePermissions()}";
    }

    private function getOctalResourcePermissions()
    {
        return PermissionFormatter::getOctal(fileperms($this->resourceURI));
    }
}