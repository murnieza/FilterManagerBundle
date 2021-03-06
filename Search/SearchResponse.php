<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\FilterManagerBundle\Search;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\FilterManagerBundle\Filters\ViewData;
use ONGR\FilterManagerBundle\SerializableInterface;

/**
 * This class holds full response of documents and filters data.
 */
class SearchResponse implements SerializableInterface
{
    /**
     * @var DocumentIterator Elasticsearch response object.
     */
    private $result;

    /**
     * @var ViewData[] View data from filters.
     */
    private $filters;

    /**
     * @var array Url Parameters represents current link to list state.
     */
    private $urlParameters;

    /**
     * @param ViewData[]       $filters
     * @param DocumentIterator $result
     * @param array            $urlParameters
     */
    public function __construct($filters, $result, $urlParameters)
    {
        $this->filters = $filters;
        $this->result = $result;
        $this->urlParameters = $urlParameters;
    }

    /**
     * @return \ONGR\FilterManagerBundle\Filters\ViewData[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return DocumentIterator
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return array
     */
    public function getUrlParameters()
    {
        return $this->urlParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializableData()
    {
        $data = [
            'count' => $this->result->count(),
            'documents' => [],
            'filters' => [],
            'url_parameters' => $this->urlParameters,
        ];

        foreach ($this->result as $document) {
            if (!$document instanceof SerializableInterface) {
                throw new \LogicException(
                    'In order to serialize search response documents MUST implement ' .
                        '"ONGR\FilterManagerBundle\SerializableInterface" interface.'
                );
            }

            $data['documents'][] = $document->getSerializableData();
        }

        foreach ($this->filters as $name => $filter) {
            $data['filters'][$name] = $filter->getSerializableData();
        }

        return $data;
    }
}
