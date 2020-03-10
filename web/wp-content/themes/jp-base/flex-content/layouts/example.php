<?php
// Most layouts will retrieve the field values with get_sub_field() and feed those as arguments to one of the modules, then render the module.

use Modules\Example;

$args           = array(
	'args_will_go_here' => get_sub_field( 'sub_field_name' ),
);
$example_object = new Example( $args );
$example_object->render();
