<?php
namespace ivol\Constraint;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ServiceAvailableConstraint extends \PHPUnit_Framework_Constraint
{
    /** @var string */
    private $url;

    /** @var ResponseInterface */
    private $res = null;
    /**
     * @param string $url
     */
    public function __construct($url)
    {
        parent::__construct();
        $this->url = $url;
    }


    protected function matches($other)
    {
        $client = new Client();
        try {
            $this->res = $client->request('GET', $this->url);
        } catch (\Exception $e) {
            return false;
        }
        return $other == $this->res->getStatusCode();
    }


    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return $this->res ? "returns {$this->res->getStatusCode()}. Url: {$this->url}"  : "{$this->url} is unavailable";
    }
}