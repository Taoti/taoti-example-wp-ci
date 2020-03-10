<?php
namespace Modules;

use Timber;

// Use this module as an example to set up more modules.

class Example {
	protected $defaults;
	protected $context;

	public function __construct( $args = array() ) {
		$this->defaults = array(
			'option1' => false,
			'option2' => false,
		);

		extract( array_merge( $this->defaults, $args ) );

		$this->context            = Timber::get_context();
		$this->context['option1'] = $option1;
		$this->context['option2'] = $option2;
	}

	public function render() {
		Timber::render( 'example.twig', $this->context );
	}
}
