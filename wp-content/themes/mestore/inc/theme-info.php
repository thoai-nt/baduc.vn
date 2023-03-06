<?php
/**
 * Theme information MeStore
 *
 * @package mestore
 */


if ( ! class_exists( 'MeStore_About_Page' ) ) {
	/**
	 * Singleton class used for generating the about page of the theme.
	 */
	class MeStore_About_Page {
		/**
		 * Define the version of the class.
		 *
		 * @var string $version The MeStore_About_Page class version.
		 */
		private $version = '1.0.0';
		/**
		 * Used for loading the texts and setup the actions inside the page.
		 *
		 * @var array $config The configuration array for the theme used.
		 */
		private $config;
		/**
		 * Get the theme name using wp_get_theme.
		 *
		 * @var string $theme_name The theme name.
		 */
		private $theme_name;
		/**
		 * Get the theme slug ( theme folder name ).
		 *
		 * @var string $theme_slug The theme slug.
		 */
		private $theme_slug;
		/**
		 * The current theme object.
		 *
		 * @var WP_Theme $theme The current theme.
		 */
		private $theme;
		/**
		 * Holds the theme version.
		 *
		 * @var string $theme_version The theme version.
		 */
		private $theme_version;		
		/**
		 * Define the html notification content displayed upon activation.
		 *
		 * @var string $notification The html notification content.
		 */
		private $notification;
		/**
		 * The single instance of MeStore_About_Page
		 *
		 * @var MeStore_About_Page $instance The MeStore_About_Page instance.
		 */
		private static $instance;
		/**
		 * The Main MeStore_About_Page instance.
		 *
		 * We make sure that only one instance of MeStore_About_Page exists in the memory at one time.
		 *
		 * @param array $config The configuration array.
		 */
		public static function mestore_init( $config ) {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MeStore_About_Page ) ) {
				self::$instance = new MeStore_About_Page;				
				self::$instance->config = $config;
				self::$instance->mestore_setup_config();
				self::$instance->mestore_setup_actions();				
			}
		}

		/**
		 * Setup the class props based on the config array.
		 */
		public function mestore_setup_config() {
			$theme = wp_get_theme();
			if ( is_child_theme() ) {
				$this->theme_name = $theme->parent()->get( 'Name' );
				$this->theme      = $theme->parent();
			} else {
				$this->theme_name = $theme->get( 'Name' );
				$this->theme      = $theme->parent();
			}
			$this->theme_version = $theme->get( 'Version' );
			$this->theme_slug    = $theme->get_template();			
			$this->notification  = isset( $this->config['notification'] ) ? $this->config['notification'] : ( '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s ! To take full advantage of this theme, please make sure you visit our %2$swelcome page%3$s.', $this->theme_name, '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $this->theme_name ) . '</a></p>' );		
		}

		/**
		 * Setup the actions used for this page.
		 */
		public function mestore_setup_actions() {
			
			/* activation notice */
			add_action( 'load-themes.php', array( $this, 'mestore_activation_admin_notice' ) );						
		}		
		

		/**
		 * Adds an admin notice upon successful activation.
		 */
		public function mestore_activation_admin_notice() {
			global $pagenow;
			if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'mestore_about_page_welcome_admin_notice' ), 99 );
			}
		}

		/**
		 * Display an admin notice linking to the about page
		 */
		public function mestore_about_page_welcome_admin_notice() {
			if ( ! empty( $this->notification ) ) {
				echo '<div class="updated notice is-dismissible">';
				echo wp_kses_post( $this->notification );
				echo '</div>';
			}
		}		

	}
}


/**
 *  Adding a About page 
 */
add_action('admin_menu', 'mestore_add_menu');

function mestore_add_menu() {
     add_theme_page(esc_html__('About MeStore Theme','mestore'), esc_html__('MeStore Info','mestore'),'manage_options', esc_html__('mestore-theme-info','mestore'), esc_html__('mestore_theme_info','mestore'));
}

/**
 *  Callback
 */
function MESTORE_theme_info() {
?>
	<div class="theme-info">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="title">
						<h2><?php esc_html_e( 'Thank you for using MeStore Free WordPress theme', 'mestore' ); ?></h2>
						<div class="title-content">
							<p><?php esc_html_e( '#', 'mestore' ); ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-visibility"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW DEMO', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-format-aside"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_DOC_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW DOCUMENTATION', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-video-alt2"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_VIDEOS_URL); ?>" target="_blank"><?php esc_html_e( 'VIDEO TUTORIALS', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-sos"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_SUPPORT_URL); ?>" target="_blank"><?php esc_html_e( 'ASK FOR SUPPORT', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
			
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-star-filled"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_RATINGS_URL); ?>" target="_blank"><?php esc_html_e( 'RATE OUR THEME', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-admin-tools"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(MESTORE_THEME_CHANGELOGS_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW CHANGELOGS', 'mestore' ); ?></a></h3>
						</div>						
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="comp-box">
						<center><h2 class="table-heading"><?php esc_html_e( 'Why should you Upgrade to our PRO Addon ?', 'mestore' ); ?></h2></center>
						<div class="comp-table">
							<table>
								<thead> 
									<tr> 
									 	<td class="thead-column1"><strong><h4><?php esc_html_e( 'Feature', 'mestore' ); ?></h4></strong></td>
										<td class="thead-column2"><strong><h4><?php esc_html_e( 'MeStore Free', 'mestore' ); ?></h4></strong></td>
										<td class="thead-column3"><strong><h4><?php esc_html_e( 'Pro Addon Plugin', 'mestore' ); ?></h4></strong></td>
									</tr> 
								</thead>
								<tbody>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Favicon, Logo, Title and Tagline Customization', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Customizer Theme Options', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '2 Custom Widgets', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'WooCommerce', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Product Category Menu', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Menu Cart', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '2 Layout Settings', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Top Bar', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Preloader', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Responsive Design', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'RTL Support', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Sidebar Options (Full, Left and Right)', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Gutenberg Compatible', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '1 Click Demo Import', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Color Settings', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><?php esc_html_e( 'Limited', 'mestore' ); ?></td>
					 					<td class="tbody-column3"><?php esc_html_e( 'Extended', 'mestore' ); ?></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Light and Dark Mode', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '800+ Google Fonts', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Social Sharing Icons', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Author Details in Single Post', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Author Widget with Social Icons', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>

									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'WooCommerce Extra Settings', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Products Wishlist', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Products Compare', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Sticky Header', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Breadcrumb Display', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Footer Editor', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Related Posts', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Header Slider', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Testimonial Slider', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Footer Columns Widgets', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'PRO Demos', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Priority Support', 'mestore' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr> 
									<tr class="last-row"> 
					 					<td class="tbody-column1"></td>
					 					<td class="tbody-column2"></td>
					 					<td class="tbody-column3"><a class="button button-primary button-large" href="<?php echo esc_url(MESTORE_THEME_PRO_URL); ?>" target="_blank"><?php esc_html_e( 'Upgrade to PRO', 'mestore' ); ?></a></td>
									</tr> 
				   				</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="title">
						<div class="review-content">
							<p><?php esc_html_e( ' Please ', 'mestore' )  ?><a href="<?php echo esc_url(MESTORE_THEME_RATINGS_URL); ?>" target="_blank"><?php esc_html_e( 'rate our theme', 'mestore' ); ?></a>
							<?php esc_html_e( '★★★★★ to help us spread the word. Thank you from the Spiracle Themes team!', 'mestore' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
<?php
}
