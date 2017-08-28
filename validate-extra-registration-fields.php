<?php
/**
 * Script to validate fields in registration form
 *
 * Small script to validate the extra fields shown at registration
 * how to use : Just add to snippets and it works, activate on frontend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @helpfrom   https://www.cloudways.com/blog/add-woocommerce-registration-form-fields/
 * @file       validate-extra-registration-fields.php
 */ 


function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {

	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: Voornaam is verplicht!', 'woocommerce' ));
	}

	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Achternaam is verplicht!', 'woocommerce' ));
	}
  
	if ( isset( $_POST['billing_country'] ) && empty( $_POST['billing_country'] ) ) {
		$validation_errors->add( 'billing_country', __( '<strong>Error</strong>: Land is verplicht!', 'woocommerce' ));
	} 
  
  //VAT NUMBER
	if ( isset( $_POST['vat_number'] ) && empty( $_POST['vat_number'] ) ) {
		$validation_errors->add( 'vat_number', __( '<strong>Error</strong>: BTW / VAT Nummer is verplicht!', 'woocommerce' ));
	}   
  
	return $validation_errors;
}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );