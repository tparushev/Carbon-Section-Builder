<?php
namespace Sections\Home_News;

use Carbon_Section_Builder\Section\Base_Section;
use Carbon_Fields\Field\Field;

/**
 * Test Home News Section
 */

class Home_News extends Base_Section {
	public function set_name() {
		$this->name = __( 'Home News', 'crb' );
	}
	
	public function fields() {
		return array(
			Field::make( 'rich_text', 'content', __( 'Content', 'crb' ) ),
		);
	}
}