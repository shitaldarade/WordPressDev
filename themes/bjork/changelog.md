# Björk Changelog

## 1.0.17, 20220621

### Fixed
- Columns block margins
- Full and wide aligned blocks z-index

### File updates
	style.css
	assets/scss/blocks.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/global.scss


## 1.0.16, 20220618

### Added
- Global link color theme option

### Updated
- Improving CSS
- Improving JS
- Improving content none page title

### Fixed
- WordPress 6.0 blocks CSS
- Editor styles

### File updates
	changelog.md
	style.css
	assets/scss/_custom-properties.scss
	assets/scss/blocks.scss
	assets/scss/customize-controls.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/global.scss
	assets/scss/woocommerce.scss
	includes/Assets/Scripts.php
	includes/Customize/Options.php
	languages/*.*
	templates/parts/content/content-none.php


## 1.0.15, 20220604

### Updated
- "Welcome" page improvements
- Removing obsolete `container_class` primary menu argument
- Improved accessibility
- Localization

### Fixed
- WordPress 6.0 align and width issues
- WordPress 6.0 large Quote styles
- Mobile navigation JavaScript issue
- Mega menu focus styles
- Cover block color contrast issue
- Primary menu `.current_page_parent` styles

### File updates
	changelog.md
	style.css
	assets/js/navigation-mobile.js
	assets/scss/blocks.scss
	assets/scss/global.scss
	assets/scss/welcome.scss
	includes/Assets/Scripts.php
	includes/Content/Blocks.php
	includes/Menu/Component.php
	includes/Welcome/Component.php
	languages/*.*
	templates/parts/admin/welcome-a11y.php
	templates/parts/admin/welcome-demo.php
	templates/parts/admin/welcome-footer.php
	templates/parts/admin/welcome-guide.php
	templates/parts/admin/welcome-header.php
	templates/parts/admin/welcome-update.php


## 1.0.14, 20220216

### Fixed
- Fixing styles issue introduced in previous verion

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/global.scss


## 1.0.13, 20220216

### Add
- TikTok social icon

### Updated
- Update notification code
- Improved accessibility
- Recommending Classic Widgets plugin
- Localization

### Fixed
- WordPress 5.9 compatibility
- WooCommerce styles
- `tel` links not clickable on large screens
- Horizontal scroll on small screens
- Page builder layout CSS class check
- RTL languages layout issues
- Deprecated function notice regarding Jetpack plugin

### File updates
	changelog.md
	readme.txt
	style.css
	assets/js/navigation-mobile.js
	assets/scss/_custom-properties.scss
	assets/scss/blocks.scss
	assets/scss/comments.scss
	assets/scss/content.scss
	assets/scss/customize-controls.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/editor-style-classic.scss
	assets/scss/global.scss
	assets/scss/jetpack.scss
	assets/scss/widgets.scss
	assets/scss/woocommerce.scss
	includes/Accessibility/Component.php
	includes/Assets/Scripts.php
	includes/Assets/Styles.php
	includes/Menu/Component.php
	includes/Menu/Social_Links.php
	includes/Plugin/TGMPA.php
	includes/Plugin/Jetpack/Component.php
	includes/Plugin/One_Click_Demo_Import/Component.php
	includes/Plugin/WooCommerce/Pages.php
	includes/Setup/Editor.php
	includes/Tool/Page_Builder.php
	includes/Tool/Update_Notification.php
	languages/*.*
	templates/parts/menu/menu-primary.php
	vendor/a11y-menu/*.*


## 1.0.12, 20213019

### Add
- Theme option to set footer logo
- WordPress 5.7 compatibility
- New recommended plugins

### Updated
- Theme options
- Improving page builder template functionality

### Fixed
- Recommended plugin installation PHP error
- WooCommerce styles

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/blocks.scss
	assets/scss/customize-preview.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/global.scss
	assets/scss/woocommerce.scss
	includes/Autoload.php
	includes/Customize/Control.php
	includes/Customize/Options.php
	includes/Footer/Component.php
	includes/Footer/Logo.php
	includes/Header/Body_Class.php
	includes/Plugin/TGMPA.php
	includes/Tool/Page_Builder.php
	languages/*.*
	vendor/tgmpa/class-tgm-plugin-activation.php


## 1.0.11, 20210126

### Updated
- Improving SEO plugins compatibility

### Fixed
- Fixing issue with WPML plugin
- Preventing infinite loop in social menu code

### File updates
	changelog.md
	readme.txt
	style.css
	includes/Header/Head.php
	includes/Menu/Social_Links.php
	includes/Plugin/WooCommerce/Loop.php
	templates/parts/header/head.php


## 1.0.10, 20201215

### Updated
- Preventing issue when using dropcap styles outside block editor produced content
- Preventing issues with plugins such as bbPress by introducing dedicated page content template part
- Improving PHP code to follow WordPress PHP coding standards (fixing "else if" to "elseif" where needed)
- jQuery code for WordPress 5.6 compatibility
- Removing obsolete CSS Vars Ponyfill JavaScript
- Updating all WooCommerce JavaScript to vanilla (no jQuery)

### Fixed
- Flex grow modifier class specificity
- Range theme option field not working with WordPress 5.6
- Blocks and block editor styles in WordPress 5.6

### File updates
	changelog.md
	readme.txt
	style.css
	assets/js/customize-controls.js
	assets/js/woocommerce.js
	assets/scss/blocks.scss
	assets/scss/comments.scss
	assets/scss/content.scss
	assets/scss/customize-controls.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/editor-style-classic.scss
	assets/scss/global.scss
	assets/scss/jetpack.scss
	assets/scss/widgets.scss
	assets/scss/woocommerce.scss
	includes/Customize/Control.php
	includes/Customize/CSS_Variables.php
	includes/Customize/Options_Partial_Refresh.php
	includes/Customize/Sanitize.php
	templates/parts/content/content-page.php


## 1.0.9, 20201127

### Fix
- Check for singular pages

### File updates
	changelog.md
	readme.txt
	style.css
	includes/Entry/Component.php


## 1.0.8, 20201127

### Update
- Preventing possible PHP attribute type hinting issues
- Improving Spacer block margins in editor
- 3rd level sub-menu background

### Fix
- Sanitization methods

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/editor-style-blocks.scss
	assets/scss/global.scss
	includes/Accessibility/Component.php
	includes/Content/Component.php
	includes/Customize/CSS_Variables.php
	includes/Menu/Component.php
	includes/Menu/Social_Links.php


## 1.0.7, 20201115

### Fix
- Block editor title styles
- Improving block margins in editor

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/editor-style-blocks.scss


## 1.0.6, 20201112

### Update
- Improving block editor styles
- Improving blocks styles

### File updates
	readme.txt
	style.css
	assets/scss/blocks.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/global.scss
	assets/scss/jetpack.scss
	assets/scss/woocommerce.scss


## 1.0.5, 20201105

### Update
- Improving block editor styles

### Fixed
- Classic editor background color
- WooCommerce products list styles in block editor

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/editor-style-blocks.scss
	assets/scss/editor-style-classic.scss
	assets/scss/global.scss
	assets/scss/woocommerce.scss
	includes/Content/Blocks.php


## 1.0.4, 20201104

### Add
- WordPress 5.5 compatibility
- Fullwidth megamenu functionality

### Update
- Improving styles
- Optimizing code
- More link HTML
- Hiding obsolete "Header image" customizer section
- Texts and localization
- Update notifier functionality

### Fixed
- Compatibility with WordPress 5.5 block editor
- Styling bugs
- `$content_width` global variable default value
- Display of menu on mobile devices when mobile menu is disabled
- WooCommerce password reset form styles

### File updates
	changelog.md
	header.php
	readme.txt
	search.php
	style.css
	assets/js/customize-preview.js
	assets/js/navigation-mobile.js
	assets/js/woocommerce-sticky-add-to-cart.js
	assets/js/woocommerce.js
	assets/scss/_custom-properties.scss
	assets/scss/blocks.scss
	assets/scss/comments.scss
	assets/scss/content.scss
	assets/scss/editor-style-blocks.scss
	assets/scss/editor-style-classic.scss
	assets/scss/global.scss
	assets/scss/jetpack.scss
	assets/scss/widgets.scss
	assets/scss/woocommerce.scss
	assets/scss/tools/_function-encode-url.scss
	assets/scss/tools/_function-important.scss
	assets/scss/tools/_mixin-linear-gradient-stopped.scss
	assets/scss/tools/_mixin-widget-title-style.scss
	includes/Autoload.php
	includes/Compatibility.php
	includes/Accessibility/Component.php
	includes/Assets/Editor.php
	includes/Assets/Factory.php
	includes/Assets/Scripts.php
	includes/Assets/Styles.php
	includes/Content/Blocks.php
	includes/Content/Component.php
	includes/Customize/Colors.php
	includes/Customize/Component.php
	includes/Customize/CSS_Variables.php
	includes/Customize/Options.php
	includes/Customize/Preview.php
	includes/Customize/RGBA.php
	includes/Customize/Sanitize.php
	includes/Customize/Styles.php
	includes/Customize/Control/HTML.php
	includes/Customize/Control/Multiselect.php
	includes/Customize/Control/Select.php
	includes/Entry/Component.php
	includes/Entry/Media.php
	includes/Entry/Page_Template.php
	includes/Footer/Component.php
	includes/Header/Body_Class.php
	includes/Header/Component.php
	includes/Header/Container.php
	includes/Loop/Pagination.php
	includes/Menu/Component.php
	includes/Menu/Social_Links.php
	includes/Plugin/TGMPA.php
	includes/Plugin/Breadcrumb_NavXT/Component.php
	includes/Plugin/Jetpack/Assets.php
	includes/Plugin/WooCommerce/Assets.php
	includes/Plugin/WooCommerce/Customize.php
	includes/Plugin/WooCommerce/Loop.php
	includes/Plugin/WooCommerce/Pages.php
	includes/Plugin/WooCommerce/Single.php
	includes/Plugin/WooCommerce/Widgets.php
	includes/Plugin/WooCommerce/Wrappers.php
	includes/Setup/Component.php
	includes/Setup/Editor.php
	includes/Setup/Media.php
	includes/Tool/Component.php
	includes/Tool/Google_Fonts.php
	includes/Tool/KSES.php
	includes/Tool/Update_Notification.php
	includes/Welcome/Component.php
	templates/parts/accessibility/menu-skip-links.php
	templates/parts/admin/welcome-accessibility.php
	templates/parts/admin/welcome-header.php
	templates/parts/admin/welcome-update.php
	templates/parts/component/entry-header-singular.php
	templates/parts/component/entry-header.php
	templates/parts/component/link-more-product.php
	templates/parts/component/link-more.php
	templates/parts/component/page-header-search.php
	templates/parts/component/page-header.php
	templates/parts/footer/site-branding.php
	templates/parts/footer/site-info.php
	templates/parts/header/site-branding.php
	templates/parts/loop/loop-categories-product.php
	templates/parts/menu/menu-primary.php
	templates/parts/meta/entry-meta-bottom.php
	templates/parts/meta/entry-meta-item-author.php
	templates/parts/meta/entry-meta-item-category.php
	templates/parts/meta/entry-meta-item-comments.php
	templates/parts/meta/entry-meta-item-date.php
	templates/parts/meta/entry-meta-item-tags.php
	templates/parts/meta/entry-meta-page-header.php
	templates/parts/meta/entry-meta-top.php
	templates/parts/plugin/content-ocdi-info.php
	templates/parts/plugin/content-ocdi-jetpack-custom-posts.php


## 1.0.3, 20200319

### Fix
- Hiding site title text

### File updates
	changelog.md
	readme.txt
	style.css
	includes/Setup/Component.php


## 1.0.2, 20200319

### Updated
- WordPress 5.4 compatibility

### File updates
	changelog.md
	readme.txt
	style.css
	assets/scss/editor-style-blocks.scss


## 1.0.1, 20200306

### Fixed
- Footer credits option output

### File updates
	changelog.md
	readme.txt
	style.css
	includes/Customize/Component.php
	includes/Customize/Control.php
	includes/Customize/Options.php
	includes/Customize/Options_Partial_Refresh.php
	templates/parts/footer/site-info.php


## 1.0.0, 20200301

- Initial release.
