<?php

if (!defined('ABSPATH')) exit;

class DS8RelatedPosts {
  
        private static $instance = null;
        public $version;
        public $themes;
        /**
         * Function constructor
         */
        function __construct() {
            $this->load_dependencies();
            $this->define_admin_hooks();
            
            //add_action('widgets_init', array($this, 'ds8_relatedposts_register_widget'));
            
            add_action('wp_enqueue_scripts', array($this, 'ds8_relatedposts_javascript'), 10);
            add_shortcode( 'ds8relatedposts', array($this, 'ds8relatedposts_shortcode_fn') );
        }
        
        /**
        * Singleton pattern
        *
        * @return void
        */
        public static function get_instance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }
        
        private function load_dependencies() {
        }
        
        /**
          * Admin hooks
          *
          * @return void
          */
        private function define_admin_hooks() {
        }
        
        public function ds8_relatedposts_register_widget() {
        }
        
        public function ds8relatedposts_shortcode_fn($atts) {
          
          if (is_admin()) return;
          
          extract( shortcode_atts( array(
              'title'   => 'Artículos Relacionados',
              'perpage' => 3
          ), $atts ) );
          
          
          $tags = wp_get_post_terms( get_the_ID(), 'post_tag', ['fields' => 'ids'] );
          $related_args = array(
                  'post_type' => 'post',
                  'posts_per_page' => 12,
                  'post_status' => 'publish',
                  'ignore_sticky_posts' => true,
                  'post__not_in' => array( get_the_ID() ),
                  'orderby' => 'date',
                  'tax_query' => array(
                      array(
                          'taxonomy' => 'post_tag',
                          'terms'    => $tags,
                      )
                  )
          );

          $my_posts = get_posts( $related_args );
          
          ob_start();
          include('template-parts/related-posts.php');
          return ob_get_clean();
         
        }
        
        /**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0
	 */
	private static function set_locale() {
		load_plugin_textdomain( 'ds8relatedposts', false, plugin_dir_path( dirname( __FILE__ ) ) . '/languages/' );

	}
        
        public static function ds8relatedposts_textdomain( $mofile, $domain ) {
                if ( 'ds8relatedposts' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
                        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
                        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
                }
                return $mofile;
        }
        
        
        /**
	 * Check if plugin is active
	 *
	 * @since    1.0
	 */
	private static function is_plugin_active( $plugin_file ) {
		return in_array( $plugin_file, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}

        public function ds8_relatedposts_javascript(){
          
            /*JLMA global $post;
            if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'ds8relatedposts') ) {
            }*/
          
            if (!is_front_page()) {
              wp_enqueue_style('ds8relatedposts-css', plugin_dir_url( __FILE__ ) . 'assets/css/relatedposts.css', array(), DS8RELATEDPOSTS_VERSION);
              wp_enqueue_style('slick-css','https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), DS8RELATEDPOSTS_VERSION);
              wp_enqueue_style('slick-theme-css','https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('slick-css'), DS8RELATEDPOSTS_VERSION);
              wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), DS8RELATEDPOSTS_VERSION, true );

              wp_register_script( 'ds8-relatedposts-js', plugin_dir_url( __FILE__ ) . 'assets/js/relatedposts.js', array('slick-js'), DS8ARTICULISTAS_VERSION, true );
              wp_enqueue_script( 'ds8-relatedposts-js' );
            }
        }
        
        public static function plugin_deactivation( ) {
        }

        /**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation() {
		if ( version_compare( $GLOBALS['wp_version'], DS8RELATEDPOSTS_MINIMUM_WP_VERSION, '<' ) ) {
			load_plugin_textdomain( 'ds8relatedposts' );
                        
			$message = '<strong>'.sprintf(esc_html__( 'DS8 Related Posts %s requires WordPress %s or higher.' , 'ds8relatedposts'), DS8RELATEDPOSTS_VERSION, DS8RELATEDPOSTS_MINIMUM_WP_VERSION ).'</strong> '.sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version.', 'ds8relatedposts'), 'https://codex.wordpress.org/Upgrading_WordPress', 'https://wordpress.org/extend/plugins/ds8relatedposts/download/');

			DS8RelatedPosts::bail_on_activation( $message );
		} elseif ( ! empty( $_SERVER['SCRIPT_NAME'] ) && false !== strpos( $_SERVER['SCRIPT_NAME'], '/wp-admin/plugins.php' ) ) {
                        flush_rewrite_rules();
			add_option( 'Activated_DS8RelatedPosts', true );
		}
	}

        private static function bail_on_activation( $message, $deactivate = true ) {
?>
<!doctype html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<style>
* {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
p {
	margin-top: 1em;
	font-size: 18px;
}
</style>
</head>
<body>
<p><?php echo esc_html( $message ); ?></p>
</body>
</html>
<?php
		if ( $deactivate ) {
			$plugins = get_option( 'active_plugins' );
			$ds8relatedposts = plugin_basename( DS8RELATEDPOSTS_PLUGIN_DIR . 'ds8relatedposts.php' );
			$update  = false;
			foreach ( $plugins as $i => $plugin ) {
				if ( $plugin === $ds8relatedposts ) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ( $update ) {
				update_option( 'active_plugins', array_filter( $plugins ) );
			}
		}
		exit;
	}

}