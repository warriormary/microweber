<?php

namespace Microweber\ContentSchema\Processors;


class ModuleContentSchemaProcessor
{

    /** @var \Microweber\Application */
    public $app;

    public function __construct($app = null)
    {
        $this->app = $app;
    }

    public function process($layout, $module = array(), $params = array())
    {

        $itemprop_id_inc = 0;
        $itemprop_id_prefix = '';

        if (isset($params['id'])) {
            $itemprop_id_prefix = $params['id'] . '-';

        }

        if (isset($params['itemprop_parent_prefix'])) {
            $itemprop_id_prefix = $params['itemprop_parent_prefix'];
        }
        if (isset($params['itemprop_parent_prefix_inc'])) {
            $itemprop_id_inc = $params['itemprop_parent_prefix_inc'];
        }

        if (isset($params['__parser_pq_doc'])) {
            $pq = $params['__parser_pq_doc'];
        } else {
            $pq = \phpQuery::newDocument($layout);
            \phpQuery::selectDocument($pq);
        }


        $doc_scope = $pq->filter(':has(itemscope)')->nextAll()->andSelf();
        if ($doc_scope) {
            foreach ($pq->children('[itemscope]') as $elem) {
                $default_itemtype = '';

                $itemtype = pq($elem)->attr('itemtype');
                $is_multiple = pq($elem)->attr('multiple');

                if ($itemtype) {
                    foreach ($pq->find('[itemprop]') as $elem_itemprop) {

                        $elem_itemprop_value = $elem_itemprop->getAttribute('itemprop');
                        $elem_itemprop_id = $elem_itemprop->getAttribute('itempropid');
                        if ($elem_itemprop_value and !$elem_itemprop_id) {
                            $itemprop_id_inc++;


                            $elem_itemprop->setAttribute('itempropid', $itemprop_id_prefix . $itemprop_id_inc);


                            $elem_clone = $elem_itemprop->cloneNode();
                            //  dd(pq($elem_itemprop)->htmlOuter());
                            foreach (pq($elem_itemprop)->children('[itemscope]') as $elem_clone_recursive) {
                                $layout_inner = pq($elem_clone)->htmlOuter();
                                //dd($layout_inner);
                                //$params['itemprop_parent_prefix'] = $itemprop_id_prefix.$elem_itemprop_value.'-';
                                $params['itemprop_parent_prefix'] = $itemprop_id_prefix.$elem_itemprop_value.'-';
                                $params['itemprop_parent_prefix_inc'] = $itemprop_id_inc;
                                $params['__parser_pq_doc'] = $pq;
                                $layout_inner = $this->process($layout_inner, $module, $params);
                                pq($elem_clone_recursive)->replaceWith($layout_inner);

                            }



                            //   }
                        }
                    }

                }
            }
            $layout = $pq->htmlOuter();
        }
        return $layout;
    }


   

}