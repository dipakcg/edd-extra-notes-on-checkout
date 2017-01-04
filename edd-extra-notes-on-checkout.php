<?php
/*
Plugin Name: Easy Digital Downloads - Extra note(s) On Checkout
Plugin URI: https://github.com/dipakcg/edd-extra-notes-on-checkout
Description: Adds 'Extra note(s)' textarea to the checkout screen for buyers to add notes about their order, in Easy Digital Downloads.
Version: 1.1
Author: Dipak C. Gajjar
Author URI: https://dipakgajjar.com
License: GPLv2 or later
*/

// Output extra note(s) HTML on checkout
function dcg_edd_output_extra_notes() {
?>
    <p>
        <label class="edd-label" for="edd-message"><?php _e('Extra note(s)', 'edd'); ?></label>
        <span class="edd-description">Anything you feel we need to know.</span>
        <textarea class="edd-input" name="edd_extra_note" id="edd-extra-note"></textarea>
    </p>
<?php
}
add_action( 'edd_purchase_form_user_info_fields', 'dcg_edd_output_extra_notes' );

// Store extra notes(s) data in the payment meta
function dcg_edd_store_extra_notes( $payment_meta ) {
    $payment_meta['extra_note'] = isset($_POST['edd_extra_note']) ? $_POST['edd_extra_note'] : '';
    return $payment_meta;
}
add_filter('edd_payment_meta', 'dcg_edd_store_extra_notes');

// Add {extra_note} tag to use in either the purchase receipt email or admin notification emails
if ( function_exists( 'edd_add_email_tag' ) ) {
    edd_add_email_tag( 'extra_note', 'Extra note(s) submitted during checkout.', 'dcg_edd_email_tag_extra_notes' );
}
// {extra_note} email tag
function dcg_edd_email_tag_extra_notes( $payment_id ) {
    $payment_data = edd_get_payment_meta( $payment_id );
    return $payment_data['extra_note'];
}
?>
