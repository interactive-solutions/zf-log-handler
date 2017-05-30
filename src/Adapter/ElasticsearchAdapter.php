<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Adapter;

use Elastica\Client;
use Elastica\Document;
use InteractiveSolutions\LogHandler\Options\ElasticsearchOptions;

final class ElasticsearchAdapter extends AbstractAdapter
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ElasticsearchOptions
     */
    private $options;

    /**
     * @param Client $client
     * @param ElasticsearchOptions $options
     */
    public function __construct(Client $client, ElasticsearchOptions $options)
    {
        $this->client  = $client;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data, string $type = null): bool
    {
        $index = $this->client->getIndex(sprintf('%s-%s', $this->options->getPrefix(), date('Y-m-d')));
        $type  = $index->getType($type);

        $document = new Document();
        $document->setData($data);

        $type->addDocument($document);

        return true;
    }
}
