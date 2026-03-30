<?php

namespace Onetoweb\Winstore;

use Onetoweb\Winstore\Endpoint\Endpoints;
use Onetoweb\Winstore\Model\ModelInterface;
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
    public const BASE_HREF = 'https://winstore-c.aca.nl/iposws/api/osd';
    
    /**
     * Methods.
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    
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
        return $this->request(self::METHOD_GET, $endpoint, null, $query);
    }
    
    /**
     * @param string $endpoint
     * @param ?ModelInterface $data = null
     * 
     * @return string|null
     */
    public function post(string $endpoint, ?ModelInterface $data = null, array $query = []): array
    {
        return $this->request(self::METHOD_POST, $endpoint, $data, $query);
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
                
                if (
                    is_numeric($value)
                    and (
                        str_starts_with($value, '0') === false
                        or $value === '0'
                    )
                ) {
                    
                    if (str_contains($value, '.')) {
                        $result[$key] = (float) $value;
                    } else {
                        $result[$key] = (int) $value;
                    }
                    
                } elseif ($value === 'true' || $value === 'false') {
                    $result[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } else {
                    
                    if (!empty($value)) {
                        $result[$key] = $value;
                    } else {
                        $result[$key] = null;
                    }
                }
            }
        }
        
        return $result;
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param ?ModelInterface $data = null
     * @param array $query = []
     * 
     * @return array
     */
    public function request(string $method, string $endpoint, ?ModelInterface $data = null, array $query = []): array
    {
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => true,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json'
            ],
            RequestOptions::AUTH => [
                $this->username,
                $this->password
            ],
            
        ];
        
        if (
            $method === self::METHOD_POST
            and $data !== null
        ) {
            
            $data->build();
            
            $options[RequestOptions::HEADERS]['Content-Type'] = 'application/xml';
            $options[RequestOptions::BODY] = (string) $data;
        }
        
        // get url
        $url = $this->getUrl($endpoint);
        
        if (count($query) > 0) {
            
            // build query string
            $queryString = '?'.str_replace('&', '?', http_build_query($query));
            
            // add query string to url
            $url .= $queryString;
        }
        
        // make request
        $response = (new GuzzleCLient())->request($method, $url, $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        $result = [];
        
        if (!empty($contents)) {
            
            if (str_starts_with($response->getHeaderLine('Content-Type'), 'application/xml')) {
                
                // get xml elements
                $xmlElements = new SimpleXMLElement($contents, LIBXML_NOERROR);
                
                foreach ($xmlElements as $xmlElement) {
                    $result[] = $this->readAttr($xmlElement);
                }
                
            } elseif (str_starts_with($response->getHeaderLine('Content-Type'), 'application/json')) {
                
                $result = json_decode($contents, true);
            }
        }
        
        return $result;
    }
}
