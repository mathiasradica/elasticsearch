<?php

function xml_to_array($dir = __DIR__ . '/maskin_ib_xml_2021/') {

    $arr = [];

    foreach (scandir($dir) as $file) {

            if (pathinfo($dir . $file, PATHINFO_EXTENSION) == 'xml' && substr($file, 0, 5) == 'item_') {
                
                $body = [];
    
                $xml = simplexml_load_file($dir . $file);
            
                foreach ($xml->product as $product) {
    
                    $body = [
                        'sku' => (string) $product->sku,
                        'name' => (string) $product->name,
                        'status' => (string) $product->attributes[0]->status,
                        'c4_status' => (string) $product->attributes[0]->c4_status,
                        'm3_status' => (string) $product->attributes[0]->m3_status,
                        'is_returnable' => (string) $product->attributes[0]->is_returnable,
                        'allow_purchase' => (string) $product->attributes[0]->allow_purchase,
                        'allow_guest_purchase' => (string) $product->attributes[0]->allow_guest_purchase,
                        'allow_back_orders' => (string) $product->attributes[0]->allow_back_orders,
                        'manufacturer' => (string) $product->attributes[0]->manufacturer,
                        'c4_sysid' => (string) $product->attributes[0]->c4_sysid,
                        'replaces' => (string) $product->attributes[0]->replaces,
                        'qty_increments' => (string) $product->attributes[0]->qty_increments,
                        'ean_number' => (string) $product->attributes[0]->ean_number,
                        'updated_at' => (string) $product->attributes[0]->updated_at,
                        'dangerous_goods' => (string) $product->attributes[0]->dangerous_goods,
                        'competitor_references' => (string) $product->attributes[0]->competitor_references,
                        'supplier' => (string) $product->attributes[0]->supplier,
                        'visibility' => (string) $product->attributes[0]->visibility,
                    ];

                    $arr[] = $body;
                }
            }
        }

    return $arr;
}

