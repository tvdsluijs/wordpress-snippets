<?php
/**
 * Script to keep new woocommerce user to auto login after registration
 * Can be used with -forwp-approve-user plugin
 *
 * how to use : Just add to snippets and it works, activate on frontend only
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @helpfrom   https://websavers.ca/using-wp-approve-user-plugin-with-woocommerce/
 * @file       stop-autologin-a-new-woocommerce-user.php
 */ 
 
function user_autologout(){
       if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                $user_id = $current_user->ID;
 
                $approved_status = get_user_meta($user_id, 'wp-approve-user', true);
//if the user hasn't been approved yet by WP Approve User plugin, destroy the cookie to kill the session and log them out 
    
    if ( $approved_status == 1 ){ 
      return $redirect_url;
    }
                else{
      wp_logout();
                        return get_permalink(woocommerce_get_page_id('myaccount')) . "?approved=false";
                }
        }
}
add_action('woocommerce_registration_redirect', 'user_autologout', 2);
 
function registration_message(){
        $not_approved_message = '<p class="registration">Send in your registration application today! NOTE: Your account will be held for moderation and you will be unable to login until it is approved.</p>';
 
        if( isset($_REQUEST['approved']) ){
                $approved = $_REQUEST['approved'];
                if ($approved == 'false')  echo '<p class="registration successful">Registration successful! You will be notified upon approval of your account.</p>';
                else echo $not_approved_message;
        }
        else echo $not_approved_message;
}
add_action('woocommerce_before_customer_login_form', 'registration_message', 2);