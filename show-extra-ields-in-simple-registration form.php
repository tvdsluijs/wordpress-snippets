<?php
/**
 * Script to Show Extra fields in simple registration form
 *
 * Small script to show extra fields in the Woocommerce / wordpress registration form
 * how to use : Just add to snippets and it works, activate on frontend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @helpfrom   https://www.cloudways.com/blog/add-woocommerce-registration-form-fields/
 * @file       show-extra-ields-in-simple-registration form.php
 */ 


function wooc_extra_register_fields() {
  
//Company NAME
echo "<p class='form-row form-row-wide'>";
echo "<label for='reg_billing_company_field'>";
_e( 'Company name', 'woocommerce' );
echo "<span class='required'>*</span>";
echo "</label>";
$field = ( ! empty( $_POST['billing_company'] ) ) ? esc_attr_e( $_POST['billing_company'] ) : "";
echo "<input type='text' class='input-text' name='billing_company' id='reg_billing_company_field' value='{$field}' />";
echo "</p>";

//FIRST NAME
echo "<p class='form-row form-row-wide'>";
echo "<label for='reg_billing_first_name'>";
_e( 'First name', 'woocommerce' );
echo "<span class='required'>*</span>";
echo "</label>";
$field = ( ! empty( $_POST['billing_first_name'] ) ) ? esc_attr_e( $_POST['billing_first_name'] ) : "";
echo "<input type='text' class='input-text' name='billing_first_name' id='reg_billing_first_name' value='{$field}' />";
echo "</p>";

// LAST NAME
echo "<p class='form-row form-row-wide'>";
echo "<label for='reg_billing_last_name'>";
_e( 'Last name', 'woocommerce' );
echo "<span class='required'>*</span>";
echo "</label>";
$field = ( ! empty( $_POST['billing_last_name'] ) ) ? esc_attr_e( $_POST['billing_last_name'] ) : "";
echo "<input type='text' class='input-text' name='billing_last_name' id='reg_billing_last_name' value='{$field}' />";
echo "</p>";

//TELEPHONE
echo "<p class='form-row form-row-wide'>";
echo "<label for='reg_billing_phone'>";
_e( 'Phone', 'woocommerce' );
echo "</label>";
$field = esc_attr_e( $_POST['billing_phone'] );
echo "<input type='text' class='input-text' name='billing_phone' id='reg_billing_phone' value='{$field}' />";
echo "</p>";

//Company Country
$countries_obj = new WC_Countries();
$countries = $countries_obj->__get('countries');

echo "<p class='form-row form-row-wide'>";
echo "<label for='reg_billing_country'>";
_e( 'Country', 'woocommerce' );
echo "<span class='required'>*</span>";
echo "</label>";
echo "<select class='country_select' name='billing_country' id='reg_billing_country'>";
foreach ($countries as $key => $value):
echo "<option value='{$key}'>{$value}</option>";
endforeach;
echo "</select>";
echo "</p>";
  
//BTW VAT NUMMER

$field = esc_attr_e( $_POST['vat_number'] );
woocommerce_form_field( 'vat_number', array(
        'type' => 'text',
        'class' => array( 'form-row form-row-wide') ,
	    'required' => true,
        'label' => __( 'BTW /VAT Nummer' ),
//        'placeholder'   => __( 'BTW Nummer' ),
    ), $field);


}
 add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );