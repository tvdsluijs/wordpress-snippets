<?php
/**
 * Script to save fields in registration form
 *
 * Small script to save the extra fields shown at registration
 * how to use : Just add to snippets and it works, activate on frontend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @file       save-fields-woocommerce-registration.php
 */ 


function wooc_save_extra_register_fields($customer_id)
{
    if (isset($_POST['billing_phone'])) {
        // Phone input filed which is used in WooCommerce
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }

    if (isset($_POST['billing_first_name'])) {
        // First name field which is by default
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
        // First name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (isset($_POST['billing_last_name'])) {
        // Last name field which is by default
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
        // Last name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }

	if (isset($_POST['billing_country'])) {
        // billing_country
        update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
  
	if (isset($_POST['billing_company'])) {
        // billing_company
        update_user_meta($customer_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
    }  
  
}

add_action('woocommerce_created_customer', 'wooc_save_extra_register_fields');