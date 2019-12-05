<?php
namespace Carbon_Section_Builder\Section;

interface Section {
	public function render( $atts );

	static public function make();
} 