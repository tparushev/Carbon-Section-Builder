<?php
namespace Carbon_Section_Builder\Renderer;

/**
 * Renderer interface 
 */

interface Renderer {
	public function render();

	public function get_sections();
	
	public function set_sections();

	public static function init( $type, $container_id = '' );
}