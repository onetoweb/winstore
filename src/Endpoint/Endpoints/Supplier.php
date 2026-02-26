<?php

namespace Onetoweb\Winstore\Endpoint\Endpoints;

use Onetoweb\Winstore\Endpoint\AbstractEndpoint;
use SimpleXMLElement;
use DOMDocument;
use DOMNode;


/**
 * Supplier Endpoint.
 */
class Supplier extends AbstractEndpoint
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->client->get('GetSuppliers');
    }
    
    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function articles(int $id): ?array
    {
        return $this->client->get('GetArticleDataBySupplierId', [
            'id' => $id
        ]);
    }
}
