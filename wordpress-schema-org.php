<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * Runs on PHP version 7
 *
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @file       wordpress-schema-org.php
 * @date       08/08/2017
 * @time       14:48
 */



function schema_org_markup() {
    $schema = 'http://schema.org/';
    // Is Woocommerce product
    if ( !function_exists(is_woocommerce) && is_woocommerce() && (!function_exists(is_product()) || !is_product() )) {
        if ( is_single() ) {
            $type = 'Article';
        }
        else {
            if ( is_page( 1 ) ) { // Identify your Contact page postID and edit numeric value is_page( foo)
                $type = 'ContactPage';
            } // Is author page
            elseif ( is_author() ) {
                $type = 'ProfilePage';
            } // Is search results page
            elseif ( is_search() ) {
                $type = 'SearchResultsPage';
            } // Is of movie post type
            elseif ( is_singular( 'movies' ) ) {
                $type = 'Movie';
            } // Is of book post type
            elseif ( is_singular( 'books' ) ) {
                $type = 'Book';
            }
            else {
                $type = 'WebPage';
            }
        }
    }
    echo "itemscope='itemscope' itemtype='{ $schema . $type}'";
}