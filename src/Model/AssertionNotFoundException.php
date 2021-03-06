<?php
namespace ivol\Model;

use Exception;

class AssertionNotFoundException extends \PHPUnit_Framework_Exception
{
    private $exceptionMessage = 'Cannot find assertation';

    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct($this->exceptionMessage, $code, $previous);
    }
}