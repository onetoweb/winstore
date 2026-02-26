<?php

namespace Onetoweb\Winstore\Endpoint\Endpoints;

use Onetoweb\Winstore\Endpoint\AbstractEndpoint;
use DateTimeInterface;

/**
 * Stock Endpoint.
 */
class Stock extends AbstractEndpoint
{
    /**
     * @param int $artikelKey
     * 
     * @return array
     */
    public function getByArtikelKey(int $artikelKey): array
    {
        return $this->client->get('GetStock', [
            'type' => 'byArtikelKey',
            'artkey' => $artikelKey
        ]);
    }
    
    /**
     * @param string $gtin
     * 
     * @return array
     */
    public function getByGtin(string $gtin): array
    {
        return $this->client->get('GetStock', [
            'type' => 'byGtin',
            'gtin' => $gtin
        ]);
    }
    
    /**
     * @param DateTimeInterface $changedByDate
     * 
     * @return array
     */
    public function getChangedBy(DateTimeInterface $changedByDate): array
    {
        return $this->client->get('GetChangedStock', [
            'date' => $changedByDate->format(DateTimeInterface::ATOM)
        ]);
    }
    
    /**
     * @param DateTimeInterface $changedByDate
     * 
     * @return array
     */
    public function getChangedByWithWarehouse(DateTimeInterface $changedByDate): array
    {
        return $this->client->get('GetChangedStockWithWarehouse', [
            'date' => $changedByDate->format(DateTimeInterface::ATOM),
            'outOfStock' => 1
        ]);
    }
    
}
