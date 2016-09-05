<?php
namespace ivol\tests\Helper;

class CustomAssert
{
    const __CLASS = __CLASS__;
    public static $isCalled = false;

    public static function assertInCustomClass()
    {
        self::$isCalled = true;
        return true;
    }
}