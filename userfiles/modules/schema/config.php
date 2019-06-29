<?php

$config = array();
$config['name'] = "Schema";
$config['author'] = "Microweber";
$config['no_cache'] = true;
$config['ui_admin'] = 1;
$config['categories'] = "other";
$config['position'] = 123;
$config['version'] = 0.1;
$config['type'] = "schema_processor";
$config['tables'] = array(
    'content_schema' => [
        'parent_id' => 'integer',
        'itemscope' => 'string',
        'itemtype' => 'string',

        'rel_id' => 'string',
        'rel_type' => 'string',

        '$index' => ['rel_id', 'rel_type', 'parent_id', 'itemscope', 'itemtype'],
    ],

    'content_schema_data' => [
        'content_schema_id' => 'integer',
        'itemprop' => 'string',
        'content' => 'text',
    ],
);
