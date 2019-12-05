# Carbon-Section-Builder
Helpers for building section builder with Carbon Fields.


### Quick setup

Extend the Base_Section class with namespace to make your own sections. You can find examples in the `examples/` folder.

The extender section class must include fields method that is returning an array with Carbon_Field, and set_name method to set the section name. Example:

```
class Home_Intro extends Base_Section {
	public function set_name() {
		$this->name = __( 'Home Intro2', 'crb' );
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
```

The section builder is used in the  Carbon Fields Container as following:

```
use Carbon_Fields\Container\Container;
use Carbon_Section_Builder\Builder;
use Sections\Home_Intro\Home_Intro;
use Sections\Home_News\Home_News;

Container::make( 'post_meta', __( 'Page Sections' ,'text-domain' ) )
	->where( 'post_type', '=', 'page' )
	->add_fields( 
		array( Builder::make( 'crb_sections', __( 'Home Sections', 'text-domain' ) )
			->add_section( Home_Intro::make() )
			->add_section( Home_News::make() )
			->load() 
		)
	);
```

To render the sections in some template, use the Section_Renderer class or extend the Renderer interface. Example:

```
use Carbon_Section_Builder\Renderer\Sections_Renderer;

get_header();

Sections_Renderer::init( 'crb_sections' )->render();

get_footer();
```