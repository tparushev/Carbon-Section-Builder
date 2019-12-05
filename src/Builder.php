<?php
namespace Carbon_Section_Builder;

use Carbon_Fields\Field\Field;

/**
 * Base Section Builder class 
 */
class Builder {
	const VERSION = '0.1.0';

	public $container = null;

	public $layout = 'tabbed-vertical';

	public $sections = [];

	function __construct( $field_name, $name ) {
		$this->container = Field::make( 'complex', $field_name, $name )
			->setup_labels( array(
				'singular_name' => __( 'Section', 'crb_builder' ),
				'plural_name' => __( 'Sections', 'crb_builder' ),
			) )
			->set_layout( $this->layout );
	}

	public function add_section( $section ) {
		$this->sections[] = $section;

		return $this;
	}

	public function load() {
		foreach ( $this->sections as $section ) {
			$this->container->add_fields( $section->id, $section->name, $section->fields() );
		}

		return $this->container;
	}

	public static function make( $field_name, $name ) {
		return ( new self( $field_name, $name ) );
	}
}