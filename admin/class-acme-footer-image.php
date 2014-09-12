<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://tommcfarlin.com
 * @since      0.1.0
 *
 * @package    Acme_Footer_Image
 * @subpackage Acme_Footer_Image/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Acme_Footer_Image
 * @subpackage Acme_Footer_Image/admin
 * @author     Tom McFarlin <tom@tommcfarlin.com>
 */
class Acme_Footer_Image {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The version of the plugin
	 */
	private $version;

	/**
	 * Initializes the plugin by defining the properties.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		$this->name = 'acme-footer-image';
		$this->version = '1.0.0';

	}

	/**
	 * Defines the hooks that will register and enqueue the JavaScriot
	 * and the meta box that will render the option.
	 *
	 * @since 0.1.0
	 */
	public function run() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_action( 'the_content', array( $this, 'the_content' ) );

	}

	/**
	 * Renders the meta box on the post and pages.
	 *
	 * @since 0.1.0
	 */
	public function add_meta_box() {

		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				$this->name,
				'Footer Featured Image',
				array( $this, 'display_featured_footer_image' ),
				$screen,
				'side'
			);

		}

	}

	/**
	 * Registers the JavaScript for handling the media uploader.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_media();

		wp_enqueue_script(
			$this->name,
			plugin_dir_url( __FILE__ ) . 'js/admin.js',
			array( 'jquery' ),
			$this->version,
			'all'
		);

	}

	/**
	 * Registers the stylesheets for handling the meta box
	 *
	 * @since 0.2.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->name,
			plugin_dir_url( __FILE__ ) . 'css/admin.css',
			array()
		);

	}

	/**
	 * Sanitized and saves the post featured footer image meta data specific with this post.
	 *
	 * @param    int    $post_id    The ID of the post with which we're currently working.
	 * @since    1.0.0
	 */
	public function save_post( $post_id ) {

		if ( isset( $_REQUEST['footer-thumbnail-src'] ) ) {
			update_post_meta( $post_id, 'footer-thumbnail-src', sanitize_text_field( $_REQUEST['footer-thumbnail-src'] ) );
		}

		if ( isset( $_REQUEST['footer-thumbnail-title'] ) ) {
			update_post_meta( $post_id, 'footer-thumbnail-title', sanitize_text_field( $_REQUEST['footer-thumbnail-title'] ) );
		}

		if ( isset( $_REQUEST['footer-thumbnail-alt'] ) ) {
			update_post_meta( $post_id, 'footer-thumbnail-alt', sanitize_text_field( $_REQUEST['footer-thumbnail-alt'] ) );
		}

	}

	/**
	 * If the current post is a single post, check to see if there is a featured image.
	 * If so, append is to the post content prior to rendering the post.
	 *
	 * @param   string    $content    The content of the post.
	 * @since   1.0.0
	 */
	public function the_content( $content ) {

		// We only care about appending the image to single pages
		if ( is_single() ) {

			// In order to append an image, there has to be at least a source attribute
			if ( '' !== ( $src = get_post_meta( get_the_ID(), 'footer-thumbnail-src', true ) ) ) {

				// read the remaining attributes even if they are empty strings
				$alt = get_post_meta( get_the_ID(), 'footer-thumbnail-alt', true );
				$title = get_post_meta( get_the_ID(), 'footer-thumbnail-title', true );

				// create the image element within its own container
				$img_html = '<p id="footer-thumbnail">';
					$img_html .= "<img src='$src' alt='$alt' title='$title' />";
				$img_html .= '</p><!-- #footer-thumbnail -->';

				// append it to the content
				$content .= $img_html;

			}

		}

		return $content;

	}

	/**
	 * Renders the view that displays the contents for the meta box that for triggering
	 * the meta box.
	 *
	 * @param    WP_Post    $post    The post object
	 * @since    0.1.0
	 */
	public function display_featured_footer_image( $post ) {
		include_once( dirname( __FILE__ ) . '/views/admin.php' );
	}

}
