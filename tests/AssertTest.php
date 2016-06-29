<?php
namespace ivol;

use ivol\Common\PermissionFormatter;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    const SERVICE = 'http://google.com';

    public function testAssertResourceExistsPassOnFileExists()
    {
        Assert::assertResourceExists(__FILE__);
    }

    /**
     * @expectedException  \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertResourceExistsFailsOnFileNotFound()
    {
        Assert::assertResourceExists(__FILE__ . '1');
    }

    public function testAssertResourcePermissionsOnCorrectPermissions()
    {
        Assert::assertResourcePermissions(__FILE__, PermissionFormatter::getOctal(fileperms(__FILE__)));
    }

    /**
     * @expectedException  \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertResourcePermissionsOnInvalidPermissions()
    {
        Assert::assertResourcePermissions(__FILE__, PermissionFormatter::getOctal(fileperms(__FILE__) + 1));
    }

    /**
     * @expectedException  \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertResourcePermissionsOnWrongFile()
    {
        Assert::assertResourcePermissions(__FILE__ . 1, PermissionFormatter::getOctal(fileperms(__FILE__)));
    }

    public function testAssertServiceAvailableOnServiceExistsAndReturnsCorrectCode()
    {
        Assert::assertServiceAvailable(self::SERVICE);
    }

    /**
     * @expectedException  \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertServiceAvailableOnServiceExistsAndReturnsIncorrectCode()
    {
        Assert::assertServiceAvailable(self::SERVICE, 500);
    }

    /**
     * @expectedException  \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertServiceAvailableOnServiceDoesntExists()
    {
        Assert::assertServiceAvailable(self::SERVICE . '1', 500);
    }
}