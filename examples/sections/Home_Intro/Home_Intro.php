<?php
namespace Sections\Home_Intro;

use Carbon_Section_Builder\Section\Base_Section;
use Carbon_Fields\Field\Field;

/**
 * Test Home Intro Section
 */

class Home_Intro extends Base_Section {
	public function set_name() {
		$this->name = __( 'Home Intro', 'crb' );
	}
	
	public function fields() {
		return array(
			Field::make( 'file', 'first_image', __( 'Image', 'crb' ) )
				->set_width( 50 ),
			Field::make( 'file', 'second_image', __( 'Image', 'crb' ) )
				->set_width( 50 ),
			Field::make( 'rich_text', 'content', __( 'Content', 'crb' ) ),
		);
	}
}