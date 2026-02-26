<?php

namespace Onetoweb\Winstore\Endpoint\Endpoints;

use Onetoweb\Winstore\Endpoint\AbstractEndpoint;
use DateTimeInterface;

/**
 * Article Endpoint.
 */
class Article extends AbstractEndpoint
{
    /**
     * @param DateTimeInterface $changedByDate
     * 
     * @return array
     */
    public function getChangedby(DateTimeInterface $changedByDate): array
    {
        return $this->client->get('GetArticleDataChangesByDate', [
            'date' => $changedByDate->format(DateTimeInterface::ATOM)
        ]);
    }
}
