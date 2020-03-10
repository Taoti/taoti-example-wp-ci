<?php
use JP\Get;
### Callback functions for shortcodes.



// Display a phone number link.
function jp_phone_number(){
    return Get::phoneNumberLink();
}
add_shortcode( 'phone', 'jp_phone_number' );
