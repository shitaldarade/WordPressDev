<?php
/**
 * Admin "Settings > Media" custom image sizes info.
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.0.0
 */

namespace WebManDesign\Bjork;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$image_sizes = Setup\Media::get_image_sizes();

if ( empty( $image_sizes ) ) {
	return;
}

?>

<div class="recommended-image-sizes">

	<h3><?php esc_html_e( 'Recommended image sizes', 'bjork' ); ?></h3>

	<p><?php esc_html_e( 'For the optimal theme display, please, set image sizes recommended in table below.', 'bjork' ); ?></p>

	<p>
		<?php esc_html_e( 'Do you already have images uploaded to your website and want to resize them?', 'bjork' ); ?>
		<a href="https://wordpress.org/plugins/search/regenerate+thumbnails/"><?php esc_html_e( 'Use a plugin &raquo;', 'bjork' ); ?></a>
	</p>

	<table>

		<thead>
			<tr>
				<th><?php esc_html_e( 'Size name', 'bjork' ); ?></th>
				<th><?php esc_html_e( 'Size ID', 'bjork' ); ?></th>
				<th><?php esc_html_e( 'Size parameters', 'bjork' ); ?></th>
				<th><?php esc_html_e( 'Theme usage', 'bjork' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php

			foreach ( $image_sizes as $size => $args ) :

				if ( 'medium_large' === $size ) {
					continue;
				}

				$crop = ( $args['crop'] ) ? ( esc_html__( 'cropped', 'bjork' ) ) : ( esc_html__( 'scaled', 'bjork' ) );

				$row_title = '';
				if ( ! in_array( $size, Setup\Media::get_default_image_sizes() ) ) {
					$row_title = __( 'Additional image size added by the theme. Can not be changed on this page.', 'bjork' );
				}

				?>

				<tr title="<?php echo esc_attr( trim( $row_title ) ); ?>">

					<th>
						<?php

						if ( isset( $args['name'] ) ) {
							echo esc_html( $args['name'] );
						} else {
							echo '&mdash;';
						}

						?>
					</th>

					<td>
						<code><?php echo esc_html( $size ); ?></code>
					</td>

					<td>
						<?php

						printf(
							/* translators: 1: image width, 2: image height, 3: cropped or scaled? */
							esc_html__( '%1$d &times; %2$d, %3$s', 'bjork' ),
							absint( $args['width'] ),
							absint( $args['height'] ),
							esc_html( $crop )
						);

						?>
					</td>

					<td class="small">
						<?php

						if ( isset( $args['description'] ) ) {
							echo esc_html( $args['description'] );
						} else {
							echo '&mdash;';
						}

						?>
					</td>

				</tr>

				<?php

			endforeach;

			?>
		</tbody>

	</table>

	<style type="text/css" media="screen">

		.recommended-image-sizes {
			display: inline-block;
			padding: 1.618em;
			border: 2px solid #dadcde;
		}

		.recommended-image-sizes h3:first-child {
			margin-top: 0;
		}

		.recommended-image-sizes table {
			margin-top: 1.618em;
		}

		.recommended-image-sizes th,
		.recommended-image-sizes td {
			width: auto;
			padding: .382em 1em;
			border-bottom: 2px dotted #dadcde;
			vertical-align: top;
		}

		.recommended-image-sizes thead th {
			padding: .618em 1em;
			text-transform: uppercase;
			font-size: .809em;
			border-bottom-style: solid;
		}

		.recommended-image-sizes tr:not([title=""]) {
			cursor: help;
		}

	</style>

</div>
