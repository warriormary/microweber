<?php

require_once(__DIR__ . DS . 'vendor' . DS . 'autoload.php');


mw()->parser->register(function ($layout, $module, $params) {

    if ($module and isset($module['module_type']) and $module['module_type'] === 'schema') {
        $processor = new Microweber\ContentSchema\Processors\ModuleContentSchemaProcessor();
        return $processor->process($layout,$module, $params);
        // dd('',$module,$layout, $params);
    }
});
