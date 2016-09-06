<?php

namespace ivol\Model;

use Exception;

class XmlNotFoundException extends \PHPUnit_Framework_Exception
{
    private $xmlNotFound = 'Cannot read xml %s';

    public function __construct($filename = "", $code = 0, Exception $previous = null)
    {
        parent::__construct(sprintf($this->xmlNotFound, $filename), $code, $previous);
    }

}