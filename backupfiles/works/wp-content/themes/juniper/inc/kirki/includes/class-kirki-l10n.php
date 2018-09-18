<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'kirki';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'juniper' ),
				'background-image'      => esc_attr__( 'Background Image', 'juniper' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'juniper' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'juniper' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'juniper' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'juniper' ),
				'inherit'               => esc_attr__( 'Inherit', 'juniper' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'juniper' ),
				'cover'                 => esc_attr__( 'Cover', 'juniper' ),
				'contain'               => esc_attr__( 'Contain', 'juniper' ),
				'background-size'       => esc_attr__( 'Background Size', 'juniper' ),
				'fixed'                 => esc_attr__( 'Fixed', 'juniper' ),
				'scroll'                => esc_attr__( 'Scroll', 'juniper' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'juniper' ),
				'left-top'              => esc_attr__( 'Left Top', 'juniper' ),
				'left-center'           => esc_attr__( 'Left Center', 'juniper' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'juniper' ),
				'right-top'             => esc_attr__( 'Right Top', 'juniper' ),
				'right-center'          => esc_attr__( 'Right Center', 'juniper' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'juniper' ),
				'center-top'            => esc_attr__( 'Center Top', 'juniper' ),
				'center-center'         => esc_attr__( 'Center Center', 'juniper' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'juniper' ),
				'background-position'   => esc_attr__( 'Background Position', 'juniper' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'juniper' ),
				'on'                    => esc_attr__( 'ON', 'juniper' ),
				'off'                   => esc_attr__( 'OFF', 'juniper' ),
				'all'                   => esc_attr__( 'All', 'juniper' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'juniper' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'juniper' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'juniper' ),
				'greek'                 => esc_attr__( 'Greek', 'juniper' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'juniper' ),
				'khmer'                 => esc_attr__( 'Khmer', 'juniper' ),
				'latin'                 => esc_attr__( 'Latin', 'juniper' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'juniper' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'juniper' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'juniper' ),
				'arabic'                => esc_attr__( 'Arabic', 'juniper' ),
				'bengali'               => esc_attr__( 'Bengali', 'juniper' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'juniper' ),
				'tamil'                 => esc_attr__( 'Tamil', 'juniper' ),
				'telugu'                => esc_attr__( 'Telugu', 'juniper' ),
				'thai'                  => esc_attr__( 'Thai', 'juniper' ),
				'serif'                 => _x( 'Serif', 'font style', 'juniper' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'juniper' ),
				'monospace'             => _x( 'Monospace', 'font style', 'juniper' ),
				'font-family'           => esc_attr__( 'Font Family', 'juniper' ),
				'font-size'             => esc_attr__( 'Font Size', 'juniper' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'juniper' ),
				'line-height'           => esc_attr__( 'Line Height', 'juniper' ),
				'font-style'            => esc_attr__( 'Font Style', 'juniper' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'juniper' ),
				'top'                   => esc_attr__( 'Top', 'juniper' ),
				'bottom'                => esc_attr__( 'Bottom', 'juniper' ),
				'left'                  => esc_attr__( 'Left', 'juniper' ),
				'right'                 => esc_attr__( 'Right', 'juniper' ),
				'center'                => esc_attr__( 'Center', 'juniper' ),
				'justify'               => esc_attr__( 'Justify', 'juniper' ),
				'color'                 => esc_attr__( 'Color', 'juniper' ),
				'add-image'             => esc_attr__( 'Add Image', 'juniper' ),
				'change-image'          => esc_attr__( 'Change Image', 'juniper' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'juniper' ),
				'add-file'              => esc_attr__( 'Add File', 'juniper' ),
				'change-file'           => esc_attr__( 'Change File', 'juniper' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'juniper' ),
				'remove'                => esc_attr__( 'Remove', 'juniper' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'juniper' ),
				'variant'               => esc_attr__( 'Variant', 'juniper' ),
				'subsets'               => esc_attr__( 'Subset', 'juniper' ),
				'size'                  => esc_attr__( 'Size', 'juniper' ),
				'height'                => esc_attr__( 'Height', 'juniper' ),
				'spacing'               => esc_attr__( 'Spacing', 'juniper' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'juniper' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'juniper' ),
				'light'                 => esc_attr__( 'Light 200', 'juniper' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'juniper' ),
				'book'                  => esc_attr__( 'Book 300', 'juniper' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'juniper' ),
				'regular'               => esc_attr__( 'Normal 400', 'juniper' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'juniper' ),
				'medium'                => esc_attr__( 'Medium 500', 'juniper' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'juniper' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'juniper' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'juniper' ),
				'bold'                  => esc_attr__( 'Bold 700', 'juniper' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'juniper' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'juniper' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'juniper' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'juniper' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'juniper' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'juniper' ),
				'add-new'           	=> esc_attr__( 'Add new', 'juniper' ),
				'row'           		=> esc_attr__( 'row', 'juniper' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'juniper' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'juniper' ),
				'back'                  => esc_attr__( 'Back', 'juniper' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'juniper' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'juniper' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'juniper' ),
				'none'                  => esc_attr__( 'None', 'juniper' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'juniper' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'juniper' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'juniper' ),
				'initial'               => esc_attr__( 'Initial', 'juniper' ),
				'select-page'           => esc_attr__( 'Select a Page', 'juniper' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'juniper' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'juniper' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'juniper' ),
			);

			$config = apply_filters( 'kirki/config', array() );

			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
