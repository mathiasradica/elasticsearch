<?php
use Elasticsearch\Helper\Iterators\SearchResponseIterator;

require 'vendor/autoload.php';
require 'simplexml.php';

$client = Elasticsearch\ClientBuilder::create()->build();
ini_set('max_execution_time', 1200);
$response = [];
$searchTerm = "";
$pageSize = 25;
$pageIndex = 0;
$resultSetSize = 0;
$pageCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $searchTerm = $_POST['searchTerm'];

    if ($searchTerm === "") {

        echo "Search term is empty";

    } else {

        $response = $client->indices()->exists([
            'index' => 'fvbeuifwfhb_index',
        ]);

        if (!$response) {

            $indexParams = [

                'index' => 'fvbeuifwfhb_index',
                'body' => [
                    'settings' => [
                        'index.mapping.total_fields.limit' => 1000000,
                    ],
                    'mappings' => [
                        'properties' => [
                            'name' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'sku' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'status' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'c4_status' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'm3_status' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'is_returnable' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'allow_purchase' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'allow_guest_purchase' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'allow_back_orders' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'manufacturer' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'c4_sysid' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'replaces' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'qty_increments' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'ean_number' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'updated_at' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'dangerous_goods' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'competitor_references' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'supplier' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            'visibility' => [
                                'type' => 'text',
                                'copy_to' => '_all',
                            ],
                            '_all' => [
                                'type' => 'text',
                            ],
                        ],
                    ],
                ],
            ];
            $client->indices()->create($indexParams);

            $arr = xml_to_array();

            $i = 1;

            foreach ($arr as $body) {

                $params = [

                    'index' => 'fvbeuifwfhb_index',
                    'id' => $i,
                    'body' => $body,
                ];

                $client->index($params);
                $i++;
            }
        }

        $search_params = [
            'index' => 'fvbeuifwfhb_index',
            'size' => $pageSize,
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => $searchTerm,
                    ],
                ],
            ],
        ];

        $response = $client->search($search_params);
        $resultSetSize = $response['hits']['total']['value'];
        $pageCount = $resultSetSize % $pageSize == 0 ? $resultSetSize / $pageSize : (int) ($resultSetSize / $pageSize) + 1;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && count($_GET) == 2 && array_key_exists('pageIndex', $_GET) && array_key_exists('searchTerm', $_GET) && is_numeric($_GET['pageIndex']) && $_GET['searchTerm'] !== "") {

    $pageIndex =  $_GET['pageIndex'];
    $searchTerm = $_GET['searchTerm'];

        $search_params = [
            'index' => 'fvbeuifwfhb_index',
            'from' => $pageIndex * $pageSize,
            'size' => $pageSize,
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => $searchTerm,
                    ],
                ],
            ],
        ];

        $response = $client->search($search_params);
        $resultSetSize = $response['hits']['total']['value'];
        $pageCount = $resultSetSize % $pageSize == 0 ? $resultSetSize / $pageSize : (int) ($resultSetSize / $pageSize) + 1;
}
?>