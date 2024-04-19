<?php
/**
 * PSR-4 autoloader.
 *
 * Via Composer or custom.
 *
 * @link  https://www.php-fig.org/psr/psr-4/
 *
 * @package    Björk
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.12
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( file_exists( BJORK_PATH_VENDOR . 'autoload.php' ) ) {
	require_once BJORK_PATH_VENDOR . 'autoload.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
} else {

	class Bjork_Autoload {

		/**
		 * Theme PHP class namespace.
		 *
		 * @var string
		 */
		private static $namespace = 'WebManDesign\Bjork';

		/**
		 * Directory to load PHP classes from.
		 *
		 * @var string
		 */
		private static $directory = 'includes';

		/**
		 * @todo  Update the list of files.
		 * Array of white-listed, allowed files for improved security.
		 *
		 * TIP:
		 * Can be obtained in code editor by searching for `namespace `
		 * in `theme-slug/includes/*.php` files.
		 *
		 * @var array
		 */
		private static $allowed_files = array(

			'/Component_Interface.php',
			'/Theme.php',

			'/Accessibility/Component.php',

			'/Assets/Component.php',
			'/Assets/Editor.php',
			'/Assets/Factory.php',
			'/Assets/Scripts.php',
			'/Assets/Styles.php',

			'/Content/Blocks.php',
			'/Content/Component.php',
			'/Content/Container.php',

			'/Customize/Colors.php',
			'/Customize/Component.php',
			'/Customize/Control.php',
			'/Customize/CSS_Variables.php',
			'/Customize/Mod.php',
			'/Customize/Options.php',
			'/Customize/Options_Conditional.php',
			'/Customize/Options_Partial_Refresh.php',
			'/Customize/Preview.php',
			'/Customize/RGBA.php',
			'/Customize/Sanitize.php',
			'/Customize/Styles.php',

				'/Customize/Control/HTML.php',
				'/Customize/Control/Multiselect.php',
				'/Customize/Control/Select.php',
				'/Customize/Control/Text.php',

			'/Entry/Component.php',
			'/Entry/Media.php',
			'/Entry/Navigation.php',
			'/Entry/Page_Template.php',
			'/Entry/Post_Class.php',
			'/Entry/Summary.php',

			'/Footer/Component.php',
			'/Footer/Container.php',
			'/Footer/Logo.php',

			'/Header/Body_Class.php',
			'/Header/Component.php',
			'/Header/Container.php',
			'/Header/Head.php',

			'/Loop/Component.php',
			'/Loop/Filter.php',
			'/Loop/Pagination.php',

			'/Menu/Component.php',
			'/Menu/Social_Links.php',

			'/Plugin/Component.php',
			'/Plugin/TGMPA.php',

				'/Plugin/Beaver_Builder/Component.php',

				'/Plugin/Breadcrumb_NavXT/Component.php',

				'/Plugin/Jetpack/Assets.php',
				'/Plugin/Jetpack/Component.php',
				'/Plugin/Jetpack/Content_Options.php',
				'/Plugin/Jetpack/Infinite_Scroll.php',
				'/Plugin/Jetpack/Post_Types.php',
				'/Plugin/Jetpack/Setup.php',

				'/Plugin/One_Click_Demo_Import/Component.php',

				'/Plugin/WooCommerce/Assets.php',
				'/Plugin/WooCommerce/Component.php',
				'/Plugin/WooCommerce/Customize.php',
				'/Plugin/WooCommerce/Loop.php',
				'/Plugin/WooCommerce/Pages.php',
				'/Plugin/WooCommerce/Setup.php',
				'/Plugin/WooCommerce/Single.php',
				'/Plugin/WooCommerce/Widgets.php',
				'/Plugin/WooCommerce/Wrappers.php',

			'/Setup/Component.php',
			'/Setup/Editor.php',
			'/Setup/Media.php',
			'/Setup/Post_Type.php',
			'/Setup/Upgrade.php',

			'/Sidebar/Component.php',

			'/Theme_Hook_Alliance/Component.php',

			'/Tool/AMP.php',
			'/Tool/Component.php',
			'/Tool/Google_Fonts.php',
			'/Tool/KSES.php',
			'/Tool/Page_Builder.php',
			'/Tool/Starter_Content.php',
			'/Tool/Taxonomy.php',
			'/Tool/Update_Notification.php',
			'/Tool/Wrapper.php',

			'/Welcome/Component.php',

			'/Widget/Component.php',
			'/Widget/Recent_Posts.php',
			'/Widget/Text.php',

		);

		/**
		 * Register custom autoload.
		 *
		 * @since  __1.0.0
		 *
		 * @param  string $class_name  Class name to load.
		 *
		 * @return  bool  True if the class was loaded, false otherwise.
		 */
		public static function register( $class_name ) {

			// Requirements check

				if ( 0 !== strpos( $class_name, self::$namespace . '\\' ) ) {
					return false;
				}


			// Variables

				$path  = '';
				$parts = explode( '\\', substr( $class_name, strlen( self::$namespace . '\\' ) ) );


			// Processing

				foreach ( $parts as $part ) {
					$path .= '/' . $part;
				}
				$path .= '.php';

				if ( ! in_array( $path, self::$allowed_files ) ) {
					return false;
				}

				$path = get_template_directory() . '/' . self::$directory . $path;

				if ( ! file_exists( $path ) ) {
					return false;
				}

				require_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound


			// Output

				return true;

		} // /register

	}

	spl_autoload_register( 'Bjork_Autoload::register' );

}
