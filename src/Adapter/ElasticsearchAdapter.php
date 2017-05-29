<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ErrorHandler\Adapter;

use Elastica\Client;
use Elastica\Document;

final class ElasticsearchAdapter extends AbstractAdapter
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function write(array $data): bool
    {
        // Make index configurable
        $index = $this->client->getIndex(sprintf('error-%s', date('Y-m-d')));
        $type  = $index->getType('errors');

        $document = new Document();
        $document->setData($data);

        $type->addDocument($document);
    }
}
