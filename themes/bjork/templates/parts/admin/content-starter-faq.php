<?php
/**
 * Starter content: FAQ page.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_admin() ) {
	return;
}

?>

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"h4"} -->
<h2 class="h4"><strong>Lorem ipsum dolor sit amet adipiscing?</strong></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"dropCap":true} -->
<p class="has-drop-cap">Lorem ipsum dolor sit amet consectetur adipiscing elit vehicula ad morbi nunc viverra, aenean duis nascetur at lacus conubia tincidunt curae volutpat pellentesque orci.  Semper nullam pellentesque curae quisque massa aptent suspendisse. Auctor aliquet accumsan conubia, morbi dui. </p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"h4"} -->
<h2 class="h4"><strong>Natoque euismod netus eu tincidunt?</strong></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"dropCap":true} -->
<p class="has-drop-cap">Dolor sit amet consectetur adipiscing elit vehicula ad morbi nunc viverra, aenean duis nascetur at lacus conubia tincidunt curae volutpat pellentesque orci.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet consectetur adipiscing elit fames, placerat maecenas gravida natoque euismod netus eu tincidunt, faucibus ante massa potenti pretium iaculis tristique.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"h4"} -->
<h2 class="h4"><strong>Dolor sit amet adipiscing?</strong></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"dropCap":true} -->
<p class="has-drop-cap">Sit amet consectetur adipiscing elit primis egestas, semper nullam pellentesque curae quisque massa aptent suspendisse. Auctor aliquet accumsan conubia, morbi dui ad morbi nunc viverra, aenean duis nascetur at lacus conubia tincidunt curae volutpat pellentesque orci.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":150} -->
<div style="height:150px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:cover {"url":"<?php echo esc_url_raw( get_theme_file_uri( 'assets/images/starter/landscape.jpg' ) ); ?>","hasParallax":true,"minHeight":653,"align":"full"} -->
<div class="wp-block-cover alignfull has-background-dim has-parallax" style="background-image:url(<?php echo esc_url_raw( get_theme_file_uri( 'assets/images/starter/landscape.jpg' ) ); ?>);min-height:653px"><div class="wp-block-cover__inner-container"><!-- wp:media-text {"mediaType":"image","isStackedOnMobile":true} -->
<div class="wp-block-media-text alignwide is-stacked-on-mobile"><figure class="wp-block-media-text__media"><img src="<?php echo esc_url_raw( get_theme_file_uri( 'assets/images/starter/dots-white.png' ) ); ?>" alt="Lorem ipsum" /></figure><div class="wp-block-media-text__content"><!-- wp:heading {"textColor":"color-accent-text"} -->
<h2 class="has-color-accent-text-color has-text-color">Lorem ipsum dolor</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"normal"} -->
<p class="has-normal-font-size">Lorem ipsum dolor sit amet consectetur adipiscing elit dis varius id per, gravida dictum condimentum vestibulum commodo facilisis felis ut sed.</p>
<!-- /wp:paragraph -->

<!-- wp:button {"className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link" href="#0">Lorem ipsum</a></div>
<!-- /wp:button --></div></div>
<!-- /wp:media-text --></div></div>
<!-- /wp:cover -->
