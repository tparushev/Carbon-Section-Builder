<?php
namespace Carbon_Section_Builder\Section;

class Base_Section implements Section {
	public $id = '';
	public $name = '';
	public $renderer = '';
	private $view_dir = '';

	function __construct() {
		$this->set_name();
		$this->id = self::encode_namespace();
		$this->set_view_dir();
	}

	public function before_render() {}

	static public function get_section_namespace() {
		return get_called_class();
	}

	private function set_view_dir() {
		$this->view_dir = $this->get_view_dir();
	}

	public function get_view_dir() {
		$reflection = new \ReflectionClass( self::decode_namespace( $this->id ) );

		return dirname( $reflection->getFileName() ) . DIRECTORY_SEPARATOR;
	}

	public function get_view_file_name() {
		$file_name = 'view.php';

		if ( 
			function_exists( 'is_amp_endpoint' ) && 
			is_amp_endpoint() && 
			file_exists( $this->view_dir . 'amp-view.php' ) 
		) {
			$file_name = 'amp-view.php';
		}

		return $file_name;
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
		$this->before_render();
		
		extract( $atts );

		include( $this->view_dir . $this->get_view_file_name() );
	}

	public function render_fragment( $fragment, $atts = array() ) {
		$fragment_dir = $this->view_dir . "fragments" . DIRECTORY_SEPARATOR . $fragment . ".php";

		if ( ! is_readable( $fragment_dir ) ) {
			return;
		}

		extract( $atts );

		include( $fragment_dir );
	}

	static public function encode_namespace() {
		$namespace = str_replace( '\\', '__', self::get_section_namespace() ) ;

		return preg_replace_callback( '/([A-Z])/', function ( $matches ) {
			return '-' . strtolower( $matches[ 0 ] );
		}, $namespace );
	}

	static public function decode_namespace( $type ) {
		$namespace = str_replace( '__', '\\', $type ) ;

		return preg_replace_callback( '/(-[a-z])/', function ( $matches ) {
			return strtoupper( str_replace( '-', '', $matches[ 0 ] ) );
		}, $namespace );
	}

	public function change_name( $name ) {
		$this->name = $name;

		return $this;
	}
}
