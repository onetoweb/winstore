<?php

namespace Onetoweb\Winstore\Endpoint\Endpoints;

use Onetoweb\Winstore\Endpoint\AbstractEndpoint;
use Onetoweb\Winstore\Model\ModelInterface;
use DateTimeInterface;

/**
 * Order Endpoint.
 */
class Order extends AbstractEndpoint
{
    /**
     * @param array $data
     * 
     * @return array
     */
    public function postOrderWithStatusCode(ModelInterface $order): array
    {
        return $this->client->post('PostOrderWithStatusCode', $order);
    }
}
