<?php
namespace Modules;

use Timber;

// Example usage
	// $args = [
	// 'heading' => get_field('heading'),
	// 'description' => get_field('description'),
	// 'button_url' => get_field('button_url'),
	// 'button_label' => get_field('button_label'),
	// ];
	// $new_module = new CTA($args);
	// $new_module->render();

class CTA {
	protected $defaults;
	protected $context;

	/**
	 * CTA constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$this->defaults = array(
			'heading'      => false,
			'description'  => false,
			'button_url'   => false,
			'button_label' => false,
			'classes'      => array(
				'l-module',
				'cta',
			),
		);

		extract( array_merge( $this->defaults, $args ) );

		$this->context                 = Timber::get_context();
		$this->context['heading']      = $heading;
		$this->context['description']  = $description;
		$this->context['button_url']   = $button_url;
		$this->context['button_label'] = $button_label;
		$this->context['classes']      = implode( ' ', $classes );

	}

	/**
	 * Render the component's twig file via Timber with current context.
	 */
	public function render() {
		Timber::render( 'cta.twig', $this->context );
	}

}
