<?php
namespace Carbon_Section_Builder\Section;

class Base_Section implements Section {
	public $id = '';
	public $name = '';
	public $view_dir = '';
	public $renderer = '';

	function __construct() {
		$this->set_name();
		$this->id = self::encode_namespace();

		$reflection = new \ReflectionClass( self::decode_namespace( $this->id ) );
		$this->view_dir = dirname( $reflection->getFileName() ) . DIRECTORY_SEPARATOR;
	}

	static public function make() {
		$class = self::get_section_namespace();

		if ( ! class_exists( $class ) ) {
			return;
		}

		$section = new $class();

		return $section;
	}

	static public function load( $type ) {
		$section_class = self::decode_namespace( $type );

		return new $section_class;
	}

	public function render( $atts ) {
		extract( $atts );

		include( $this->view_dir . 'view.php' );
	}

	static public function get_section_namespace() {
		return get_called_class();
	}

	static public function encode_namespace() {
		$namespace = str_replace( '\\', '__', self::get_section_namespace() ) ;

		return preg_replace_callback( '/([A-Z])/', function ( $matches ) {
			return '-' . strtolower( $matches[ 0 ] );
		}, $namespace );
	}

	static public function decode_namespace( $type ) {
		$namespace = str_replace( '__', DIRECTORY_SEPARATOR, $type ) ;

		return preg_replace_callback( '/(-[a-z])/', function ( $matches ) {
			return strtoupper( str_replace( '-', '', $matches[ 0 ] ) );
		}, $namespace );
	}
}