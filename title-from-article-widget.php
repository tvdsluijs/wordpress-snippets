<?php
/**
 * Show special post titles
 *
 * Small script to show some article titels in a widget, works like : [getTitles category="2" orderby="date" order="DESC"]
 *
 * Runs on PHP version 7
 *
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @file       title-from-article-widget.php
 * @date       14/08/2017
 * @time       22:11
 */

function getPostTitles($arr) {
    extract( shortcode_atts( array(
        'category' => '2',
        'orderby' => 'date',
        'order' => 'DESC'
    ), $arr));


    $args = array(
        'category'         => $category,
        'orderby'          => $orderby,
        'order'            => $order,
    );


    $posts = get_posts($args);
    shuffle($posts);
    foreach($posts as $post){
        $url = get_permalink($post->ID);
        echo $post->post_title . " &nbsp;&nbsp;<a href='{$url}'>Lees meer...</a><br/>";
        break;
    }
}
add_shortcode('getTitles', 'getPostTitles');