<?php
/**
 * Starter content: Pricing page.
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

<!-- wp:heading -->
<h2>Lorem ipsum dolor</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet consectetur adipiscing, elit nibh tempor sodales posuere, scelerisque curabitur senectus porttitor nullam. Eget rutrum ac pretium metus class, aptent nisi taciti vel auctor, sociis cras cursus laoreet.</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":150} -->
<div style="height:150px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {} -->
<div class="wp-block-columns"><!-- wp:column {"className":"has-background has-color-accent-background-color"} -->
<div class="wp-block-column has-background has-color-accent-background-color"><!-- wp:paragraph {"textColor":"color-accent-text","customFontSize":64,"className":"has-no-margin-vertical has-nowrap-white-space"} -->
<p style="font-size:64px" class="has-text-color has-color-accent-text-color has-no-margin-vertical has-nowrap-white-space">€<strong>19</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"color-accent-text"} -->
<p class="has-text-color has-color-accent-text-color">Dolor sit</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"textColor":"color-accent-text","className":"h5 has-uppercase-text-transform"} -->
<h3 class="has-color-accent-text-color has-text-color h5 has-uppercase-text-transform"><strong>Lorem ipsum</strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"color-accent-text"} -->
<p class="has-text-color has-color-accent-text-color">Lorem ipsum dolor sit amet consectetur adipiscing elit facilisi posuere at bibendum, ultricies montes porta congue fermentum ac mollis felis morbi.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"has-color-accent-text-color"} -->
<ul class="has-color-accent-text-color"><li>Lorem ipsum dolor</li><li>Lorem ipsum dolor</li><li>Lorem ipsum dolor</li><li><strong>Lorem ipsum dolor</strong></li><li><strong>Lorem ipsum dolor</strong></li></ul>
<!-- /wp:list -->

<!-- wp:button {"textColor":"color-accent-text","className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color has-color-accent-text-color" href="#0">Dolor &rarr;</a></div>
<!-- /wp:button --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"has-background has-palette-4-background-color"} -->
<div class="wp-block-column has-background has-palette-4-background-color"><!-- wp:paragraph {"textColor":"palette-1","customFontSize":64,"className":"has-no-margin-vertical has-nowrap-white-space"} -->
<p style="font-size:64px" class="has-text-color has-palette-1-color has-no-margin-vertical has-nowrap-white-space">€<strong>9</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Dolor sit</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"h5 has-uppercase-text-transform"} -->
<h3 class="h5 has-uppercase-text-transform"><strong>Dolor amet</strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet consectetur adipiscing elit facilisi posuere at bibendum, ultricies montes porta congue fermentum ac mollis felis morbi.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><li><strong>Lorem ipsum dolor</strong></li><li><strong>Lorem ipsum dolor</strong></li><li><strong>Lorem ipsum dolor</strong></li><li><del>Lorem ipsum dolor</del></li><li><del>Lorem ipsum dolor</del></li></ul>
<!-- /wp:list -->

<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link" href="#0">Dolor &rarr;</a></div>
<!-- /wp:button --></div>
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
