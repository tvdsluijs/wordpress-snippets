<?php
/**
 * Show VAT field in user profile
 *
 * Small script to show vat field within userprofile on the backend
 * how to use : Just add to snippets and it works, activate on backend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @file       show_vat_field_user_profile_backend.php
 */ 
 

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) {
$str = "	<h3>Extra informatie</h3>";
$str .= "	<table class='form-table'>";
$str .= "		<tr>";
$str .= "			<th><label for='vat_number'>VAT</label></th>";
$str .= "			<td>";
$vat_number = esc_attr( get_the_author_meta( 'vat_number', $user->ID ) );
$str .= "				<input type='text' name='vat_number' id='vat_number' value='{$vat_number}' class='regular-text' /><br />";
$str .= "				<span class='description'>BTW Nummer</span>";
$str .= "			</td>";
$str .= "		</tr>";
$str .= "</table>";

  echo $str;
}


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'vat_number' to the field ID. */
	update_usermeta( $user_id, 'vat_number', $_POST['vat_number'] );
}