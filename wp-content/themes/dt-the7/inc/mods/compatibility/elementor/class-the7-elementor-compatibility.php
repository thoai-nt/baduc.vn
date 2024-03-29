<?php
/**
 * The7 Elementor plugin compatibility class.
 * @since   7.7.0
 * @package The7
 */


use Elementor\Core\Settings\Manager as Settings_Manager;
use Elementor\Plugin as Elementor;
use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document;
use ElementorPro\Modules\ThemeBuilder\Module as ThemeBuilderModule;
use The7\Adapters\Elementor\The7_Elementor_Page_Settings;
use The7\Adapters\Elementor\The7_Elementor_Template_Manager;
use The7\Adapters\Elementor\The7_Elementor_Widgets;
use The7\Adapters\Elementor\The7_Kit_Manager_Control;
use The7\Adapters\Elementor\The7_Schemes_Manager_Control;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Elementor_Compatibility
 */
class The7_Elementor_Compatibility {

	/**
	 * Instance.
	 * Holds the plugin instance.
	 * @since  1.0.0
	 * @access public
	 * @static
	 * @var Plugin
	 */
	public static $instance = null;

	public $page_settings;
	public $icons_extension;
	public $widgets;
	public $template_manager;
	public $theme_builder_adapter;
	public $kit_manager_control;
	public $scheme_manager_control;

	/**
	 * Instance.
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 * @since  1.0.0
	 * @access public
	 * @static
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->bootstrap();
		}

		return self::$instance;
	}

	/**
	 * Bootstrap module.
	 */
	public function bootstrap() {
		require_once __DIR__ . '/elementor-functions.php';
		require_once __DIR__ . '/class-the7-elementor-widgets.php';
		require_once __DIR__ . '/class-the7-elementor-page-settings.php';
		require_once __DIR__ . '/class-the7-elementor-icons-extension.php';
		require_once __DIR__ . '/meta-adapters/class-the7-elementor-color-meta-adapter.php';
		require_once __DIR__ . '/meta-adapters/class-the7-elementor-padding-meta-adapter.php';
		require_once __DIR__ . '/class-the7-elementor-kit-manager-control.php';
		require_once __DIR__ . '/class-the7-elementor-schemes-manager-control.php';
		require_once __DIR__ . '/class-the7-elementor-template-manager.php';
		require_once __DIR__ . '/upgrade/class-the7-elementor-updater.php';
		require_once __DIR__ . '/upgrade/class-the7-elementor-widget-migrations.php';
		require_once __DIR__ . '/upgrade/widgets/class-the7-elementor-masonry-migrations.php';

		$this->page_settings = new The7_Elementor_Page_Settings();
		$this->page_settings->bootstrap();

		$this->icons_extension = new The7_Elementor_Icons_Extension();
		$this->icons_extension->bootstrap();

		$this->widgets = new The7_Elementor_Widgets();
		$this->widgets->bootstrap();

		$this->template_manager = new The7_Elementor_Template_Manager();
		$this->template_manager->bootstrap();

		if ( true )//todo add option dependency
		{
			$this->kit_manager_control = new The7_Kit_Manager_Control();
			$this->kit_manager_control->bootstrap();
		}

		if ( true )//todo add option dependency
		{
			$this->scheme_manager_control = new The7_Schemes_Manager_Control();
			$this->scheme_manager_control->bootstrap();
		}

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$this->bootstrap_pro();
		}

		add_action( 'wp_enqueue_scripts',   [ $this, 'enqueue_elementor_global_style_css'], 30  );
		add_filter( 'presscore_localized_script', [ $this, 'extract_elementor_settings_to_js' ] );
	}

	/**
	 * @param array $dt_local
	 *
	 * @return array
	 */
	public function extract_elementor_settings_to_js( $dt_local ) {
		$dt_local['elementor'] = [
			'settings' => [
				'container_width' => (int) self::get_elementor_settings( 'elementor_container_width' ),
			],
		];

		return $dt_local;
	}

	/**
	 * @return array|mixed|null
	 */
	public static function get_elementor_settings( $key = null ) {
		return Settings_Manager::get_settings_managers( 'general' )->get_model()->get_settings( $key );
	}

	protected function bootstrap_pro() {
		require_once __DIR__ . '/pro/class-the7-elementor-theme-builder-adapter.php';

		$this->theme_builder_adapter = new \The7\Adapters\Elementor\Pro\The7_Elementor_Theme_Builder_Adapter();
		$this->theme_builder_adapter->bootstrap();
		if ( dt_is_woocommerce_enabled() ) {
			require_once __DIR__ . '/pro/modules/woocommerce/class-the7-woocommerce-support.php';
			new \The7\Adapters\Elementor\Pro\WoocommerceSupport\Woocommerce_Support();
		}

	}

	public static function get_applied_archive_page_id( $page_id = null ) {
		$document = false;
		$location = '';
		if ( is_singular() ) {
			$document = self::get_frontend_document();
		}
		if ( $document && $document instanceof Theme_Document ) {
			// For editor preview iframe.
			$location = $document->get_location();
		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			$location = 'archive';
		} elseif ( is_archive() || is_tax() || is_home() || is_search() ) {
			$location = 'archive';
		} elseif ( is_singular() || is_404() ) {
			$location = 'single';
		}
		if ( ! empty( $location ) ) {
			return self::get_document_id_for_location( $location, $page_id );
		}

		return $page_id;
	}

	public static function get_frontend_document() {
		return Elementor::$instance->documents->get_doc_for_frontend( get_the_ID() );
	}

	/**
	 * @param string $location
	 * @param null   $page_id
	 *
	 * @return int|null
	 */
	public static function get_document_id_for_location( $location, $page_id = null ) {
		$document = self::get_document_applied_for_location( $location );
		if ( $document ) {
			$page_id = $document->get_post()->ID;
		}

		return $page_id;
	}

	/**
	 * @return \Elementor\Core\Base\Document|false
	 */
	public static function get_document_applied_for_location( $location ) {
		$document = null;
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$documents = ThemeBuilderModule::instance()->get_conditions_manager()->get_documents_for_location( $location );
			foreach ( $documents as $document ) {
				if ( is_preview() || Elementor::$instance->preview->is_preview_mode() ) {
					$document = Elementor::$instance->documents->get_doc_or_auto_save( $document->get_id(), get_current_user_id() );
				} else {
					$document = Elementor::$instance->documents->get( $document->get_id() );
				}
				break;
			}
		}

		return $document;
	}

	public static function enqueue_elementor_global_style_css() {
		the7_register_style(
			'the7-elementor-global',
			PRESSCORE_THEME_URI . '/css/compatibility/elementor/elementor-global'
		);

		wp_enqueue_style( 'the7-elementor-global' );
	}
}
