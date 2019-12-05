<?php
namespace Carbon_Section_Builder\Renderer;

use Carbon_Section_Builder\Section\Base_Section;

/**
 * Base Section Renderer class 
 */
class Sections_Renderer implements Renderer {
	private $sections = [];

	public static function init( $type, $container_id = '' ) {
		$renderer = new Self;

		$raw_sections = carbon_get_the_post_meta( $type, $container_id );

		if ( !$raw_sections ) {
			return;
		}

		$renderer->set_sections( $raw_sections );

		return $renderer;
	}

	public function get_sections() {
		return $this->sections;
	}

	public function set_sections ( $raw_sections ) {
		foreach ( $raw_sections as $raw_section ) {
			$section = Base_Section::load( $raw_section[ '_type' ] );

			$this->add_section( $section, $raw_section );

			$section->renderer = $this;
		}
	}

	public function add_section( $section, $attrs ) {
		$this->sections[] = array(
			'section' => $section,
			'attrs' => $attrs,	
		);
	}
	
	public function render() {
		foreach ( $this->sections as $section ) {
			$section[ 'section' ]->render( $section[ 'attrs' ] );
		}
	}
}