<?php
namespace ivol;

use ivol\Constraint\ResourceExistsConstraint;
use ivol\Constraint\ResourcePermissionsConstraint;
use ivol\Constraint\ServiceAvailableConstraint;

abstract class Assert
{
    /**
     * Check that passed uri exists.
     * @see http://php.net/manual/en/wrappers.php
     * @see http://php.net/manual/en/function.file-exists.php
     *
     * @param string $resourceURI Can be directory/file/url path
     */
    public static function assertResourceExists($resourceURI, $message = "")
    {
        \PHPUnit_Framework_Assert::assertThat($resourceURI, new ResourceExistsConstraint(), $message);
    }

    /**
     * Check permissions of resource.
     *
     * @param string $resourceURI Can be directory/file/url path
     * @param string $expectedPermissions Permissions in unix form like 0444
     */
    public static function assertResourcePermissions($resourceURI, $expectedPermissions, $message = "")
    {
        self::assertResourceExists($resourceURI);
        \PHPUnit_Framework_Assert::assertThat($expectedPermissions, new ResourcePermissionsConstraint($resourceURI), $message);
    }

    /**
     * Sends GET request to url and check return code
     *
     * @param string $url
     * @param int $expectedReturnCode
     */
    public static function assertServiceAvailable($url, $expectedReturnCode = 200, $message = "")
    {
        \PHPUnit_Framework_Assert::assertThat($expectedReturnCode, new ServiceAvailableConstraint($url), $message);
    }
}