<?php

namespace Onetoweb\Winstore;

use Onetoweb\Winstore\Endpoint\Endpoints;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use SimpleXMLElement;

/**
 * Winstore Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * Base href
     */
    public const BASE_HREF = 'https://winstore-c.aca.nl/iposws/api/osd/';
    
    /**
     * Methods.
     */
    public const METHOD_GET = 'GET';
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @param string $endpoint
     * 
     * @return string
     */
    public function getUrl(string $endpoint): string
    {
        return self::BASE_HREF . '/' . ltrim($endpoint, '/');
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return string|null
     */
    public function get(string $endpoint, array $query = []): array
    {
        return $this->request(self::METHOD_GET, $endpoint, [], $query);
    }
    
    /**
     * @param SimpleXMLElement $xmlElement
     * 
     * @return array
     */
    private function readAttr(SimpleXMLElement $xmlElement): array
    {
        $result = [];
        
        foreach ($xmlElement as $key => $value) {
            
            if ($value->count() > 0) {
                
                foreach ($value as $child) {
                    $result[$key][] = $this->readAttr($child);
                }
                
            } else {
                
                $value = (string) $value;
                
                if (is_numeric($value)) {
                    $result[$key] = (int) $value;
                } elseif ($value === 'true' || $value === 'false') {
                    $result[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } else {
                    $result[$key] = $value;
                }
            }
        }
        
        return $result;
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * 
     * @return array
     */
    public function request(string $method, string $endpoint, array $data = [], array $query = []): array
    {
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => true,
            RequestOptions::HEADERS => [],
            RequestOptions::AUTH => [
                $this->username,
                $this->password
            ],
            RequestOptions::QUERY => $query,
        ];
        
        // make request
        $response = (new GuzzleCLient())->request($method, $this->getUrl($endpoint), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        $result = [];
        if (!empty($contents)) {
            
            // get xml elements
            $xmlElements = new SimpleXMLElement($contents, LIBXML_NOERROR);
            
            foreach ($xmlElements as $xmlElement) {
                $result[] = $this->readAttr($xmlElement);
            }
        }
        
        return $result;
    }
}
