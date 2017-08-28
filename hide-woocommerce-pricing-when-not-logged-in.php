<?php
/**
 * Script to Hide Woocommerce pricing when not logged in
 *
 * Small script to show extra fields in the Woocommerce / wordpress registration form
 * how to use : Just add to snippets and it works, activate on frontend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @helpfrom   https://www.cloudways.com/blog/add-woocommerce-registration-form-fields/
 * @file       hide-woocommerce-pricing-when-not-logged-in.php
 */ 
 
 
// Hide prices
add_action('after_setup_theme','activate_filter') ; 
function activate_filter(){
	add_filter('woocommerce_get_price_html', 'show_price_logged');
}

function show_price_logged($price){
	if(is_user_logged_in() ){
    	return $price;
    }else{
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		return '<a href="' . get_permalink(woocommerce_get_page_id('myaccount')) . '">Login of registreer</a>';
	}
}