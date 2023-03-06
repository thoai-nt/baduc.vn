<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 *
 * Class Vc_IconPicker
 * @since 4.4
 * See example usage in shortcode 'vc_icon'
 *
 *      `` example
 *        array(
 *            'type' => 'iconpicker',
 *            'heading' => esc_html__( 'Icon', 'js_composer' ),
 *            'param_name' => 'icon_fontawesome',
 *            'settings' => array(
 *                'emptyIcon' => false, // default true, display an "EMPTY"
 *     icon? - if false it will display first icon from set as default.
 *                'iconsPerPage' => 200, // default 100, how many icons
 *     per/page to display
 *            ),
 *            'dependency' => array(
 *                'element' => 'type',
 *                'value' => 'fontawesome',
 *            ),
 *        ),
 * vc_filter: vc_iconpicker-type-{your_icon_font_name} - filter to add new icon
 *     font type. see example for vc_iconpicker-type-fontawesome in bottom of
 *     this file Also // SEE HOOKS FOLDER FOR FONTS REGISTERING/ENQUEUE IN BASE
 * @path "/include/autoload/hook-vc-iconpicker-param.php"
 */
class Vc_IconPicker {
	/**
	 * @since 4.4
	 * @var array - save current param data array from vc_map
	 */
	protected $settings;
	/**
	 * @since 4.4
	 * @var string - save a current field value
	 */
	protected $value;
	/**
	 * @since 4.4
	 * @var array - optional, can be used as self source from self array., you
	 *     can pass it also with filter see Vc_IconPicker::setDefaults
	 */
	protected $source = array();

	/**
	 * @param $settings - param field data array
	 * @param $value - param field value
	 * @since 4.4
	 *
	 */
	public function __construct( $settings, $value ) {
		$this->settings = $settings;
		$this->setDefaults();

		$this->value = $value; // param field value
	}

	/**
	 * Set default function will extend current settings with defaults
	 * It can be used in Vc_IconPicker::render, but also it is passed to input
	 * field and was hooked in composer-atts.js file See vc.atts.iconpicker in
	 * wp-content/plugins/js_composer/assets/js/params/composer-atts.js init
	 * method
	 *  - it initializes javascript logic, you can provide ANY default param to
	 * it with 'settings' key
	 * @since 4.4
	 */
	protected function setDefaults() {
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['type'] ) ) {
			$this->settings['settings']['type'] = 'fontawesome'; // Default type for icons
		}

		// More about this you can read in http://codeb.it/fonticonpicker/
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['hasSearch'] ) ) {
			// Whether or not to show the search bar.
			$this->settings['settings']['hasSearch'] = true;
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['emptyIcon'] ) ) {
			// Whether or not empty icon should be shown on the icon picker
			$this->settings['settings']['emptyIcon'] = true;
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['allCategoryText'] ) ) {
			// If categorized then use this option
			$this->settings['settings']['allCategoryText'] = esc_html__( 'From all categories', 'js_composer' );
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['unCategorizedText'] ) ) {
			// If categorized then use this option
			$this->settings['settings']['unCategorizedText'] = esc_html__( 'Uncategorized', 'js_composer' );
		}

		/**
		 * Source for icons, can be passed via "mapping" or with filter vc_iconpicker-type-{your_type} (default fontawesome)
		 * vc_filter: vc_iconpicker-type-{your_type} (default fontawesome)
		 */
		if ( isset( $this->settings['settings'], $this->settings['settings']['source'] ) ) {
			$this->source = $this->settings['settings']['source'];
			unset( $this->settings['settings']['source'] ); // We don't need this on frontend.(js)
		}
	}

	/**
	 * Render edit form field type 'iconpicker' with selected settings and
	 * provided value. It uses javascript file vc-icon-picker
	 * (vc_iconpicker_base_register_js, vc_iconpicker_editor_jscss), see
	 * wp-content/plugins/js_composer/include/autoload/hook-vc-iconpicker-param.php
	 * folder
	 * @return string - rendered param field for editor panel
	 * @since 4.4
	 */
	public function render() {

		$output = '<div class="vc-iconpicker-wrapper"><select class="vc-iconpicker">';

		// call filter vc_iconpicker-type-{your_type}, e.g. vc_iconpicker-type-fontawesome with passed source from shortcode(default empty array). to get icons
		$arr = apply_filters( 'vc_iconpicker-type-' . esc_attr( $this->settings['settings']['type'] ), $this->source );
		if ( isset( $this->settings['settings'], $this->settings['settings']['emptyIcon'] ) && true === $this->settings['settings']['emptyIcon'] ) {
			array_unshift( $arr, array() );
		}
		if ( ! empty( $arr ) ) {
			foreach ( $arr as $group => $icons ) {
				if ( ! is_array( $icons ) || ! is_array( current( $icons ) ) ) {
					$class_key = key( $icons );
					$output .= '<option value="' . esc_attr( $class_key ) . '" ' . ( strcmp( $class_key, $this->value ) === 0 ? 'selected' : '' ) . '>' . esc_html( current( $icons ) ) . '</option>' . "\n";
				} else {
					$output .= '<optgroup label="' . esc_attr( $group ) . '">' . "\n";
					foreach ( $icons as $key => $label ) {
						$class_key = key( $label );
						$output .= '<option value="' . esc_attr( $class_key ) . '" ' . ( strcmp( $class_key, $this->value ) === 0 ? 'selected' : '' ) . '>' . esc_html( current( $label ) ) . '</option>' . "\n";
					}
					$output .= '</optgroup>' . "\n";
				}
			}
		}
		$output .= '</select></div>';

		$output .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value  ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $this->value ) . '" ' . ( ( isset( $this->settings['settings'] ) && ! empty( $this->settings['settings'] ) ) ? ' data-settings="' . esc_attr( wp_json_encode( $this->settings['settings'] ) ) . '" ' : '' ) . ' />';

		return $output;
	}
}

/**
 * Function for rendering param in edit form (add element)
 * Parse settings from vc_map and entered values.
 *
 * @param $settings
 * @param $value
 * @param $tag
 *
 * @return string - rendered template for params in edit form
 *
 * @since 4.4
 */
function vc_iconpicker_form_field( $settings, $value, $tag ) {

	$icon_picker = new Vc_IconPicker( $settings, $value );

	return apply_filters( 'vc_iconpicker_render_filter', $icon_picker->render() );
}

// SEE HOOKS FOLDER FOR FONTS REGISTERING/ENQUEUE IN BASE @path "/include/autoload/hook-vc-iconpicker-param.php"

add_filter( 'vc_iconpicker-type-fontawesome', 'vc_iconpicker_type_fontawesome' );

/**
 * Fontawesome icons from FontAwesome :)
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_fontawesome( $icons ) {
	// Categorized icons ( you can also output simple array ( key=> value ), where key = icon class, value = icon readable name ).
	/**
	 * @version 4.7
	 */
	$fontawesome_icons = array(
		'Accessibility' => array(
			array( 'fab fa-accessible-icon' => 'Accessible Icon (accessibility,handicap,person,wheelchair,wheelchair-alt)' ),
			array( 'fas fa-american-sign-language-interpreting' => 'American Sign Language Interpreting (asl,deaf,finger,hand,interpret,speak)' ),
			array( 'fas fa-assistive-listening-systems' => 'Assistive Listening Systems (amplify,audio,deaf,ear,headset,hearing,sound)' ),
			array( 'fas fa-audio-description' => 'Audio Description (blind,narration,video,visual)' ),
			array( 'fas fa-blind' => 'Blind (cane,disability,person,sight)' ),
			array( 'fas fa-braille' => 'Braille (alphabet,blind,dots,raised,vision)' ),
			array( 'fas fa-closed-captioning' => 'Closed Captioning (cc,deaf,hearing,subtitle,subtitling,text,video)' ),
			array( 'far fa-closed-captioning' => 'Closed Captioning (cc,deaf,hearing,subtitle,subtitling,text,video)' ),
			array( 'fas fa-deaf' => 'Deaf (ear,hearing,sign language)' ),
			array( 'fas fa-low-vision' => 'Low Vision (blind,eye,sight)' ),
			array( 'fas fa-phone-volume' => 'Phone Volume (call,earphone,number,sound,support,telephone,voice,volume-control-phone)' ),
			array( 'fas fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'far fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'fas fa-sign-language' => 'Sign Language (Translate,asl,deaf,hands)' ),
			array( 'fas fa-tty' => 'TTY (communication,deaf,telephone,teletypewriter,text)' ),
			array( 'fas fa-universal-access' => 'Universal Access (accessibility,hearing,person,seeing,visual impairment)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
		),
		'Alert' => array(
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-exclamation' => 'exclamation (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-circle' => 'Exclamation Circle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-triangle' => 'Exclamation Triangle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-radiation' => 'Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-radiation-alt' => 'Alternate Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
		),
		'Animals' => array(
			array( 'fas fa-cat' => 'Cat (feline,halloween,holiday,kitten,kitty,meow,pet)' ),
			array( 'fas fa-crow' => 'Crow (bird,bullfrog,fauna,halloween,holiday,toad)' ),
			array( 'fas fa-dog' => 'Dog (animal,canine,fauna,mammal,pet,pooch,puppy,woof)' ),
			array( 'fas fa-dove' => 'Dove (bird,fauna,flying,peace,war)' ),
			array( 'fas fa-dragon' => 'Dragon (Dungeons & Dragons,d&d,dnd,fantasy,fire,lizard,serpent)' ),
			array( 'fas fa-feather' => 'Feather (bird,light,plucked,quill,write)' ),
			array( 'fas fa-feather-alt' => 'Alternate Feather (bird,light,plucked,quill,write)' ),
			array( 'fas fa-fish' => 'Fish (fauna,gold,seafood,swimming)' ),
			array( 'fas fa-frog' => 'Frog (amphibian,bullfrog,fauna,hop,kermit,kiss,prince,ribbit,toad,wart)' ),
			array( 'fas fa-hippo' => 'Hippo (animal,fauna,hippopotamus,hungry,mammal)' ),
			array( 'fas fa-horse' => 'Horse (equus,fauna,mammmal,mare,neigh,pony)' ),
			array( 'fas fa-horse-head' => 'Horse Head (equus,fauna,mammmal,mare,neigh,pony)' ),
			array( 'fas fa-kiwi-bird' => 'Kiwi Bird (bird,fauna,new zealand)' ),
			array( 'fas fa-otter' => 'Otter (animal,badger,fauna,fur,mammal,marten)' ),
			array( 'fas fa-paw' => 'Paw (animal,cat,dog,pet,print)' ),
			array( 'fas fa-spider' => 'Spider (arachnid,bug,charlotte,crawl,eight,halloween)' ),
		),
		'Arrows' => array(
			array( 'fas fa-angle-double-down' => 'Angle Double Down (arrows,caret,download,expand)' ),
			array( 'fas fa-angle-double-left' => 'Angle Double Left (arrows,back,caret,laquo,previous,quote)' ),
			array( 'fas fa-angle-double-right' => 'Angle Double Right (arrows,caret,forward,more,next,quote,raquo)' ),
			array( 'fas fa-angle-double-up' => 'Angle Double Up (arrows,caret,collapse,upload)' ),
			array( 'fas fa-angle-down' => 'angle-down (arrow,caret,download,expand)' ),
			array( 'fas fa-angle-left' => 'angle-left (arrow,back,caret,less,previous)' ),
			array( 'fas fa-angle-right' => 'angle-right (arrow,care,forward,more,next)' ),
			array( 'fas fa-angle-up' => 'angle-up (arrow,caret,collapse,upload)' ),
			array( 'fas fa-arrow-alt-circle-down' => 'Alternate Arrow Circle Down (arrow-circle-o-down,download)' ),
			array( 'far fa-arrow-alt-circle-down' => 'Alternate Arrow Circle Down (arrow-circle-o-down,download)' ),
			array( 'fas fa-arrow-alt-circle-left' => 'Alternate Arrow Circle Left (arrow-circle-o-left,back,previous)' ),
			array( 'far fa-arrow-alt-circle-left' => 'Alternate Arrow Circle Left (arrow-circle-o-left,back,previous)' ),
			array( 'fas fa-arrow-alt-circle-right' => 'Alternate Arrow Circle Right (arrow-circle-o-right,forward,next)' ),
			array( 'far fa-arrow-alt-circle-right' => 'Alternate Arrow Circle Right (arrow-circle-o-right,forward,next)' ),
			array( 'fas fa-arrow-alt-circle-up' => 'Alternate Arrow Circle Up (arrow-circle-o-up)' ),
			array( 'far fa-arrow-alt-circle-up' => 'Alternate Arrow Circle Up (arrow-circle-o-up)' ),
			array( 'fas fa-arrow-circle-down' => 'Arrow Circle Down (download)' ),
			array( 'fas fa-arrow-circle-left' => 'Arrow Circle Left (back,previous)' ),
			array( 'fas fa-arrow-circle-right' => 'Arrow Circle Right (forward,next)' ),
			array( 'fas fa-arrow-circle-up' => 'Arrow Circle Up (upload)' ),
			array( 'fas fa-arrow-down' => 'arrow-down (download)' ),
			array( 'fas fa-arrow-left' => 'arrow-left (back,previous)' ),
			array( 'fas fa-arrow-right' => 'arrow-right (forward,next)' ),
			array( 'fas fa-arrow-up' => 'arrow-up (forward,upload)' ),
			array( 'fas fa-arrows-alt' => 'Alternate Arrows (arrow,arrows,bigger,enlarge,expand,fullscreen,move,position,reorder,resize)' ),
			array( 'fas fa-arrows-alt-h' => 'Alternate Arrows Horizontal (arrows-h,expand,horizontal,landscape,resize,wide)' ),
			array( 'fas fa-arrows-alt-v' => 'Alternate Arrows Vertical (arrows-v,expand,portrait,resize,tall,vertical)' ),
			array( 'fas fa-caret-down' => 'Caret Down (arrow,dropdown,expand,menu,more,triangle)' ),
			array( 'fas fa-caret-left' => 'Caret Left (arrow,back,previous,triangle)' ),
			array( 'fas fa-caret-right' => 'Caret Right (arrow,forward,next,triangle)' ),
			array( 'fas fa-caret-square-down' => 'Caret Square Down (arrow,caret-square-o-down,dropdown,expand,menu,more,triangle)' ),
			array( 'far fa-caret-square-down' => 'Caret Square Down (arrow,caret-square-o-down,dropdown,expand,menu,more,triangle)' ),
			array( 'fas fa-caret-square-left' => 'Caret Square Left (arrow,back,caret-square-o-left,previous,triangle)' ),
			array( 'far fa-caret-square-left' => 'Caret Square Left (arrow,back,caret-square-o-left,previous,triangle)' ),
			array( 'fas fa-caret-square-right' => 'Caret Square Right (arrow,caret-square-o-right,forward,next,triangle)' ),
			array( 'far fa-caret-square-right' => 'Caret Square Right (arrow,caret-square-o-right,forward,next,triangle)' ),
			array( 'fas fa-caret-square-up' => 'Caret Square Up (arrow,caret-square-o-up,collapse,triangle,upload)' ),
			array( 'far fa-caret-square-up' => 'Caret Square Up (arrow,caret-square-o-up,collapse,triangle,upload)' ),
			array( 'fas fa-caret-up' => 'Caret Up (arrow,collapse,triangle)' ),
			array( 'fas fa-cart-arrow-down' => 'Shopping Cart Arrow Down (download,save,shopping)' ),
			array( 'fas fa-chart-line' => 'Line Chart (activity,analytics,chart,dashboard,gain,graph,increase,line)' ),
			array( 'fas fa-chevron-circle-down' => 'Chevron Circle Down (arrow,download,dropdown,menu,more)' ),
			array( 'fas fa-chevron-circle-left' => 'Chevron Circle Left (arrow,back,previous)' ),
			array( 'fas fa-chevron-circle-right' => 'Chevron Circle Right (arrow,forward,next)' ),
			array( 'fas fa-chevron-circle-up' => 'Chevron Circle Up (arrow,collapse,upload)' ),
			array( 'fas fa-chevron-down' => 'chevron-down (arrow,download,expand)' ),
			array( 'fas fa-chevron-left' => 'chevron-left (arrow,back,bracket,previous)' ),
			array( 'fas fa-chevron-right' => 'chevron-right (arrow,bracket,forward,next)' ),
			array( 'fas fa-chevron-up' => 'chevron-up (arrow,collapse,upload)' ),
			array( 'fas fa-cloud-download-alt' => 'Alternate Cloud Download (download,export,save)' ),
			array( 'fas fa-cloud-upload-alt' => 'Alternate Cloud Upload (cloud-upload,import,save,upload)' ),
			array( 'fas fa-compress-arrows-alt' => 'Alternate Compress Arrows (collapse,fullscreen,minimize,move,resize,shrink,smaller)' ),
			array( 'fas fa-download' => 'Download (export,hard drive,save,transfer)' ),
			array( 'fas fa-exchange-alt' => 'Alternate Exchange (arrow,arrows,exchange,reciprocate,return,swap,transfer)' ),
			array( 'fas fa-expand-arrows-alt' => 'Alternate Expand Arrows (arrows-alt,bigger,enlarge,move,resize)' ),
			array( 'fas fa-external-link-alt' => 'Alternate External Link (external-link,new,open,share)' ),
			array( 'fas fa-external-link-square-alt' => 'Alternate External Link Square (external-link-square,new,open,share)' ),
			array( 'fas fa-hand-point-down' => 'Hand Pointing Down (finger,hand-o-down,point)' ),
			array( 'far fa-hand-point-down' => 'Hand Pointing Down (finger,hand-o-down,point)' ),
			array( 'fas fa-hand-point-left' => 'Hand Pointing Left (back,finger,hand-o-left,left,point,previous)' ),
			array( 'far fa-hand-point-left' => 'Hand Pointing Left (back,finger,hand-o-left,left,point,previous)' ),
			array( 'fas fa-hand-point-right' => 'Hand Pointing Right (finger,forward,hand-o-right,next,point,right)' ),
			array( 'far fa-hand-point-right' => 'Hand Pointing Right (finger,forward,hand-o-right,next,point,right)' ),
			array( 'fas fa-hand-point-up' => 'Hand Pointing Up (finger,hand-o-up,point)' ),
			array( 'far fa-hand-point-up' => 'Hand Pointing Up (finger,hand-o-up,point)' ),
			array( 'fas fa-hand-pointer' => 'Pointer (Hand) (arrow,cursor,select)' ),
			array( 'far fa-hand-pointer' => 'Pointer (Hand) (arrow,cursor,select)' ),
			array( 'fas fa-history' => 'History (Rewind,clock,reverse,time,time machine)' ),
			array( 'fas fa-level-down-alt' => 'Alternate Level Down (arrow,level-down)' ),
			array( 'fas fa-level-up-alt' => 'Alternate Level Up (arrow,level-up)' ),
			array( 'fas fa-location-arrow' => 'location-arrow (address,compass,coordinate,direction,gps,map,navigation,place)' ),
			array( 'fas fa-long-arrow-alt-down' => 'Alternate Long Arrow Down (download,long-arrow-down)' ),
			array( 'fas fa-long-arrow-alt-left' => 'Alternate Long Arrow Left (back,long-arrow-left,previous)' ),
			array( 'fas fa-long-arrow-alt-right' => 'Alternate Long Arrow Right (forward,long-arrow-right,next)' ),
			array( 'fas fa-long-arrow-alt-up' => 'Alternate Long Arrow Up (long-arrow-up,upload)' ),
			array( 'fas fa-mouse-pointer' => 'Mouse Pointer (arrow,cursor,select)' ),
			array( 'fas fa-play' => 'play (audio,music,playing,sound,start,video)' ),
			array( 'fas fa-random' => 'random (arrows,shuffle,sort,swap,switch,transfer)' ),
			array( 'fas fa-recycle' => 'Recycle (Waste,compost,garbage,reuse,trash)' ),
			array( 'fas fa-redo' => 'Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-redo-alt' => 'Alternate Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-reply' => 'Reply (mail,message,respond)' ),
			array( 'fas fa-reply-all' => 'reply-all (mail,message,respond)' ),
			array( 'fas fa-retweet' => 'Retweet (refresh,reload,share,swap)' ),
			array( 'fas fa-share' => 'Share (forward,save,send,social)' ),
			array( 'fas fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'far fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'fas fa-sign-in-alt' => 'Alternate Sign In (arrow,enter,join,log in,login,sign in,sign up,sign-in,signin,signup)' ),
			array( 'fas fa-sign-out-alt' => 'Alternate Sign Out (arrow,exit,leave,log out,logout,sign-out)' ),
			array( 'fas fa-sort' => 'Sort (filter,order)' ),
			array( 'fas fa-sort-alpha-down' => 'Sort Alphabetical Down (alphabetical,arrange,filter,order,sort-alpha-asc)' ),
			array( 'fas fa-sort-alpha-down-alt' => 'Alternate Sort Alphabetical Down (alphabetical,arrange,filter,order,sort-alpha-asc)' ),
			array( 'fas fa-sort-alpha-up' => 'Sort Alphabetical Up (alphabetical,arrange,filter,order,sort-alpha-desc)' ),
			array( 'fas fa-sort-alpha-up-alt' => 'Alternate Sort Alphabetical Up (alphabetical,arrange,filter,order,sort-alpha-desc)' ),
			array( 'fas fa-sort-amount-down' => 'Sort Amount Down (arrange,filter,number,order,sort-amount-asc)' ),
			array( 'fas fa-sort-amount-down-alt' => 'Alternate Sort Amount Down (arrange,filter,order,sort-amount-asc)' ),
			array( 'fas fa-sort-amount-up' => 'Sort Amount Up (arrange,filter,order,sort-amount-desc)' ),
			array( 'fas fa-sort-amount-up-alt' => 'Alternate Sort Amount Up (arrange,filter,order,sort-amount-desc)' ),
			array( 'fas fa-sort-down' => 'Sort Down (Descending) (arrow,descending,filter,order,sort-desc)' ),
			array( 'fas fa-sort-numeric-down' => 'Sort Numeric Down (arrange,filter,numbers,order,sort-numeric-asc)' ),
			array( 'fas fa-sort-numeric-down-alt' => 'Alternate Sort Numeric Down (arrange,filter,numbers,order,sort-numeric-asc)' ),
			array( 'fas fa-sort-numeric-up' => 'Sort Numeric Up (arrange,filter,numbers,order,sort-numeric-desc)' ),
			array( 'fas fa-sort-numeric-up-alt' => 'Alternate Sort Numeric Up (arrange,filter,numbers,order,sort-numeric-desc)' ),
			array( 'fas fa-sort-up' => 'Sort Up (Ascending) (arrow,ascending,filter,order,sort-asc)' ),
			array( 'fas fa-sync' => 'Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-sync-alt' => 'Alternate Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-text-height' => 'text-height (edit,font,format,text,type)' ),
			array( 'fas fa-text-width' => 'Text Width (edit,font,format,text,type)' ),
			array( 'fas fa-undo' => 'Undo (back,control z,exchange,oops,return,rotate,swap)' ),
			array( 'fas fa-undo-alt' => 'Alternate Undo (back,control z,exchange,oops,return,swap)' ),
			array( 'fas fa-upload' => 'Upload (hard drive,import,publish)' ),
		),
		'Audio & Video' => array(
			array( 'fas fa-audio-description' => 'Audio Description (blind,narration,video,visual)' ),
			array( 'fas fa-backward' => 'backward (previous,rewind)' ),
			array( 'fas fa-broadcast-tower' => 'Broadcast Tower (airwaves,antenna,radio,reception,waves)' ),
			array( 'fas fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'far fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'fas fa-closed-captioning' => 'Closed Captioning (cc,deaf,hearing,subtitle,subtitling,text,video)' ),
			array( 'far fa-closed-captioning' => 'Closed Captioning (cc,deaf,hearing,subtitle,subtitling,text,video)' ),
			array( 'fas fa-compress' => 'Compress (collapse,fullscreen,minimize,move,resize,shrink,smaller)' ),
			array( 'fas fa-compress-arrows-alt' => 'Alternate Compress Arrows (collapse,fullscreen,minimize,move,resize,shrink,smaller)' ),
			array( 'fas fa-eject' => 'eject (abort,cancel,cd,discharge)' ),
			array( 'fas fa-expand' => 'Expand (arrow,bigger,enlarge,resize)' ),
			array( 'fas fa-expand-arrows-alt' => 'Alternate Expand Arrows (arrows-alt,bigger,enlarge,move,resize)' ),
			array( 'fas fa-fast-backward' => 'fast-backward (beginning,first,previous,rewind,start)' ),
			array( 'fas fa-fast-forward' => 'fast-forward (end,last,next)' ),
			array( 'fas fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'far fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'fas fa-file-video' => 'Video File (document,m4v,movie,mp4,play)' ),
			array( 'far fa-file-video' => 'Video File (document,m4v,movie,mp4,play)' ),
			array( 'fas fa-film' => 'Film (cinema,movie,strip,video)' ),
			array( 'fas fa-forward' => 'forward (forward,next,skip)' ),
			array( 'fas fa-headphones' => 'headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt-slash' => 'Alternate Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-music' => 'Music (lyrics,melody,note,sing,sound)' ),
			array( 'fas fa-pause' => 'pause (hold,wait)' ),
			array( 'fas fa-pause-circle' => 'Pause Circle (hold,wait)' ),
			array( 'far fa-pause-circle' => 'Pause Circle (hold,wait)' ),
			array( 'fas fa-phone-volume' => 'Phone Volume (call,earphone,number,sound,support,telephone,voice,volume-control-phone)' ),
			array( 'fas fa-photo-video' => 'Photo Video (av,film,image,library,media)' ),
			array( 'fas fa-play' => 'play (audio,music,playing,sound,start,video)' ),
			array( 'fas fa-play-circle' => 'Play Circle (audio,music,playing,sound,start,video)' ),
			array( 'far fa-play-circle' => 'Play Circle (audio,music,playing,sound,start,video)' ),
			array( 'fas fa-podcast' => 'Podcast (audio,broadcast,music,sound)' ),
			array( 'fas fa-random' => 'random (arrows,shuffle,sort,swap,switch,transfer)' ),
			array( 'fas fa-redo' => 'Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-redo-alt' => 'Alternate Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-rss' => 'rss (blog,feed,journal,news,writing)' ),
			array( 'fas fa-rss-square' => 'RSS Square (blog,feed,journal,news,writing)' ),
			array( 'fas fa-step-backward' => 'step-backward (beginning,first,previous,rewind,start)' ),
			array( 'fas fa-step-forward' => 'step-forward (end,last,next)' ),
			array( 'fas fa-stop' => 'stop (block,box,square)' ),
			array( 'fas fa-stop-circle' => 'Stop Circle (block,box,circle,square)' ),
			array( 'far fa-stop-circle' => 'Stop Circle (block,box,circle,square)' ),
			array( 'fas fa-sync' => 'Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-sync-alt' => 'Alternate Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
			array( 'fas fa-undo' => 'Undo (back,control z,exchange,oops,return,rotate,swap)' ),
			array( 'fas fa-undo-alt' => 'Alternate Undo (back,control z,exchange,oops,return,swap)' ),
			array( 'fas fa-video' => 'Video (camera,film,movie,record,video-camera)' ),
			array( 'fas fa-volume-down' => 'Volume Down (audio,lower,music,quieter,sound,speaker)' ),
			array( 'fas fa-volume-mute' => 'Volume Mute (audio,music,quiet,sound,speaker)' ),
			array( 'fas fa-volume-off' => 'Volume Off (audio,ban,music,mute,quiet,silent,sound)' ),
			array( 'fas fa-volume-up' => 'Volume Up (audio,higher,louder,music,sound,speaker)' ),
			array( 'fab fa-youtube' => 'YouTube (film,video,youtube-play,youtube-square)' ),
		),
		'Automotive' => array(
			array( 'fas fa-air-freshener' => 'Air Freshener (car,deodorize,fresh,pine,scent)' ),
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-bus' => 'Bus (public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-bus-alt' => 'Bus Alt (mta,public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-car' => 'Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-car-alt' => 'Alternate Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-car-battery' => 'Car Battery (auto,electric,mechanic,power)' ),
			array( 'fas fa-car-crash' => 'Car Crash (accident,auto,automobile,insurance,sedan,transportation,vehicle,wreck)' ),
			array( 'fas fa-car-side' => 'Car Side (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-charging-station' => 'Charging Station (electric,ev,tesla,vehicle)' ),
			array( 'fas fa-gas-pump' => 'Gas Pump (car,fuel,gasoline,petrol)' ),
			array( 'fas fa-motorcycle' => 'Motorcycle (bike,machine,transportation,vehicle)' ),
			array( 'fas fa-oil-can' => 'Oil Can (auto,crude,gasoline,grease,lubricate,petroleum)' ),
			array( 'fas fa-shuttle-van' => 'Shuttle Van (airport,machine,public-transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-tachometer-alt' => 'Alternate Tachometer (dashboard,fast,odometer,speed,speedometer)' ),
			array( 'fas fa-taxi' => 'Taxi (cab,cabbie,car,car service,lyft,machine,transportation,travel,uber,vehicle)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-truck-monster' => 'Truck Monster (offroad,vehicle,wheel)' ),
			array( 'fas fa-truck-pickup' => 'Truck Side (cargo,vehicle)' ),
		),
		'Autumn' => array(
			array( 'fas fa-apple-alt' => 'Fruit Apple (fall,fruit,fuji,macintosh,orchard,seasonal,vegan)' ),
			array( 'fas fa-campground' => 'Campground (camping,fall,outdoors,teepee,tent,tipi)' ),
			array( 'fas fa-cloud-sun' => 'Cloud with Sun (clear,day,daytime,fall,outdoors,overcast,partly cloudy)' ),
			array( 'fas fa-drumstick-bite' => 'Drumstick with Bite Taken Out (bone,chicken,leg,meat,poultry,turkey)' ),
			array( 'fas fa-football-ball' => 'Football Ball (ball,fall,nfl,pigskin,seasonal)' ),
			array( 'fas fa-hiking' => 'Hiking (activity,backpack,fall,fitness,outdoors,person,seasonal,walking)' ),
			array( 'fas fa-mountain' => 'Mountain (glacier,hiking,hill,landscape,travel,view)' ),
			array( 'fas fa-tractor' => 'Tractor (agriculture,farm,vehicle)' ),
			array( 'fas fa-tree' => 'Tree (bark,fall,flora,forest,nature,plant,seasonal)' ),
			array( 'fas fa-wind' => 'Wind (air,blow,breeze,fall,seasonal,weather)' ),
			array( 'fas fa-wine-bottle' => 'Wine Bottle (alcohol,beverage,cabernet,drink,glass,grapes,merlot,sauvignon)' ),
		),
		'Beverage' => array(
			array( 'fas fa-beer' => 'beer (alcohol,ale,bar,beverage,brewery,drink,lager,liquor,mug,stein)' ),
			array( 'fas fa-blender' => 'Blender (cocktail,milkshake,mixer,puree,smoothie)' ),
			array( 'fas fa-cocktail' => 'Cocktail (alcohol,beverage,drink,gin,glass,margarita,martini,vodka)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-flask' => 'Flask (beaker,experimental,labs,science)' ),
			array( 'fas fa-glass-cheers' => 'Glass Cheers (alcohol,bar,beverage,celebration,champagne,clink,drink,holiday,new year\'s eve,party,toast)' ),
			array( 'fas fa-glass-martini' => 'Martini Glass (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-glass-martini-alt' => 'Alternate Glass Martini (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-glass-whiskey' => 'Glass Whiskey (alcohol,bar,beverage,bourbon,drink,liquor,neat,rye,scotch,whisky)' ),
			array( 'fas fa-mug-hot' => 'Mug Hot (caliente,cocoa,coffee,cup,drink,holiday,hot chocolate,steam,tea,warmth)' ),
			array( 'fas fa-wine-bottle' => 'Wine Bottle (alcohol,beverage,cabernet,drink,glass,grapes,merlot,sauvignon)' ),
			array( 'fas fa-wine-glass' => 'Wine Glass (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
			array( 'fas fa-wine-glass-alt' => 'Alternate Wine Glas (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
		),
		'Brands' => array(
			array( 'fab fa-creative-commons' => 'Creative Commons' ),
			array( 'fab fa-twitter-square' => 'Twitter Square (social network,tweet)' ),
			array( 'fab fa-facebook-square' => 'Facebook Square (social network)' ),
			array( 'fab fa-linkedin' => 'LinkedIn (linkedin-square)' ),
			array( 'fab fa-github-square' => 'GitHub Square (octocat)' ),
			array( 'fab fa-twitter' => 'Twitter (social network,tweet)' ),
			array( 'fab fa-facebook-f' => 'Facebook F (facebook)' ),
			array( 'fab fa-github' => 'GitHub (octocat)' ),
			array( 'fab fa-pinterest' => 'Pinterest' ),
			array( 'fab fa-pinterest-square' => 'Pinterest Square' ),
			array( 'fab fa-google-plus-square' => 'Google Plus Square (social network)' ),
			array( 'fab fa-google-plus-g' => 'Google Plus G (google-plus,social network)' ),
			array( 'fab fa-linkedin-in' => 'LinkedIn In (linkedin)' ),
			array( 'fab fa-github-alt' => 'Alternate GitHub (octocat)' ),
			array( 'fab fa-maxcdn' => 'MaxCDN' ),
			array( 'fab fa-html5' => 'HTML 5 Logo' ),
			array( 'fab fa-css3' => 'CSS 3 Logo (code)' ),
			array( 'fab fa-youtube-square' => 'YouTube Square' ),
			array( 'fab fa-xing' => 'Xing' ),
			array( 'fab fa-xing-square' => 'Xing Square' ),
			array( 'fab fa-dropbox' => 'Dropbox' ),
			array( 'fab fa-stack-overflow' => 'Stack Overflow' ),
			array( 'fab fa-instagram' => 'Instagram' ),
			array( 'fab fa-flickr' => 'Flickr' ),
			array( 'fab fa-adn' => 'App.net' ),
			array( 'fab fa-bitbucket' => 'Bitbucket (atlassian,bitbucket-square,git)' ),
			array( 'fab fa-tumblr' => 'Tumblr' ),
			array( 'fab fa-tumblr-square' => 'Tumblr Square' ),
			array( 'fab fa-apple' => 'Apple (fruit,ios,mac,operating system,os,osx)' ),
			array( 'fab fa-windows' => 'Windows (microsoft,operating system,os)' ),
			array( 'fab fa-android' => 'Android (robot)' ),
			array( 'fab fa-linux' => 'Linux (tux)' ),
			array( 'fab fa-dribbble' => 'Dribbble' ),
			array( 'fab fa-skype' => 'Skype' ),
			array( 'fab fa-foursquare' => 'Foursquare' ),
			array( 'fab fa-trello' => 'Trello (atlassian)' ),
			array( 'fab fa-gratipay' => 'Gratipay (Gittip) (favorite,heart,like,love)' ),
			array( 'fab fa-vk' => 'VK' ),
			array( 'fab fa-weibo' => 'Weibo' ),
			array( 'fab fa-renren' => 'Renren' ),
			array( 'fab fa-pagelines' => 'Pagelines (eco,flora,leaf,leaves,nature,plant,tree)' ),
			array( 'fab fa-stack-exchange' => 'Stack Exchange' ),
			array( 'fab fa-vimeo-square' => 'Vimeo Square' ),
			array( 'fab fa-slack' => 'Slack Logo (anchor,hash,hashtag)' ),
			array( 'fab fa-wordpress' => 'WordPress Logo' ),
			array( 'fab fa-openid' => 'OpenID' ),
			array( 'fab fa-yahoo' => 'Yahoo Logo' ),
			array( 'fab fa-google' => 'Google Logo' ),
			array( 'fab fa-reddit' => 'reddit Logo' ),
			array( 'fab fa-reddit-square' => 'reddit Square' ),
			array( 'fab fa-stumbleupon-circle' => 'StumbleUpon Circle' ),
			array( 'fab fa-stumbleupon' => 'StumbleUpon Logo' ),
			array( 'fab fa-delicious' => 'Delicious' ),
			array( 'fab fa-digg' => 'Digg Logo' ),
			array( 'fab fa-pied-piper-pp' => 'Pied Piper PP Logo (Old)' ),
			array( 'fab fa-pied-piper-alt' => 'Alternate Pied Piper Logo' ),
			array( 'fab fa-drupal' => 'Drupal Logo' ),
			array( 'fab fa-joomla' => 'Joomla Logo' ),
			array( 'fab fa-behance' => 'Behance' ),
			array( 'fab fa-behance-square' => 'Behance Square' ),
			array( 'fab fa-deviantart' => 'deviantART' ),
			array( 'fab fa-vine' => 'Vine' ),
			array( 'fab fa-codepen' => 'Codepen' ),
			array( 'fab fa-jsfiddle' => 'jsFiddle' ),
			array( 'fab fa-rebel' => 'Rebel Alliance' ),
			array( 'fab fa-empire' => 'Galactic Empire' ),
			array( 'fab fa-git-square' => 'Git Square' ),
			array( 'fab fa-git' => 'Git' ),
			array( 'fab fa-hacker-news' => 'Hacker News' ),
			array( 'fab fa-tencent-weibo' => 'Tencent Weibo' ),
			array( 'fab fa-qq' => 'QQ' ),
			array( 'fab fa-weixin' => 'Weixin (WeChat)' ),
			array( 'fab fa-slideshare' => 'Slideshare' ),
			array( 'fab fa-yelp' => 'Yelp' ),
			array( 'fab fa-lastfm' => 'last.fm' ),
			array( 'fab fa-lastfm-square' => 'last.fm Square' ),
			array( 'fab fa-ioxhost' => 'ioxhost' ),
			array( 'fab fa-angellist' => 'AngelList' ),
			array( 'fab fa-font-awesome' => 'Font Awesome (meanpath)' ),
			array( 'fab fa-buysellads' => 'BuySellAds' ),
			array( 'fab fa-connectdevelop' => 'Connect Develop' ),
			array( 'fab fa-dashcube' => 'DashCube' ),
			array( 'fab fa-forumbee' => 'Forumbee' ),
			array( 'fab fa-leanpub' => 'Leanpub' ),
			array( 'fab fa-sellsy' => 'Sellsy' ),
			array( 'fab fa-shirtsinbulk' => 'Shirts in Bulk' ),
			array( 'fab fa-simplybuilt' => 'SimplyBuilt' ),
			array( 'fab fa-skyatlas' => 'skyatlas' ),
			array( 'fab fa-facebook' => 'Facebook (facebook-official,social network)' ),
			array( 'fab fa-pinterest-p' => 'Pinterest P' ),
			array( 'fab fa-whatsapp' => 'What\'s App' ),
			array( 'fab fa-viacoin' => 'Viacoin' ),
			array( 'fab fa-medium' => 'Medium' ),
			array( 'fab fa-y-combinator' => 'Y Combinator' ),
			array( 'fab fa-optin-monster' => 'Optin Monster' ),
			array( 'fab fa-opencart' => 'OpenCart' ),
			array( 'fab fa-expeditedssl' => 'ExpeditedSSL' ),
			array( 'fab fa-tripadvisor' => 'TripAdvisor' ),
			array( 'fab fa-odnoklassniki' => 'Odnoklassniki' ),
			array( 'fab fa-odnoklassniki-square' => 'Odnoklassniki Square' ),
			array( 'fab fa-get-pocket' => 'Get Pocket' ),
			array( 'fab fa-wikipedia-w' => 'Wikipedia W' ),
			array( 'fab fa-safari' => 'Safari (browser)' ),
			array( 'fab fa-chrome' => 'Chrome (browser)' ),
			array( 'fab fa-firefox' => 'Firefox (browser)' ),
			array( 'fab fa-opera' => 'Opera' ),
			array( 'fab fa-internet-explorer' => 'Internet-explorer (browser,ie)' ),
			array( 'fab fa-contao' => 'Contao' ),
			array( 'fab fa-500px' => '500px' ),
			array( 'fab fa-amazon' => 'Amazon' ),
			array( 'fab fa-houzz' => 'Houzz' ),
			array( 'fab fa-vimeo-v' => 'Vimeo (vimeo)' ),
			array( 'fab fa-black-tie' => 'Font Awesome Black Tie' ),
			array( 'fab fa-fonticons' => 'Fonticons' ),
			array( 'fab fa-reddit-alien' => 'reddit Alien' ),
			array( 'fab fa-edge' => 'Edge Browser (browser,ie)' ),
			array( 'fab fa-codiepie' => 'Codie Pie' ),
			array( 'fab fa-modx' => 'MODX' ),
			array( 'fab fa-fort-awesome' => 'Fort Awesome (castle)' ),
			array( 'fab fa-usb' => 'USB' ),
			array( 'fab fa-product-hunt' => 'Product Hunt' ),
			array( 'fab fa-mixcloud' => 'Mixcloud' ),
			array( 'fab fa-scribd' => 'Scribd' ),
			array( 'fab fa-gitlab' => 'GitLab (Axosoft)' ),
			array( 'fab fa-wpbeginner' => 'WPBeginner' ),
			array( 'fab fa-wpforms' => 'WPForms' ),
			array( 'fab fa-envira' => 'Envira Gallery (leaf)' ),
			array( 'fab fa-glide' => 'Glide' ),
			array( 'fab fa-glide-g' => 'Glide G' ),
			array( 'fab fa-viadeo' => 'Video' ),
			array( 'fab fa-viadeo-square' => 'Video Square' ),
			array( 'fab fa-snapchat' => 'Snapchat' ),
			array( 'fab fa-snapchat-ghost' => 'Snapchat Ghost' ),
			array( 'fab fa-snapchat-square' => 'Snapchat Square' ),
			array( 'fab fa-pied-piper' => 'Pied Piper Logo' ),
			array( 'fab fa-first-order' => 'First Order' ),
			array( 'fab fa-yoast' => 'Yoast' ),
			array( 'fab fa-themeisle' => 'ThemeIsle' ),
			array( 'fab fa-google-plus' => 'Google Plus (google-plus-circle,google-plus-official)' ),
			array( 'fab fa-linode' => 'Linode' ),
			array( 'fab fa-quora' => 'Quora' ),
			array( 'fab fa-free-code-camp' => 'Free Code Camp' ),
			array( 'fab fa-telegram' => 'Telegram' ),
			array( 'fab fa-bandcamp' => 'Bandcamp' ),
			array( 'fab fa-grav' => 'Grav' ),
			array( 'fab fa-etsy' => 'Etsy' ),
			array( 'fab fa-imdb' => 'IMDB' ),
			array( 'fab fa-ravelry' => 'Ravelry' ),
			array( 'fab fa-sellcast' => 'Sellcast (eercast)' ),
			array( 'fab fa-superpowers' => 'Superpowers' ),
			array( 'fab fa-wpexplorer' => 'WPExplorer' ),
			array( 'fab fa-meetup' => 'Meetup' ),
		),
		'Buildings' => array(
			array( 'fas fa-archway' => 'Archway (arc,monument,road,street,tunnel)' ),
			array( 'fas fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'far fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'fas fa-campground' => 'Campground (camping,fall,outdoors,teepee,tent,tipi)' ),
			array( 'fas fa-church' => 'Church (building,cathedral,chapel,community,religion)' ),
			array( 'fas fa-city' => 'City (buildings,busy,skyscrapers,urban,windows)' ),
			array( 'fas fa-clinic-medical' => 'Medical Clinic (doctor,general practitioner,hospital,infirmary,medicine,office,outpatient)' ),
			array( 'fas fa-dungeon' => 'Dungeon (Dungeons & Dragons,building,d&d,dnd,door,entrance,fantasy,gate)' ),
			array( 'fas fa-gopuram' => 'Gopuram (building,entrance,hinduism,temple,tower)' ),
			array( 'fas fa-home' => 'home (abode,building,house,main)' ),
			array( 'fas fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'far fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'fas fa-hospital-alt' => 'Alternate Hospital (building,emergency room,medical center)' ),
			array( 'fas fa-hotel' => 'Hotel (building,inn,lodging,motel,resort,travel)' ),
			array( 'fas fa-house-damage' => 'Damaged House (building,devastation,disaster,home,insurance)' ),
			array( 'fas fa-igloo' => 'Igloo (dome,dwelling,eskimo,home,house,ice,snow)' ),
			array( 'fas fa-industry' => 'Industry (building,factory,industrial,manufacturing,mill,warehouse)' ),
			array( 'fas fa-kaaba' => 'Kaaba (building,cube,islam,muslim)' ),
			array( 'fas fa-landmark' => 'Landmark (building,historic,memorable,monument,politics)' ),
			array( 'fas fa-monument' => 'Monument (building,historic,landmark,memorable)' ),
			array( 'fas fa-mosque' => 'Mosque (building,islam,landmark,muslim)' ),
			array( 'fas fa-place-of-worship' => 'Place of Worship (building,church,holy,mosque,synagogue)' ),
			array( 'fas fa-school' => 'School (building,education,learn,student,teacher)' ),
			array( 'fas fa-store' => 'Store (building,buy,purchase,shopping)' ),
			array( 'fas fa-store-alt' => 'Alternate Store (building,buy,purchase,shopping)' ),
			array( 'fas fa-synagogue' => 'Synagogue (building,jewish,judaism,religion,star of david,temple)' ),
			array( 'fas fa-torii-gate' => 'Torii Gate (building,shintoism)' ),
			array( 'fas fa-university' => 'University (bank,building,college,higher education - students,institution)' ),
			array( 'fas fa-vihara' => 'Vihara (buddhism,buddhist,building,monastery)' ),
			array( 'fas fa-warehouse' => 'Warehouse (building,capacity,garage,inventory,storage)' ),
		),
		'Business' => array(
			array( 'fas fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'far fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'fas fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'far fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-balance-scale' => 'Balance Scale (balanced,justice,legal,measure,weight)' ),
			array( 'fas fa-balance-scale-left' => 'Balance Scale (Left-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-balance-scale-right' => 'Balance Scale (Right-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-birthday-cake' => 'Birthday Cake (anniversary,bakery,candles,celebration,dessert,frosting,holiday,party,pastry)' ),
			array( 'fas fa-book' => 'book (diary,documentation,journal,library,read)' ),
			array( 'fas fa-briefcase' => 'Briefcase (bag,business,luggage,office,work)' ),
			array( 'fas fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'far fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-bullseye' => 'Bullseye (archery,goal,objective,target)' ),
			array( 'fas fa-business-time' => 'Business Time (alarm,briefcase,business socks,clock,flight of the conchords,reminder,wednesday)' ),
			array( 'fas fa-calculator' => 'Calculator (abacus,addition,arithmetic,counting,math,multiplication,subtraction)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'far fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'fas fa-certificate' => 'certificate (badge,star,verified)' ),
			array( 'fas fa-chart-area' => 'Area Chart (analytics,area,chart,graph)' ),
			array( 'fas fa-chart-bar' => 'Bar Chart (analytics,bar,chart,graph)' ),
			array( 'far fa-chart-bar' => 'Bar Chart (analytics,bar,chart,graph)' ),
			array( 'fas fa-chart-line' => 'Line Chart (activity,analytics,chart,dashboard,gain,graph,increase,line)' ),
			array( 'fas fa-chart-pie' => 'Pie Chart (analytics,chart,diagram,graph,pie)' ),
			array( 'fas fa-city' => 'City (buildings,busy,skyscrapers,urban,windows)' ),
			array( 'fas fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'far fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-columns' => 'Columns (browser,dashboard,organize,panes,split)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-copyright' => 'Copyright (brand,mark,register,trademark)' ),
			array( 'far fa-copyright' => 'Copyright (brand,mark,register,trademark)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'far fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-square' => 'Envelope Square (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-fax' => 'Fax (business,communicate,copy,facsimile,send)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-minus' => 'Folder Minus (archive,delete,directory,document,file,negative,remove)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-folder-plus' => 'Folder Plus (add,archive,create,directory,document,file,new,positive)' ),
			array( 'fas fa-glasses' => 'Glasses (hipster,nerd,reading,sight,spectacles,vision)' ),
			array( 'fas fa-globe' => 'Globe (all,coordinates,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-highlighter' => 'Highlighter (edit,marker,sharpie,update,write)' ),
			array( 'fas fa-industry' => 'Industry (building,factory,industrial,manufacturing,mill,warehouse)' ),
			array( 'fas fa-landmark' => 'Landmark (building,historic,memorable,monument,politics)' ),
			array( 'fas fa-marker' => 'Marker (design,edit,sharpie,update,write)' ),
			array( 'fas fa-paperclip' => 'Paperclip (attach,attachment,connect,link)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-fancy' => 'Pen Fancy (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pen-nib' => 'Pen Nib (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pen-square' => 'Pen Square (edit,pencil-square,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-percent' => 'Percent (discount,fraction,proportion,rate,ratio)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-slash' => 'Phone Slash (call,cancel,earphone,mute,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square' => 'Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square-alt' => 'Alternate Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-volume' => 'Phone Volume (call,earphone,number,sound,support,telephone,voice,volume-control-phone)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-project-diagram' => 'Project Diagram (chart,graph,network,pert)' ),
			array( 'fas fa-registered' => 'Registered Trademark (copyright,mark,trademark)' ),
			array( 'far fa-registered' => 'Registered Trademark (copyright,mark,trademark)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-sitemap' => 'Sitemap (directory,hierarchy,ia,information architecture,organization)' ),
			array( 'fas fa-socks' => 'Socks (business socks,business time,clothing,feet,flight of the conchords,wednesday)' ),
			array( 'fas fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'far fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'fas fa-stream' => 'Stream (flow,list,timeline)' ),
			array( 'fas fa-table' => 'table (data,excel,spreadsheet)' ),
			array( 'fas fa-tag' => 'tag (discount,label,price,shopping)' ),
			array( 'fas fa-tags' => 'tags (discount,label,price,shopping)' ),
			array( 'fas fa-tasks' => 'Tasks (checklist,downloading,downloads,loading,progress,project management,settings,to do)' ),
			array( 'fas fa-thumbtack' => 'Thumbtack (coordinates,location,marker,pin,thumb-tack)' ),
			array( 'fas fa-trademark' => 'Trademark (copyright,register,symbol)' ),
			array( 'fas fa-wallet' => 'Wallet (billfold,cash,currency,money)' ),
		),
		'Camping' => array(
			array( 'fas fa-binoculars' => 'Binoculars (glasses,magnify,scenic,spyglass,view)' ),
			array( 'fas fa-campground' => 'Campground (camping,fall,outdoors,teepee,tent,tipi)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-fire' => 'fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-first-aid' => 'First Aid (emergency,emt,health,medical,rescue)' ),
			array( 'fas fa-frog' => 'Frog (amphibian,bullfrog,fauna,hop,kermit,kiss,prince,ribbit,toad,wart)' ),
			array( 'fas fa-hiking' => 'Hiking (activity,backpack,fall,fitness,outdoors,person,seasonal,walking)' ),
			array( 'fas fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'far fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marked' => 'Map Marked (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marked-alt' => 'Alternate Map Marked (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-signs' => 'Map Signs (directions,directory,map,signage,wayfinding)' ),
			array( 'fas fa-mountain' => 'Mountain (glacier,hiking,hill,landscape,travel,view)' ),
			array( 'fas fa-route' => 'Route (directions,navigation,travel)' ),
			array( 'fas fa-toilet-paper' => 'Toilet Paper (bathroom,halloween,holiday,lavatory,prank,restroom,roll)' ),
			array( 'fas fa-tree' => 'Tree (bark,fall,flora,forest,nature,plant,seasonal)' ),
		),
		'Charity' => array(
			array( 'fas fa-dollar-sign' => 'Dollar Sign ($,cost,dollar-sign,money,price,usd)' ),
			array( 'fas fa-donate' => 'Donate (contribute,generosity,gift,give)' ),
			array( 'fas fa-dove' => 'Dove (bird,fauna,flying,peace,war)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-globe' => 'Globe (all,coordinates,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-hand-holding-heart' => 'Hand Holding Heart (carry,charity,gift,lift,package)' ),
			array( 'fas fa-hand-holding-usd' => 'Hand Holding US Dollar ($,carry,dollar sign,donation,giving,lift,money,price)' ),
			array( 'fas fa-hands-helping' => 'Helping Hands (aid,assistance,handshake,partnership,volunteering)' ),
			array( 'fas fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'far fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-leaf' => 'leaf (eco,flora,nature,plant,vegan)' ),
			array( 'fas fa-parachute-box' => 'Parachute Box (aid,assistance,rescue,supplies)' ),
			array( 'fas fa-piggy-bank' => 'Piggy Bank (bank,save,savings)' ),
			array( 'fas fa-ribbon' => 'Ribbon (badge,cause,lapel,pin)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
		),
		'Chat' => array(
			array( 'fas fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-dots' => 'Comment Dots (bubble,chat,commenting,conversation,feedback,message,more,note,notification,reply,sms,speech,texting)' ),
			array( 'far fa-comment-dots' => 'Comment Dots (bubble,chat,commenting,conversation,feedback,message,more,note,notification,reply,sms,speech,texting)' ),
			array( 'fas fa-comment-medical' => 'Alternate Medical Chat (advice,bubble,chat,commenting,conversation,diagnose,feedback,message,note,notification,prescription,sms,speech,texting)' ),
			array( 'fas fa-comment-slash' => 'Comment Slash (bubble,cancel,chat,commenting,conversation,feedback,message,mute,note,notification,quiet,sms,speech,texting)' ),
			array( 'fas fa-comments' => 'comments (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comments' => 'comments (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'far fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'fas fa-icons' => 'Icons (bolt,emoji,heart,image,music,photo,symbols)' ),
			array( 'fas fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-slash' => 'Phone Slash (call,cancel,earphone,mute,number,support,telephone,voice)' ),
			array( 'fas fa-poo' => 'Poo (crap,poop,shit,smile,turd)' ),
			array( 'fas fa-quote-left' => 'quote-left (mention,note,phrase,text,type)' ),
			array( 'fas fa-quote-right' => 'quote-right (mention,note,phrase,text,type)' ),
			array( 'fas fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'far fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'fas fa-sms' => 'SMS (chat,conversation,message,mobile,notification,phone,sms,texting)' ),
			array( 'fas fa-video' => 'Video (camera,film,movie,record,video-camera)' ),
			array( 'fas fa-video-slash' => 'Video Slash (add,create,film,new,positive,record,video)' ),
		),
		'Chess' => array(
			array( 'fas fa-chess' => 'Chess (board,castle,checkmate,game,king,rook,strategy,tournament)' ),
			array( 'fas fa-chess-bishop' => 'Chess Bishop (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-board' => 'Chess Board (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-king' => 'Chess King (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-knight' => 'Chess Knight (board,checkmate,game,horse,strategy)' ),
			array( 'fas fa-chess-pawn' => 'Chess Pawn (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-queen' => 'Chess Queen (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-rook' => 'Chess Rook (board,castle,checkmate,game,strategy)' ),
			array( 'fas fa-square-full' => 'Square Full (block,box,shape)' ),
		),
		'Childhood' => array(
			array( 'fas fa-apple-alt' => 'Fruit Apple (fall,fruit,fuji,macintosh,orchard,seasonal,vegan)' ),
			array( 'fas fa-baby' => 'Baby (child,diaper,doll,human,infant,kid,offspring,person,sprout)' ),
			array( 'fas fa-baby-carriage' => 'Baby Carriage (buggy,carrier,infant,push,stroller,transportation,walk,wheels)' ),
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-biking' => 'Biking (bicycle,bike,cycle,cycling,ride,wheel)' ),
			array( 'fas fa-birthday-cake' => 'Birthday Cake (anniversary,bakery,candles,celebration,dessert,frosting,holiday,party,pastry)' ),
			array( 'fas fa-cookie' => 'Cookie (baked good,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-cookie-bite' => 'Cookie Bite (baked good,bitten,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-gamepad' => 'Gamepad (arcade,controller,d-pad,joystick,video,video game)' ),
			array( 'fas fa-ice-cream' => 'Ice Cream (chocolate,cone,dessert,frozen,scoop,sorbet,vanilla,yogurt)' ),
			array( 'fas fa-mitten' => 'Mitten (clothing,cold,glove,hands,knitted,seasonal,warmth)' ),
			array( 'fas fa-robot' => 'Robot (android,automate,computer,cyborg)' ),
			array( 'fas fa-school' => 'School (building,education,learn,student,teacher)' ),
			array( 'fas fa-shapes' => 'Shapes (blocks,build,circle,square,triangle)' ),
			array( 'fas fa-snowman' => 'Snowman (decoration,frost,frosty,holiday)' ),
		),
		'Clothing' => array(
			array( 'fas fa-graduation-cap' => 'Graduation Cap (ceremony,college,graduate,learning,school,student)' ),
			array( 'fas fa-hat-cowboy' => 'Cowboy Hat (buckaroo,horse,jackeroo,john b.,old west,pardner,ranch,rancher,rodeo,western,wrangler)' ),
			array( 'fas fa-hat-cowboy-side' => 'Cowboy Hat Side (buckaroo,horse,jackeroo,john b.,old west,pardner,ranch,rancher,rodeo,western,wrangler)' ),
			array( 'fas fa-hat-wizard' => 'Wizard\'s Hat (Dungeons & Dragons,accessory,buckle,clothing,d&d,dnd,fantasy,halloween,head,holiday,mage,magic,pointy,witch)' ),
			array( 'fas fa-mitten' => 'Mitten (clothing,cold,glove,hands,knitted,seasonal,warmth)' ),
			array( 'fas fa-shoe-prints' => 'Shoe Prints (feet,footprints,steps,walk)' ),
			array( 'fas fa-socks' => 'Socks (business socks,business time,clothing,feet,flight of the conchords,wednesday)' ),
			array( 'fas fa-tshirt' => 'T-Shirt (clothing,fashion,garment,shirt)' ),
			array( 'fas fa-user-tie' => 'User Tie (avatar,business,clothing,formal,professional,suit)' ),
		),
		'Code' => array(
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-barcode' => 'barcode (info,laser,price,scan,upc)' ),
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-bug' => 'Bug (beetle,error,insect,report)' ),
			array( 'fas fa-code' => 'Code (brackets,code,development,html)' ),
			array( 'fas fa-code-branch' => 'Code Branch (branch,code-fork,fork,git,github,rebase,svn,vcs,version)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-file-code' => 'Code File (css,development,document,html)' ),
			array( 'far fa-file-code' => 'Code File (css,development,document,html)' ),
			array( 'fas fa-filter' => 'Filter (funnel,options,separate,sort)' ),
			array( 'fas fa-fire-extinguisher' => 'fire-extinguisher (burn,caliente,fire fighter,flame,heat,hot,rescue)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'far fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'fas fa-laptop-code' => 'Laptop Code (computer,cpu,dell,demo,develop,device,mac,macbook,machine,pc)' ),
			array( 'fas fa-microchip' => 'Microchip (cpu,hardware,processor,technology)' ),
			array( 'fas fa-project-diagram' => 'Project Diagram (chart,graph,network,pert)' ),
			array( 'fas fa-qrcode' => 'qrcode (barcode,info,information,scan)' ),
			array( 'fas fa-shield-alt' => 'Alternate Shield (achievement,award,block,defend,security,winner)' ),
			array( 'fas fa-sitemap' => 'Sitemap (directory,hierarchy,ia,information architecture,organization)' ),
			array( 'fas fa-stream' => 'Stream (flow,list,timeline)' ),
			array( 'fas fa-terminal' => 'Terminal (code,command,console,development,prompt)' ),
			array( 'fas fa-user-secret' => 'User Secret (clothing,coat,hat,incognito,person,privacy,spy,whisper)' ),
			array( 'fas fa-window-close' => 'Window Close (browser,cancel,computer,development)' ),
			array( 'far fa-window-close' => 'Window Close (browser,cancel,computer,development)' ),
			array( 'fas fa-window-maximize' => 'Window Maximize (browser,computer,development,expand)' ),
			array( 'far fa-window-maximize' => 'Window Maximize (browser,computer,development,expand)' ),
			array( 'fas fa-window-minimize' => 'Window Minimize (browser,collapse,computer,development)' ),
			array( 'far fa-window-minimize' => 'Window Minimize (browser,collapse,computer,development)' ),
			array( 'fas fa-window-restore' => 'Window Restore (browser,computer,development)' ),
			array( 'far fa-window-restore' => 'Window Restore (browser,computer,development)' ),
		),
		'Communication' => array(
			array( 'fas fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'far fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'fas fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'far fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'fas fa-american-sign-language-interpreting' => 'American Sign Language Interpreting (asl,deaf,finger,hand,interpret,speak)' ),
			array( 'fas fa-assistive-listening-systems' => 'Assistive Listening Systems (amplify,audio,deaf,ear,headset,hearing,sound)' ),
			array( 'fas fa-at' => 'At (address,author,e-mail,email,handle)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fab fa-bluetooth' => 'Bluetooth' ),
			array( 'fab fa-bluetooth-b' => 'Bluetooth' ),
			array( 'fas fa-broadcast-tower' => 'Broadcast Tower (airwaves,antenna,radio,reception,waves)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-chalkboard' => 'Chalkboard (blackboard,learning,school,teaching,whiteboard,writing)' ),
			array( 'fas fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comments' => 'comments (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comments' => 'comments (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-square' => 'Envelope Square (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-fax' => 'Fax (business,communicate,copy,facsimile,send)' ),
			array( 'fas fa-inbox' => 'inbox (archive,desk,email,mail,message)' ),
			array( 'fas fa-language' => 'Language (dialect,idiom,localize,speech,translate,vernacular)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt-slash' => 'Alternate Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-mobile' => 'Mobile Phone (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-mobile-alt' => 'Alternate Mobile (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'far fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-slash' => 'Phone Slash (call,cancel,earphone,mute,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square' => 'Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square-alt' => 'Alternate Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-volume' => 'Phone Volume (call,earphone,number,sound,support,telephone,voice,volume-control-phone)' ),
			array( 'fas fa-rss' => 'rss (blog,feed,journal,news,writing)' ),
			array( 'fas fa-rss-square' => 'RSS Square (blog,feed,journal,news,writing)' ),
			array( 'fas fa-tty' => 'TTY (communication,deaf,telephone,teletypewriter,text)' ),
			array( 'fas fa-voicemail' => 'Voicemail (answer,inbox,message,phone)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
		),
		'Computers' => array(
			array( 'fas fa-database' => 'Database (computer,development,directory,memory,storage)' ),
			array( 'fas fa-desktop' => 'Desktop (computer,cpu,demo,desktop,device,imac,machine,monitor,pc,screen)' ),
			array( 'fas fa-download' => 'Download (export,hard drive,save,transfer)' ),
			array( 'fas fa-ethernet' => 'Ethernet (cable,cat 5,cat 6,connection,hardware,internet,network,wired)' ),
			array( 'fas fa-hdd' => 'HDD (cpu,hard drive,harddrive,machine,save,storage)' ),
			array( 'far fa-hdd' => 'HDD (cpu,hard drive,harddrive,machine,save,storage)' ),
			array( 'fas fa-headphones' => 'headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'far fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'fas fa-laptop' => 'Laptop (computer,cpu,dell,demo,device,mac,macbook,machine,pc)' ),
			array( 'fas fa-memory' => 'Memory (DIMM,RAM,hardware,storage,technology)' ),
			array( 'fas fa-microchip' => 'Microchip (cpu,hardware,processor,technology)' ),
			array( 'fas fa-mobile' => 'Mobile Phone (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-mobile-alt' => 'Alternate Mobile (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-mouse' => 'Mouse (click,computer,cursor,input,peripheral)' ),
			array( 'fas fa-plug' => 'Plug (connect,electric,online,power)' ),
			array( 'fas fa-power-off' => 'Power Off (cancel,computer,on,reboot,restart)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-satellite' => 'Satellite (communications,hardware,orbit,space)' ),
			array( 'fas fa-satellite-dish' => 'Satellite Dish (SETI,communications,hardware,receiver,saucer,signal)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-sd-card' => 'Sd Card (image,memory,photo,save)' ),
			array( 'fas fa-server' => 'Server (computer,cpu,database,hardware,network)' ),
			array( 'fas fa-sim-card' => 'SIM Card (hard drive,hardware,portable,storage,technology,tiny)' ),
			array( 'fas fa-stream' => 'Stream (flow,list,timeline)' ),
			array( 'fas fa-tablet' => 'tablet (apple,device,ipad,kindle,screen)' ),
			array( 'fas fa-tablet-alt' => 'Alternate Tablet (apple,device,ipad,kindle,screen)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
			array( 'fas fa-upload' => 'Upload (hard drive,import,publish)' ),
		),
		'Construction' => array(
			array( 'fas fa-brush' => 'Brush (art,bristles,color,handle,paint)' ),
			array( 'fas fa-drafting-compass' => 'Drafting Compass (design,map,mechanical drawing,plot,plotting)' ),
			array( 'fas fa-dumpster' => 'Dumpster (alley,bin,commercial,trash,waste)' ),
			array( 'fas fa-hammer' => 'Hammer (admin,fix,repair,settings,tool)' ),
			array( 'fas fa-hard-hat' => 'Hard Hat (construction,hardhat,helmet,safety)' ),
			array( 'fas fa-paint-roller' => 'Paint Roller (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-pencil-ruler' => 'Pencil Ruler (design,draft,draw,pencil)' ),
			array( 'fas fa-ruler' => 'Ruler (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-combined' => 'Ruler Combined (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-horizontal' => 'Ruler Horizontal (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-vertical' => 'Ruler Vertical (design,draft,length,measure,planning)' ),
			array( 'fas fa-screwdriver' => 'Screwdriver (admin,fix,mechanic,repair,settings,tool)' ),
			array( 'fas fa-toolbox' => 'Toolbox (admin,container,fix,repair,settings,tools)' ),
			array( 'fas fa-tools' => 'Tools (admin,fix,repair,screwdriver,settings,tools,wrench)' ),
			array( 'fas fa-truck-pickup' => 'Truck Side (cargo,vehicle)' ),
			array( 'fas fa-wrench' => 'Wrench (construction,fix,mechanic,plumbing,settings,spanner,tool,update)' ),
		),
		'Currency' => array(
			array( 'fab fa-bitcoin' => 'Bitcoin' ),
			array( 'fab fa-btc' => 'BTC' ),
			array( 'fas fa-dollar-sign' => 'Dollar Sign ($,cost,dollar-sign,money,price,usd)' ),
			array( 'fab fa-ethereum' => 'Ethereum' ),
			array( 'fas fa-euro-sign' => 'Euro Sign (currency,dollar,exchange,money)' ),
			array( 'fab fa-gg' => 'GG Currency' ),
			array( 'fab fa-gg-circle' => 'GG Currency Circle' ),
			array( 'fas fa-hryvnia' => 'Hryvnia (currency,money,ukraine,ukrainian)' ),
			array( 'fas fa-lira-sign' => 'Turkish Lira Sign (currency,money,try,turkish)' ),
			array( 'fas fa-money-bill' => 'Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'far fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-wave' => 'Wavy Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-wave-alt' => 'Alternate Wavy Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-check' => 'Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-money-check-alt' => 'Alternate Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-pound-sign' => 'Pound Sign (currency,gbp,money)' ),
			array( 'fas fa-ruble-sign' => 'Ruble Sign (currency,money,rub)' ),
			array( 'fas fa-rupee-sign' => 'Indian Rupee Sign (currency,indian,inr,money)' ),
			array( 'fas fa-shekel-sign' => 'Shekel Sign (currency,ils,money)' ),
			array( 'fas fa-tenge' => 'Tenge (currency,kazakhstan,money,price)' ),
			array( 'fas fa-won-sign' => 'Won Sign (currency,krw,money)' ),
			array( 'fas fa-yen-sign' => 'Yen Sign (currency,jpy,money)' ),
		),
		'Date & Time' => array(
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'far fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'far fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'fas fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'far fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'fas fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'far fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'fas fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'far fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'fas fa-clock' => 'Clock (date,late,schedule,time,timer,timestamp,watch)' ),
			array( 'far fa-clock' => 'Clock (date,late,schedule,time,timer,timestamp,watch)' ),
			array( 'fas fa-hourglass' => 'Hourglass (hour,minute,sand,stopwatch,time)' ),
			array( 'far fa-hourglass' => 'Hourglass (hour,minute,sand,stopwatch,time)' ),
			array( 'fas fa-hourglass-end' => 'Hourglass End (hour,minute,sand,stopwatch,time)' ),
			array( 'fas fa-hourglass-half' => 'Hourglass Half (hour,minute,sand,stopwatch,time)' ),
			array( 'fas fa-hourglass-start' => 'Hourglass Start (hour,minute,sand,stopwatch,time)' ),
			array( 'fas fa-stopwatch' => 'Stopwatch (clock,reminder,time)' ),
		),
		'Design' => array(
			array( 'fas fa-adjust' => 'adjust (contrast,dark,light,saturation)' ),
			array( 'fas fa-bezier-curve' => 'Bezier Curve (curves,illustrator,lines,path,vector)' ),
			array( 'fas fa-brush' => 'Brush (art,bristles,color,handle,paint)' ),
			array( 'fas fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'far fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-crop' => 'crop (design,frame,mask,resize,shrink)' ),
			array( 'fas fa-crop-alt' => 'Alternate Crop (design,frame,mask,resize,shrink)' ),
			array( 'fas fa-crosshairs' => 'Crosshairs (aim,bullseye,gpd,picker,position)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-drafting-compass' => 'Drafting Compass (design,map,mechanical drawing,plot,plotting)' ),
			array( 'fas fa-draw-polygon' => 'Draw Polygon (anchors,lines,object,render,shape)' ),
			array( 'fas fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'far fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-dropper' => 'Eye Dropper (beaker,clone,color,copy,eyedropper,pipette)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-fill' => 'Fill (bucket,color,paint,paint bucket)' ),
			array( 'fas fa-fill-drip' => 'Fill Drip (bucket,color,drop,paint,paint bucket,spill)' ),
			array( 'fas fa-highlighter' => 'Highlighter (edit,marker,sharpie,update,write)' ),
			array( 'fas fa-icons' => 'Icons (bolt,emoji,heart,image,music,photo,symbols)' ),
			array( 'fas fa-layer-group' => 'Layer Group (arrange,develop,layers,map,stack)' ),
			array( 'fas fa-magic' => 'magic (autocomplete,automatic,mage,magic,spell,wand,witch,wizard)' ),
			array( 'fas fa-marker' => 'Marker (design,edit,sharpie,update,write)' ),
			array( 'fas fa-object-group' => 'Object Group (combine,copy,design,merge,select)' ),
			array( 'far fa-object-group' => 'Object Group (combine,copy,design,merge,select)' ),
			array( 'fas fa-object-ungroup' => 'Object Ungroup (copy,design,merge,select,separate)' ),
			array( 'far fa-object-ungroup' => 'Object Ungroup (copy,design,merge,select,separate)' ),
			array( 'fas fa-paint-brush' => 'Paint Brush (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-paint-roller' => 'Paint Roller (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-palette' => 'Palette (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-fancy' => 'Pen Fancy (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pen-nib' => 'Pen Nib (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-pencil-ruler' => 'Pencil Ruler (design,draft,draw,pencil)' ),
			array( 'fas fa-ruler-combined' => 'Ruler Combined (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-horizontal' => 'Ruler Horizontal (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-vertical' => 'Ruler Vertical (design,draft,length,measure,planning)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-splotch' => 'Splotch (Ink,blob,blotch,glob,stain)' ),
			array( 'fas fa-spray-can' => 'Spray Can (Paint,aerosol,design,graffiti,tag)' ),
			array( 'fas fa-stamp' => 'Stamp (art,certificate,imprint,rubber,seal)' ),
			array( 'fas fa-swatchbook' => 'Swatchbook (Pantone,color,design,hue,palette)' ),
			array( 'fas fa-tint' => 'tint (color,drop,droplet,raindrop,waterdrop)' ),
			array( 'fas fa-tint-slash' => 'Tint Slash (color,drop,droplet,raindrop,waterdrop)' ),
			array( 'fas fa-vector-square' => 'Vector Square (anchors,lines,object,render,shape)' ),
		),
		'Editors' => array(
			array( 'fas fa-align-center' => 'align-center (format,middle,paragraph,text)' ),
			array( 'fas fa-align-justify' => 'align-justify (format,paragraph,text)' ),
			array( 'fas fa-align-left' => 'align-left (format,paragraph,text)' ),
			array( 'fas fa-align-right' => 'align-right (format,paragraph,text)' ),
			array( 'fas fa-bold' => 'bold (emphasis,format,text)' ),
			array( 'fas fa-border-all' => 'Border All (cell,grid,outline,stroke,table)' ),
			array( 'fas fa-border-none' => 'Border None (cell,grid,outline,stroke,table)' ),
			array( 'fas fa-border-style' => 'Border Style' ),
			array( 'fas fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'far fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'fas fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'far fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'fas fa-columns' => 'Columns (browser,dashboard,organize,panes,split)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'far fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-font' => 'font (alphabet,glyph,text,type,typeface)' ),
			array( 'fas fa-glasses' => 'Glasses (hipster,nerd,reading,sight,spectacles,vision)' ),
			array( 'fas fa-heading' => 'heading (format,header,text,title)' ),
			array( 'fas fa-highlighter' => 'Highlighter (edit,marker,sharpie,update,write)' ),
			array( 'fas fa-i-cursor' => 'I Beam Cursor (editing,i-beam,type,writing)' ),
			array( 'fas fa-icons' => 'Icons (bolt,emoji,heart,image,music,photo,symbols)' ),
			array( 'fas fa-indent' => 'Indent (align,justify,paragraph,tab)' ),
			array( 'fas fa-italic' => 'italic (edit,emphasis,font,format,text,type)' ),
			array( 'fas fa-link' => 'Link (attach,attachment,chain,connect)' ),
			array( 'fas fa-list' => 'List (checklist,completed,done,finished,ol,todo,ul)' ),
			array( 'fas fa-list-alt' => 'Alternate List (checklist,completed,done,finished,ol,todo,ul)' ),
			array( 'far fa-list-alt' => 'Alternate List (checklist,completed,done,finished,ol,todo,ul)' ),
			array( 'fas fa-list-ol' => 'list-ol (checklist,completed,done,finished,numbers,ol,todo,ul)' ),
			array( 'fas fa-list-ul' => 'list-ul (checklist,completed,done,finished,ol,todo,ul)' ),
			array( 'fas fa-marker' => 'Marker (design,edit,sharpie,update,write)' ),
			array( 'fas fa-outdent' => 'Outdent (align,justify,paragraph,tab)' ),
			array( 'fas fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'far fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'fas fa-paperclip' => 'Paperclip (attach,attachment,connect,link)' ),
			array( 'fas fa-paragraph' => 'paragraph (edit,format,text,writing)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-fancy' => 'Pen Fancy (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pen-nib' => 'Pen Nib (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-quote-left' => 'quote-left (mention,note,phrase,text,type)' ),
			array( 'fas fa-quote-right' => 'quote-right (mention,note,phrase,text,type)' ),
			array( 'fas fa-redo' => 'Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-redo-alt' => 'Alternate Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-remove-format' => 'Remove Format (cancel,font,format,remove,style,text)' ),
			array( 'fas fa-reply' => 'Reply (mail,message,respond)' ),
			array( 'fas fa-reply-all' => 'reply-all (mail,message,respond)' ),
			array( 'fas fa-screwdriver' => 'Screwdriver (admin,fix,mechanic,repair,settings,tool)' ),
			array( 'fas fa-share' => 'Share (forward,save,send,social)' ),
			array( 'fas fa-spell-check' => 'Spell Check (dictionary,edit,editor,grammar,text)' ),
			array( 'fas fa-strikethrough' => 'Strikethrough (cancel,edit,font,format,text,type)' ),
			array( 'fas fa-subscript' => 'subscript (edit,font,format,text,type)' ),
			array( 'fas fa-superscript' => 'superscript (edit,exponential,font,format,text,type)' ),
			array( 'fas fa-sync' => 'Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-sync-alt' => 'Alternate Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-table' => 'table (data,excel,spreadsheet)' ),
			array( 'fas fa-tasks' => 'Tasks (checklist,downloading,downloads,loading,progress,project management,settings,to do)' ),
			array( 'fas fa-text-height' => 'text-height (edit,font,format,text,type)' ),
			array( 'fas fa-text-width' => 'Text Width (edit,font,format,text,type)' ),
			array( 'fas fa-th' => 'th (blocks,boxes,grid,squares)' ),
			array( 'fas fa-th-large' => 'th-large (blocks,boxes,grid,squares)' ),
			array( 'fas fa-th-list' => 'th-list (checklist,completed,done,finished,ol,todo,ul)' ),
			array( 'fas fa-tools' => 'Tools (admin,fix,repair,screwdriver,settings,tools,wrench)' ),
			array( 'fas fa-trash' => 'Trash (delete,garbage,hide,remove)' ),
			array( 'fas fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'far fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'fas fa-trash-restore' => 'Trash Restore (back,control z,oops,undo)' ),
			array( 'fas fa-trash-restore-alt' => 'Alternative Trash Restore (back,control z,oops,undo)' ),
			array( 'fas fa-underline' => 'Underline (edit,emphasis,format,text,writing)' ),
			array( 'fas fa-undo' => 'Undo (back,control z,exchange,oops,return,rotate,swap)' ),
			array( 'fas fa-undo-alt' => 'Alternate Undo (back,control z,exchange,oops,return,swap)' ),
			array( 'fas fa-unlink' => 'unlink (attachment,chain,chain-broken,remove)' ),
			array( 'fas fa-wrench' => 'Wrench (construction,fix,mechanic,plumbing,settings,spanner,tool,update)' ),
		),
		'Education' => array(
			array( 'fas fa-apple-alt' => 'Fruit Apple (fall,fruit,fuji,macintosh,orchard,seasonal,vegan)' ),
			array( 'fas fa-atom' => 'Atom (atheism,chemistry,ion,nuclear,science)' ),
			array( 'fas fa-award' => 'Award (honor,praise,prize,recognition,ribbon,trophy)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-book-open' => 'Book Open (flyer,library,notebook,open book,pamphlet,reading)' ),
			array( 'fas fa-book-reader' => 'Book Reader (flyer,library,notebook,open book,pamphlet,reading)' ),
			array( 'fas fa-chalkboard' => 'Chalkboard (blackboard,learning,school,teaching,whiteboard,writing)' ),
			array( 'fas fa-chalkboard-teacher' => 'Chalkboard Teacher (blackboard,instructor,learning,professor,school,whiteboard,writing)' ),
			array( 'fas fa-graduation-cap' => 'Graduation Cap (ceremony,college,graduate,learning,school,student)' ),
			array( 'fas fa-laptop-code' => 'Laptop Code (computer,cpu,dell,demo,develop,device,mac,macbook,machine,pc)' ),
			array( 'fas fa-microscope' => 'Microscope (electron,lens,optics,science,shrink)' ),
			array( 'fas fa-music' => 'Music (lyrics,melody,note,sing,sound)' ),
			array( 'fas fa-school' => 'School (building,education,learn,student,teacher)' ),
			array( 'fas fa-shapes' => 'Shapes (blocks,build,circle,square,triangle)' ),
			array( 'fas fa-theater-masks' => 'Theater Masks (comedy,perform,theatre,tragedy)' ),
			array( 'fas fa-user-graduate' => 'User Graduate (cap,clothing,commencement,gown,graduation,person,student)' ),
		),
		'Emoji' => array(
			array( 'fas fa-angry' => 'Angry Face (disapprove,emoticon,face,mad,upset)' ),
			array( 'far fa-angry' => 'Angry Face (disapprove,emoticon,face,mad,upset)' ),
			array( 'fas fa-dizzy' => 'Dizzy Face (dazed,dead,disapprove,emoticon,face)' ),
			array( 'far fa-dizzy' => 'Dizzy Face (dazed,dead,disapprove,emoticon,face)' ),
			array( 'fas fa-flushed' => 'Flushed Face (embarrassed,emoticon,face)' ),
			array( 'far fa-flushed' => 'Flushed Face (embarrassed,emoticon,face)' ),
			array( 'fas fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'far fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'fas fa-frown-open' => 'Frowning Face With Open Mouth (disapprove,emoticon,face,rating,sad)' ),
			array( 'far fa-frown-open' => 'Frowning Face With Open Mouth (disapprove,emoticon,face,rating,sad)' ),
			array( 'fas fa-grimace' => 'Grimacing Face (cringe,emoticon,face,teeth)' ),
			array( 'far fa-grimace' => 'Grimacing Face (cringe,emoticon,face,teeth)' ),
			array( 'fas fa-grin' => 'Grinning Face (emoticon,face,laugh,smile)' ),
			array( 'far fa-grin' => 'Grinning Face (emoticon,face,laugh,smile)' ),
			array( 'fas fa-grin-alt' => 'Alternate Grinning Face (emoticon,face,laugh,smile)' ),
			array( 'far fa-grin-alt' => 'Alternate Grinning Face (emoticon,face,laugh,smile)' ),
			array( 'fas fa-grin-beam' => 'Grinning Face With Smiling Eyes (emoticon,face,laugh,smile)' ),
			array( 'far fa-grin-beam' => 'Grinning Face With Smiling Eyes (emoticon,face,laugh,smile)' ),
			array( 'fas fa-grin-beam-sweat' => 'Grinning Face With Sweat (embarass,emoticon,face,smile)' ),
			array( 'far fa-grin-beam-sweat' => 'Grinning Face With Sweat (embarass,emoticon,face,smile)' ),
			array( 'fas fa-grin-hearts' => 'Smiling Face With Heart-Eyes (emoticon,face,love,smile)' ),
			array( 'far fa-grin-hearts' => 'Smiling Face With Heart-Eyes (emoticon,face,love,smile)' ),
			array( 'fas fa-grin-squint' => 'Grinning Squinting Face (emoticon,face,laugh,smile)' ),
			array( 'far fa-grin-squint' => 'Grinning Squinting Face (emoticon,face,laugh,smile)' ),
			array( 'fas fa-grin-squint-tears' => 'Rolling on the Floor Laughing (emoticon,face,happy,smile)' ),
			array( 'far fa-grin-squint-tears' => 'Rolling on the Floor Laughing (emoticon,face,happy,smile)' ),
			array( 'fas fa-grin-stars' => 'Star-Struck (emoticon,face,star-struck)' ),
			array( 'far fa-grin-stars' => 'Star-Struck (emoticon,face,star-struck)' ),
			array( 'fas fa-grin-tears' => 'Face With Tears of Joy (LOL,emoticon,face)' ),
			array( 'far fa-grin-tears' => 'Face With Tears of Joy (LOL,emoticon,face)' ),
			array( 'fas fa-grin-tongue' => 'Face With Tongue (LOL,emoticon,face)' ),
			array( 'far fa-grin-tongue' => 'Face With Tongue (LOL,emoticon,face)' ),
			array( 'fas fa-grin-tongue-squint' => 'Squinting Face With Tongue (LOL,emoticon,face)' ),
			array( 'far fa-grin-tongue-squint' => 'Squinting Face With Tongue (LOL,emoticon,face)' ),
			array( 'fas fa-grin-tongue-wink' => 'Winking Face With Tongue (LOL,emoticon,face)' ),
			array( 'far fa-grin-tongue-wink' => 'Winking Face With Tongue (LOL,emoticon,face)' ),
			array( 'fas fa-grin-wink' => 'Grinning Winking Face (emoticon,face,flirt,laugh,smile)' ),
			array( 'far fa-grin-wink' => 'Grinning Winking Face (emoticon,face,flirt,laugh,smile)' ),
			array( 'fas fa-kiss' => 'Kissing Face (beso,emoticon,face,love,smooch)' ),
			array( 'far fa-kiss' => 'Kissing Face (beso,emoticon,face,love,smooch)' ),
			array( 'fas fa-kiss-beam' => 'Kissing Face With Smiling Eyes (beso,emoticon,face,love,smooch)' ),
			array( 'far fa-kiss-beam' => 'Kissing Face With Smiling Eyes (beso,emoticon,face,love,smooch)' ),
			array( 'fas fa-kiss-wink-heart' => 'Face Blowing a Kiss (beso,emoticon,face,love,smooch)' ),
			array( 'far fa-kiss-wink-heart' => 'Face Blowing a Kiss (beso,emoticon,face,love,smooch)' ),
			array( 'fas fa-laugh' => 'Grinning Face With Big Eyes (LOL,emoticon,face,laugh,smile)' ),
			array( 'far fa-laugh' => 'Grinning Face With Big Eyes (LOL,emoticon,face,laugh,smile)' ),
			array( 'fas fa-laugh-beam' => 'Laugh Face with Beaming Eyes (LOL,emoticon,face,happy,smile)' ),
			array( 'far fa-laugh-beam' => 'Laugh Face with Beaming Eyes (LOL,emoticon,face,happy,smile)' ),
			array( 'fas fa-laugh-squint' => 'Laughing Squinting Face (LOL,emoticon,face,happy,smile)' ),
			array( 'far fa-laugh-squint' => 'Laughing Squinting Face (LOL,emoticon,face,happy,smile)' ),
			array( 'fas fa-laugh-wink' => 'Laughing Winking Face (LOL,emoticon,face,happy,smile)' ),
			array( 'far fa-laugh-wink' => 'Laughing Winking Face (LOL,emoticon,face,happy,smile)' ),
			array( 'fas fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'fas fa-meh-blank' => 'Face Without Mouth (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh-blank' => 'Face Without Mouth (emoticon,face,neutral,rating)' ),
			array( 'fas fa-meh-rolling-eyes' => 'Face With Rolling Eyes (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh-rolling-eyes' => 'Face With Rolling Eyes (emoticon,face,neutral,rating)' ),
			array( 'fas fa-sad-cry' => 'Crying Face (emoticon,face,tear,tears)' ),
			array( 'far fa-sad-cry' => 'Crying Face (emoticon,face,tear,tears)' ),
			array( 'fas fa-sad-tear' => 'Loudly Crying Face (emoticon,face,tear,tears)' ),
			array( 'far fa-sad-tear' => 'Loudly Crying Face (emoticon,face,tear,tears)' ),
			array( 'fas fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'far fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'fas fa-smile-beam' => 'Beaming Face With Smiling Eyes (emoticon,face,happy,positive)' ),
			array( 'far fa-smile-beam' => 'Beaming Face With Smiling Eyes (emoticon,face,happy,positive)' ),
			array( 'fas fa-smile-wink' => 'Winking Face (emoticon,face,happy,hint,joke)' ),
			array( 'far fa-smile-wink' => 'Winking Face (emoticon,face,happy,hint,joke)' ),
			array( 'fas fa-surprise' => 'Hushed Face (emoticon,face,shocked)' ),
			array( 'far fa-surprise' => 'Hushed Face (emoticon,face,shocked)' ),
			array( 'fas fa-tired' => 'Tired Face (angry,emoticon,face,grumpy,upset)' ),
			array( 'far fa-tired' => 'Tired Face (angry,emoticon,face,grumpy,upset)' ),
		),
		'Energy' => array(
			array( 'fas fa-atom' => 'Atom (atheism,chemistry,ion,nuclear,science)' ),
			array( 'fas fa-battery-empty' => 'Battery Empty (charge,dead,power,status)' ),
			array( 'fas fa-battery-full' => 'Battery Full (charge,power,status)' ),
			array( 'fas fa-battery-half' => 'Battery 1/2 Full (charge,power,status)' ),
			array( 'fas fa-battery-quarter' => 'Battery 1/4 Full (charge,low,power,status)' ),
			array( 'fas fa-battery-three-quarters' => 'Battery 3/4 Full (charge,power,status)' ),
			array( 'fas fa-broadcast-tower' => 'Broadcast Tower (airwaves,antenna,radio,reception,waves)' ),
			array( 'fas fa-burn' => 'Burn (caliente,energy,fire,flame,gas,heat,hot)' ),
			array( 'fas fa-charging-station' => 'Charging Station (electric,ev,tesla,vehicle)' ),
			array( 'fas fa-fire' => 'fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-gas-pump' => 'Gas Pump (car,fuel,gasoline,petrol)' ),
			array( 'fas fa-industry' => 'Industry (building,factory,industrial,manufacturing,mill,warehouse)' ),
			array( 'fas fa-leaf' => 'leaf (eco,flora,nature,plant,vegan)' ),
			array( 'fas fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'far fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'fas fa-plug' => 'Plug (connect,electric,online,power)' ),
			array( 'fas fa-poop' => 'Poop (crap,poop,shit,smile,turd)' ),
			array( 'fas fa-power-off' => 'Power Off (cancel,computer,on,reboot,restart)' ),
			array( 'fas fa-radiation' => 'Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-radiation-alt' => 'Alternate Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
			array( 'fas fa-solar-panel' => 'Solar Panel (clean,eco-friendly,energy,green,sun)' ),
			array( 'fas fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'far fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'fas fa-water' => 'Water (lake,liquid,ocean,sea,swim,wet)' ),
			array( 'fas fa-wind' => 'Wind (air,blow,breeze,fall,seasonal,weather)' ),
		),
		'Files' => array(
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'far fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-file-archive' => 'Archive File (.zip,bundle,compress,compression,download,zip)' ),
			array( 'far fa-file-archive' => 'Archive File (.zip,bundle,compress,compression,download,zip)' ),
			array( 'fas fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'far fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'fas fa-file-code' => 'Code File (css,development,document,html)' ),
			array( 'far fa-file-code' => 'Code File (css,development,document,html)' ),
			array( 'fas fa-file-excel' => 'Excel File (csv,document,numbers,spreadsheets,table)' ),
			array( 'far fa-file-excel' => 'Excel File (csv,document,numbers,spreadsheets,table)' ),
			array( 'fas fa-file-image' => 'Image File (document,image,jpg,photo,png)' ),
			array( 'far fa-file-image' => 'Image File (document,image,jpg,photo,png)' ),
			array( 'fas fa-file-pdf' => 'PDF File (acrobat,document,preview,save)' ),
			array( 'far fa-file-pdf' => 'PDF File (acrobat,document,preview,save)' ),
			array( 'fas fa-file-powerpoint' => 'Powerpoint File (display,document,keynote,presentation)' ),
			array( 'far fa-file-powerpoint' => 'Powerpoint File (display,document,keynote,presentation)' ),
			array( 'fas fa-file-video' => 'Video File (document,m4v,movie,mp4,play)' ),
			array( 'far fa-file-video' => 'Video File (document,m4v,movie,mp4,play)' ),
			array( 'fas fa-file-word' => 'Word File (document,edit,page,text,writing)' ),
			array( 'far fa-file-word' => 'Word File (document,edit,page,text,writing)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-photo-video' => 'Photo Video (av,film,image,library,media)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'far fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
		),
		'Finance' => array(
			array( 'fas fa-balance-scale' => 'Balance Scale (balanced,justice,legal,measure,weight)' ),
			array( 'fas fa-balance-scale-left' => 'Balance Scale (Left-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-balance-scale-right' => 'Balance Scale (Right-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-book' => 'book (diary,documentation,journal,library,read)' ),
			array( 'fas fa-cash-register' => 'Cash Register (buy,cha-ching,change,checkout,commerce,leaerboard,machine,pay,payment,purchase,store)' ),
			array( 'fas fa-chart-line' => 'Line Chart (activity,analytics,chart,dashboard,gain,graph,increase,line)' ),
			array( 'fas fa-chart-pie' => 'Pie Chart (analytics,chart,diagram,graph,pie)' ),
			array( 'fas fa-coins' => 'Coins (currency,dime,financial,gold,money,penny)' ),
			array( 'fas fa-comment-dollar' => 'Comment Dollar (bubble,chat,commenting,conversation,feedback,message,money,note,notification,pay,sms,speech,spend,texting,transfer)' ),
			array( 'fas fa-comments-dollar' => 'Comments Dollar (bubble,chat,commenting,conversation,feedback,message,money,note,notification,pay,sms,speech,spend,texting,transfer)' ),
			array( 'fas fa-credit-card' => 'Credit Card (buy,checkout,credit-card-alt,debit,money,payment,purchase)' ),
			array( 'far fa-credit-card' => 'Credit Card (buy,checkout,credit-card-alt,debit,money,payment,purchase)' ),
			array( 'fas fa-donate' => 'Donate (contribute,generosity,gift,give)' ),
			array( 'fas fa-file-invoice' => 'File Invoice (account,bill,charge,document,payment,receipt)' ),
			array( 'fas fa-file-invoice-dollar' => 'File Invoice with US Dollar ($,account,bill,charge,document,dollar-sign,money,payment,receipt,usd)' ),
			array( 'fas fa-hand-holding-usd' => 'Hand Holding US Dollar ($,carry,dollar sign,donation,giving,lift,money,price)' ),
			array( 'fas fa-landmark' => 'Landmark (building,historic,memorable,monument,politics)' ),
			array( 'fas fa-money-bill' => 'Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'far fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-wave' => 'Wavy Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-wave-alt' => 'Alternate Wavy Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-check' => 'Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-money-check-alt' => 'Alternate Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-percentage' => 'Percentage (discount,fraction,proportion,rate,ratio)' ),
			array( 'fas fa-piggy-bank' => 'Piggy Bank (bank,save,savings)' ),
			array( 'fas fa-receipt' => 'Receipt (check,invoice,money,pay,table)' ),
			array( 'fas fa-stamp' => 'Stamp (art,certificate,imprint,rubber,seal)' ),
			array( 'fas fa-wallet' => 'Wallet (billfold,cash,currency,money)' ),
		),
		'Fitness' => array(
			array( 'fas fa-bicycle' => 'Bicycle (bike,gears,pedal,transportation,vehicle)' ),
			array( 'fas fa-biking' => 'Biking (bicycle,bike,cycle,cycling,ride,wheel)' ),
			array( 'fas fa-burn' => 'Burn (caliente,energy,fire,flame,gas,heat,hot)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heartbeat' => 'Heartbeat (ekg,electrocardiogram,health,lifeline,vital signs)' ),
			array( 'fas fa-hiking' => 'Hiking (activity,backpack,fall,fitness,outdoors,person,seasonal,walking)' ),
			array( 'fas fa-running' => 'Running (exercise,health,jog,person,run,sport,sprint)' ),
			array( 'fas fa-shoe-prints' => 'Shoe Prints (feet,footprints,steps,walk)' ),
			array( 'fas fa-skating' => 'Skating (activity,figure skating,fitness,ice,person,winter)' ),
			array( 'fas fa-skiing' => 'Skiing (activity,downhill,fast,fitness,olympics,outdoors,person,seasonal,slalom)' ),
			array( 'fas fa-skiing-nordic' => 'Skiing Nordic (activity,cross country,fitness,outdoors,person,seasonal)' ),
			array( 'fas fa-snowboarding' => 'Snowboarding (activity,fitness,olympics,outdoors,person)' ),
			array( 'fas fa-spa' => 'Spa (flora,massage,mindfulness,plant,wellness)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-walking' => 'Walking (exercise,health,pedometer,person,steps)' ),
		),
		'Food' => array(
			array( 'fas fa-apple-alt' => 'Fruit Apple (fall,fruit,fuji,macintosh,orchard,seasonal,vegan)' ),
			array( 'fas fa-bacon' => 'Bacon (blt,breakfast,ham,lard,meat,pancetta,pork,rasher)' ),
			array( 'fas fa-bone' => 'Bone (calcium,dog,skeletal,skeleton,tibia)' ),
			array( 'fas fa-bread-slice' => 'Bread Slice (bake,bakery,baking,dough,flour,gluten,grain,sandwich,sourdough,toast,wheat,yeast)' ),
			array( 'fas fa-candy-cane' => 'Candy Cane (candy,christmas,holiday,mint,peppermint,striped,xmas)' ),
			array( 'fas fa-carrot' => 'Carrot (bugs bunny,orange,vegan,vegetable)' ),
			array( 'fas fa-cheese' => 'Cheese (cheddar,curd,gouda,melt,parmesan,sandwich,swiss,wedge)' ),
			array( 'fas fa-cloud-meatball' => 'Cloud with (a chance of) Meatball (FLDSMDFR,food,spaghetti,storm)' ),
			array( 'fas fa-cookie' => 'Cookie (baked good,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-drumstick-bite' => 'Drumstick with Bite Taken Out (bone,chicken,leg,meat,poultry,turkey)' ),
			array( 'fas fa-egg' => 'Egg (breakfast,chicken,easter,shell,yolk)' ),
			array( 'fas fa-fish' => 'Fish (fauna,gold,seafood,swimming)' ),
			array( 'fas fa-hamburger' => 'Hamburger (bacon,beef,burger,burger king,cheeseburger,fast food,grill,ground beef,mcdonalds,sandwich)' ),
			array( 'fas fa-hotdog' => 'Hot Dog (bun,chili,frankfurt,frankfurter,kosher,polish,sandwich,sausage,vienna,weiner)' ),
			array( 'fas fa-ice-cream' => 'Ice Cream (chocolate,cone,dessert,frozen,scoop,sorbet,vanilla,yogurt)' ),
			array( 'fas fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'far fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'fas fa-pepper-hot' => 'Hot Pepper (buffalo wings,capsicum,chili,chilli,habanero,jalapeno,mexican,spicy,tabasco,vegetable)' ),
			array( 'fas fa-pizza-slice' => 'Pizza Slice (cheese,chicago,italian,mozzarella,new york,pepperoni,pie,slice,teenage mutant ninja turtles,tomato)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
			array( 'fas fa-stroopwafel' => 'Stroopwafel (caramel,cookie,dessert,sweets,waffle)' ),
		),
		'Fruits & Vegetables' => array(
			array( 'fas fa-apple-alt' => 'Fruit Apple (fall,fruit,fuji,macintosh,orchard,seasonal,vegan)' ),
			array( 'fas fa-carrot' => 'Carrot (bugs bunny,orange,vegan,vegetable)' ),
			array( 'fas fa-leaf' => 'leaf (eco,flora,nature,plant,vegan)' ),
			array( 'fas fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'far fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'fas fa-pepper-hot' => 'Hot Pepper (buffalo wings,capsicum,chili,chilli,habanero,jalapeno,mexican,spicy,tabasco,vegetable)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
		),
		'Games' => array(
			array( 'fas fa-chess' => 'Chess (board,castle,checkmate,game,king,rook,strategy,tournament)' ),
			array( 'fas fa-chess-bishop' => 'Chess Bishop (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-board' => 'Chess Board (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-king' => 'Chess King (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-knight' => 'Chess Knight (board,checkmate,game,horse,strategy)' ),
			array( 'fas fa-chess-pawn' => 'Chess Pawn (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-queen' => 'Chess Queen (board,checkmate,game,strategy)' ),
			array( 'fas fa-chess-rook' => 'Chess Rook (board,castle,checkmate,game,strategy)' ),
			array( 'fas fa-dice' => 'Dice (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-d20' => 'Dice D20 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dice-d6' => 'Dice D6 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dice-five' => 'Dice Five (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-four' => 'Dice Four (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-one' => 'Dice One (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-six' => 'Dice Six (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-three' => 'Dice Three (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-two' => 'Dice Two (chance,gambling,game,roll)' ),
			array( 'fas fa-gamepad' => 'Gamepad (arcade,controller,d-pad,joystick,video,video game)' ),
			array( 'fas fa-ghost' => 'Ghost (apparition,blinky,clyde,floating,halloween,holiday,inky,pinky,spirit)' ),
			array( 'fas fa-headset' => 'Headset (audio,gamer,gaming,listen,live chat,microphone,shot caller,sound,support,telemarketer)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fab fa-playstation' => 'PlayStation' ),
			array( 'fas fa-puzzle-piece' => 'Puzzle Piece (add-on,addon,game,section)' ),
			array( 'fab fa-steam' => 'Steam' ),
			array( 'fab fa-steam-square' => 'Steam Square' ),
			array( 'fab fa-steam-symbol' => 'Steam Symbol' ),
			array( 'fab fa-twitch' => 'Twitch' ),
			array( 'fab fa-xbox' => 'Xbox' ),
		),
		'Genders' => array(
			array( 'fas fa-genderless' => 'Genderless (androgynous,asexual,sexless)' ),
			array( 'fas fa-mars' => 'Mars (male)' ),
			array( 'fas fa-mars-double' => 'Mars Double' ),
			array( 'fas fa-mars-stroke' => 'Mars Stroke' ),
			array( 'fas fa-mars-stroke-h' => 'Mars Stroke Horizontal' ),
			array( 'fas fa-mars-stroke-v' => 'Mars Stroke Vertical' ),
			array( 'fas fa-mercury' => 'Mercury (transgender)' ),
			array( 'fas fa-neuter' => 'Neuter' ),
			array( 'fas fa-transgender' => 'Transgender (intersex)' ),
			array( 'fas fa-transgender-alt' => 'Alternate Transgender (intersex)' ),
			array( 'fas fa-venus' => 'Venus (female)' ),
			array( 'fas fa-venus-double' => 'Venus Double (female)' ),
			array( 'fas fa-venus-mars' => 'Venus Mars (Gender)' ),
		),
		'Halloween' => array(
			array( 'fas fa-book-dead' => 'Book of the Dead (Dungeons & Dragons,crossbones,d&d,dark arts,death,dnd,documentation,evil,fantasy,halloween,holiday,necronomicon,read,skull,spell)' ),
			array( 'fas fa-broom' => 'Broom (clean,firebolt,fly,halloween,nimbus 2000,quidditch,sweep,witch)' ),
			array( 'fas fa-cat' => 'Cat (feline,halloween,holiday,kitten,kitty,meow,pet)' ),
			array( 'fas fa-cloud-moon' => 'Cloud with Moon (crescent,evening,lunar,night,partly cloudy,sky)' ),
			array( 'fas fa-crow' => 'Crow (bird,bullfrog,fauna,halloween,holiday,toad)' ),
			array( 'fas fa-ghost' => 'Ghost (apparition,blinky,clyde,floating,halloween,holiday,inky,pinky,spirit)' ),
			array( 'fas fa-hat-wizard' => 'Wizard\'s Hat (Dungeons & Dragons,accessory,buckle,clothing,d&d,dnd,fantasy,halloween,head,holiday,mage,magic,pointy,witch)' ),
			array( 'fas fa-mask' => 'Mask (carnivale,costume,disguise,halloween,secret,super hero)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fas fa-spider' => 'Spider (arachnid,bug,charlotte,crawl,eight,halloween)' ),
			array( 'fas fa-toilet-paper' => 'Toilet Paper (bathroom,halloween,holiday,lavatory,prank,restroom,roll)' ),
		),
		'Hands' => array(
			array( 'fas fa-allergies' => 'Allergies (allergy,freckles,hand,hives,pox,skin,spots)' ),
			array( 'fas fa-fist-raised' => 'Raised Fist (Dungeons & Dragons,d&d,dnd,fantasy,hand,ki,monk,resist,strength,unarmed combat)' ),
			array( 'fas fa-hand-holding' => 'Hand Holding (carry,lift)' ),
			array( 'fas fa-hand-holding-heart' => 'Hand Holding Heart (carry,charity,gift,lift,package)' ),
			array( 'fas fa-hand-holding-usd' => 'Hand Holding US Dollar ($,carry,dollar sign,donation,giving,lift,money,price)' ),
			array( 'fas fa-hand-lizard' => 'Lizard (Hand) (game,roshambo)' ),
			array( 'far fa-hand-lizard' => 'Lizard (Hand) (game,roshambo)' ),
			array( 'fas fa-hand-middle-finger' => 'Hand with Middle Finger Raised (flip the bird,gesture,hate,rude)' ),
			array( 'fas fa-hand-paper' => 'Paper (Hand) (game,halt,roshambo,stop)' ),
			array( 'far fa-hand-paper' => 'Paper (Hand) (game,halt,roshambo,stop)' ),
			array( 'fas fa-hand-peace' => 'Peace (Hand) (rest,truce)' ),
			array( 'far fa-hand-peace' => 'Peace (Hand) (rest,truce)' ),
			array( 'fas fa-hand-point-down' => 'Hand Pointing Down (finger,hand-o-down,point)' ),
			array( 'far fa-hand-point-down' => 'Hand Pointing Down (finger,hand-o-down,point)' ),
			array( 'fas fa-hand-point-left' => 'Hand Pointing Left (back,finger,hand-o-left,left,point,previous)' ),
			array( 'far fa-hand-point-left' => 'Hand Pointing Left (back,finger,hand-o-left,left,point,previous)' ),
			array( 'fas fa-hand-point-right' => 'Hand Pointing Right (finger,forward,hand-o-right,next,point,right)' ),
			array( 'far fa-hand-point-right' => 'Hand Pointing Right (finger,forward,hand-o-right,next,point,right)' ),
			array( 'fas fa-hand-point-up' => 'Hand Pointing Up (finger,hand-o-up,point)' ),
			array( 'far fa-hand-point-up' => 'Hand Pointing Up (finger,hand-o-up,point)' ),
			array( 'fas fa-hand-pointer' => 'Pointer (Hand) (arrow,cursor,select)' ),
			array( 'far fa-hand-pointer' => 'Pointer (Hand) (arrow,cursor,select)' ),
			array( 'fas fa-hand-rock' => 'Rock (Hand) (fist,game,roshambo)' ),
			array( 'far fa-hand-rock' => 'Rock (Hand) (fist,game,roshambo)' ),
			array( 'fas fa-hand-scissors' => 'Scissors (Hand) (cut,game,roshambo)' ),
			array( 'far fa-hand-scissors' => 'Scissors (Hand) (cut,game,roshambo)' ),
			array( 'fas fa-hand-spock' => 'Spock (Hand) (live long,prosper,salute,star trek,vulcan)' ),
			array( 'far fa-hand-spock' => 'Spock (Hand) (live long,prosper,salute,star trek,vulcan)' ),
			array( 'fas fa-hands' => 'Hands (carry,hold,lift)' ),
			array( 'fas fa-hands-helping' => 'Helping Hands (aid,assistance,handshake,partnership,volunteering)' ),
			array( 'fas fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'far fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'fas fa-praying-hands' => 'Praying Hands (kneel,preach,religion,worship)' ),
			array( 'fas fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'far fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'fas fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'far fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
		),
		'Health' => array(
			array( 'fab fa-accessible-icon' => 'Accessible Icon (accessibility,handicap,person,wheelchair,wheelchair-alt)' ),
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-h-square' => 'H Square (directions,emergency,hospital,hotel,map)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heartbeat' => 'Heartbeat (ekg,electrocardiogram,health,lifeline,vital signs)' ),
			array( 'fas fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'far fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'fas fa-medkit' => 'medkit (first aid,firstaid,health,help,support)' ),
			array( 'fas fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'far fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-prescription' => 'Prescription (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-stethoscope' => 'Stethoscope (diagnosis,doctor,general practitioner,hospital,infirmary,medicine,office,outpatient)' ),
			array( 'fas fa-user-md' => 'Doctor (job,medical,nurse,occupation,physician,profile,surgeon)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
		),
		'Holiday' => array(
			array( 'fas fa-candy-cane' => 'Candy Cane (candy,christmas,holiday,mint,peppermint,striped,xmas)' ),
			array( 'fas fa-carrot' => 'Carrot (bugs bunny,orange,vegan,vegetable)' ),
			array( 'fas fa-cookie-bite' => 'Cookie Bite (baked good,bitten,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-gifts' => 'Gifts (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-glass-cheers' => 'Glass Cheers (alcohol,bar,beverage,celebration,champagne,clink,drink,holiday,new year\'s eve,party,toast)' ),
			array( 'fas fa-holly-berry' => 'Holly Berry (catwoman,christmas,decoration,flora,halle,holiday,ororo munroe,plant,storm,xmas)' ),
			array( 'fas fa-mug-hot' => 'Mug Hot (caliente,cocoa,coffee,cup,drink,holiday,hot chocolate,steam,tea,warmth)' ),
			array( 'fas fa-sleigh' => 'Sleigh (christmas,claus,fly,holiday,santa,sled,snow,xmas)' ),
			array( 'fas fa-snowman' => 'Snowman (decoration,frost,frosty,holiday)' ),
		),
		'Hotel' => array(
			array( 'fas fa-baby-carriage' => 'Baby Carriage (buggy,carrier,infant,push,stroller,transportation,walk,wheels)' ),
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-briefcase' => 'Briefcase (bag,business,luggage,office,work)' ),
			array( 'fas fa-car' => 'Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-cocktail' => 'Cocktail (alcohol,beverage,drink,gin,glass,margarita,martini,vodka)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-concierge-bell' => 'Concierge Bell (attention,hotel,receptionist,service,support)' ),
			array( 'fas fa-dice' => 'Dice (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-five' => 'Dice Five (chance,gambling,game,roll)' ),
			array( 'fas fa-door-closed' => 'Door Closed (enter,exit,locked)' ),
			array( 'fas fa-door-open' => 'Door Open (enter,exit,welcome)' ),
			array( 'fas fa-dumbbell' => 'Dumbbell (exercise,gym,strength,weight,weight-lifting)' ),
			array( 'fas fa-glass-martini' => 'Martini Glass (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-glass-martini-alt' => 'Alternate Glass Martini (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-hot-tub' => 'Hot Tub (bath,jacuzzi,massage,sauna,spa)' ),
			array( 'fas fa-hotel' => 'Hotel (building,inn,lodging,motel,resort,travel)' ),
			array( 'fas fa-infinity' => 'Infinity (eternity,forever,math)' ),
			array( 'fas fa-key' => 'key (lock,password,private,secret,unlock)' ),
			array( 'fas fa-luggage-cart' => 'Luggage Cart (bag,baggage,suitcase,travel)' ),
			array( 'fas fa-shower' => 'Shower (bath,clean,faucet,water)' ),
			array( 'fas fa-shuttle-van' => 'Shuttle Van (airport,machine,public-transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-smoking' => 'Smoking (cancer,cigarette,nicotine,smoking status,tobacco)' ),
			array( 'fas fa-smoking-ban' => 'Smoking Ban (ban,cancel,no smoking,non-smoking)' ),
			array( 'fas fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'far fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'fas fa-spa' => 'Spa (flora,massage,mindfulness,plant,wellness)' ),
			array( 'fas fa-suitcase' => 'Suitcase (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-suitcase-rolling' => 'Suitcase Rolling (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-swimming-pool' => 'Swimming Pool (ladder,recreation,swim,water)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
			array( 'fas fa-umbrella-beach' => 'Umbrella Beach (protection,recreation,sand,shade,summer,sun)' ),
			array( 'fas fa-utensils' => 'Utensils (cutlery,dining,dinner,eat,food,fork,knife,restaurant)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
		),
		'Household' => array(
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-blender' => 'Blender (cocktail,milkshake,mixer,puree,smoothie)' ),
			array( 'fas fa-chair' => 'Chair (furniture,seat,sit)' ),
			array( 'fas fa-couch' => 'Couch (chair,cushion,furniture,relax,sofa)' ),
			array( 'fas fa-door-closed' => 'Door Closed (enter,exit,locked)' ),
			array( 'fas fa-door-open' => 'Door Open (enter,exit,welcome)' ),
			array( 'fas fa-dungeon' => 'Dungeon (Dungeons & Dragons,building,d&d,dnd,door,entrance,fantasy,gate)' ),
			array( 'fas fa-fan' => 'Fan (ac,air conditioning,blade,blower,cool,hot)' ),
			array( 'fas fa-shower' => 'Shower (bath,clean,faucet,water)' ),
			array( 'fas fa-toilet-paper' => 'Toilet Paper (bathroom,halloween,holiday,lavatory,prank,restroom,roll)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
		),
		'Images' => array(
			array( 'fas fa-adjust' => 'adjust (contrast,dark,light,saturation)' ),
			array( 'fas fa-bolt' => 'Lightning Bolt (electricity,lightning,weather,zap)' ),
			array( 'fas fa-camera' => 'camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-camera-retro' => 'Retro Camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-chalkboard' => 'Chalkboard (blackboard,learning,school,teaching,whiteboard,writing)' ),
			array( 'fas fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'far fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'fas fa-compress' => 'Compress (collapse,fullscreen,minimize,move,resize,shrink,smaller)' ),
			array( 'fas fa-compress-arrows-alt' => 'Alternate Compress Arrows (collapse,fullscreen,minimize,move,resize,shrink,smaller)' ),
			array( 'fas fa-expand' => 'Expand (arrow,bigger,enlarge,resize)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-dropper' => 'Eye Dropper (beaker,clone,color,copy,eyedropper,pipette)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-file-image' => 'Image File (document,image,jpg,photo,png)' ),
			array( 'far fa-file-image' => 'Image File (document,image,jpg,photo,png)' ),
			array( 'fas fa-film' => 'Film (cinema,movie,strip,video)' ),
			array( 'fas fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'far fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'fas fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'far fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'far fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'fas fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'far fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'fas fa-photo-video' => 'Photo Video (av,film,image,library,media)' ),
			array( 'fas fa-portrait' => 'Portrait (id,image,photo,picture,selfie)' ),
			array( 'fas fa-sliders-h' => 'Horizontal Sliders (adjust,settings,sliders,toggle)' ),
			array( 'fas fa-tint' => 'tint (color,drop,droplet,raindrop,waterdrop)' ),
		),
		'Interfaces' => array(
			array( 'fas fa-award' => 'Award (honor,praise,prize,recognition,ribbon,trophy)' ),
			array( 'fas fa-ban' => 'ban (abort,ban,block,cancel,delete,hide,prohibit,remove,stop,trash)' ),
			array( 'fas fa-barcode' => 'barcode (info,laser,price,scan,upc)' ),
			array( 'fas fa-bars' => 'Bars (checklist,drag,hamburger,list,menu,nav,navigation,ol,reorder,settings,todo,ul)' ),
			array( 'fas fa-beer' => 'beer (alcohol,ale,bar,beverage,brewery,drink,lager,liquor,mug,stein)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-blog' => 'Blog (journal,log,online,personal,post,web 2.0,wordpress,writing)' ),
			array( 'fas fa-bug' => 'Bug (beetle,error,insect,report)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-bullseye' => 'Bullseye (archery,goal,objective,target)' ),
			array( 'fas fa-calculator' => 'Calculator (abacus,addition,arithmetic,counting,math,multiplication,subtraction)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'far fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'far fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'fas fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'far fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'fas fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'far fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'fas fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'far fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'fas fa-certificate' => 'certificate (badge,star,verified)' ),
			array( 'fas fa-check' => 'Check (accept,agree,checkmark,confirm,correct,done,notice,notification,notify,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-check-circle' => 'Check Circle (accept,agree,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'far fa-check-circle' => 'Check Circle (accept,agree,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-check-double' => 'Double Check (accept,agree,checkmark,confirm,correct,done,notice,notification,notify,ok,select,success,tick,todo)' ),
			array( 'fas fa-check-square' => 'Check Square (accept,agree,checkmark,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'far fa-check-square' => 'Check Square (accept,agree,checkmark,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'far fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'fas fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'far fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'fas fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'far fa-clone' => 'Clone (arrange,copy,duplicate,paste)' ),
			array( 'fas fa-cloud' => 'Cloud (atmosphere,fog,overcast,save,upload,weather)' ),
			array( 'fas fa-cloud-download-alt' => 'Alternate Cloud Download (download,export,save)' ),
			array( 'fas fa-cloud-upload-alt' => 'Alternate Cloud Upload (cloud-upload,import,save,upload)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-cog' => 'cog (gear,mechanical,settings,sprocket,wheel)' ),
			array( 'fas fa-cogs' => 'cogs (gears,mechanical,settings,sprocket,wheel)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-database' => 'Database (computer,development,directory,memory,storage)' ),
			array( 'fas fa-dot-circle' => 'Dot Circle (bullseye,notification,target)' ),
			array( 'far fa-dot-circle' => 'Dot Circle (bullseye,notification,target)' ),
			array( 'fas fa-download' => 'Download (export,hard drive,save,transfer)' ),
			array( 'fas fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'far fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'fas fa-ellipsis-h' => 'Horizontal Ellipsis (dots,drag,kebab,list,menu,nav,navigation,ol,reorder,settings,ul)' ),
			array( 'fas fa-ellipsis-v' => 'Vertical Ellipsis (dots,drag,kebab,list,menu,nav,navigation,ol,reorder,settings,ul)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-exclamation' => 'exclamation (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-circle' => 'Exclamation Circle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-triangle' => 'Exclamation Triangle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-external-link-alt' => 'Alternate External Link (external-link,new,open,share)' ),
			array( 'fas fa-external-link-square-alt' => 'Alternate External Link Square (external-link-square,new,open,share)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-file-download' => 'File Download (document,export,save)' ),
			array( 'fas fa-file-export' => 'File Export (download,save)' ),
			array( 'fas fa-file-import' => 'File Import (copy,document,send,upload)' ),
			array( 'fas fa-file-upload' => 'File Upload (document,import,page,save)' ),
			array( 'fas fa-filter' => 'Filter (funnel,options,separate,sort)' ),
			array( 'fas fa-fingerprint' => 'Fingerprint (human,id,identification,lock,smudge,touch,unique,unlock)' ),
			array( 'fas fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'far fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'fas fa-flag-checkered' => 'flag-checkered (notice,notification,notify,pole,racing,report,symbol)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'far fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'fas fa-glasses' => 'Glasses (hipster,nerd,reading,sight,spectacles,vision)' ),
			array( 'fas fa-grip-horizontal' => 'Grip Horizontal (affordance,drag,drop,grab,handle)' ),
			array( 'fas fa-grip-lines' => 'Grip Lines (affordance,drag,drop,grab,handle)' ),
			array( 'fas fa-grip-lines-vertical' => 'Grip Lines Vertical (affordance,drag,drop,grab,handle)' ),
			array( 'fas fa-grip-vertical' => 'Grip Vertical (affordance,drag,drop,grab,handle)' ),
			array( 'fas fa-hashtag' => 'Hashtag (Twitter,instagram,pound,social media,tag)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-history' => 'History (Rewind,clock,reverse,time,time machine)' ),
			array( 'fas fa-home' => 'home (abode,building,house,main)' ),
			array( 'fas fa-i-cursor' => 'I Beam Cursor (editing,i-beam,type,writing)' ),
			array( 'fas fa-info' => 'Info (details,help,information,more,support)' ),
			array( 'fas fa-info-circle' => 'Info Circle (details,help,information,more,support)' ),
			array( 'fas fa-language' => 'Language (dialect,idiom,localize,speech,translate,vernacular)' ),
			array( 'fas fa-magic' => 'magic (autocomplete,automatic,mage,magic,spell,wand,witch,wizard)' ),
			array( 'fas fa-marker' => 'Marker (design,edit,sharpie,update,write)' ),
			array( 'fas fa-medal' => 'Medal (award,ribbon,star,trophy)' ),
			array( 'fas fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-minus' => 'minus (collapse,delete,hide,minify,negative,remove,trash)' ),
			array( 'fas fa-minus-circle' => 'Minus Circle (delete,hide,negative,remove,shape,trash)' ),
			array( 'fas fa-minus-square' => 'Minus Square (collapse,delete,hide,minify,negative,remove,shape,trash)' ),
			array( 'far fa-minus-square' => 'Minus Square (collapse,delete,hide,minify,negative,remove,shape,trash)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-fancy' => 'Pen Fancy (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-plus' => 'plus (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-plus-circle' => 'Plus Circle (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'far fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-poo' => 'Poo (crap,poop,shit,smile,turd)' ),
			array( 'fas fa-qrcode' => 'qrcode (barcode,info,information,scan)' ),
			array( 'fas fa-question' => 'Question (help,information,support,unknown)' ),
			array( 'fas fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'far fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'fas fa-quote-left' => 'quote-left (mention,note,phrase,text,type)' ),
			array( 'fas fa-quote-right' => 'quote-right (mention,note,phrase,text,type)' ),
			array( 'fas fa-redo' => 'Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-redo-alt' => 'Alternate Redo (forward,refresh,reload,repeat)' ),
			array( 'fas fa-reply' => 'Reply (mail,message,respond)' ),
			array( 'fas fa-reply-all' => 'reply-all (mail,message,respond)' ),
			array( 'fas fa-rss' => 'rss (blog,feed,journal,news,writing)' ),
			array( 'fas fa-rss-square' => 'RSS Square (blog,feed,journal,news,writing)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-screwdriver' => 'Screwdriver (admin,fix,mechanic,repair,settings,tool)' ),
			array( 'fas fa-search' => 'Search (bigger,enlarge,find,magnify,preview,zoom)' ),
			array( 'fas fa-search-minus' => 'Search Minus (minify,negative,smaller,zoom,zoom out)' ),
			array( 'fas fa-search-plus' => 'Search Plus (bigger,enlarge,magnify,positive,zoom,zoom in)' ),
			array( 'fas fa-share' => 'Share (forward,save,send,social)' ),
			array( 'fas fa-share-alt' => 'Alternate Share (forward,save,send,social)' ),
			array( 'fas fa-share-alt-square' => 'Alternate Share Square (forward,save,send,social)' ),
			array( 'fas fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'far fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'fas fa-shield-alt' => 'Alternate Shield (achievement,award,block,defend,security,winner)' ),
			array( 'fas fa-sign-in-alt' => 'Alternate Sign In (arrow,enter,join,log in,login,sign in,sign up,sign-in,signin,signup)' ),
			array( 'fas fa-sign-out-alt' => 'Alternate Sign Out (arrow,exit,leave,log out,logout,sign-out)' ),
			array( 'fas fa-signal' => 'signal (bars,graph,online,reception,status)' ),
			array( 'fas fa-sitemap' => 'Sitemap (directory,hierarchy,ia,information architecture,organization)' ),
			array( 'fas fa-sliders-h' => 'Horizontal Sliders (adjust,settings,sliders,toggle)' ),
			array( 'fas fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'far fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'fas fa-sort' => 'Sort (filter,order)' ),
			array( 'fas fa-sort-alpha-down' => 'Sort Alphabetical Down (alphabetical,arrange,filter,order,sort-alpha-asc)' ),
			array( 'fas fa-sort-alpha-down-alt' => 'Alternate Sort Alphabetical Down (alphabetical,arrange,filter,order,sort-alpha-asc)' ),
			array( 'fas fa-sort-alpha-up' => 'Sort Alphabetical Up (alphabetical,arrange,filter,order,sort-alpha-desc)' ),
			array( 'fas fa-sort-alpha-up-alt' => 'Alternate Sort Alphabetical Up (alphabetical,arrange,filter,order,sort-alpha-desc)' ),
			array( 'fas fa-sort-amount-down' => 'Sort Amount Down (arrange,filter,number,order,sort-amount-asc)' ),
			array( 'fas fa-sort-amount-down-alt' => 'Alternate Sort Amount Down (arrange,filter,order,sort-amount-asc)' ),
			array( 'fas fa-sort-amount-up' => 'Sort Amount Up (arrange,filter,order,sort-amount-desc)' ),
			array( 'fas fa-sort-amount-up-alt' => 'Alternate Sort Amount Up (arrange,filter,order,sort-amount-desc)' ),
			array( 'fas fa-sort-down' => 'Sort Down (Descending) (arrow,descending,filter,order,sort-desc)' ),
			array( 'fas fa-sort-numeric-down' => 'Sort Numeric Down (arrange,filter,numbers,order,sort-numeric-asc)' ),
			array( 'fas fa-sort-numeric-down-alt' => 'Alternate Sort Numeric Down (arrange,filter,numbers,order,sort-numeric-asc)' ),
			array( 'fas fa-sort-numeric-up' => 'Sort Numeric Up (arrange,filter,numbers,order,sort-numeric-desc)' ),
			array( 'fas fa-sort-numeric-up-alt' => 'Alternate Sort Numeric Up (arrange,filter,numbers,order,sort-numeric-desc)' ),
			array( 'fas fa-sort-up' => 'Sort Up (Ascending) (arrow,ascending,filter,order,sort-asc)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fas fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'far fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'fas fa-sync' => 'Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-sync-alt' => 'Alternate Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'far fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'fas fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'far fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'fas fa-times' => 'Times (close,cross,error,exit,incorrect,notice,notification,notify,problem,wrong,x)' ),
			array( 'fas fa-times-circle' => 'Times Circle (close,cross,exit,incorrect,notice,notification,notify,problem,wrong,x)' ),
			array( 'far fa-times-circle' => 'Times Circle (close,cross,exit,incorrect,notice,notification,notify,problem,wrong,x)' ),
			array( 'fas fa-toggle-off' => 'Toggle Off (switch)' ),
			array( 'fas fa-toggle-on' => 'Toggle On (switch)' ),
			array( 'fas fa-tools' => 'Tools (admin,fix,repair,screwdriver,settings,tools,wrench)' ),
			array( 'fas fa-trash' => 'Trash (delete,garbage,hide,remove)' ),
			array( 'fas fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'far fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'fas fa-trash-restore' => 'Trash Restore (back,control z,oops,undo)' ),
			array( 'fas fa-trash-restore-alt' => 'Alternative Trash Restore (back,control z,oops,undo)' ),
			array( 'fas fa-trophy' => 'trophy (achievement,award,cup,game,winner)' ),
			array( 'fas fa-undo' => 'Undo (back,control z,exchange,oops,return,rotate,swap)' ),
			array( 'fas fa-undo-alt' => 'Alternate Undo (back,control z,exchange,oops,return,swap)' ),
			array( 'fas fa-upload' => 'Upload (hard drive,import,publish)' ),
			array( 'fas fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-alt' => 'Alternate User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-volume-down' => 'Volume Down (audio,lower,music,quieter,sound,speaker)' ),
			array( 'fas fa-volume-mute' => 'Volume Mute (audio,music,quiet,sound,speaker)' ),
			array( 'fas fa-volume-off' => 'Volume Off (audio,ban,music,mute,quiet,silent,sound)' ),
			array( 'fas fa-volume-up' => 'Volume Up (audio,higher,louder,music,sound,speaker)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
			array( 'fas fa-wrench' => 'Wrench (construction,fix,mechanic,plumbing,settings,spanner,tool,update)' ),
		),
		'Logistics' => array(
			array( 'fas fa-box' => 'Box (archive,container,package,storage)' ),
			array( 'fas fa-boxes' => 'Boxes (archives,inventory,storage,warehouse)' ),
			array( 'fas fa-clipboard-check' => 'Clipboard with Check (accept,agree,confirm,done,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-clipboard-list' => 'Clipboard List (checklist,completed,done,finished,intinerary,ol,schedule,tick,todo,ul)' ),
			array( 'fas fa-dolly' => 'Dolly (carry,shipping,transport)' ),
			array( 'fas fa-dolly-flatbed' => 'Dolly Flatbed (carry,inventory,shipping,transport)' ),
			array( 'fas fa-hard-hat' => 'Hard Hat (construction,hardhat,helmet,safety)' ),
			array( 'fas fa-pallet' => 'Pallet (archive,box,inventory,shipping,warehouse)' ),
			array( 'fas fa-shipping-fast' => 'Shipping Fast (express,fedex,mail,overnight,package,ups)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-warehouse' => 'Warehouse (building,capacity,garage,inventory,storage)' ),
		),
		'Maps' => array(
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-anchor' => 'Anchor (berth,boat,dock,embed,link,maritime,moor,secure)' ),
			array( 'fas fa-balance-scale' => 'Balance Scale (balanced,justice,legal,measure,weight)' ),
			array( 'fas fa-balance-scale-left' => 'Balance Scale (Left-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-balance-scale-right' => 'Balance Scale (Right-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-beer' => 'beer (alcohol,ale,bar,beverage,brewery,drink,lager,liquor,mug,stein)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-bicycle' => 'Bicycle (bike,gears,pedal,transportation,vehicle)' ),
			array( 'fas fa-binoculars' => 'Binoculars (glasses,magnify,scenic,spyglass,view)' ),
			array( 'fas fa-birthday-cake' => 'Birthday Cake (anniversary,bakery,candles,celebration,dessert,frosting,holiday,party,pastry)' ),
			array( 'fas fa-blind' => 'Blind (cane,disability,person,sight)' ),
			array( 'fas fa-bomb' => 'Bomb (error,explode,fuse,grenade,warning)' ),
			array( 'fas fa-book' => 'book (diary,documentation,journal,library,read)' ),
			array( 'fas fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'far fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'fas fa-briefcase' => 'Briefcase (bag,business,luggage,office,work)' ),
			array( 'fas fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'far fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'fas fa-car' => 'Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-crosshairs' => 'Crosshairs (aim,bullseye,gpd,picker,position)' ),
			array( 'fas fa-directions' => 'Directions (map,navigation,sign,turn)' ),
			array( 'fas fa-dollar-sign' => 'Dollar Sign ($,cost,dollar-sign,money,price,usd)' ),
			array( 'fas fa-draw-polygon' => 'Draw Polygon (anchors,lines,object,render,shape)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-fighter-jet' => 'fighter-jet (airplane,fast,fly,goose,maverick,plane,quick,top gun,transportation,travel)' ),
			array( 'fas fa-fire' => 'fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-extinguisher' => 'fire-extinguisher (burn,caliente,fire fighter,flame,heat,hot,rescue)' ),
			array( 'fas fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'far fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'fas fa-flag-checkered' => 'flag-checkered (notice,notification,notify,pole,racing,report,symbol)' ),
			array( 'fas fa-flask' => 'Flask (beaker,experimental,labs,science)' ),
			array( 'fas fa-gamepad' => 'Gamepad (arcade,controller,d-pad,joystick,video,video game)' ),
			array( 'fas fa-gavel' => 'Gavel (hammer,judge,law,lawyer,opinion)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-glass-martini' => 'Martini Glass (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-globe' => 'Globe (all,coordinates,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-graduation-cap' => 'Graduation Cap (ceremony,college,graduate,learning,school,student)' ),
			array( 'fas fa-h-square' => 'H Square (directions,emergency,hospital,hotel,map)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heartbeat' => 'Heartbeat (ekg,electrocardiogram,health,lifeline,vital signs)' ),
			array( 'fas fa-helicopter' => 'Helicopter (airwolf,apache,chopper,flight,fly,travel)' ),
			array( 'fas fa-home' => 'home (abode,building,house,main)' ),
			array( 'fas fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'far fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'fas fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'far fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'fas fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'far fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'fas fa-industry' => 'Industry (building,factory,industrial,manufacturing,mill,warehouse)' ),
			array( 'fas fa-info' => 'Info (details,help,information,more,support)' ),
			array( 'fas fa-info-circle' => 'Info Circle (details,help,information,more,support)' ),
			array( 'fas fa-key' => 'key (lock,password,private,secret,unlock)' ),
			array( 'fas fa-landmark' => 'Landmark (building,historic,memorable,monument,politics)' ),
			array( 'fas fa-layer-group' => 'Layer Group (arrange,develop,layers,map,stack)' ),
			array( 'fas fa-leaf' => 'leaf (eco,flora,nature,plant,vegan)' ),
			array( 'fas fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'far fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'fas fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'far fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'fas fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'far fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'fas fa-location-arrow' => 'location-arrow (address,compass,coordinate,direction,gps,map,navigation,place)' ),
			array( 'fas fa-low-vision' => 'Low Vision (blind,eye,sight)' ),
			array( 'fas fa-magnet' => 'magnet (Attract,lodestone,tool)' ),
			array( 'fas fa-male' => 'Male (human,man,person,profile,user)' ),
			array( 'fas fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'far fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker' => 'map-marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker-alt' => 'Alternate Map Marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-pin' => 'Map Pin (address,agree,coordinates,destination,gps,localize,location,map,marker,navigation,pin,place,position,travel)' ),
			array( 'fas fa-map-signs' => 'Map Signs (directions,directory,map,signage,wayfinding)' ),
			array( 'fas fa-medkit' => 'medkit (first aid,firstaid,health,help,support)' ),
			array( 'fas fa-money-bill' => 'Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'far fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-motorcycle' => 'Motorcycle (bike,machine,transportation,vehicle)' ),
			array( 'fas fa-music' => 'Music (lyrics,melody,note,sing,sound)' ),
			array( 'fas fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'far fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'fas fa-parking' => 'Parking (auto,car,garage,meter)' ),
			array( 'fas fa-paw' => 'Paw (animal,cat,dog,pet,print)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square' => 'Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-square-alt' => 'Alternate Phone Square (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-volume' => 'Phone Volume (call,earphone,number,sound,support,telephone,voice,volume-control-phone)' ),
			array( 'fas fa-plane' => 'plane (airplane,destination,fly,location,mode,travel,trip)' ),
			array( 'fas fa-plug' => 'Plug (connect,electric,online,power)' ),
			array( 'fas fa-plus' => 'plus (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'far fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-recycle' => 'Recycle (Waste,compost,garbage,reuse,trash)' ),
			array( 'fas fa-restroom' => 'Restroom (bathroom,john,loo,potty,washroom,waste,wc)' ),
			array( 'fas fa-road' => 'road (highway,map,pavement,route,street,travel)' ),
			array( 'fas fa-rocket' => 'rocket (aircraft,app,jet,launch,nasa,space)' ),
			array( 'fas fa-route' => 'Route (directions,navigation,travel)' ),
			array( 'fas fa-search' => 'Search (bigger,enlarge,find,magnify,preview,zoom)' ),
			array( 'fas fa-search-minus' => 'Search Minus (minify,negative,smaller,zoom,zoom out)' ),
			array( 'fas fa-search-plus' => 'Search Plus (bigger,enlarge,magnify,positive,zoom,zoom in)' ),
			array( 'fas fa-ship' => 'Ship (boat,sea,water)' ),
			array( 'fas fa-shoe-prints' => 'Shoe Prints (feet,footprints,steps,walk)' ),
			array( 'fas fa-shopping-bag' => 'Shopping Bag (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-basket' => 'Shopping Basket (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shower' => 'Shower (bath,clean,faucet,water)' ),
			array( 'fas fa-snowplow' => 'Snowplow (clean up,cold,road,storm,winter)' ),
			array( 'fas fa-street-view' => 'Street View (directions,location,map,navigation)' ),
			array( 'fas fa-subway' => 'Subway (machine,railway,train,transportation,vehicle)' ),
			array( 'fas fa-suitcase' => 'Suitcase (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-tag' => 'tag (discount,label,price,shopping)' ),
			array( 'fas fa-tags' => 'tags (discount,label,price,shopping)' ),
			array( 'fas fa-taxi' => 'Taxi (cab,cabbie,car,car service,lyft,machine,transportation,travel,uber,vehicle)' ),
			array( 'fas fa-thumbtack' => 'Thumbtack (coordinates,location,marker,pin,thumb-tack)' ),
			array( 'fas fa-ticket-alt' => 'Alternate Ticket (movie,pass,support,ticket)' ),
			array( 'fas fa-tint' => 'tint (color,drop,droplet,raindrop,waterdrop)' ),
			array( 'fas fa-traffic-light' => 'Traffic Light (direction,road,signal,travel)' ),
			array( 'fas fa-train' => 'Train (bullet,commute,locomotive,railway,subway)' ),
			array( 'fas fa-tram' => 'Tram (crossing,machine,mountains,seasonal,transportation)' ),
			array( 'fas fa-tree' => 'Tree (bark,fall,flora,forest,nature,plant,seasonal)' ),
			array( 'fas fa-trophy' => 'trophy (achievement,award,cup,game,winner)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-tty' => 'TTY (communication,deaf,telephone,teletypewriter,text)' ),
			array( 'fas fa-umbrella' => 'Umbrella (protection,rain,storm,wet)' ),
			array( 'fas fa-university' => 'University (bank,building,college,higher education - students,institution)' ),
			array( 'fas fa-utensil-spoon' => 'Utensil Spoon (cutlery,dining,scoop,silverware,spoon)' ),
			array( 'fas fa-utensils' => 'Utensils (cutlery,dining,dinner,eat,food,fork,knife,restaurant)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
			array( 'fas fa-wine-glass' => 'Wine Glass (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
			array( 'fas fa-wrench' => 'Wrench (construction,fix,mechanic,plumbing,settings,spanner,tool,update)' ),
		),
		'Maritime' => array(
			array( 'fas fa-anchor' => 'Anchor (berth,boat,dock,embed,link,maritime,moor,secure)' ),
			array( 'fas fa-binoculars' => 'Binoculars (glasses,magnify,scenic,spyglass,view)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-dharmachakra' => 'Dharmachakra (buddhism,buddhist,wheel of dharma)' ),
			array( 'fas fa-frog' => 'Frog (amphibian,bullfrog,fauna,hop,kermit,kiss,prince,ribbit,toad,wart)' ),
			array( 'fas fa-ship' => 'Ship (boat,sea,water)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-water' => 'Water (lake,liquid,ocean,sea,swim,wet)' ),
			array( 'fas fa-wind' => 'Wind (air,blow,breeze,fall,seasonal,weather)' ),
		),
		'Marketing' => array(
			array( 'fas fa-ad' => 'Ad (advertisement,media,newspaper,promotion,publicity)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-bullseye' => 'Bullseye (archery,goal,objective,target)' ),
			array( 'fas fa-comment-dollar' => 'Comment Dollar (bubble,chat,commenting,conversation,feedback,message,money,note,notification,pay,sms,speech,spend,texting,transfer)' ),
			array( 'fas fa-comments-dollar' => 'Comments Dollar (bubble,chat,commenting,conversation,feedback,message,money,note,notification,pay,sms,speech,spend,texting,transfer)' ),
			array( 'fas fa-envelope-open-text' => 'Envelope Open-text (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-funnel-dollar' => 'Funnel Dollar (filter,money,options,separate,sort)' ),
			array( 'fas fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'far fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'fas fa-mail-bulk' => 'Mail Bulk (archive,envelope,letter,post office,postal,postcard,send,stamp,usps)' ),
			array( 'fas fa-poll' => 'Poll (results,survey,trend,vote,voting)' ),
			array( 'fas fa-poll-h' => 'Poll H (results,survey,trend,vote,voting)' ),
			array( 'fas fa-search-dollar' => 'Search Dollar (bigger,enlarge,find,magnify,money,preview,zoom)' ),
			array( 'fas fa-search-location' => 'Search Location (bigger,enlarge,find,magnify,preview,zoom)' ),
		),
		'Mathematics' => array(
			array( 'fas fa-calculator' => 'Calculator (abacus,addition,arithmetic,counting,math,multiplication,subtraction)' ),
			array( 'fas fa-divide' => 'Divide (arithmetic,calculus,division,math)' ),
			array( 'fas fa-equals' => 'Equals (arithmetic,even,match,math)' ),
			array( 'fas fa-greater-than' => 'Greater Than (arithmetic,compare,math)' ),
			array( 'fas fa-greater-than-equal' => 'Greater Than Equal To (arithmetic,compare,math)' ),
			array( 'fas fa-infinity' => 'Infinity (eternity,forever,math)' ),
			array( 'fas fa-less-than' => 'Less Than (arithmetic,compare,math)' ),
			array( 'fas fa-less-than-equal' => 'Less Than Equal To (arithmetic,compare,math)' ),
			array( 'fas fa-minus' => 'minus (collapse,delete,hide,minify,negative,remove,trash)' ),
			array( 'fas fa-not-equal' => 'Not Equal (arithmetic,compare,math)' ),
			array( 'fas fa-percentage' => 'Percentage (discount,fraction,proportion,rate,ratio)' ),
			array( 'fas fa-plus' => 'plus (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-square-root-alt' => 'Alternate Square Root (arithmetic,calculus,division,math)' ),
			array( 'fas fa-subscript' => 'subscript (edit,font,format,text,type)' ),
			array( 'fas fa-superscript' => 'superscript (edit,exponential,font,format,text,type)' ),
			array( 'fas fa-times' => 'Times (close,cross,error,exit,incorrect,notice,notification,notify,problem,wrong,x)' ),
			array( 'fas fa-wave-square' => 'Square Wave (frequency,pulse,signal)' ),
		),
		'Medical' => array(
			array( 'fas fa-allergies' => 'Allergies (allergy,freckles,hand,hives,pox,skin,spots)' ),
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-band-aid' => 'Band-Aid (bandage,boo boo,first aid,ouch)' ),
			array( 'fas fa-biohazard' => 'Biohazard (danger,dangerous,hazmat,medical,radioactive,toxic,waste,zombie)' ),
			array( 'fas fa-bone' => 'Bone (calcium,dog,skeletal,skeleton,tibia)' ),
			array( 'fas fa-bong' => 'Bong (aparatus,cannabis,marijuana,pipe,smoke,smoking)' ),
			array( 'fas fa-book-medical' => 'Medical Book (diary,documentation,health,history,journal,library,read,record)' ),
			array( 'fas fa-brain' => 'Brain (cerebellum,gray matter,intellect,medulla oblongata,mind,noodle,wit)' ),
			array( 'fas fa-briefcase-medical' => 'Medical Briefcase (doctor,emt,first aid,health)' ),
			array( 'fas fa-burn' => 'Burn (caliente,energy,fire,flame,gas,heat,hot)' ),
			array( 'fas fa-cannabis' => 'Cannabis (bud,chronic,drugs,endica,endo,ganja,marijuana,mary jane,pot,reefer,sativa,spliff,weed,whacky-tabacky)' ),
			array( 'fas fa-capsules' => 'Capsules (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-clinic-medical' => 'Medical Clinic (doctor,general practitioner,hospital,infirmary,medicine,office,outpatient)' ),
			array( 'fas fa-comment-medical' => 'Alternate Medical Chat (advice,bubble,chat,commenting,conversation,diagnose,feedback,message,note,notification,prescription,sms,speech,texting)' ),
			array( 'fas fa-crutch' => 'Crutch (cane,injury,mobility,wheelchair)' ),
			array( 'fas fa-diagnoses' => 'Diagnoses (analyze,detect,diagnosis,examine,medicine)' ),
			array( 'fas fa-dna' => 'DNA (double helix,genetic,helix,molecule,protein)' ),
			array( 'fas fa-file-medical' => 'Medical File (document,health,history,prescription,record)' ),
			array( 'fas fa-file-medical-alt' => 'Alternate Medical File (document,health,history,prescription,record)' ),
			array( 'fas fa-file-prescription' => 'File Prescription (document,drugs,medical,medicine,rx)' ),
			array( 'fas fa-first-aid' => 'First Aid (emergency,emt,health,medical,rescue)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heartbeat' => 'Heartbeat (ekg,electrocardiogram,health,lifeline,vital signs)' ),
			array( 'fas fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'far fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'fas fa-hospital-alt' => 'Alternate Hospital (building,emergency room,medical center)' ),
			array( 'fas fa-hospital-symbol' => 'Hospital Symbol (clinic,emergency,map)' ),
			array( 'fas fa-id-card-alt' => 'Alternate Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-joint' => 'Joint (blunt,cannabis,doobie,drugs,marijuana,roach,smoke,smoking,spliff)' ),
			array( 'fas fa-laptop-medical' => 'Laptop Medical (computer,device,ehr,electronic health records,history)' ),
			array( 'fas fa-microscope' => 'Microscope (electron,lens,optics,science,shrink)' ),
			array( 'fas fa-mortar-pestle' => 'Mortar Pestle (crush,culinary,grind,medical,mix,pharmacy,prescription,spices)' ),
			array( 'fas fa-notes-medical' => 'Medical Notes (clipboard,doctor,ehr,health,history,records)' ),
			array( 'fas fa-pager' => 'Pager (beeper,cellphone,communication)' ),
			array( 'fas fa-pills' => 'Pills (drugs,medicine,prescription,tablets)' ),
			array( 'fas fa-plus' => 'plus (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-poop' => 'Poop (crap,poop,shit,smile,turd)' ),
			array( 'fas fa-prescription' => 'Prescription (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-prescription-bottle' => 'Prescription Bottle (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-prescription-bottle-alt' => 'Alternate Prescription Bottle (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-procedures' => 'Procedures (EKG,bed,electrocardiogram,health,hospital,life,patient,vital)' ),
			array( 'fas fa-radiation' => 'Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-radiation-alt' => 'Alternate Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-smoking' => 'Smoking (cancer,cigarette,nicotine,smoking status,tobacco)' ),
			array( 'fas fa-smoking-ban' => 'Smoking Ban (ban,cancel,no smoking,non-smoking)' ),
			array( 'fas fa-star-of-life' => 'Star of Life (doctor,emt,first aid,health,medical)' ),
			array( 'fas fa-stethoscope' => 'Stethoscope (diagnosis,doctor,general practitioner,hospital,infirmary,medicine,office,outpatient)' ),
			array( 'fas fa-syringe' => 'Syringe (doctor,immunizations,medical,needle)' ),
			array( 'fas fa-tablets' => 'Tablets (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-teeth' => 'Teeth (bite,dental,dentist,gums,mouth,smile,tooth)' ),
			array( 'fas fa-teeth-open' => 'Teeth Open (dental,dentist,gums bite,mouth,smile,tooth)' ),
			array( 'fas fa-thermometer' => 'Thermometer (mercury,status,temperature)' ),
			array( 'fas fa-tooth' => 'Tooth (bicuspid,dental,dentist,molar,mouth,teeth)' ),
			array( 'fas fa-user-md' => 'Doctor (job,medical,nurse,occupation,physician,profile,surgeon)' ),
			array( 'fas fa-user-nurse' => 'Nurse (doctor,midwife,practitioner,surgeon)' ),
			array( 'fas fa-vial' => 'Vial (experiment,lab,sample,science,test,test tube)' ),
			array( 'fas fa-vials' => 'Vials (experiment,lab,sample,science,test,test tube)' ),
			array( 'fas fa-weight' => 'Weight (health,measurement,scale,weight)' ),
			array( 'fas fa-x-ray' => 'X-Ray (health,medical,radiological images,radiology,skeleton)' ),
		),
		'Moving' => array(
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-box-open' => 'Box Open (archive,container,package,storage,unpack)' ),
			array( 'fas fa-couch' => 'Couch (chair,cushion,furniture,relax,sofa)' ),
			array( 'fas fa-dolly' => 'Dolly (carry,shipping,transport)' ),
			array( 'fas fa-people-carry' => 'People Carry (box,carry,fragile,help,movers,package)' ),
			array( 'fas fa-route' => 'Route (directions,navigation,travel)' ),
			array( 'fas fa-sign' => 'Sign (directions,real estate,signage,wayfinding)' ),
			array( 'fas fa-suitcase' => 'Suitcase (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-tape' => 'Tape (design,package,sticky)' ),
			array( 'fas fa-truck-loading' => 'Truck Loading (box,cargo,delivery,inventory,moving,rental,vehicle)' ),
			array( 'fas fa-truck-moving' => 'Truck Moving (cargo,inventory,rental,vehicle)' ),
			array( 'fas fa-wine-glass' => 'Wine Glass (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
		),
		'Music' => array(
			array( 'fas fa-drum' => 'Drum (instrument,music,percussion,snare,sound)' ),
			array( 'fas fa-drum-steelpan' => 'Drum Steelpan (calypso,instrument,music,percussion,reggae,snare,sound,steel,tropical)' ),
			array( 'fas fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'far fa-file-audio' => 'Audio File (document,mp3,music,page,play,sound)' ),
			array( 'fas fa-guitar' => 'Guitar (acoustic,instrument,music,rock,rock and roll,song,strings)' ),
			array( 'fas fa-headphones' => 'headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-headphones-alt' => 'Alternate Headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt-slash' => 'Alternate Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-music' => 'Music (lyrics,melody,note,sing,sound)' ),
			array( 'fab fa-napster' => 'Napster' ),
			array( 'fas fa-play' => 'play (audio,music,playing,sound,start,video)' ),
			array( 'fas fa-record-vinyl' => 'Record Vinyl (LP,album,analog,music,phonograph,sound)' ),
			array( 'fas fa-sliders-h' => 'Horizontal Sliders (adjust,settings,sliders,toggle)' ),
			array( 'fab fa-soundcloud' => 'SoundCloud' ),
			array( 'fab fa-spotify' => 'Spotify' ),
			array( 'fas fa-volume-down' => 'Volume Down (audio,lower,music,quieter,sound,speaker)' ),
			array( 'fas fa-volume-mute' => 'Volume Mute (audio,music,quiet,sound,speaker)' ),
			array( 'fas fa-volume-off' => 'Volume Off (audio,ban,music,mute,quiet,silent,sound)' ),
			array( 'fas fa-volume-up' => 'Volume Up (audio,higher,louder,music,sound,speaker)' ),
		),
		'Objects' => array(
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-anchor' => 'Anchor (berth,boat,dock,embed,link,maritime,moor,secure)' ),
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-award' => 'Award (honor,praise,prize,recognition,ribbon,trophy)' ),
			array( 'fas fa-baby-carriage' => 'Baby Carriage (buggy,carrier,infant,push,stroller,transportation,walk,wheels)' ),
			array( 'fas fa-balance-scale' => 'Balance Scale (balanced,justice,legal,measure,weight)' ),
			array( 'fas fa-balance-scale-left' => 'Balance Scale (Left-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-balance-scale-right' => 'Balance Scale (Right-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-bath' => 'Bath (clean,shower,tub,wash)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-beer' => 'beer (alcohol,ale,bar,beverage,brewery,drink,lager,liquor,mug,stein)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bicycle' => 'Bicycle (bike,gears,pedal,transportation,vehicle)' ),
			array( 'fas fa-binoculars' => 'Binoculars (glasses,magnify,scenic,spyglass,view)' ),
			array( 'fas fa-birthday-cake' => 'Birthday Cake (anniversary,bakery,candles,celebration,dessert,frosting,holiday,party,pastry)' ),
			array( 'fas fa-blender' => 'Blender (cocktail,milkshake,mixer,puree,smoothie)' ),
			array( 'fas fa-bomb' => 'Bomb (error,explode,fuse,grenade,warning)' ),
			array( 'fas fa-book' => 'book (diary,documentation,journal,library,read)' ),
			array( 'fas fa-book-dead' => 'Book of the Dead (Dungeons & Dragons,crossbones,d&d,dark arts,death,dnd,documentation,evil,fantasy,halloween,holiday,necronomicon,read,skull,spell)' ),
			array( 'fas fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'far fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'fas fa-briefcase' => 'Briefcase (bag,business,luggage,office,work)' ),
			array( 'fas fa-broadcast-tower' => 'Broadcast Tower (airwaves,antenna,radio,reception,waves)' ),
			array( 'fas fa-bug' => 'Bug (beetle,error,insect,report)' ),
			array( 'fas fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'far fa-building' => 'Building (apartment,business,city,company,office,work)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-bullseye' => 'Bullseye (archery,goal,objective,target)' ),
			array( 'fas fa-bus' => 'Bus (public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-calculator' => 'Calculator (abacus,addition,arithmetic,counting,math,multiplication,subtraction)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'far fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'fas fa-camera' => 'camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-camera-retro' => 'Retro Camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-candy-cane' => 'Candy Cane (candy,christmas,holiday,mint,peppermint,striped,xmas)' ),
			array( 'fas fa-car' => 'Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-carrot' => 'Carrot (bugs bunny,orange,vegan,vegetable)' ),
			array( 'fas fa-church' => 'Church (building,cathedral,chapel,community,religion)' ),
			array( 'fas fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'far fa-clipboard' => 'Clipboard (copy,notes,paste,record)' ),
			array( 'fas fa-cloud' => 'Cloud (atmosphere,fog,overcast,save,upload,weather)' ),
			array( 'fas fa-coffee' => 'Coffee (beverage,breakfast,cafe,drink,fall,morning,mug,seasonal,tea)' ),
			array( 'fas fa-cog' => 'cog (gear,mechanical,settings,sprocket,wheel)' ),
			array( 'fas fa-cogs' => 'cogs (gears,mechanical,settings,sprocket,wheel)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-cookie' => 'Cookie (baked good,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-cookie-bite' => 'Cookie Bite (baked good,bitten,chips,chocolate,eat,snack,sweet,treat)' ),
			array( 'fas fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'far fa-copy' => 'Copy (clone,duplicate,file,files-o,paper,paste)' ),
			array( 'fas fa-cube' => 'Cube (3d,block,dice,package,square,tesseract)' ),
			array( 'fas fa-cubes' => 'Cubes (3d,block,dice,package,pyramid,square,stack,tesseract)' ),
			array( 'fas fa-cut' => 'Cut (clip,scissors,snip)' ),
			array( 'fas fa-dice' => 'Dice (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-d20' => 'Dice D20 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dice-d6' => 'Dice D6 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dice-five' => 'Dice Five (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-four' => 'Dice Four (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-one' => 'Dice One (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-six' => 'Dice Six (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-three' => 'Dice Three (chance,gambling,game,roll)' ),
			array( 'fas fa-dice-two' => 'Dice Two (chance,gambling,game,roll)' ),
			array( 'fas fa-digital-tachograph' => 'Digital Tachograph (data,distance,speed,tachometer)' ),
			array( 'fas fa-door-closed' => 'Door Closed (enter,exit,locked)' ),
			array( 'fas fa-door-open' => 'Door Open (enter,exit,welcome)' ),
			array( 'fas fa-drum' => 'Drum (instrument,music,percussion,snare,sound)' ),
			array( 'fas fa-drum-steelpan' => 'Drum Steelpan (calypso,instrument,music,percussion,reggae,snare,sound,steel,tropical)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-dropper' => 'Eye Dropper (beaker,clone,color,copy,eyedropper,pipette)' ),
			array( 'fas fa-fax' => 'Fax (business,communicate,copy,facsimile,send)' ),
			array( 'fas fa-feather' => 'Feather (bird,light,plucked,quill,write)' ),
			array( 'fas fa-feather-alt' => 'Alternate Feather (bird,light,plucked,quill,write)' ),
			array( 'fas fa-fighter-jet' => 'fighter-jet (airplane,fast,fly,goose,maverick,plane,quick,top gun,transportation,travel)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-file-prescription' => 'File Prescription (document,drugs,medical,medicine,rx)' ),
			array( 'fas fa-film' => 'Film (cinema,movie,strip,video)' ),
			array( 'fas fa-fire' => 'fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-extinguisher' => 'fire-extinguisher (burn,caliente,fire fighter,flame,heat,hot,rescue)' ),
			array( 'fas fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'far fa-flag' => 'flag (country,notice,notification,notify,pole,report,symbol)' ),
			array( 'fas fa-flag-checkered' => 'flag-checkered (notice,notification,notify,pole,racing,report,symbol)' ),
			array( 'fas fa-flask' => 'Flask (beaker,experimental,labs,science)' ),
			array( 'fas fa-futbol' => 'Futbol (ball,football,mls,soccer)' ),
			array( 'far fa-futbol' => 'Futbol (ball,football,mls,soccer)' ),
			array( 'fas fa-gamepad' => 'Gamepad (arcade,controller,d-pad,joystick,video,video game)' ),
			array( 'fas fa-gavel' => 'Gavel (hammer,judge,law,lawyer,opinion)' ),
			array( 'fas fa-gem' => 'Gem (diamond,jewelry,sapphire,stone,treasure)' ),
			array( 'far fa-gem' => 'Gem (diamond,jewelry,sapphire,stone,treasure)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-gifts' => 'Gifts (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-glass-cheers' => 'Glass Cheers (alcohol,bar,beverage,celebration,champagne,clink,drink,holiday,new year\'s eve,party,toast)' ),
			array( 'fas fa-glass-martini' => 'Martini Glass (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-glass-whiskey' => 'Glass Whiskey (alcohol,bar,beverage,bourbon,drink,liquor,neat,rye,scotch,whisky)' ),
			array( 'fas fa-glasses' => 'Glasses (hipster,nerd,reading,sight,spectacles,vision)' ),
			array( 'fas fa-globe' => 'Globe (all,coordinates,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-graduation-cap' => 'Graduation Cap (ceremony,college,graduate,learning,school,student)' ),
			array( 'fas fa-guitar' => 'Guitar (acoustic,instrument,music,rock,rock and roll,song,strings)' ),
			array( 'fas fa-hat-wizard' => 'Wizard\'s Hat (Dungeons & Dragons,accessory,buckle,clothing,d&d,dnd,fantasy,halloween,head,holiday,mage,magic,pointy,witch)' ),
			array( 'fas fa-hdd' => 'HDD (cpu,hard drive,harddrive,machine,save,storage)' ),
			array( 'far fa-hdd' => 'HDD (cpu,hard drive,harddrive,machine,save,storage)' ),
			array( 'fas fa-headphones' => 'headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-headphones-alt' => 'Alternate Headphones (audio,listen,music,sound,speaker)' ),
			array( 'fas fa-headset' => 'Headset (audio,gamer,gaming,listen,live chat,microphone,shot caller,sound,support,telemarketer)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heart-broken' => 'Heart Broken (breakup,crushed,dislike,dumped,grief,love,lovesick,relationship,sad)' ),
			array( 'fas fa-helicopter' => 'Helicopter (airwolf,apache,chopper,flight,fly,travel)' ),
			array( 'fas fa-highlighter' => 'Highlighter (edit,marker,sharpie,update,write)' ),
			array( 'fas fa-holly-berry' => 'Holly Berry (catwoman,christmas,decoration,flora,halle,holiday,ororo munroe,plant,storm,xmas)' ),
			array( 'fas fa-home' => 'home (abode,building,house,main)' ),
			array( 'fas fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'far fa-hospital' => 'hospital (building,emergency room,medical center)' ),
			array( 'fas fa-hourglass' => 'Hourglass (hour,minute,sand,stopwatch,time)' ),
			array( 'far fa-hourglass' => 'Hourglass (hour,minute,sand,stopwatch,time)' ),
			array( 'fas fa-igloo' => 'Igloo (dome,dwelling,eskimo,home,house,ice,snow)' ),
			array( 'fas fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'far fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'fas fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'far fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'fas fa-industry' => 'Industry (building,factory,industrial,manufacturing,mill,warehouse)' ),
			array( 'fas fa-key' => 'key (lock,password,private,secret,unlock)' ),
			array( 'fas fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'far fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'fas fa-laptop' => 'Laptop (computer,cpu,dell,demo,device,mac,macbook,machine,pc)' ),
			array( 'fas fa-leaf' => 'leaf (eco,flora,nature,plant,vegan)' ),
			array( 'fas fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'far fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'fas fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'far fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'fas fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'far fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'fas fa-lock' => 'lock (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-lock-open' => 'Lock Open (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-magic' => 'magic (autocomplete,automatic,mage,magic,spell,wand,witch,wizard)' ),
			array( 'fas fa-magnet' => 'magnet (Attract,lodestone,tool)' ),
			array( 'fas fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'far fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker' => 'map-marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker-alt' => 'Alternate Map Marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-pin' => 'Map Pin (address,agree,coordinates,destination,gps,localize,location,map,marker,navigation,pin,place,position,travel)' ),
			array( 'fas fa-map-signs' => 'Map Signs (directions,directory,map,signage,wayfinding)' ),
			array( 'fas fa-marker' => 'Marker (design,edit,sharpie,update,write)' ),
			array( 'fas fa-medal' => 'Medal (award,ribbon,star,trophy)' ),
			array( 'fas fa-medkit' => 'medkit (first aid,firstaid,health,help,support)' ),
			array( 'fas fa-memory' => 'Memory (DIMM,RAM,hardware,storage,technology)' ),
			array( 'fas fa-microchip' => 'Microchip (cpu,hardware,processor,technology)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-mitten' => 'Mitten (clothing,cold,glove,hands,knitted,seasonal,warmth)' ),
			array( 'fas fa-mobile' => 'Mobile Phone (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-mobile-alt' => 'Alternate Mobile (apple,call,cell phone,cellphone,device,iphone,number,screen,telephone)' ),
			array( 'fas fa-money-bill' => 'Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'far fa-money-bill-alt' => 'Alternate Money Bill (buy,cash,checkout,money,payment,price,purchase)' ),
			array( 'fas fa-money-check' => 'Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-money-check-alt' => 'Alternate Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'far fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'fas fa-motorcycle' => 'Motorcycle (bike,machine,transportation,vehicle)' ),
			array( 'fas fa-mug-hot' => 'Mug Hot (caliente,cocoa,coffee,cup,drink,holiday,hot chocolate,steam,tea,warmth)' ),
			array( 'fas fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'far fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'fas fa-paint-brush' => 'Paint Brush (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'far fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'fas fa-paperclip' => 'Paperclip (attach,attachment,connect,link)' ),
			array( 'fas fa-paste' => 'Paste (clipboard,copy,document,paper)' ),
			array( 'fas fa-paw' => 'Paw (animal,cat,dog,pet,print)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-fancy' => 'Pen Fancy (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pen-nib' => 'Pen Nib (design,edit,fountain pen,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-plane' => 'plane (airplane,destination,fly,location,mode,travel,trip)' ),
			array( 'fas fa-plug' => 'Plug (connect,electric,online,power)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-puzzle-piece' => 'Puzzle Piece (add-on,addon,game,section)' ),
			array( 'fas fa-ring' => 'Ring (Dungeons & Dragons,Gollum,band,binding,d&d,dnd,engagement,fantasy,gold,jewelry,marriage,precious)' ),
			array( 'fas fa-road' => 'road (highway,map,pavement,route,street,travel)' ),
			array( 'fas fa-rocket' => 'rocket (aircraft,app,jet,launch,nasa,space)' ),
			array( 'fas fa-ruler-combined' => 'Ruler Combined (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-horizontal' => 'Ruler Horizontal (design,draft,length,measure,planning)' ),
			array( 'fas fa-ruler-vertical' => 'Ruler Vertical (design,draft,length,measure,planning)' ),
			array( 'fas fa-satellite' => 'Satellite (communications,hardware,orbit,space)' ),
			array( 'fas fa-satellite-dish' => 'Satellite Dish (SETI,communications,hardware,receiver,saucer,signal)' ),
			array( 'fas fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'far fa-save' => 'Save (disk,download,floppy,floppy-o)' ),
			array( 'fas fa-school' => 'School (building,education,learn,student,teacher)' ),
			array( 'fas fa-screwdriver' => 'Screwdriver (admin,fix,mechanic,repair,settings,tool)' ),
			array( 'fas fa-scroll' => 'Scroll (Dungeons & Dragons,announcement,d&d,dnd,fantasy,paper,script)' ),
			array( 'fas fa-sd-card' => 'Sd Card (image,memory,photo,save)' ),
			array( 'fas fa-search' => 'Search (bigger,enlarge,find,magnify,preview,zoom)' ),
			array( 'fas fa-shield-alt' => 'Alternate Shield (achievement,award,block,defend,security,winner)' ),
			array( 'fas fa-shopping-bag' => 'Shopping Bag (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-basket' => 'Shopping Basket (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shower' => 'Shower (bath,clean,faucet,water)' ),
			array( 'fas fa-sim-card' => 'SIM Card (hard drive,hardware,portable,storage,technology,tiny)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fas fa-sleigh' => 'Sleigh (christmas,claus,fly,holiday,santa,sled,snow,xmas)' ),
			array( 'fas fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'far fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'fas fa-snowplow' => 'Snowplow (clean up,cold,road,storm,winter)' ),
			array( 'fas fa-space-shuttle' => 'Space Shuttle (astronaut,machine,nasa,rocket,transportation)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fas fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'far fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'fas fa-stopwatch' => 'Stopwatch (clock,reminder,time)' ),
			array( 'fas fa-stroopwafel' => 'Stroopwafel (caramel,cookie,dessert,sweets,waffle)' ),
			array( 'fas fa-subway' => 'Subway (machine,railway,train,transportation,vehicle)' ),
			array( 'fas fa-suitcase' => 'Suitcase (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'far fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'fas fa-tablet' => 'tablet (apple,device,ipad,kindle,screen)' ),
			array( 'fas fa-tablet-alt' => 'Alternate Tablet (apple,device,ipad,kindle,screen)' ),
			array( 'fas fa-tachometer-alt' => 'Alternate Tachometer (dashboard,fast,odometer,speed,speedometer)' ),
			array( 'fas fa-tag' => 'tag (discount,label,price,shopping)' ),
			array( 'fas fa-tags' => 'tags (discount,label,price,shopping)' ),
			array( 'fas fa-taxi' => 'Taxi (cab,cabbie,car,car service,lyft,machine,transportation,travel,uber,vehicle)' ),
			array( 'fas fa-thumbtack' => 'Thumbtack (coordinates,location,marker,pin,thumb-tack)' ),
			array( 'fas fa-ticket-alt' => 'Alternate Ticket (movie,pass,support,ticket)' ),
			array( 'fas fa-toilet' => 'Toilet (bathroom,flush,john,loo,pee,plumbing,poop,porcelain,potty,restroom,throne,washroom,waste,wc)' ),
			array( 'fas fa-toolbox' => 'Toolbox (admin,container,fix,repair,settings,tools)' ),
			array( 'fas fa-tools' => 'Tools (admin,fix,repair,screwdriver,settings,tools,wrench)' ),
			array( 'fas fa-train' => 'Train (bullet,commute,locomotive,railway,subway)' ),
			array( 'fas fa-tram' => 'Tram (crossing,machine,mountains,seasonal,transportation)' ),
			array( 'fas fa-trash' => 'Trash (delete,garbage,hide,remove)' ),
			array( 'fas fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'far fa-trash-alt' => 'Alternate Trash (delete,garbage,hide,remove,trash-o)' ),
			array( 'fas fa-tree' => 'Tree (bark,fall,flora,forest,nature,plant,seasonal)' ),
			array( 'fas fa-trophy' => 'trophy (achievement,award,cup,game,winner)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
			array( 'fas fa-umbrella' => 'Umbrella (protection,rain,storm,wet)' ),
			array( 'fas fa-university' => 'University (bank,building,college,higher education - students,institution)' ),
			array( 'fas fa-unlock' => 'unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-unlock-alt' => 'Alternate Unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-utensil-spoon' => 'Utensil Spoon (cutlery,dining,scoop,silverware,spoon)' ),
			array( 'fas fa-utensils' => 'Utensils (cutlery,dining,dinner,eat,food,fork,knife,restaurant)' ),
			array( 'fas fa-wallet' => 'Wallet (billfold,cash,currency,money)' ),
			array( 'fas fa-weight' => 'Weight (health,measurement,scale,weight)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
			array( 'fas fa-wine-glass' => 'Wine Glass (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
			array( 'fas fa-wrench' => 'Wrench (construction,fix,mechanic,plumbing,settings,spanner,tool,update)' ),
		),
		'Payments & Shopping' => array(
			array( 'fab fa-alipay' => 'Alipay' ),
			array( 'fab fa-amazon-pay' => 'Amazon Pay' ),
			array( 'fab fa-apple-pay' => 'Apple Pay' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fab fa-bitcoin' => 'Bitcoin' ),
			array( 'fas fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'far fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'fab fa-btc' => 'BTC' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-camera' => 'camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-camera-retro' => 'Retro Camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-cart-arrow-down' => 'Shopping Cart Arrow Down (download,save,shopping)' ),
			array( 'fas fa-cart-plus' => 'Add to Shopping Cart (add,create,new,positive,shopping)' ),
			array( 'fab fa-cc-amazon-pay' => 'Amazon Pay Credit Card' ),
			array( 'fab fa-cc-amex' => 'American Express Credit Card (amex)' ),
			array( 'fab fa-cc-apple-pay' => 'Apple Pay Credit Card' ),
			array( 'fab fa-cc-diners-club' => 'Diner\'s Club Credit Card' ),
			array( 'fab fa-cc-discover' => 'Discover Credit Card' ),
			array( 'fab fa-cc-jcb' => 'JCB Credit Card' ),
			array( 'fab fa-cc-mastercard' => 'MasterCard Credit Card' ),
			array( 'fab fa-cc-paypal' => 'Paypal Credit Card' ),
			array( 'fab fa-cc-stripe' => 'Stripe Credit Card' ),
			array( 'fab fa-cc-visa' => 'Visa Credit Card' ),
			array( 'fas fa-certificate' => 'certificate (badge,star,verified)' ),
			array( 'fas fa-credit-card' => 'Credit Card (buy,checkout,credit-card-alt,debit,money,payment,purchase)' ),
			array( 'far fa-credit-card' => 'Credit Card (buy,checkout,credit-card-alt,debit,money,payment,purchase)' ),
			array( 'fab fa-ethereum' => 'Ethereum' ),
			array( 'fas fa-gem' => 'Gem (diamond,jewelry,sapphire,stone,treasure)' ),
			array( 'far fa-gem' => 'Gem (diamond,jewelry,sapphire,stone,treasure)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fab fa-google-wallet' => 'Google Wallet' ),
			array( 'fas fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'far fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-key' => 'key (lock,password,private,secret,unlock)' ),
			array( 'fas fa-money-check' => 'Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fas fa-money-check-alt' => 'Alternate Money Check (bank check,buy,checkout,cheque,money,payment,price,purchase)' ),
			array( 'fab fa-paypal' => 'Paypal' ),
			array( 'fas fa-receipt' => 'Receipt (check,invoice,money,pay,table)' ),
			array( 'fas fa-shopping-bag' => 'Shopping Bag (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-basket' => 'Shopping Basket (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fab fa-stripe' => 'Stripe' ),
			array( 'fab fa-stripe-s' => 'Stripe S' ),
			array( 'fas fa-tag' => 'tag (discount,label,price,shopping)' ),
			array( 'fas fa-tags' => 'tags (discount,label,price,shopping)' ),
			array( 'fas fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'far fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'fas fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'far fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'fas fa-trophy' => 'trophy (achievement,award,cup,game,winner)' ),
		),
		'Pharmacy' => array(
			array( 'fas fa-band-aid' => 'Band-Aid (bandage,boo boo,first aid,ouch)' ),
			array( 'fas fa-book-medical' => 'Medical Book (diary,documentation,health,history,journal,library,read,record)' ),
			array( 'fas fa-cannabis' => 'Cannabis (bud,chronic,drugs,endica,endo,ganja,marijuana,mary jane,pot,reefer,sativa,spliff,weed,whacky-tabacky)' ),
			array( 'fas fa-capsules' => 'Capsules (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-clinic-medical' => 'Medical Clinic (doctor,general practitioner,hospital,infirmary,medicine,office,outpatient)' ),
			array( 'fas fa-eye-dropper' => 'Eye Dropper (beaker,clone,color,copy,eyedropper,pipette)' ),
			array( 'fas fa-file-medical' => 'Medical File (document,health,history,prescription,record)' ),
			array( 'fas fa-file-prescription' => 'File Prescription (document,drugs,medical,medicine,rx)' ),
			array( 'fas fa-first-aid' => 'First Aid (emergency,emt,health,medical,rescue)' ),
			array( 'fas fa-flask' => 'Flask (beaker,experimental,labs,science)' ),
			array( 'fas fa-history' => 'History (Rewind,clock,reverse,time,time machine)' ),
			array( 'fas fa-joint' => 'Joint (blunt,cannabis,doobie,drugs,marijuana,roach,smoke,smoking,spliff)' ),
			array( 'fas fa-laptop-medical' => 'Laptop Medical (computer,device,ehr,electronic health records,history)' ),
			array( 'fas fa-mortar-pestle' => 'Mortar Pestle (crush,culinary,grind,medical,mix,pharmacy,prescription,spices)' ),
			array( 'fas fa-notes-medical' => 'Medical Notes (clipboard,doctor,ehr,health,history,records)' ),
			array( 'fas fa-pills' => 'Pills (drugs,medicine,prescription,tablets)' ),
			array( 'fas fa-prescription' => 'Prescription (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-prescription-bottle' => 'Prescription Bottle (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-prescription-bottle-alt' => 'Alternate Prescription Bottle (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-receipt' => 'Receipt (check,invoice,money,pay,table)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fas fa-syringe' => 'Syringe (doctor,immunizations,medical,needle)' ),
			array( 'fas fa-tablets' => 'Tablets (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-thermometer' => 'Thermometer (mercury,status,temperature)' ),
			array( 'fas fa-vial' => 'Vial (experiment,lab,sample,science,test,test tube)' ),
			array( 'fas fa-vials' => 'Vials (experiment,lab,sample,science,test,test tube)' ),
		),
		'Political' => array(
			array( 'fas fa-award' => 'Award (honor,praise,prize,recognition,ribbon,trophy)' ),
			array( 'fas fa-balance-scale' => 'Balance Scale (balanced,justice,legal,measure,weight)' ),
			array( 'fas fa-balance-scale-left' => 'Balance Scale (Left-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-balance-scale-right' => 'Balance Scale (Right-Weighted) (justice,legal,measure,unbalanced,weight)' ),
			array( 'fas fa-bullhorn' => 'bullhorn (announcement,broadcast,louder,megaphone,share)' ),
			array( 'fas fa-check-double' => 'Double Check (accept,agree,checkmark,confirm,correct,done,notice,notification,notify,ok,select,success,tick,todo)' ),
			array( 'fas fa-democrat' => 'Democrat (american,democratic party,donkey,election,left,left-wing,liberal,politics,usa)' ),
			array( 'fas fa-donate' => 'Donate (contribute,generosity,gift,give)' ),
			array( 'fas fa-dove' => 'Dove (bird,fauna,flying,peace,war)' ),
			array( 'fas fa-fist-raised' => 'Raised Fist (Dungeons & Dragons,d&d,dnd,fantasy,hand,ki,monk,resist,strength,unarmed combat)' ),
			array( 'fas fa-flag-usa' => 'United States of America Flag (betsy ross,country,old glory,stars,stripes,symbol)' ),
			array( 'fas fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'far fa-handshake' => 'Handshake (agreement,greeting,meeting,partnership)' ),
			array( 'fas fa-person-booth' => 'Person Entering Booth (changing,changing room,election,human,person,vote,voting)' ),
			array( 'fas fa-piggy-bank' => 'Piggy Bank (bank,save,savings)' ),
			array( 'fas fa-republican' => 'Republican (american,conservative,election,elephant,politics,republican party,right,right-wing,usa)' ),
			array( 'fas fa-vote-yea' => 'Vote Yea (accept,cast,election,politics,positive,yes)' ),
		),
		'Religion' => array(
			array( 'fas fa-ankh' => 'Ankh (amulet,copper,coptic christianity,copts,crux ansata,egypt,venus)' ),
			array( 'fas fa-atom' => 'Atom (atheism,chemistry,ion,nuclear,science)' ),
			array( 'fas fa-bible' => 'Bible (book,catholicism,christianity,god,holy)' ),
			array( 'fas fa-church' => 'Church (building,cathedral,chapel,community,religion)' ),
			array( 'fas fa-cross' => 'Cross (catholicism,christianity,church,jesus)' ),
			array( 'fas fa-dharmachakra' => 'Dharmachakra (buddhism,buddhist,wheel of dharma)' ),
			array( 'fas fa-dove' => 'Dove (bird,fauna,flying,peace,war)' ),
			array( 'fas fa-gopuram' => 'Gopuram (building,entrance,hinduism,temple,tower)' ),
			array( 'fas fa-hamsa' => 'Hamsa (amulet,christianity,islam,jewish,judaism,muslim,protection)' ),
			array( 'fas fa-hanukiah' => 'Hanukiah (candle,hanukkah,jewish,judaism,light)' ),
			array( 'fas fa-haykal' => 'Haykal (bahai,bahá\'í,star)' ),
			array( 'fas fa-jedi' => 'Jedi (crest,force,sith,skywalker,star wars,yoda)' ),
			array( 'fas fa-journal-whills' => 'Journal of the Whills (book,force,jedi,sith,star wars,yoda)' ),
			array( 'fas fa-kaaba' => 'Kaaba (building,cube,islam,muslim)' ),
			array( 'fas fa-khanda' => 'Khanda (chakkar,sikh,sikhism,sword)' ),
			array( 'fas fa-menorah' => 'Menorah (candle,hanukkah,jewish,judaism,light)' ),
			array( 'fas fa-mosque' => 'Mosque (building,islam,landmark,muslim)' ),
			array( 'fas fa-om' => 'Om (buddhism,hinduism,jainism,mantra)' ),
			array( 'fas fa-pastafarianism' => 'Pastafarianism (agnosticism,atheism,flying spaghetti monster,fsm)' ),
			array( 'fas fa-peace' => 'Peace (serenity,tranquility,truce,war)' ),
			array( 'fas fa-place-of-worship' => 'Place of Worship (building,church,holy,mosque,synagogue)' ),
			array( 'fas fa-pray' => 'Pray (kneel,preach,religion,worship)' ),
			array( 'fas fa-praying-hands' => 'Praying Hands (kneel,preach,religion,worship)' ),
			array( 'fas fa-quran' => 'Quran (book,islam,muslim,religion)' ),
			array( 'fas fa-star-and-crescent' => 'Star and Crescent (islam,muslim,religion)' ),
			array( 'fas fa-star-of-david' => 'Star of David (jewish,judaism,religion)' ),
			array( 'fas fa-synagogue' => 'Synagogue (building,jewish,judaism,religion,star of david,temple)' ),
			array( 'fas fa-torah' => 'Torah (book,jewish,judaism,religion,scroll)' ),
			array( 'fas fa-torii-gate' => 'Torii Gate (building,shintoism)' ),
			array( 'fas fa-vihara' => 'Vihara (buddhism,buddhist,building,monastery)' ),
			array( 'fas fa-yin-yang' => 'Yin Yang (daoism,opposites,taoism)' ),
		),
		'Science' => array(
			array( 'fas fa-atom' => 'Atom (atheism,chemistry,ion,nuclear,science)' ),
			array( 'fas fa-biohazard' => 'Biohazard (danger,dangerous,hazmat,medical,radioactive,toxic,waste,zombie)' ),
			array( 'fas fa-brain' => 'Brain (cerebellum,gray matter,intellect,medulla oblongata,mind,noodle,wit)' ),
			array( 'fas fa-burn' => 'Burn (caliente,energy,fire,flame,gas,heat,hot)' ),
			array( 'fas fa-capsules' => 'Capsules (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-clipboard-check' => 'Clipboard with Check (accept,agree,confirm,done,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-dna' => 'DNA (double helix,genetic,helix,molecule,protein)' ),
			array( 'fas fa-eye-dropper' => 'Eye Dropper (beaker,clone,color,copy,eyedropper,pipette)' ),
			array( 'fas fa-filter' => 'Filter (funnel,options,separate,sort)' ),
			array( 'fas fa-fire' => 'fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-fire-alt' => 'Alternate Fire (burn,caliente,flame,heat,hot,popular)' ),
			array( 'fas fa-flask' => 'Flask (beaker,experimental,labs,science)' ),
			array( 'fas fa-frog' => 'Frog (amphibian,bullfrog,fauna,hop,kermit,kiss,prince,ribbit,toad,wart)' ),
			array( 'fas fa-magnet' => 'magnet (Attract,lodestone,tool)' ),
			array( 'fas fa-microscope' => 'Microscope (electron,lens,optics,science,shrink)' ),
			array( 'fas fa-mortar-pestle' => 'Mortar Pestle (crush,culinary,grind,medical,mix,pharmacy,prescription,spices)' ),
			array( 'fas fa-pills' => 'Pills (drugs,medicine,prescription,tablets)' ),
			array( 'fas fa-prescription-bottle' => 'Prescription Bottle (drugs,medical,medicine,pharmacy,rx)' ),
			array( 'fas fa-radiation' => 'Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-radiation-alt' => 'Alternate Radiation (danger,dangerous,deadly,hazard,nuclear,radioactive,warning)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fas fa-syringe' => 'Syringe (doctor,immunizations,medical,needle)' ),
			array( 'fas fa-tablets' => 'Tablets (drugs,medicine,pills,prescription)' ),
			array( 'fas fa-temperature-high' => 'High Temperature (cook,mercury,summer,thermometer,warm)' ),
			array( 'fas fa-temperature-low' => 'Low Temperature (cold,cool,mercury,thermometer,winter)' ),
			array( 'fas fa-vial' => 'Vial (experiment,lab,sample,science,test,test tube)' ),
			array( 'fas fa-vials' => 'Vials (experiment,lab,sample,science,test,test tube)' ),
		),
		'Science Fiction' => array(
			array( 'fab fa-galactic-republic' => 'Galactic Republic (politics,star wars)' ),
			array( 'fab fa-galactic-senate' => 'Galactic Senate (star wars)' ),
			array( 'fas fa-globe' => 'Globe (all,coordinates,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-jedi' => 'Jedi (crest,force,sith,skywalker,star wars,yoda)' ),
			array( 'fab fa-jedi-order' => 'Jedi Order (star wars)' ),
			array( 'fas fa-journal-whills' => 'Journal of the Whills (book,force,jedi,sith,star wars,yoda)' ),
			array( 'fas fa-meteor' => 'Meteor (armageddon,asteroid,comet,shooting star,space)' ),
			array( 'fas fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'far fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'fab fa-old-republic' => 'Old Republic (politics,star wars)' ),
			array( 'fas fa-robot' => 'Robot (android,automate,computer,cyborg)' ),
			array( 'fas fa-rocket' => 'rocket (aircraft,app,jet,launch,nasa,space)' ),
			array( 'fas fa-satellite' => 'Satellite (communications,hardware,orbit,space)' ),
			array( 'fas fa-satellite-dish' => 'Satellite Dish (SETI,communications,hardware,receiver,saucer,signal)' ),
			array( 'fas fa-space-shuttle' => 'Space Shuttle (astronaut,machine,nasa,rocket,transportation)' ),
			array( 'fas fa-user-astronaut' => 'User Astronaut (avatar,clothing,cosmonaut,nasa,space,suit)' ),
		),
		'Security' => array(
			array( 'fas fa-ban' => 'ban (abort,ban,block,cancel,delete,hide,prohibit,remove,stop,trash)' ),
			array( 'fas fa-bug' => 'Bug (beetle,error,insect,report)' ),
			array( 'fas fa-door-closed' => 'Door Closed (enter,exit,locked)' ),
			array( 'fas fa-door-open' => 'Door Open (enter,exit,welcome)' ),
			array( 'fas fa-dungeon' => 'Dungeon (Dungeons & Dragons,building,d&d,dnd,door,entrance,fantasy,gate)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-file-contract' => 'File Contract (agreement,binding,document,legal,signature)' ),
			array( 'fas fa-file-signature' => 'File Signature (John Hancock,contract,document,name)' ),
			array( 'fas fa-fingerprint' => 'Fingerprint (human,id,identification,lock,smudge,touch,unique,unlock)' ),
			array( 'fas fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'far fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'fas fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'far fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-id-card-alt' => 'Alternate Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-key' => 'key (lock,password,private,secret,unlock)' ),
			array( 'fas fa-lock' => 'lock (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-lock-open' => 'Lock Open (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-mask' => 'Mask (carnivale,costume,disguise,halloween,secret,super hero)' ),
			array( 'fas fa-passport' => 'Passport (document,id,identification,issued,travel)' ),
			array( 'fas fa-shield-alt' => 'Alternate Shield (achievement,award,block,defend,security,winner)' ),
			array( 'fas fa-unlock' => 'unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-unlock-alt' => 'Alternate Unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-user-lock' => 'User Lock (admin,lock,person,private,unlock)' ),
			array( 'fas fa-user-secret' => 'User Secret (clothing,coat,hat,incognito,person,privacy,spy,whisper)' ),
			array( 'fas fa-user-shield' => 'User Shield (admin,person,private,protect,safe)' ),
		),
		'Shapes' => array(
			array( 'fas fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'far fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-certificate' => 'certificate (badge,star,verified)' ),
			array( 'fas fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'far fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'fas fa-cloud' => 'Cloud (atmosphere,fog,overcast,save,upload,weather)' ),
			array( 'fas fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-heart-broken' => 'Heart Broken (breakup,crushed,dislike,dumped,grief,love,lovesick,relationship,sad)' ),
			array( 'fas fa-map-marker' => 'map-marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-play' => 'play (audio,music,playing,sound,start,video)' ),
			array( 'fas fa-shapes' => 'Shapes (blocks,build,circle,square,triangle)' ),
			array( 'fas fa-square' => 'Square (block,box,shape)' ),
			array( 'far fa-square' => 'Square (block,box,shape)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
		),
		'Shopping' => array(
			array( 'fas fa-barcode' => 'barcode (info,laser,price,scan,upc)' ),
			array( 'fas fa-cart-arrow-down' => 'Shopping Cart Arrow Down (download,save,shopping)' ),
			array( 'fas fa-cart-plus' => 'Add to Shopping Cart (add,create,new,positive,shopping)' ),
			array( 'fas fa-cash-register' => 'Cash Register (buy,cha-ching,change,checkout,commerce,leaerboard,machine,pay,payment,purchase,store)' ),
			array( 'fas fa-gift' => 'gift (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-gifts' => 'Gifts (christmas,generosity,giving,holiday,party,present,wrapped,xmas)' ),
			array( 'fas fa-person-booth' => 'Person Entering Booth (changing,changing room,election,human,person,vote,voting)' ),
			array( 'fas fa-receipt' => 'Receipt (check,invoice,money,pay,table)' ),
			array( 'fas fa-shipping-fast' => 'Shipping Fast (express,fedex,mail,overnight,package,ups)' ),
			array( 'fas fa-shopping-bag' => 'Shopping Bag (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-basket' => 'Shopping Basket (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-store' => 'Store (building,buy,purchase,shopping)' ),
			array( 'fas fa-store-alt' => 'Alternate Store (building,buy,purchase,shopping)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-tshirt' => 'T-Shirt (clothing,fashion,garment,shirt)' ),
		),
		'Social' => array(
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-birthday-cake' => 'Birthday Cake (anniversary,bakery,candles,celebration,dessert,frosting,holiday,party,pastry)' ),
			array( 'fas fa-camera' => 'camera (image,lens,photo,picture,record,shutter,video)' ),
			array( 'fas fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-hashtag' => 'Hashtag (Twitter,instagram,pound,social media,tag)' ),
			array( 'fas fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'far fa-heart' => 'Heart (favorite,like,love,relationship,valentine)' ),
			array( 'fas fa-icons' => 'Icons (bolt,emoji,heart,image,music,photo,symbols)' ),
			array( 'fas fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'far fa-image' => 'Image (album,landscape,photo,picture)' ),
			array( 'fas fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'far fa-images' => 'Images (album,landscape,photo,picture)' ),
			array( 'fas fa-map-marker' => 'map-marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker-alt' => 'Alternate Map Marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-photo-video' => 'Photo Video (av,film,image,library,media)' ),
			array( 'fas fa-poll' => 'Poll (results,survey,trend,vote,voting)' ),
			array( 'fas fa-poll-h' => 'Poll H (results,survey,trend,vote,voting)' ),
			array( 'fas fa-retweet' => 'Retweet (refresh,reload,share,swap)' ),
			array( 'fas fa-share' => 'Share (forward,save,send,social)' ),
			array( 'fas fa-share-alt' => 'Alternate Share (forward,save,send,social)' ),
			array( 'fas fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'far fa-share-square' => 'Share Square (forward,save,send,social)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fas fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'far fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'fas fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'far fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'fas fa-thumbtack' => 'Thumbtack (coordinates,location,marker,pin,thumb-tack)' ),
			array( 'fas fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-friends' => 'User Friends (group,people,person,team,users)' ),
			array( 'fas fa-user-plus' => 'User Plus (add,avatar,positive,sign up,signup,team)' ),
			array( 'fas fa-users' => 'Users (friends,group,people,persons,profiles,team)' ),
			array( 'fas fa-video' => 'Video (camera,film,movie,record,video-camera)' ),
		),
		'Spinners' => array(
			array( 'fas fa-asterisk' => 'asterisk (annotation,details,reference,star)' ),
			array( 'fas fa-atom' => 'Atom (atheism,chemistry,ion,nuclear,science)' ),
			array( 'fas fa-certificate' => 'certificate (badge,star,verified)' ),
			array( 'fas fa-circle-notch' => 'Circle Notched (circle-o-notch,diameter,dot,ellipse,round,spinner)' ),
			array( 'fas fa-cog' => 'cog (gear,mechanical,settings,sprocket,wheel)' ),
			array( 'fas fa-compact-disc' => 'Compact Disc (album,bluray,cd,disc,dvd,media,movie,music,record,video,vinyl)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-crosshairs' => 'Crosshairs (aim,bullseye,gpd,picker,position)' ),
			array( 'fas fa-dharmachakra' => 'Dharmachakra (buddhism,buddhist,wheel of dharma)' ),
			array( 'fas fa-fan' => 'Fan (ac,air conditioning,blade,blower,cool,hot)' ),
			array( 'fas fa-haykal' => 'Haykal (bahai,bahá\'í,star)' ),
			array( 'fas fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'far fa-life-ring' => 'Life Ring (coast guard,help,overboard,save,support)' ),
			array( 'fas fa-palette' => 'Palette (acrylic,art,brush,color,fill,paint,pigment,watercolor)' ),
			array( 'fas fa-ring' => 'Ring (Dungeons & Dragons,Gollum,band,binding,d&d,dnd,engagement,fantasy,gold,jewelry,marriage,precious)' ),
			array( 'fas fa-slash' => 'Slash (cancel,close,mute,off,stop,x)' ),
			array( 'fas fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'far fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'fas fa-spinner' => 'Spinner (circle,loading,progress)' ),
			array( 'fas fa-stroopwafel' => 'Stroopwafel (caramel,cookie,dessert,sweets,waffle)' ),
			array( 'fas fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'far fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'fas fa-sync' => 'Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-sync-alt' => 'Alternate Sync (exchange,refresh,reload,rotate,swap)' ),
			array( 'fas fa-yin-yang' => 'Yin Yang (daoism,opposites,taoism)' ),
		),
		'Sports' => array(
			array( 'fas fa-baseball-ball' => 'Baseball Ball (foul,hardball,league,leather,mlb,softball,sport)' ),
			array( 'fas fa-basketball-ball' => 'Basketball Ball (dribble,dunk,hoop,nba)' ),
			array( 'fas fa-biking' => 'Biking (bicycle,bike,cycle,cycling,ride,wheel)' ),
			array( 'fas fa-bowling-ball' => 'Bowling Ball (alley,candlepin,gutter,lane,strike,tenpin)' ),
			array( 'fas fa-dumbbell' => 'Dumbbell (exercise,gym,strength,weight,weight-lifting)' ),
			array( 'fas fa-football-ball' => 'Football Ball (ball,fall,nfl,pigskin,seasonal)' ),
			array( 'fas fa-futbol' => 'Futbol (ball,football,mls,soccer)' ),
			array( 'far fa-futbol' => 'Futbol (ball,football,mls,soccer)' ),
			array( 'fas fa-golf-ball' => 'Golf Ball (caddy,eagle,putt,tee)' ),
			array( 'fas fa-hockey-puck' => 'Hockey Puck (ice,nhl,sport)' ),
			array( 'fas fa-quidditch' => 'Quidditch (ball,bludger,broom,golden snitch,harry potter,hogwarts,quaffle,sport,wizard)' ),
			array( 'fas fa-running' => 'Running (exercise,health,jog,person,run,sport,sprint)' ),
			array( 'fas fa-skating' => 'Skating (activity,figure skating,fitness,ice,person,winter)' ),
			array( 'fas fa-skiing' => 'Skiing (activity,downhill,fast,fitness,olympics,outdoors,person,seasonal,slalom)' ),
			array( 'fas fa-skiing-nordic' => 'Skiing Nordic (activity,cross country,fitness,outdoors,person,seasonal)' ),
			array( 'fas fa-snowboarding' => 'Snowboarding (activity,fitness,olympics,outdoors,person)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-table-tennis' => 'Table Tennis (ball,paddle,ping pong)' ),
			array( 'fas fa-volleyball-ball' => 'Volleyball Ball (beach,olympics,sport)' ),
		),
		'Spring' => array(
			array( 'fas fa-allergies' => 'Allergies (allergy,freckles,hand,hives,pox,skin,spots)' ),
			array( 'fas fa-broom' => 'Broom (clean,firebolt,fly,halloween,nimbus 2000,quidditch,sweep,witch)' ),
			array( 'fas fa-cloud-sun' => 'Cloud with Sun (clear,day,daytime,fall,outdoors,overcast,partly cloudy)' ),
			array( 'fas fa-cloud-sun-rain' => 'Cloud with Sun and Rain (day,overcast,precipitation,storm,summer,sunshower)' ),
			array( 'fas fa-frog' => 'Frog (amphibian,bullfrog,fauna,hop,kermit,kiss,prince,ribbit,toad,wart)' ),
			array( 'fas fa-rainbow' => 'Rainbow (gold,leprechaun,prism,rain,sky)' ),
			array( 'fas fa-seedling' => 'Seedling (flora,grow,plant,vegan)' ),
			array( 'fas fa-umbrella' => 'Umbrella (protection,rain,storm,wet)' ),
		),
		'Status' => array(
			array( 'fas fa-ban' => 'ban (abort,ban,block,cancel,delete,hide,prohibit,remove,stop,trash)' ),
			array( 'fas fa-battery-empty' => 'Battery Empty (charge,dead,power,status)' ),
			array( 'fas fa-battery-full' => 'Battery Full (charge,power,status)' ),
			array( 'fas fa-battery-half' => 'Battery 1/2 Full (charge,power,status)' ),
			array( 'fas fa-battery-quarter' => 'Battery 1/4 Full (charge,low,power,status)' ),
			array( 'fas fa-battery-three-quarters' => 'Battery 3/4 Full (charge,power,status)' ),
			array( 'fas fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'far fa-bell' => 'bell (alarm,alert,chime,notification,reminder)' ),
			array( 'fas fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'far fa-bell-slash' => 'Bell Slash (alert,cancel,disabled,notification,off,reminder)' ),
			array( 'fas fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'far fa-calendar' => 'Calendar (calendar-o,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'far fa-calendar-alt' => 'Alternate Calendar (calendar,date,event,schedule,time,when)' ),
			array( 'fas fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'far fa-calendar-check' => 'Calendar Check (accept,agree,appointment,confirm,correct,date,done,event,ok,schedule,select,success,tick,time,todo,when)' ),
			array( 'fas fa-calendar-day' => 'Calendar with Day Focus (date,detail,event,focus,schedule,single day,time,today,when)' ),
			array( 'fas fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'far fa-calendar-minus' => 'Calendar Minus (calendar,date,delete,event,negative,remove,schedule,time,when)' ),
			array( 'fas fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'far fa-calendar-plus' => 'Calendar Plus (add,calendar,create,date,event,new,positive,schedule,time,when)' ),
			array( 'fas fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'far fa-calendar-times' => 'Calendar Times (archive,calendar,date,delete,event,remove,schedule,time,when,x)' ),
			array( 'fas fa-calendar-week' => 'Calendar with Week Focus (date,detail,event,focus,schedule,single week,time,today,when)' ),
			array( 'fas fa-cart-arrow-down' => 'Shopping Cart Arrow Down (download,save,shopping)' ),
			array( 'fas fa-cart-plus' => 'Add to Shopping Cart (add,create,new,positive,shopping)' ),
			array( 'fas fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment' => 'comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'far fa-comment-alt' => 'Alternate Comment (bubble,chat,commenting,conversation,feedback,message,note,notification,sms,speech,texting)' ),
			array( 'fas fa-comment-slash' => 'Comment Slash (bubble,cancel,chat,commenting,conversation,feedback,message,mute,note,notification,quiet,sms,speech,texting)' ),
			array( 'fas fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'far fa-compass' => 'Compass (directions,directory,location,menu,navigation,safari,travel)' ),
			array( 'fas fa-door-closed' => 'Door Closed (enter,exit,locked)' ),
			array( 'fas fa-door-open' => 'Door Open (enter,exit,welcome)' ),
			array( 'fas fa-exclamation' => 'exclamation (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-circle' => 'Exclamation Circle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-exclamation-triangle' => 'Exclamation Triangle (alert,danger,error,important,notice,notification,notify,problem,warning)' ),
			array( 'fas fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'far fa-eye' => 'Eye (look,optic,see,seen,show,sight,views,visible)' ),
			array( 'fas fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'far fa-eye-slash' => 'Eye Slash (blind,hide,show,toggle,unseen,views,visible,visiblity)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-gas-pump' => 'Gas Pump (car,fuel,gasoline,petrol)' ),
			array( 'fas fa-info' => 'Info (details,help,information,more,support)' ),
			array( 'fas fa-info-circle' => 'Info Circle (details,help,information,more,support)' ),
			array( 'fas fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'far fa-lightbulb' => 'Lightbulb (energy,idea,inspiration,light)' ),
			array( 'fas fa-lock' => 'lock (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-lock-open' => 'Lock Open (admin,lock,open,password,private,protect,security)' ),
			array( 'fas fa-map-marker' => 'map-marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marker-alt' => 'Alternate Map Marker (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt' => 'Alternate Microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-alt-slash' => 'Alternate Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-minus' => 'minus (collapse,delete,hide,minify,negative,remove,trash)' ),
			array( 'fas fa-minus-circle' => 'Minus Circle (delete,hide,negative,remove,shape,trash)' ),
			array( 'fas fa-minus-square' => 'Minus Square (collapse,delete,hide,minify,negative,remove,shape,trash)' ),
			array( 'far fa-minus-square' => 'Minus Square (collapse,delete,hide,minify,negative,remove,shape,trash)' ),
			array( 'fas fa-parking' => 'Parking (auto,car,garage,meter)' ),
			array( 'fas fa-phone' => 'Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-alt' => 'Alternate Phone (call,earphone,number,support,telephone,voice)' ),
			array( 'fas fa-phone-slash' => 'Phone Slash (call,cancel,earphone,mute,number,support,telephone,voice)' ),
			array( 'fas fa-plus' => 'plus (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-plus-circle' => 'Plus Circle (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'far fa-plus-square' => 'Plus Square (add,create,expand,new,positive,shape)' ),
			array( 'fas fa-print' => 'print (business,copy,document,office,paper)' ),
			array( 'fas fa-question' => 'Question (help,information,support,unknown)' ),
			array( 'fas fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'far fa-question-circle' => 'Question Circle (help,information,support,unknown)' ),
			array( 'fas fa-shield-alt' => 'Alternate Shield (achievement,award,block,defend,security,winner)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-sign-in-alt' => 'Alternate Sign In (arrow,enter,join,log in,login,sign in,sign up,sign-in,signin,signup)' ),
			array( 'fas fa-sign-out-alt' => 'Alternate Sign Out (arrow,exit,leave,log out,logout,sign-out)' ),
			array( 'fas fa-signal' => 'signal (bars,graph,online,reception,status)' ),
			array( 'fas fa-smoking-ban' => 'Smoking Ban (ban,cancel,no smoking,non-smoking)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fas fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'far fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'fas fa-star-half-alt' => 'Alternate Star Half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'fas fa-stream' => 'Stream (flow,list,timeline)' ),
			array( 'fas fa-thermometer-empty' => 'Thermometer Empty (cold,mercury,status,temperature)' ),
			array( 'fas fa-thermometer-full' => 'Thermometer Full (fever,hot,mercury,status,temperature)' ),
			array( 'fas fa-thermometer-half' => 'Thermometer 1/2 Full (mercury,status,temperature)' ),
			array( 'fas fa-thermometer-quarter' => 'Thermometer 1/4 Full (mercury,status,temperature)' ),
			array( 'fas fa-thermometer-three-quarters' => 'Thermometer 3/4 Full (mercury,status,temperature)' ),
			array( 'fas fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'far fa-thumbs-down' => 'thumbs-down (disagree,disapprove,dislike,hand,social,thumbs-o-down)' ),
			array( 'fas fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'far fa-thumbs-up' => 'thumbs-up (agree,approve,favorite,hand,like,ok,okay,social,success,thumbs-o-up,yes,you got it dude)' ),
			array( 'fas fa-tint' => 'tint (color,drop,droplet,raindrop,waterdrop)' ),
			array( 'fas fa-tint-slash' => 'Tint Slash (color,drop,droplet,raindrop,waterdrop)' ),
			array( 'fas fa-toggle-off' => 'Toggle Off (switch)' ),
			array( 'fas fa-toggle-on' => 'Toggle On (switch)' ),
			array( 'fas fa-unlock' => 'unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-unlock-alt' => 'Alternate Unlock (admin,lock,password,private,protect)' ),
			array( 'fas fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-alt' => 'Alternate User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-alt-slash' => 'Alternate User Slash (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-slash' => 'User Slash (ban,delete,remove)' ),
			array( 'fas fa-video' => 'Video (camera,film,movie,record,video-camera)' ),
			array( 'fas fa-video-slash' => 'Video Slash (add,create,film,new,positive,record,video)' ),
			array( 'fas fa-volume-down' => 'Volume Down (audio,lower,music,quieter,sound,speaker)' ),
			array( 'fas fa-volume-mute' => 'Volume Mute (audio,music,quiet,sound,speaker)' ),
			array( 'fas fa-volume-off' => 'Volume Off (audio,ban,music,mute,quiet,silent,sound)' ),
			array( 'fas fa-volume-up' => 'Volume Up (audio,higher,louder,music,sound,speaker)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
		),
		'Summer' => array(
			array( 'fas fa-anchor' => 'Anchor (berth,boat,dock,embed,link,maritime,moor,secure)' ),
			array( 'fas fa-biking' => 'Biking (bicycle,bike,cycle,cycling,ride,wheel)' ),
			array( 'fas fa-fish' => 'Fish (fauna,gold,seafood,swimming)' ),
			array( 'fas fa-hotdog' => 'Hot Dog (bun,chili,frankfurt,frankfurter,kosher,polish,sandwich,sausage,vienna,weiner)' ),
			array( 'fas fa-ice-cream' => 'Ice Cream (chocolate,cone,dessert,frozen,scoop,sorbet,vanilla,yogurt)' ),
			array( 'fas fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'far fa-lemon' => 'Lemon (citrus,lemonade,lime,tart)' ),
			array( 'fas fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'far fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-swimming-pool' => 'Swimming Pool (ladder,recreation,swim,water)' ),
			array( 'fas fa-umbrella-beach' => 'Umbrella Beach (protection,recreation,sand,shade,summer,sun)' ),
			array( 'fas fa-volleyball-ball' => 'Volleyball Ball (beach,olympics,sport)' ),
			array( 'fas fa-water' => 'Water (lake,liquid,ocean,sea,swim,wet)' ),
		),
		'Tabletop Gaming' => array(
			array( 'fab fa-acquisitions-incorporated' => 'Acquisitions Incorporated (Dungeons & Dragons,d&d,dnd,fantasy,game,gaming,tabletop)' ),
			array( 'fas fa-book-dead' => 'Book of the Dead (Dungeons & Dragons,crossbones,d&d,dark arts,death,dnd,documentation,evil,fantasy,halloween,holiday,necronomicon,read,skull,spell)' ),
			array( 'fab fa-critical-role' => 'Critical Role (Dungeons & Dragons,d&d,dnd,fantasy,game,gaming,tabletop)' ),
			array( 'fab fa-d-and-d' => 'Dungeons & Dragons' ),
			array( 'fab fa-d-and-d-beyond' => 'D&D Beyond (Dungeons & Dragons,d&d,dnd,fantasy,gaming,tabletop)' ),
			array( 'fas fa-dice-d20' => 'Dice D20 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dice-d6' => 'Dice D6 (Dungeons & Dragons,chance,d&d,dnd,fantasy,gambling,game,roll)' ),
			array( 'fas fa-dragon' => 'Dragon (Dungeons & Dragons,d&d,dnd,fantasy,fire,lizard,serpent)' ),
			array( 'fas fa-dungeon' => 'Dungeon (Dungeons & Dragons,building,d&d,dnd,door,entrance,fantasy,gate)' ),
			array( 'fab fa-fantasy-flight-games' => 'Fantasy Flight-games (Dungeons & Dragons,d&d,dnd,fantasy,game,gaming,tabletop)' ),
			array( 'fas fa-fist-raised' => 'Raised Fist (Dungeons & Dragons,d&d,dnd,fantasy,hand,ki,monk,resist,strength,unarmed combat)' ),
			array( 'fas fa-hat-wizard' => 'Wizard\'s Hat (Dungeons & Dragons,accessory,buckle,clothing,d&d,dnd,fantasy,halloween,head,holiday,mage,magic,pointy,witch)' ),
			array( 'fab fa-penny-arcade' => 'Penny Arcade (Dungeons & Dragons,d&d,dnd,fantasy,game,gaming,pax,tabletop)' ),
			array( 'fas fa-ring' => 'Ring (Dungeons & Dragons,Gollum,band,binding,d&d,dnd,engagement,fantasy,gold,jewelry,marriage,precious)' ),
			array( 'fas fa-scroll' => 'Scroll (Dungeons & Dragons,announcement,d&d,dnd,fantasy,paper,script)' ),
			array( 'fas fa-skull-crossbones' => 'Skull & Crossbones (Dungeons & Dragons,alert,bones,d&d,danger,dead,deadly,death,dnd,fantasy,halloween,holiday,jolly-roger,pirate,poison,skeleton,warning)' ),
			array( 'fab fa-wizards-of-the-coast' => 'Wizards of the Coast (Dungeons & Dragons,d&d,dnd,fantasy,game,gaming,tabletop)' ),
		),
		'Toggle' => array(
			array( 'fas fa-bullseye' => 'Bullseye (archery,goal,objective,target)' ),
			array( 'fas fa-check-circle' => 'Check Circle (accept,agree,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'far fa-check-circle' => 'Check Circle (accept,agree,confirm,correct,done,ok,select,success,tick,todo,yes)' ),
			array( 'fas fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'far fa-circle' => 'Circle (circle-thin,diameter,dot,ellipse,notification,round)' ),
			array( 'fas fa-dot-circle' => 'Dot Circle (bullseye,notification,target)' ),
			array( 'far fa-dot-circle' => 'Dot Circle (bullseye,notification,target)' ),
			array( 'fas fa-microphone' => 'microphone (audio,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-microphone-slash' => 'Microphone Slash (audio,disable,mute,podcast,record,sing,sound,voice)' ),
			array( 'fas fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'far fa-star' => 'Star (achievement,award,favorite,important,night,rating,score)' ),
			array( 'fas fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'far fa-star-half' => 'star-half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'fas fa-star-half-alt' => 'Alternate Star Half (achievement,award,rating,score,star-half-empty,star-half-full)' ),
			array( 'fas fa-toggle-off' => 'Toggle Off (switch)' ),
			array( 'fas fa-toggle-on' => 'Toggle On (switch)' ),
			array( 'fas fa-wifi' => 'WiFi (connection,hotspot,internet,network,wireless)' ),
		),
		'Travel' => array(
			array( 'fas fa-archway' => 'Archway (arc,monument,road,street,tunnel)' ),
			array( 'fas fa-atlas' => 'Atlas (book,directions,geography,globe,map,travel,wayfinding)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-bus' => 'Bus (public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-bus-alt' => 'Bus Alt (mta,public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-cocktail' => 'Cocktail (alcohol,beverage,drink,gin,glass,margarita,martini,vodka)' ),
			array( 'fas fa-concierge-bell' => 'Concierge Bell (attention,hotel,receptionist,service,support)' ),
			array( 'fas fa-dumbbell' => 'Dumbbell (exercise,gym,strength,weight,weight-lifting)' ),
			array( 'fas fa-glass-martini' => 'Martini Glass (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-glass-martini-alt' => 'Alternate Glass Martini (alcohol,bar,beverage,drink,liquor)' ),
			array( 'fas fa-globe-africa' => 'Globe with Africa shown (all,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-globe-americas' => 'Globe with Americas shown (all,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-globe-asia' => 'Globe with Asia shown (all,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-globe-europe' => 'Globe with Europe shown (all,country,earth,global,gps,language,localize,location,map,online,place,planet,translate,travel,world)' ),
			array( 'fas fa-hot-tub' => 'Hot Tub (bath,jacuzzi,massage,sauna,spa)' ),
			array( 'fas fa-hotel' => 'Hotel (building,inn,lodging,motel,resort,travel)' ),
			array( 'fas fa-luggage-cart' => 'Luggage Cart (bag,baggage,suitcase,travel)' ),
			array( 'fas fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'far fa-map' => 'Map (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marked' => 'Map Marked (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-map-marked-alt' => 'Alternate Map Marked (address,coordinates,destination,gps,localize,location,map,navigation,paper,pin,place,point of interest,position,route,travel)' ),
			array( 'fas fa-monument' => 'Monument (building,historic,landmark,memorable)' ),
			array( 'fas fa-passport' => 'Passport (document,id,identification,issued,travel)' ),
			array( 'fas fa-plane' => 'plane (airplane,destination,fly,location,mode,travel,trip)' ),
			array( 'fas fa-plane-arrival' => 'Plane Arrival (airplane,arriving,destination,fly,land,landing,location,mode,travel,trip)' ),
			array( 'fas fa-plane-departure' => 'Plane Departure (airplane,departing,destination,fly,location,mode,take off,taking off,travel,trip)' ),
			array( 'fas fa-shuttle-van' => 'Shuttle Van (airport,machine,public-transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-spa' => 'Spa (flora,massage,mindfulness,plant,wellness)' ),
			array( 'fas fa-suitcase' => 'Suitcase (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-suitcase-rolling' => 'Suitcase Rolling (baggage,luggage,move,suitcase,travel,trip)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-swimming-pool' => 'Swimming Pool (ladder,recreation,swim,water)' ),
			array( 'fas fa-taxi' => 'Taxi (cab,cabbie,car,car service,lyft,machine,transportation,travel,uber,vehicle)' ),
			array( 'fas fa-tram' => 'Tram (crossing,machine,mountains,seasonal,transportation)' ),
			array( 'fas fa-tv' => 'Television (computer,display,monitor,television)' ),
			array( 'fas fa-umbrella-beach' => 'Umbrella Beach (protection,recreation,sand,shade,summer,sun)' ),
			array( 'fas fa-wine-glass' => 'Wine Glass (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
			array( 'fas fa-wine-glass-alt' => 'Alternate Wine Glas (alcohol,beverage,cabernet,drink,grapes,merlot,sauvignon)' ),
		),
		'Users & People' => array(
			array( 'fab fa-accessible-icon' => 'Accessible Icon (accessibility,handicap,person,wheelchair,wheelchair-alt)' ),
			array( 'fas fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'far fa-address-book' => 'Address Book (contact,directory,index,little black book,rolodex)' ),
			array( 'fas fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'far fa-address-card' => 'Address Card (about,contact,id,identification,postcard,profile)' ),
			array( 'fas fa-baby' => 'Baby (child,diaper,doll,human,infant,kid,offspring,person,sprout)' ),
			array( 'fas fa-bed' => 'Bed (lodging,rest,sleep,travel)' ),
			array( 'fas fa-biking' => 'Biking (bicycle,bike,cycle,cycling,ride,wheel)' ),
			array( 'fas fa-blind' => 'Blind (cane,disability,person,sight)' ),
			array( 'fas fa-chalkboard-teacher' => 'Chalkboard Teacher (blackboard,instructor,learning,professor,school,whiteboard,writing)' ),
			array( 'fas fa-child' => 'Child (boy,girl,kid,toddler,young)' ),
			array( 'fas fa-female' => 'Female (human,person,profile,user,woman)' ),
			array( 'fas fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'far fa-frown' => 'Frowning Face (disapprove,emoticon,face,rating,sad)' ),
			array( 'fas fa-hiking' => 'Hiking (activity,backpack,fall,fitness,outdoors,person,seasonal,walking)' ),
			array( 'fas fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'far fa-id-badge' => 'Identification Badge (address,contact,identification,license,profile)' ),
			array( 'fas fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'far fa-id-card' => 'Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-id-card-alt' => 'Alternate Identification Card (contact,demographics,document,identification,issued,profile)' ),
			array( 'fas fa-male' => 'Male (human,man,person,profile,user)' ),
			array( 'fas fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'far fa-meh' => 'Neutral Face (emoticon,face,neutral,rating)' ),
			array( 'fas fa-people-carry' => 'People Carry (box,carry,fragile,help,movers,package)' ),
			array( 'fas fa-person-booth' => 'Person Entering Booth (changing,changing room,election,human,person,vote,voting)' ),
			array( 'fas fa-poo' => 'Poo (crap,poop,shit,smile,turd)' ),
			array( 'fas fa-portrait' => 'Portrait (id,image,photo,picture,selfie)' ),
			array( 'fas fa-power-off' => 'Power Off (cancel,computer,on,reboot,restart)' ),
			array( 'fas fa-pray' => 'Pray (kneel,preach,religion,worship)' ),
			array( 'fas fa-restroom' => 'Restroom (bathroom,john,loo,potty,washroom,waste,wc)' ),
			array( 'fas fa-running' => 'Running (exercise,health,jog,person,run,sport,sprint)' ),
			array( 'fas fa-skating' => 'Skating (activity,figure skating,fitness,ice,person,winter)' ),
			array( 'fas fa-skiing' => 'Skiing (activity,downhill,fast,fitness,olympics,outdoors,person,seasonal,slalom)' ),
			array( 'fas fa-skiing-nordic' => 'Skiing Nordic (activity,cross country,fitness,outdoors,person,seasonal)' ),
			array( 'fas fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'far fa-smile' => 'Smiling Face (approve,emoticon,face,happy,rating,satisfied)' ),
			array( 'fas fa-snowboarding' => 'Snowboarding (activity,fitness,olympics,outdoors,person)' ),
			array( 'fas fa-street-view' => 'Street View (directions,location,map,navigation)' ),
			array( 'fas fa-swimmer' => 'Swimmer (athlete,head,man,olympics,person,pool,water)' ),
			array( 'fas fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user' => 'User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-alt' => 'Alternate User (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-alt-slash' => 'Alternate User Slash (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-astronaut' => 'User Astronaut (avatar,clothing,cosmonaut,nasa,space,suit)' ),
			array( 'fas fa-user-check' => 'User Check (accept,check,person,verified)' ),
			array( 'fas fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'far fa-user-circle' => 'User Circle (account,avatar,head,human,man,person,profile)' ),
			array( 'fas fa-user-clock' => 'User Clock (alert,person,remind,time)' ),
			array( 'fas fa-user-cog' => 'User Cog (admin,cog,person,settings)' ),
			array( 'fas fa-user-edit' => 'User Edit (edit,pen,pencil,person,update,write)' ),
			array( 'fas fa-user-friends' => 'User Friends (group,people,person,team,users)' ),
			array( 'fas fa-user-graduate' => 'User Graduate (cap,clothing,commencement,gown,graduation,person,student)' ),
			array( 'fas fa-user-injured' => 'User Injured (cast,injury,ouch,patient,person,sling)' ),
			array( 'fas fa-user-lock' => 'User Lock (admin,lock,person,private,unlock)' ),
			array( 'fas fa-user-md' => 'Doctor (job,medical,nurse,occupation,physician,profile,surgeon)' ),
			array( 'fas fa-user-minus' => 'User Minus (delete,negative,remove)' ),
			array( 'fas fa-user-ninja' => 'User Ninja (assassin,avatar,dangerous,deadly,sneaky)' ),
			array( 'fas fa-user-nurse' => 'Nurse (doctor,midwife,practitioner,surgeon)' ),
			array( 'fas fa-user-plus' => 'User Plus (add,avatar,positive,sign up,signup,team)' ),
			array( 'fas fa-user-secret' => 'User Secret (clothing,coat,hat,incognito,person,privacy,spy,whisper)' ),
			array( 'fas fa-user-shield' => 'User Shield (admin,person,private,protect,safe)' ),
			array( 'fas fa-user-slash' => 'User Slash (ban,delete,remove)' ),
			array( 'fas fa-user-tag' => 'User Tag (avatar,discount,label,person,role,special)' ),
			array( 'fas fa-user-tie' => 'User Tie (avatar,business,clothing,formal,professional,suit)' ),
			array( 'fas fa-user-times' => 'Remove User (archive,delete,remove,x)' ),
			array( 'fas fa-users' => 'Users (friends,group,people,persons,profiles,team)' ),
			array( 'fas fa-users-cog' => 'Users Cog (admin,cog,group,person,settings,team)' ),
			array( 'fas fa-walking' => 'Walking (exercise,health,pedometer,person,steps)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
		),
		'Vehicles' => array(
			array( 'fab fa-accessible-icon' => 'Accessible Icon (accessibility,handicap,person,wheelchair,wheelchair-alt)' ),
			array( 'fas fa-ambulance' => 'ambulance (emergency,emt,er,help,hospital,support,vehicle)' ),
			array( 'fas fa-baby-carriage' => 'Baby Carriage (buggy,carrier,infant,push,stroller,transportation,walk,wheels)' ),
			array( 'fas fa-bicycle' => 'Bicycle (bike,gears,pedal,transportation,vehicle)' ),
			array( 'fas fa-bus' => 'Bus (public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-bus-alt' => 'Bus Alt (mta,public transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-car' => 'Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-car-alt' => 'Alternate Car (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-car-crash' => 'Car Crash (accident,auto,automobile,insurance,sedan,transportation,vehicle,wreck)' ),
			array( 'fas fa-car-side' => 'Car Side (auto,automobile,sedan,transportation,travel,vehicle)' ),
			array( 'fas fa-fighter-jet' => 'fighter-jet (airplane,fast,fly,goose,maverick,plane,quick,top gun,transportation,travel)' ),
			array( 'fas fa-helicopter' => 'Helicopter (airwolf,apache,chopper,flight,fly,travel)' ),
			array( 'fas fa-horse' => 'Horse (equus,fauna,mammmal,mare,neigh,pony)' ),
			array( 'fas fa-motorcycle' => 'Motorcycle (bike,machine,transportation,vehicle)' ),
			array( 'fas fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'far fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'fas fa-plane' => 'plane (airplane,destination,fly,location,mode,travel,trip)' ),
			array( 'fas fa-rocket' => 'rocket (aircraft,app,jet,launch,nasa,space)' ),
			array( 'fas fa-ship' => 'Ship (boat,sea,water)' ),
			array( 'fas fa-shopping-cart' => 'shopping-cart (buy,checkout,grocery,payment,purchase)' ),
			array( 'fas fa-shuttle-van' => 'Shuttle Van (airport,machine,public-transportation,transportation,travel,vehicle)' ),
			array( 'fas fa-sleigh' => 'Sleigh (christmas,claus,fly,holiday,santa,sled,snow,xmas)' ),
			array( 'fas fa-snowplow' => 'Snowplow (clean up,cold,road,storm,winter)' ),
			array( 'fas fa-space-shuttle' => 'Space Shuttle (astronaut,machine,nasa,rocket,transportation)' ),
			array( 'fas fa-subway' => 'Subway (machine,railway,train,transportation,vehicle)' ),
			array( 'fas fa-taxi' => 'Taxi (cab,cabbie,car,car service,lyft,machine,transportation,travel,uber,vehicle)' ),
			array( 'fas fa-tractor' => 'Tractor (agriculture,farm,vehicle)' ),
			array( 'fas fa-train' => 'Train (bullet,commute,locomotive,railway,subway)' ),
			array( 'fas fa-tram' => 'Tram (crossing,machine,mountains,seasonal,transportation)' ),
			array( 'fas fa-truck' => 'truck (cargo,delivery,shipping,vehicle)' ),
			array( 'fas fa-truck-monster' => 'Truck Monster (offroad,vehicle,wheel)' ),
			array( 'fas fa-truck-pickup' => 'Truck Side (cargo,vehicle)' ),
			array( 'fas fa-wheelchair' => 'Wheelchair (accessible,handicap,person)' ),
		),
		'Weather' => array(
			array( 'fas fa-bolt' => 'Lightning Bolt (electricity,lightning,weather,zap)' ),
			array( 'fas fa-cloud' => 'Cloud (atmosphere,fog,overcast,save,upload,weather)' ),
			array( 'fas fa-cloud-meatball' => 'Cloud with (a chance of) Meatball (FLDSMDFR,food,spaghetti,storm)' ),
			array( 'fas fa-cloud-moon' => 'Cloud with Moon (crescent,evening,lunar,night,partly cloudy,sky)' ),
			array( 'fas fa-cloud-moon-rain' => 'Cloud with Moon and Rain (crescent,evening,lunar,night,partly cloudy,precipitation,rain,sky,storm)' ),
			array( 'fas fa-cloud-rain' => 'Cloud with Rain (precipitation,rain,sky,storm)' ),
			array( 'fas fa-cloud-showers-heavy' => 'Cloud with Heavy Showers (precipitation,rain,sky,storm)' ),
			array( 'fas fa-cloud-sun' => 'Cloud with Sun (clear,day,daytime,fall,outdoors,overcast,partly cloudy)' ),
			array( 'fas fa-cloud-sun-rain' => 'Cloud with Sun and Rain (day,overcast,precipitation,storm,summer,sunshower)' ),
			array( 'fas fa-meteor' => 'Meteor (armageddon,asteroid,comet,shooting star,space)' ),
			array( 'fas fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'far fa-moon' => 'Moon (contrast,crescent,dark,lunar,night)' ),
			array( 'fas fa-poo-storm' => 'Poo Storm (bolt,cloud,euphemism,lightning,mess,poop,shit,turd)' ),
			array( 'fas fa-rainbow' => 'Rainbow (gold,leprechaun,prism,rain,sky)' ),
			array( 'fas fa-smog' => 'Smog (dragon,fog,haze,pollution,smoke,weather)' ),
			array( 'fas fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'far fa-snowflake' => 'Snowflake (precipitation,rain,winter)' ),
			array( 'fas fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'far fa-sun' => 'Sun (brighten,contrast,day,lighter,sol,solar,star,weather)' ),
			array( 'fas fa-temperature-high' => 'High Temperature (cook,mercury,summer,thermometer,warm)' ),
			array( 'fas fa-temperature-low' => 'Low Temperature (cold,cool,mercury,thermometer,winter)' ),
			array( 'fas fa-umbrella' => 'Umbrella (protection,rain,storm,wet)' ),
			array( 'fas fa-water' => 'Water (lake,liquid,ocean,sea,swim,wet)' ),
			array( 'fas fa-wind' => 'Wind (air,blow,breeze,fall,seasonal,weather)' ),
		),
		'Winter' => array(
			array( 'fas fa-glass-whiskey' => 'Glass Whiskey (alcohol,bar,beverage,bourbon,drink,liquor,neat,rye,scotch,whisky)' ),
			array( 'fas fa-icicles' => 'Icicles (cold,frozen,hanging,ice,seasonal,sharp)' ),
			array( 'fas fa-igloo' => 'Igloo (dome,dwelling,eskimo,home,house,ice,snow)' ),
			array( 'fas fa-mitten' => 'Mitten (clothing,cold,glove,hands,knitted,seasonal,warmth)' ),
			array( 'fas fa-skating' => 'Skating (activity,figure skating,fitness,ice,person,winter)' ),
			array( 'fas fa-skiing' => 'Skiing (activity,downhill,fast,fitness,olympics,outdoors,person,seasonal,slalom)' ),
			array( 'fas fa-skiing-nordic' => 'Skiing Nordic (activity,cross country,fitness,outdoors,person,seasonal)' ),
			array( 'fas fa-snowboarding' => 'Snowboarding (activity,fitness,olympics,outdoors,person)' ),
			array( 'fas fa-snowplow' => 'Snowplow (clean up,cold,road,storm,winter)' ),
			array( 'fas fa-tram' => 'Tram (crossing,machine,mountains,seasonal,transportation)' ),
		),
		'Writing' => array(
			array( 'fas fa-archive' => 'Archive (box,package,save,storage)' ),
			array( 'fas fa-blog' => 'Blog (journal,log,online,personal,post,web 2.0,wordpress,writing)' ),
			array( 'fas fa-book' => 'book (diary,documentation,journal,library,read)' ),
			array( 'fas fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'far fa-bookmark' => 'bookmark (favorite,marker,read,remember,save)' ),
			array( 'fas fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'far fa-edit' => 'Edit (edit,pen,pencil,update,write)' ),
			array( 'fas fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope' => 'Envelope (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'far fa-envelope-open' => 'Envelope Open (e-mail,email,letter,mail,message,notification,support)' ),
			array( 'fas fa-eraser' => 'eraser (art,delete,remove,rubber)' ),
			array( 'fas fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'far fa-file' => 'File (document,new,page,pdf,resume)' ),
			array( 'fas fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'far fa-file-alt' => 'Alternate File (document,file-text,invoice,new,page,pdf)' ),
			array( 'fas fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'far fa-folder' => 'Folder (archive,directory,document,file)' ),
			array( 'fas fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'far fa-folder-open' => 'Folder Open (archive,directory,document,empty,file,new)' ),
			array( 'fas fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'far fa-keyboard' => 'Keyboard (accessory,edit,input,text,type,write)' ),
			array( 'fas fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'far fa-newspaper' => 'Newspaper (article,editorial,headline,journal,journalism,news,press)' ),
			array( 'fas fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'far fa-paper-plane' => 'Paper Plane (air,float,fold,mail,paper,send)' ),
			array( 'fas fa-paperclip' => 'Paperclip (attach,attachment,connect,link)' ),
			array( 'fas fa-paragraph' => 'paragraph (edit,format,text,writing)' ),
			array( 'fas fa-pen' => 'Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-alt' => 'Alternate Pen (design,edit,update,write)' ),
			array( 'fas fa-pen-square' => 'Pen Square (edit,pencil-square,update,write)' ),
			array( 'fas fa-pencil-alt' => 'Alternate Pencil (design,edit,pencil,update,write)' ),
			array( 'fas fa-quote-left' => 'quote-left (mention,note,phrase,text,type)' ),
			array( 'fas fa-quote-right' => 'quote-right (mention,note,phrase,text,type)' ),
			array( 'fas fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'far fa-sticky-note' => 'Sticky Note (message,note,paper,reminder,sticker)' ),
			array( 'fas fa-thumbtack' => 'Thumbtack (coordinates,location,marker,pin,thumb-tack)' ),
		),
		'Other' => array(
			array( 'fas fa-backspace' => 'Backspace (command,delete,erase,keyboard,undo)' ),
			array( 'fas fa-blender-phone' => 'Blender Phone (appliance,cocktail,communication,fantasy,milkshake,mixer,puree,silly,smoothie)' ),
			array( 'fas fa-crown' => 'Crown (award,favorite,king,queen,royal,tiara)' ),
			array( 'fas fa-dumpster-fire' => 'Dumpster Fire (alley,bin,commercial,danger,dangerous,euphemism,flame,heat,hot,trash,waste)' ),
			array( 'fas fa-file-csv' => 'File CSV (document,excel,numbers,spreadsheets,table)' ),
			array( 'fas fa-network-wired' => 'Wired Network (computer,connect,ethernet,internet,intranet)' ),
			array( 'fas fa-signature' => 'Signature (John Hancock,cursive,name,writing)' ),
			array( 'fas fa-skull' => 'Skull (bones,skeleton,x-ray,yorick)' ),
			array( 'fas fa-vr-cardboard' => 'Cardboard VR (3d,augment,google,reality,virtual)' ),
			array( 'fas fa-weight-hanging' => 'Hanging Weight (anvil,heavy,measurement)' ),
		),
	);

	return array_merge( $icons, $fontawesome_icons );
}

add_filter( 'vc_iconpicker-type-openiconic', 'vc_iconpicker_type_openiconic' );

/**
 * Openicons icons from fontello.com
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_openiconic( $icons ) {
	$openiconic_icons = array(
		array( 'vc-oi vc-oi-dial' => 'Dial' ),
		array( 'vc-oi vc-oi-pilcrow' => 'Pilcrow' ),
		array( 'vc-oi vc-oi-at' => 'At' ),
		array( 'vc-oi vc-oi-hash' => 'Hash' ),
		array( 'vc-oi vc-oi-key-inv' => 'Key-inv' ),
		array( 'vc-oi vc-oi-key' => 'Key' ),
		array( 'vc-oi vc-oi-chart-pie-alt' => 'Chart-pie-alt' ),
		array( 'vc-oi vc-oi-chart-pie' => 'Chart-pie' ),
		array( 'vc-oi vc-oi-chart-bar' => 'Chart-bar' ),
		array( 'vc-oi vc-oi-umbrella' => 'Umbrella' ),
		array( 'vc-oi vc-oi-moon-inv' => 'Moon-inv' ),
		array( 'vc-oi vc-oi-mobile' => 'Mobile' ),
		array( 'vc-oi vc-oi-cd' => 'Cd' ),
		array( 'vc-oi vc-oi-split' => 'Split' ),
		array( 'vc-oi vc-oi-exchange' => 'Exchange' ),
		array( 'vc-oi vc-oi-block' => 'Block' ),
		array( 'vc-oi vc-oi-resize-full' => 'Resize-full' ),
		array( 'vc-oi vc-oi-article-alt' => 'Article-alt' ),
		array( 'vc-oi vc-oi-article' => 'Article' ),
		array( 'vc-oi vc-oi-pencil-alt' => 'Pencil-alt' ),
		array( 'vc-oi vc-oi-undo' => 'Undo' ),
		array( 'vc-oi vc-oi-attach' => 'Attach' ),
		array( 'vc-oi vc-oi-link' => 'Link' ),
		array( 'vc-oi vc-oi-search' => 'Search' ),
		array( 'vc-oi vc-oi-mail' => 'Mail' ),
		array( 'vc-oi vc-oi-heart' => 'Heart' ),
		array( 'vc-oi vc-oi-comment' => 'Comment' ),
		array( 'vc-oi vc-oi-resize-full-alt' => 'Resize-full-alt' ),
		array( 'vc-oi vc-oi-lock' => 'Lock' ),
		array( 'vc-oi vc-oi-book-open' => 'Book-open' ),
		array( 'vc-oi vc-oi-arrow-curved' => 'Arrow-curved' ),
		array( 'vc-oi vc-oi-equalizer' => 'Equalizer' ),
		array( 'vc-oi vc-oi-heart-empty' => 'Heart-empty' ),
		array( 'vc-oi vc-oi-lock-empty' => 'Lock-empty' ),
		array( 'vc-oi vc-oi-comment-inv' => 'Comment-inv' ),
		array( 'vc-oi vc-oi-folder' => 'Folder' ),
		array( 'vc-oi vc-oi-resize-small' => 'Resize-small' ),
		array( 'vc-oi vc-oi-play' => 'Play' ),
		array( 'vc-oi vc-oi-cursor' => 'Cursor' ),
		array( 'vc-oi vc-oi-aperture' => 'Aperture' ),
		array( 'vc-oi vc-oi-play-circle2' => 'Play-circle2' ),
		array( 'vc-oi vc-oi-resize-small-alt' => 'Resize-small-alt' ),
		array( 'vc-oi vc-oi-folder-empty' => 'Folder-empty' ),
		array( 'vc-oi vc-oi-comment-alt' => 'Comment-alt' ),
		array( 'vc-oi vc-oi-lock-open' => 'Lock-open' ),
		array( 'vc-oi vc-oi-star' => 'Star' ),
		array( 'vc-oi vc-oi-user' => 'User' ),
		array( 'vc-oi vc-oi-lock-open-empty' => 'Lock-open-empty' ),
		array( 'vc-oi vc-oi-box' => 'Box' ),
		array( 'vc-oi vc-oi-resize-vertical' => 'Resize-vertical' ),
		array( 'vc-oi vc-oi-stop' => 'Stop' ),
		array( 'vc-oi vc-oi-aperture-alt' => 'Aperture-alt' ),
		array( 'vc-oi vc-oi-book' => 'Book' ),
		array( 'vc-oi vc-oi-steering-wheel' => 'Steering-wheel' ),
		array( 'vc-oi vc-oi-pause' => 'Pause' ),
		array( 'vc-oi vc-oi-to-start' => 'To-start' ),
		array( 'vc-oi vc-oi-move' => 'Move' ),
		array( 'vc-oi vc-oi-resize-horizontal' => 'Resize-horizontal' ),
		array( 'vc-oi vc-oi-rss-alt' => 'Rss-alt' ),
		array( 'vc-oi vc-oi-comment-alt2' => 'Comment-alt2' ),
		array( 'vc-oi vc-oi-rss' => 'Rss' ),
		array( 'vc-oi vc-oi-comment-inv-alt' => 'Comment-inv-alt' ),
		array( 'vc-oi vc-oi-comment-inv-alt2' => 'Comment-inv-alt2' ),
		array( 'vc-oi vc-oi-eye' => 'Eye' ),
		array( 'vc-oi vc-oi-pin' => 'Pin' ),
		array( 'vc-oi vc-oi-video' => 'Video' ),
		array( 'vc-oi vc-oi-picture' => 'Picture' ),
		array( 'vc-oi vc-oi-camera' => 'Camera' ),
		array( 'vc-oi vc-oi-tag' => 'Tag' ),
		array( 'vc-oi vc-oi-chat' => 'Chat' ),
		array( 'vc-oi vc-oi-cog' => 'Cog' ),
		array( 'vc-oi vc-oi-popup' => 'Popup' ),
		array( 'vc-oi vc-oi-to-end' => 'To-end' ),
		array( 'vc-oi vc-oi-book-alt' => 'Book-alt' ),
		array( 'vc-oi vc-oi-brush' => 'Brush' ),
		array( 'vc-oi vc-oi-eject' => 'Eject' ),
		array( 'vc-oi vc-oi-down' => 'Down' ),
		array( 'vc-oi vc-oi-wrench' => 'Wrench' ),
		array( 'vc-oi vc-oi-chat-inv' => 'Chat-inv' ),
		array( 'vc-oi vc-oi-tag-empty' => 'Tag-empty' ),
		array( 'vc-oi vc-oi-ok' => 'Ok' ),
		array( 'vc-oi vc-oi-ok-circle' => 'Ok-circle' ),
		array( 'vc-oi vc-oi-download' => 'Download' ),
		array( 'vc-oi vc-oi-location' => 'Location' ),
		array( 'vc-oi vc-oi-share' => 'Share' ),
		array( 'vc-oi vc-oi-left' => 'Left' ),
		array( 'vc-oi vc-oi-target' => 'Target' ),
		array( 'vc-oi vc-oi-brush-alt' => 'Brush-alt' ),
		array( 'vc-oi vc-oi-cancel' => 'Cancel' ),
		array( 'vc-oi vc-oi-upload' => 'Upload' ),
		array( 'vc-oi vc-oi-location-inv' => 'Location-inv' ),
		array( 'vc-oi vc-oi-calendar' => 'Calendar' ),
		array( 'vc-oi vc-oi-right' => 'Right' ),
		array( 'vc-oi vc-oi-signal' => 'Signal' ),
		array( 'vc-oi vc-oi-eyedropper' => 'Eyedropper' ),
		array( 'vc-oi vc-oi-layers' => 'Layers' ),
		array( 'vc-oi vc-oi-award' => 'Award' ),
		array( 'vc-oi vc-oi-up' => 'Up' ),
		array( 'vc-oi vc-oi-calendar-inv' => 'Calendar-inv' ),
		array( 'vc-oi vc-oi-location-alt' => 'Location-alt' ),
		array( 'vc-oi vc-oi-download-cloud' => 'Download-cloud' ),
		array( 'vc-oi vc-oi-cancel-circle' => 'Cancel-circle' ),
		array( 'vc-oi vc-oi-plus' => 'Plus' ),
		array( 'vc-oi vc-oi-upload-cloud' => 'Upload-cloud' ),
		array( 'vc-oi vc-oi-compass' => 'Compass' ),
		array( 'vc-oi vc-oi-calendar-alt' => 'Calendar-alt' ),
		array( 'vc-oi vc-oi-down-circle' => 'Down-circle' ),
		array( 'vc-oi vc-oi-award-empty' => 'Award-empty' ),
		array( 'vc-oi vc-oi-layers-alt' => 'Layers-alt' ),
		array( 'vc-oi vc-oi-sun' => 'Sun' ),
		array( 'vc-oi vc-oi-list' => 'List' ),
		array( 'vc-oi vc-oi-left-circle' => 'Left-circle' ),
		array( 'vc-oi vc-oi-mic' => 'Mic' ),
		array( 'vc-oi vc-oi-trash' => 'Trash' ),
		array( 'vc-oi vc-oi-quote-left' => 'Quote-left' ),
		array( 'vc-oi vc-oi-plus-circle' => 'Plus-circle' ),
		array( 'vc-oi vc-oi-minus' => 'Minus' ),
		array( 'vc-oi vc-oi-quote-right' => 'Quote-right' ),
		array( 'vc-oi vc-oi-trash-empty' => 'Trash-empty' ),
		array( 'vc-oi vc-oi-volume-off' => 'Volume-off' ),
		array( 'vc-oi vc-oi-right-circle' => 'Right-circle' ),
		array( 'vc-oi vc-oi-list-nested' => 'List-nested' ),
		array( 'vc-oi vc-oi-sun-inv' => 'Sun-inv' ),
		array( 'vc-oi vc-oi-bat-empty' => 'Bat-empty' ),
		array( 'vc-oi vc-oi-up-circle' => 'Up-circle' ),
		array( 'vc-oi vc-oi-volume-up' => 'Volume-up' ),
		array( 'vc-oi vc-oi-doc' => 'Doc' ),
		array( 'vc-oi vc-oi-quote-left-alt' => 'Quote-left-alt' ),
		array( 'vc-oi vc-oi-minus-circle' => 'Minus-circle' ),
		array( 'vc-oi vc-oi-cloud' => 'Cloud' ),
		array( 'vc-oi vc-oi-rain' => 'Rain' ),
		array( 'vc-oi vc-oi-bat-half' => 'Bat-half' ),
		array( 'vc-oi vc-oi-cw' => 'Cw' ),
		array( 'vc-oi vc-oi-headphones' => 'Headphones' ),
		array( 'vc-oi vc-oi-doc-inv' => 'Doc-inv' ),
		array( 'vc-oi vc-oi-quote-right-alt' => 'Quote-right-alt' ),
		array( 'vc-oi vc-oi-help' => 'Help' ),
		array( 'vc-oi vc-oi-info' => 'Info' ),
		array( 'vc-oi vc-oi-pencil' => 'Pencil' ),
		array( 'vc-oi vc-oi-doc-alt' => 'Doc-alt' ),
		array( 'vc-oi vc-oi-clock' => 'Clock' ),
		array( 'vc-oi vc-oi-loop' => 'Loop' ),
		array( 'vc-oi vc-oi-bat-full' => 'Bat-full' ),
		array( 'vc-oi vc-oi-flash' => 'Flash' ),
		array( 'vc-oi vc-oi-moon' => 'Moon' ),
		array( 'vc-oi vc-oi-bat-charge' => 'Bat-charge' ),
		array( 'vc-oi vc-oi-loop-alt' => 'Loop-alt' ),
		array( 'vc-oi vc-oi-lamp' => 'Lamp' ),
		array( 'vc-oi vc-oi-doc-inv-alt' => 'Doc-inv-alt' ),
		array( 'vc-oi vc-oi-pencil-neg' => 'Pencil-neg' ),
		array( 'vc-oi vc-oi-home' => 'Home' ),
	);

	return array_merge( $icons, $openiconic_icons );
}

add_filter( 'vc_iconpicker-type-typicons', 'vc_iconpicker_type_typicons' );

/**
 * Typicons icons from github.com/stephenhutchings/typicons.font
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_typicons( $icons ) {
	$typicons_icons = array(
		array( 'typcn typcn-adjust-brightness' => 'Adjust Brightness' ),
		array( 'typcn typcn-adjust-contrast' => 'Adjust Contrast' ),
		array( 'typcn typcn-anchor-outline' => 'Anchor Outline' ),
		array( 'typcn typcn-anchor' => 'Anchor' ),
		array( 'typcn typcn-archive' => 'Archive' ),
		array( 'typcn typcn-arrow-back-outline' => 'Arrow Back Outline' ),
		array( 'typcn typcn-arrow-back' => 'Arrow Back' ),
		array( 'typcn typcn-arrow-down-outline' => 'Arrow Down Outline' ),
		array( 'typcn typcn-arrow-down-thick' => 'Arrow Down Thick' ),
		array( 'typcn typcn-arrow-down' => 'Arrow Down' ),
		array( 'typcn typcn-arrow-forward-outline' => 'Arrow Forward Outline' ),
		array( 'typcn typcn-arrow-forward' => 'Arrow Forward' ),
		array( 'typcn typcn-arrow-left-outline' => 'Arrow Left Outline' ),
		array( 'typcn typcn-arrow-left-thick' => 'Arrow Left Thick' ),
		array( 'typcn typcn-arrow-left' => 'Arrow Left' ),
		array( 'typcn typcn-arrow-loop-outline' => 'Arrow Loop Outline' ),
		array( 'typcn typcn-arrow-loop' => 'Arrow Loop' ),
		array( 'typcn typcn-arrow-maximise-outline' => 'Arrow Maximise Outline' ),
		array( 'typcn typcn-arrow-maximise' => 'Arrow Maximise' ),
		array( 'typcn typcn-arrow-minimise-outline' => 'Arrow Minimise Outline' ),
		array( 'typcn typcn-arrow-minimise' => 'Arrow Minimise' ),
		array( 'typcn typcn-arrow-move-outline' => 'Arrow Move Outline' ),
		array( 'typcn typcn-arrow-move' => 'Arrow Move' ),
		array( 'typcn typcn-arrow-repeat-outline' => 'Arrow Repeat Outline' ),
		array( 'typcn typcn-arrow-repeat' => 'Arrow Repeat' ),
		array( 'typcn typcn-arrow-right-outline' => 'Arrow Right Outline' ),
		array( 'typcn typcn-arrow-right-thick' => 'Arrow Right Thick' ),
		array( 'typcn typcn-arrow-right' => 'Arrow Right' ),
		array( 'typcn typcn-arrow-shuffle' => 'Arrow Shuffle' ),
		array( 'typcn typcn-arrow-sorted-down' => 'Arrow Sorted Down' ),
		array( 'typcn typcn-arrow-sorted-up' => 'Arrow Sorted Up' ),
		array( 'typcn typcn-arrow-sync-outline' => 'Arrow Sync Outline' ),
		array( 'typcn typcn-arrow-sync' => 'Arrow Sync' ),
		array( 'typcn typcn-arrow-unsorted' => 'Arrow Unsorted' ),
		array( 'typcn typcn-arrow-up-outline' => 'Arrow Up Outline' ),
		array( 'typcn typcn-arrow-up-thick' => 'Arrow Up Thick' ),
		array( 'typcn typcn-arrow-up' => 'Arrow Up' ),
		array( 'typcn typcn-at' => 'At' ),
		array( 'typcn typcn-attachment-outline' => 'Attachment Outline' ),
		array( 'typcn typcn-attachment' => 'Attachment' ),
		array( 'typcn typcn-backspace-outline' => 'Backspace Outline' ),
		array( 'typcn typcn-backspace' => 'Backspace' ),
		array( 'typcn typcn-battery-charge' => 'Battery Charge' ),
		array( 'typcn typcn-battery-full' => 'Battery Full' ),
		array( 'typcn typcn-battery-high' => 'Battery High' ),
		array( 'typcn typcn-battery-low' => 'Battery Low' ),
		array( 'typcn typcn-battery-mid' => 'Battery Mid' ),
		array( 'typcn typcn-beaker' => 'Beaker' ),
		array( 'typcn typcn-beer' => 'Beer' ),
		array( 'typcn typcn-bell' => 'Bell' ),
		array( 'typcn typcn-book' => 'Book' ),
		array( 'typcn typcn-bookmark' => 'Bookmark' ),
		array( 'typcn typcn-briefcase' => 'Briefcase' ),
		array( 'typcn typcn-brush' => 'Brush' ),
		array( 'typcn typcn-business-card' => 'Business Card' ),
		array( 'typcn typcn-calculator' => 'Calculator' ),
		array( 'typcn typcn-calendar-outline' => 'Calendar Outline' ),
		array( 'typcn typcn-calendar' => 'Calendar' ),
		array( 'typcn typcn-camera-outline' => 'Camera Outline' ),
		array( 'typcn typcn-camera' => 'Camera' ),
		array( 'typcn typcn-cancel-outline' => 'Cancel Outline' ),
		array( 'typcn typcn-cancel' => 'Cancel' ),
		array( 'typcn typcn-chart-area-outline' => 'Chart Area Outline' ),
		array( 'typcn typcn-chart-area' => 'Chart Area' ),
		array( 'typcn typcn-chart-bar-outline' => 'Chart Bar Outline' ),
		array( 'typcn typcn-chart-bar' => 'Chart Bar' ),
		array( 'typcn typcn-chart-line-outline' => 'Chart Line Outline' ),
		array( 'typcn typcn-chart-line' => 'Chart Line' ),
		array( 'typcn typcn-chart-pie-outline' => 'Chart Pie Outline' ),
		array( 'typcn typcn-chart-pie' => 'Chart Pie' ),
		array( 'typcn typcn-chevron-left-outline' => 'Chevron Left Outline' ),
		array( 'typcn typcn-chevron-left' => 'Chevron Left' ),
		array( 'typcn typcn-chevron-right-outline' => 'Chevron Right Outline' ),
		array( 'typcn typcn-chevron-right' => 'Chevron Right' ),
		array( 'typcn typcn-clipboard' => 'Clipboard' ),
		array( 'typcn typcn-cloud-storage' => 'Cloud Storage' ),
		array( 'typcn typcn-cloud-storage-outline' => 'Cloud Storage Outline' ),
		array( 'typcn typcn-code-outline' => 'Code Outline' ),
		array( 'typcn typcn-code' => 'Code' ),
		array( 'typcn typcn-coffee' => 'Coffee' ),
		array( 'typcn typcn-cog-outline' => 'Cog Outline' ),
		array( 'typcn typcn-cog' => 'Cog' ),
		array( 'typcn typcn-compass' => 'Compass' ),
		array( 'typcn typcn-contacts' => 'Contacts' ),
		array( 'typcn typcn-credit-card' => 'Credit Card' ),
		array( 'typcn typcn-css3' => 'Css3' ),
		array( 'typcn typcn-database' => 'Database' ),
		array( 'typcn typcn-delete-outline' => 'Delete Outline' ),
		array( 'typcn typcn-delete' => 'Delete' ),
		array( 'typcn typcn-device-desktop' => 'Device Desktop' ),
		array( 'typcn typcn-device-laptop' => 'Device Laptop' ),
		array( 'typcn typcn-device-phone' => 'Device Phone' ),
		array( 'typcn typcn-device-tablet' => 'Device Tablet' ),
		array( 'typcn typcn-directions' => 'Directions' ),
		array( 'typcn typcn-divide-outline' => 'Divide Outline' ),
		array( 'typcn typcn-divide' => 'Divide' ),
		array( 'typcn typcn-document-add' => 'Document Add' ),
		array( 'typcn typcn-document-delete' => 'Document Delete' ),
		array( 'typcn typcn-document-text' => 'Document Text' ),
		array( 'typcn typcn-document' => 'Document' ),
		array( 'typcn typcn-download-outline' => 'Download Outline' ),
		array( 'typcn typcn-download' => 'Download' ),
		array( 'typcn typcn-dropbox' => 'Dropbox' ),
		array( 'typcn typcn-edit' => 'Edit' ),
		array( 'typcn typcn-eject-outline' => 'Eject Outline' ),
		array( 'typcn typcn-eject' => 'Eject' ),
		array( 'typcn typcn-equals-outline' => 'Equals Outline' ),
		array( 'typcn typcn-equals' => 'Equals' ),
		array( 'typcn typcn-export-outline' => 'Export Outline' ),
		array( 'typcn typcn-export' => 'Export' ),
		array( 'typcn typcn-eye-outline' => 'Eye Outline' ),
		array( 'typcn typcn-eye' => 'Eye' ),
		array( 'typcn typcn-feather' => 'Feather' ),
		array( 'typcn typcn-film' => 'Film' ),
		array( 'typcn typcn-filter' => 'Filter' ),
		array( 'typcn typcn-flag-outline' => 'Flag Outline' ),
		array( 'typcn typcn-flag' => 'Flag' ),
		array( 'typcn typcn-flash-outline' => 'Flash Outline' ),
		array( 'typcn typcn-flash' => 'Flash' ),
		array( 'typcn typcn-flow-children' => 'Flow Children' ),
		array( 'typcn typcn-flow-merge' => 'Flow Merge' ),
		array( 'typcn typcn-flow-parallel' => 'Flow Parallel' ),
		array( 'typcn typcn-flow-switch' => 'Flow Switch' ),
		array( 'typcn typcn-folder-add' => 'Folder Add' ),
		array( 'typcn typcn-folder-delete' => 'Folder Delete' ),
		array( 'typcn typcn-folder-open' => 'Folder Open' ),
		array( 'typcn typcn-folder' => 'Folder' ),
		array( 'typcn typcn-gift' => 'Gift' ),
		array( 'typcn typcn-globe-outline' => 'Globe Outline' ),
		array( 'typcn typcn-globe' => 'Globe' ),
		array( 'typcn typcn-group-outline' => 'Group Outline' ),
		array( 'typcn typcn-group' => 'Group' ),
		array( 'typcn typcn-headphones' => 'Headphones' ),
		array( 'typcn typcn-heart-full-outline' => 'Heart Full Outline' ),
		array( 'typcn typcn-heart-half-outline' => 'Heart Half Outline' ),
		array( 'typcn typcn-heart-outline' => 'Heart Outline' ),
		array( 'typcn typcn-heart' => 'Heart' ),
		array( 'typcn typcn-home-outline' => 'Home Outline' ),
		array( 'typcn typcn-home' => 'Home' ),
		array( 'typcn typcn-html5' => 'Html5' ),
		array( 'typcn typcn-image-outline' => 'Image Outline' ),
		array( 'typcn typcn-image' => 'Image' ),
		array( 'typcn typcn-infinity-outline' => 'Infinity Outline' ),
		array( 'typcn typcn-infinity' => 'Infinity' ),
		array( 'typcn typcn-info-large-outline' => 'Info Large Outline' ),
		array( 'typcn typcn-info-large' => 'Info Large' ),
		array( 'typcn typcn-info-outline' => 'Info Outline' ),
		array( 'typcn typcn-info' => 'Info' ),
		array( 'typcn typcn-input-checked-outline' => 'Input Checked Outline' ),
		array( 'typcn typcn-input-checked' => 'Input Checked' ),
		array( 'typcn typcn-key-outline' => 'Key Outline' ),
		array( 'typcn typcn-key' => 'Key' ),
		array( 'typcn typcn-keyboard' => 'Keyboard' ),
		array( 'typcn typcn-leaf' => 'Leaf' ),
		array( 'typcn typcn-lightbulb' => 'Lightbulb' ),
		array( 'typcn typcn-link-outline' => 'Link Outline' ),
		array( 'typcn typcn-link' => 'Link' ),
		array( 'typcn typcn-location-arrow-outline' => 'Location Arrow Outline' ),
		array( 'typcn typcn-location-arrow' => 'Location Arrow' ),
		array( 'typcn typcn-location-outline' => 'Location Outline' ),
		array( 'typcn typcn-location' => 'Location' ),
		array( 'typcn typcn-lock-closed-outline' => 'Lock Closed Outline' ),
		array( 'typcn typcn-lock-closed' => 'Lock Closed' ),
		array( 'typcn typcn-lock-open-outline' => 'Lock Open Outline' ),
		array( 'typcn typcn-lock-open' => 'Lock Open' ),
		array( 'typcn typcn-mail' => 'Mail' ),
		array( 'typcn typcn-map' => 'Map' ),
		array( 'typcn typcn-media-eject-outline' => 'Media Eject Outline' ),
		array( 'typcn typcn-media-eject' => 'Media Eject' ),
		array( 'typcn typcn-media-fast-forward-outline' => 'Media Fast Forward Outline' ),
		array( 'typcn typcn-media-fast-forward' => 'Media Fast Forward' ),
		array( 'typcn typcn-media-pause-outline' => 'Media Pause Outline' ),
		array( 'typcn typcn-media-pause' => 'Media Pause' ),
		array( 'typcn typcn-media-play-outline' => 'Media Play Outline' ),
		array( 'typcn typcn-media-play-reverse-outline' => 'Media Play Reverse Outline' ),
		array( 'typcn typcn-media-play-reverse' => 'Media Play Reverse' ),
		array( 'typcn typcn-media-play' => 'Media Play' ),
		array( 'typcn typcn-media-record-outline' => 'Media Record Outline' ),
		array( 'typcn typcn-media-record' => 'Media Record' ),
		array( 'typcn typcn-media-rewind-outline' => 'Media Rewind Outline' ),
		array( 'typcn typcn-media-rewind' => 'Media Rewind' ),
		array( 'typcn typcn-media-stop-outline' => 'Media Stop Outline' ),
		array( 'typcn typcn-media-stop' => 'Media Stop' ),
		array( 'typcn typcn-message-typing' => 'Message Typing' ),
		array( 'typcn typcn-message' => 'Message' ),
		array( 'typcn typcn-messages' => 'Messages' ),
		array( 'typcn typcn-microphone-outline' => 'Microphone Outline' ),
		array( 'typcn typcn-microphone' => 'Microphone' ),
		array( 'typcn typcn-minus-outline' => 'Minus Outline' ),
		array( 'typcn typcn-minus' => 'Minus' ),
		array( 'typcn typcn-mortar-board' => 'Mortar Board' ),
		array( 'typcn typcn-news' => 'News' ),
		array( 'typcn typcn-notes-outline' => 'Notes Outline' ),
		array( 'typcn typcn-notes' => 'Notes' ),
		array( 'typcn typcn-pen' => 'Pen' ),
		array( 'typcn typcn-pencil' => 'Pencil' ),
		array( 'typcn typcn-phone-outline' => 'Phone Outline' ),
		array( 'typcn typcn-phone' => 'Phone' ),
		array( 'typcn typcn-pi-outline' => 'Pi Outline' ),
		array( 'typcn typcn-pi' => 'Pi' ),
		array( 'typcn typcn-pin-outline' => 'Pin Outline' ),
		array( 'typcn typcn-pin' => 'Pin' ),
		array( 'typcn typcn-pipette' => 'Pipette' ),
		array( 'typcn typcn-plane-outline' => 'Plane Outline' ),
		array( 'typcn typcn-plane' => 'Plane' ),
		array( 'typcn typcn-plug' => 'Plug' ),
		array( 'typcn typcn-plus-outline' => 'Plus Outline' ),
		array( 'typcn typcn-plus' => 'Plus' ),
		array( 'typcn typcn-point-of-interest-outline' => 'Point Of Interest Outline' ),
		array( 'typcn typcn-point-of-interest' => 'Point Of Interest' ),
		array( 'typcn typcn-power-outline' => 'Power Outline' ),
		array( 'typcn typcn-power' => 'Power' ),
		array( 'typcn typcn-printer' => 'Printer' ),
		array( 'typcn typcn-puzzle-outline' => 'Puzzle Outline' ),
		array( 'typcn typcn-puzzle' => 'Puzzle' ),
		array( 'typcn typcn-radar-outline' => 'Radar Outline' ),
		array( 'typcn typcn-radar' => 'Radar' ),
		array( 'typcn typcn-refresh-outline' => 'Refresh Outline' ),
		array( 'typcn typcn-refresh' => 'Refresh' ),
		array( 'typcn typcn-rss-outline' => 'Rss Outline' ),
		array( 'typcn typcn-rss' => 'Rss' ),
		array( 'typcn typcn-scissors-outline' => 'Scissors Outline' ),
		array( 'typcn typcn-scissors' => 'Scissors' ),
		array( 'typcn typcn-shopping-bag' => 'Shopping Bag' ),
		array( 'typcn typcn-shopping-cart' => 'Shopping Cart' ),
		array( 'typcn typcn-social-at-circular' => 'Social At Circular' ),
		array( 'typcn typcn-social-dribbble-circular' => 'Social Dribbble Circular' ),
		array( 'typcn typcn-social-dribbble' => 'Social Dribbble' ),
		array( 'typcn typcn-social-facebook-circular' => 'Social Facebook Circular' ),
		array( 'typcn typcn-social-facebook' => 'Social Facebook' ),
		array( 'typcn typcn-social-flickr-circular' => 'Social Flickr Circular' ),
		array( 'typcn typcn-social-flickr' => 'Social Flickr' ),
		array( 'typcn typcn-social-github-circular' => 'Social Github Circular' ),
		array( 'typcn typcn-social-github' => 'Social Github' ),
		array( 'typcn typcn-social-google-plus-circular' => 'Social Google Plus Circular' ),
		array( 'typcn typcn-social-google-plus' => 'Social Google Plus' ),
		array( 'typcn typcn-social-instagram-circular' => 'Social Instagram Circular' ),
		array( 'typcn typcn-social-instagram' => 'Social Instagram' ),
		array( 'typcn typcn-social-last-fm-circular' => 'Social Last Fm Circular' ),
		array( 'typcn typcn-social-last-fm' => 'Social Last Fm' ),
		array( 'typcn typcn-social-linkedin-circular' => 'Social Linkedin Circular' ),
		array( 'typcn typcn-social-linkedin' => 'Social Linkedin' ),
		array( 'typcn typcn-social-pinterest-circular' => 'Social Pinterest Circular' ),
		array( 'typcn typcn-social-pinterest' => 'Social Pinterest' ),
		array( 'typcn typcn-social-skype-outline' => 'Social Skype Outline' ),
		array( 'typcn typcn-social-skype' => 'Social Skype' ),
		array( 'typcn typcn-social-tumbler-circular' => 'Social Tumbler Circular' ),
		array( 'typcn typcn-social-tumbler' => 'Social Tumbler' ),
		array( 'typcn typcn-social-twitter-circular' => 'Social Twitter Circular' ),
		array( 'typcn typcn-social-twitter' => 'Social Twitter' ),
		array( 'typcn typcn-social-vimeo-circular' => 'Social Vimeo Circular' ),
		array( 'typcn typcn-social-vimeo' => 'Social Vimeo' ),
		array( 'typcn typcn-social-youtube-circular' => 'Social Youtube Circular' ),
		array( 'typcn typcn-social-youtube' => 'Social Youtube' ),
		array( 'typcn typcn-sort-alphabetically-outline' => 'Sort Alphabetically Outline' ),
		array( 'typcn typcn-sort-alphabetically' => 'Sort Alphabetically' ),
		array( 'typcn typcn-sort-numerically-outline' => 'Sort Numerically Outline' ),
		array( 'typcn typcn-sort-numerically' => 'Sort Numerically' ),
		array( 'typcn typcn-spanner-outline' => 'Spanner Outline' ),
		array( 'typcn typcn-spanner' => 'Spanner' ),
		array( 'typcn typcn-spiral' => 'Spiral' ),
		array( 'typcn typcn-star-full-outline' => 'Star Full Outline' ),
		array( 'typcn typcn-star-half-outline' => 'Star Half Outline' ),
		array( 'typcn typcn-star-half' => 'Star Half' ),
		array( 'typcn typcn-star-outline' => 'Star Outline' ),
		array( 'typcn typcn-star' => 'Star' ),
		array( 'typcn typcn-starburst-outline' => 'Starburst Outline' ),
		array( 'typcn typcn-starburst' => 'Starburst' ),
		array( 'typcn typcn-stopwatch' => 'Stopwatch' ),
		array( 'typcn typcn-support' => 'Support' ),
		array( 'typcn typcn-tabs-outline' => 'Tabs Outline' ),
		array( 'typcn typcn-tag' => 'Tag' ),
		array( 'typcn typcn-tags' => 'Tags' ),
		array( 'typcn typcn-th-large-outline' => 'Th Large Outline' ),
		array( 'typcn typcn-th-large' => 'Th Large' ),
		array( 'typcn typcn-th-list-outline' => 'Th List Outline' ),
		array( 'typcn typcn-th-list' => 'Th List' ),
		array( 'typcn typcn-th-menu-outline' => 'Th Menu Outline' ),
		array( 'typcn typcn-th-menu' => 'Th Menu' ),
		array( 'typcn typcn-th-small-outline' => 'Th Small Outline' ),
		array( 'typcn typcn-th-small' => 'Th Small' ),
		array( 'typcn typcn-thermometer' => 'Thermometer' ),
		array( 'typcn typcn-thumbs-down' => 'Thumbs Down' ),
		array( 'typcn typcn-thumbs-ok' => 'Thumbs Ok' ),
		array( 'typcn typcn-thumbs-up' => 'Thumbs Up' ),
		array( 'typcn typcn-tick-outline' => 'Tick Outline' ),
		array( 'typcn typcn-tick' => 'Tick' ),
		array( 'typcn typcn-ticket' => 'Ticket' ),
		array( 'typcn typcn-time' => 'Time' ),
		array( 'typcn typcn-times-outline' => 'Times Outline' ),
		array( 'typcn typcn-times' => 'Times' ),
		array( 'typcn typcn-trash' => 'Trash' ),
		array( 'typcn typcn-tree' => 'Tree' ),
		array( 'typcn typcn-upload-outline' => 'Upload Outline' ),
		array( 'typcn typcn-upload' => 'Upload' ),
		array( 'typcn typcn-user-add-outline' => 'User Add Outline' ),
		array( 'typcn typcn-user-add' => 'User Add' ),
		array( 'typcn typcn-user-delete-outline' => 'User Delete Outline' ),
		array( 'typcn typcn-user-delete' => 'User Delete' ),
		array( 'typcn typcn-user-outline' => 'User Outline' ),
		array( 'typcn typcn-user' => 'User' ),
		array( 'typcn typcn-vendor-android' => 'Vendor Android' ),
		array( 'typcn typcn-vendor-apple' => 'Vendor Apple' ),
		array( 'typcn typcn-vendor-microsoft' => 'Vendor Microsoft' ),
		array( 'typcn typcn-video-outline' => 'Video Outline' ),
		array( 'typcn typcn-video' => 'Video' ),
		array( 'typcn typcn-volume-down' => 'Volume Down' ),
		array( 'typcn typcn-volume-mute' => 'Volume Mute' ),
		array( 'typcn typcn-volume-up' => 'Volume Up' ),
		array( 'typcn typcn-volume' => 'Volume' ),
		array( 'typcn typcn-warning-outline' => 'Warning Outline' ),
		array( 'typcn typcn-warning' => 'Warning' ),
		array( 'typcn typcn-watch' => 'Watch' ),
		array( 'typcn typcn-waves-outline' => 'Waves Outline' ),
		array( 'typcn typcn-waves' => 'Waves' ),
		array( 'typcn typcn-weather-cloudy' => 'Weather Cloudy' ),
		array( 'typcn typcn-weather-downpour' => 'Weather Downpour' ),
		array( 'typcn typcn-weather-night' => 'Weather Night' ),
		array( 'typcn typcn-weather-partly-sunny' => 'Weather Partly Sunny' ),
		array( 'typcn typcn-weather-shower' => 'Weather Shower' ),
		array( 'typcn typcn-weather-snow' => 'Weather Snow' ),
		array( 'typcn typcn-weather-stormy' => 'Weather Stormy' ),
		array( 'typcn typcn-weather-sunny' => 'Weather Sunny' ),
		array( 'typcn typcn-weather-windy-cloudy' => 'Weather Windy Cloudy' ),
		array( 'typcn typcn-weather-windy' => 'Weather Windy' ),
		array( 'typcn typcn-wi-fi-outline' => 'Wi Fi Outline' ),
		array( 'typcn typcn-wi-fi' => 'Wi Fi' ),
		array( 'typcn typcn-wine' => 'Wine' ),
		array( 'typcn typcn-world-outline' => 'World Outline' ),
		array( 'typcn typcn-world' => 'World' ),
		array( 'typcn typcn-zoom-in-outline' => 'Zoom In Outline' ),
		array( 'typcn typcn-zoom-in' => 'Zoom In' ),
		array( 'typcn typcn-zoom-out-outline' => 'Zoom Out Outline' ),
		array( 'typcn typcn-zoom-out' => 'Zoom Out' ),
		array( 'typcn typcn-zoom-outline' => 'Zoom Outline' ),
		array( 'typcn typcn-zoom' => 'Zoom' ),
	);

	return array_merge( $icons, $typicons_icons );
}

add_filter( 'vc_iconpicker-type-entypo', 'vc_iconpicker_type_entypo' );
/**
 * Entypo icons from github.com/danielbruce/entypo
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_entypo( $icons ) {
	$entypo_icons = array(
		array( 'entypo-icon entypo-icon-note' => 'Note' ),
		array( 'entypo-icon entypo-icon-note-beamed' => 'Note Beamed' ),
		array( 'entypo-icon entypo-icon-music' => 'Music' ),
		array( 'entypo-icon entypo-icon-search' => 'Search' ),
		array( 'entypo-icon entypo-icon-flashlight' => 'Flashlight' ),
		array( 'entypo-icon entypo-icon-mail' => 'Mail' ),
		array( 'entypo-icon entypo-icon-heart' => 'Heart' ),
		array( 'entypo-icon entypo-icon-heart-empty' => 'Heart Empty' ),
		array( 'entypo-icon entypo-icon-star' => 'Star' ),
		array( 'entypo-icon entypo-icon-star-empty' => 'Star Empty' ),
		array( 'entypo-icon entypo-icon-user' => 'User' ),
		array( 'entypo-icon entypo-icon-users' => 'Users' ),
		array( 'entypo-icon entypo-icon-user-add' => 'User Add' ),
		array( 'entypo-icon entypo-icon-video' => 'Video' ),
		array( 'entypo-icon entypo-icon-picture' => 'Picture' ),
		array( 'entypo-icon entypo-icon-camera' => 'Camera' ),
		array( 'entypo-icon entypo-icon-layout' => 'Layout' ),
		array( 'entypo-icon entypo-icon-menu' => 'Menu' ),
		array( 'entypo-icon entypo-icon-check' => 'Check' ),
		array( 'entypo-icon entypo-icon-cancel' => 'Cancel' ),
		array( 'entypo-icon entypo-icon-cancel-circled' => 'Cancel Circled' ),
		array( 'entypo-icon entypo-icon-cancel-squared' => 'Cancel Squared' ),
		array( 'entypo-icon entypo-icon-plus' => 'Plus' ),
		array( 'entypo-icon entypo-icon-plus-circled' => 'Plus Circled' ),
		array( 'entypo-icon entypo-icon-plus-squared' => 'Plus Squared' ),
		array( 'entypo-icon entypo-icon-minus' => 'Minus' ),
		array( 'entypo-icon entypo-icon-minus-circled' => 'Minus Circled' ),
		array( 'entypo-icon entypo-icon-minus-squared' => 'Minus Squared' ),
		array( 'entypo-icon entypo-icon-help' => 'Help' ),
		array( 'entypo-icon entypo-icon-help-circled' => 'Help Circled' ),
		array( 'entypo-icon entypo-icon-info' => 'Info' ),
		array( 'entypo-icon entypo-icon-info-circled' => 'Info Circled' ),
		array( 'entypo-icon entypo-icon-back' => 'Back' ),
		array( 'entypo-icon entypo-icon-home' => 'Home' ),
		array( 'entypo-icon entypo-icon-link' => 'Link' ),
		array( 'entypo-icon entypo-icon-attach' => 'Attach' ),
		array( 'entypo-icon entypo-icon-lock' => 'Lock' ),
		array( 'entypo-icon entypo-icon-lock-open' => 'Lock Open' ),
		array( 'entypo-icon entypo-icon-eye' => 'Eye' ),
		array( 'entypo-icon entypo-icon-tag' => 'Tag' ),
		array( 'entypo-icon entypo-icon-bookmark' => 'Bookmark' ),
		array( 'entypo-icon entypo-icon-bookmarks' => 'Bookmarks' ),
		array( 'entypo-icon entypo-icon-flag' => 'Flag' ),
		array( 'entypo-icon entypo-icon-thumbs-up' => 'Thumbs Up' ),
		array( 'entypo-icon entypo-icon-thumbs-down' => 'Thumbs Down' ),
		array( 'entypo-icon entypo-icon-download' => 'Download' ),
		array( 'entypo-icon entypo-icon-upload' => 'Upload' ),
		array( 'entypo-icon entypo-icon-upload-cloud' => 'Upload Cloud' ),
		array( 'entypo-icon entypo-icon-reply' => 'Reply' ),
		array( 'entypo-icon entypo-icon-reply-all' => 'Reply All' ),
		array( 'entypo-icon entypo-icon-forward' => 'Forward' ),
		array( 'entypo-icon entypo-icon-quote' => 'Quote' ),
		array( 'entypo-icon entypo-icon-code' => 'Code' ),
		array( 'entypo-icon entypo-icon-export' => 'Export' ),
		array( 'entypo-icon entypo-icon-pencil' => 'Pencil' ),
		array( 'entypo-icon entypo-icon-feather' => 'Feather' ),
		array( 'entypo-icon entypo-icon-print' => 'Print' ),
		array( 'entypo-icon entypo-icon-retweet' => 'Retweet' ),
		array( 'entypo-icon entypo-icon-keyboard' => 'Keyboard' ),
		array( 'entypo-icon entypo-icon-comment' => 'Comment' ),
		array( 'entypo-icon entypo-icon-chat' => 'Chat' ),
		array( 'entypo-icon entypo-icon-bell' => 'Bell' ),
		array( 'entypo-icon entypo-icon-attention' => 'Attention' ),
		array( 'entypo-icon entypo-icon-alert' => 'Alert' ),
		array( 'entypo-icon entypo-icon-vcard' => 'Vcard' ),
		array( 'entypo-icon entypo-icon-address' => 'Address' ),
		array( 'entypo-icon entypo-icon-location' => 'Location' ),
		array( 'entypo-icon entypo-icon-map' => 'Map' ),
		array( 'entypo-icon entypo-icon-direction' => 'Direction' ),
		array( 'entypo-icon entypo-icon-compass' => 'Compass' ),
		array( 'entypo-icon entypo-icon-cup' => 'Cup' ),
		array( 'entypo-icon entypo-icon-trash' => 'Trash' ),
		array( 'entypo-icon entypo-icon-doc' => 'Doc' ),
		array( 'entypo-icon entypo-icon-docs' => 'Docs' ),
		array( 'entypo-icon entypo-icon-doc-landscape' => 'Doc Landscape' ),
		array( 'entypo-icon entypo-icon-doc-text' => 'Doc Text' ),
		array( 'entypo-icon entypo-icon-doc-text-inv' => 'Doc Text Inv' ),
		array( 'entypo-icon entypo-icon-newspaper' => 'Newspaper' ),
		array( 'entypo-icon entypo-icon-book-open' => 'Book Open' ),
		array( 'entypo-icon entypo-icon-book' => 'Book' ),
		array( 'entypo-icon entypo-icon-folder' => 'Folder' ),
		array( 'entypo-icon entypo-icon-archive' => 'Archive' ),
		array( 'entypo-icon entypo-icon-box' => 'Box' ),
		array( 'entypo-icon entypo-icon-rss' => 'Rss' ),
		array( 'entypo-icon entypo-icon-phone' => 'Phone' ),
		array( 'entypo-icon entypo-icon-cog' => 'Cog' ),
		array( 'entypo-icon entypo-icon-tools' => 'Tools' ),
		array( 'entypo-icon entypo-icon-share' => 'Share' ),
		array( 'entypo-icon entypo-icon-shareable' => 'Shareable' ),
		array( 'entypo-icon entypo-icon-basket' => 'Basket' ),
		array( 'entypo-icon entypo-icon-bag' => 'Bag' ),
		array( 'entypo-icon entypo-icon-calendar' => 'Calendar' ),
		array( 'entypo-icon entypo-icon-login' => 'Login' ),
		array( 'entypo-icon entypo-icon-logout' => 'Logout' ),
		array( 'entypo-icon entypo-icon-mic' => 'Mic' ),
		array( 'entypo-icon entypo-icon-mute' => 'Mute' ),
		array( 'entypo-icon entypo-icon-sound' => 'Sound' ),
		array( 'entypo-icon entypo-icon-volume' => 'Volume' ),
		array( 'entypo-icon entypo-icon-clock' => 'Clock' ),
		array( 'entypo-icon entypo-icon-hourglass' => 'Hourglass' ),
		array( 'entypo-icon entypo-icon-lamp' => 'Lamp' ),
		array( 'entypo-icon entypo-icon-light-down' => 'Light Down' ),
		array( 'entypo-icon entypo-icon-light-up' => 'Light Up' ),
		array( 'entypo-icon entypo-icon-adjust' => 'Adjust' ),
		array( 'entypo-icon entypo-icon-block' => 'Block' ),
		array( 'entypo-icon entypo-icon-resize-full' => 'Resize Full' ),
		array( 'entypo-icon entypo-icon-resize-small' => 'Resize Small' ),
		array( 'entypo-icon entypo-icon-popup' => 'Popup' ),
		array( 'entypo-icon entypo-icon-publish' => 'Publish' ),
		array( 'entypo-icon entypo-icon-window' => 'Window' ),
		array( 'entypo-icon entypo-icon-arrow-combo' => 'Arrow Combo' ),
		array( 'entypo-icon entypo-icon-down-circled' => 'Down Circled' ),
		array( 'entypo-icon entypo-icon-left-circled' => 'Left Circled' ),
		array( 'entypo-icon entypo-icon-right-circled' => 'Right Circled' ),
		array( 'entypo-icon entypo-icon-up-circled' => 'Up Circled' ),
		array( 'entypo-icon entypo-icon-down-open' => 'Down Open' ),
		array( 'entypo-icon entypo-icon-left-open' => 'Left Open' ),
		array( 'entypo-icon entypo-icon-right-open' => 'Right Open' ),
		array( 'entypo-icon entypo-icon-up-open' => 'Up Open' ),
		array( 'entypo-icon entypo-icon-down-open-mini' => 'Down Open Mini' ),
		array( 'entypo-icon entypo-icon-left-open-mini' => 'Left Open Mini' ),
		array( 'entypo-icon entypo-icon-right-open-mini' => 'Right Open Mini' ),
		array( 'entypo-icon entypo-icon-up-open-mini' => 'Up Open Mini' ),
		array( 'entypo-icon entypo-icon-down-open-big' => 'Down Open Big' ),
		array( 'entypo-icon entypo-icon-left-open-big' => 'Left Open Big' ),
		array( 'entypo-icon entypo-icon-right-open-big' => 'Right Open Big' ),
		array( 'entypo-icon entypo-icon-up-open-big' => 'Up Open Big' ),
		array( 'entypo-icon entypo-icon-down' => 'Down' ),
		array( 'entypo-icon entypo-icon-left' => 'Left' ),
		array( 'entypo-icon entypo-icon-right' => 'Right' ),
		array( 'entypo-icon entypo-icon-up' => 'Up' ),
		array( 'entypo-icon entypo-icon-down-dir' => 'Down Dir' ),
		array( 'entypo-icon entypo-icon-left-dir' => 'Left Dir' ),
		array( 'entypo-icon entypo-icon-right-dir' => 'Right Dir' ),
		array( 'entypo-icon entypo-icon-up-dir' => 'Up Dir' ),
		array( 'entypo-icon entypo-icon-down-bold' => 'Down Bold' ),
		array( 'entypo-icon entypo-icon-left-bold' => 'Left Bold' ),
		array( 'entypo-icon entypo-icon-right-bold' => 'Right Bold' ),
		array( 'entypo-icon entypo-icon-up-bold' => 'Up Bold' ),
		array( 'entypo-icon entypo-icon-down-thin' => 'Down Thin' ),
		array( 'entypo-icon entypo-icon-left-thin' => 'Left Thin' ),
		array( 'entypo-icon entypo-icon-right-thin' => 'Right Thin' ),
		array( 'entypo-icon entypo-icon-up-thin' => 'Up Thin' ),
		array( 'entypo-icon entypo-icon-ccw' => 'Ccw' ),
		array( 'entypo-icon entypo-icon-cw' => 'Cw' ),
		array( 'entypo-icon entypo-icon-arrows-ccw' => 'Arrows Ccw' ),
		array( 'entypo-icon entypo-icon-level-down' => 'Level Down' ),
		array( 'entypo-icon entypo-icon-level-up' => 'Level Up' ),
		array( 'entypo-icon entypo-icon-shuffle' => 'Shuffle' ),
		array( 'entypo-icon entypo-icon-loop' => 'Loop' ),
		array( 'entypo-icon entypo-icon-switch' => 'Switch' ),
		array( 'entypo-icon entypo-icon-play' => 'Play' ),
		array( 'entypo-icon entypo-icon-stop' => 'Stop' ),
		array( 'entypo-icon entypo-icon-pause' => 'Pause' ),
		array( 'entypo-icon entypo-icon-record' => 'Record' ),
		array( 'entypo-icon entypo-icon-to-end' => 'To End' ),
		array( 'entypo-icon entypo-icon-to-start' => 'To Start' ),
		array( 'entypo-icon entypo-icon-fast-forward' => 'Fast Forward' ),
		array( 'entypo-icon entypo-icon-fast-backward' => 'Fast Backward' ),
		array( 'entypo-icon entypo-icon-progress-0' => 'Progress 0' ),
		array( 'entypo-icon entypo-icon-progress-1' => 'Progress 1' ),
		array( 'entypo-icon entypo-icon-progress-2' => 'Progress 2' ),
		array( 'entypo-icon entypo-icon-progress-3' => 'Progress 3' ),
		array( 'entypo-icon entypo-icon-target' => 'Target' ),
		array( 'entypo-icon entypo-icon-palette' => 'Palette' ),
		array( 'entypo-icon entypo-icon-list' => 'List' ),
		array( 'entypo-icon entypo-icon-list-add' => 'List Add' ),
		array( 'entypo-icon entypo-icon-signal' => 'Signal' ),
		array( 'entypo-icon entypo-icon-trophy' => 'Trophy' ),
		array( 'entypo-icon entypo-icon-battery' => 'Battery' ),
		array( 'entypo-icon entypo-icon-back-in-time' => 'Back In Time' ),
		array( 'entypo-icon entypo-icon-monitor' => 'Monitor' ),
		array( 'entypo-icon entypo-icon-mobile' => 'Mobile' ),
		array( 'entypo-icon entypo-icon-network' => 'Network' ),
		array( 'entypo-icon entypo-icon-cd' => 'Cd' ),
		array( 'entypo-icon entypo-icon-inbox' => 'Inbox' ),
		array( 'entypo-icon entypo-icon-install' => 'Install' ),
		array( 'entypo-icon entypo-icon-globe' => 'Globe' ),
		array( 'entypo-icon entypo-icon-cloud' => 'Cloud' ),
		array( 'entypo-icon entypo-icon-cloud-thunder' => 'Cloud Thunder' ),
		array( 'entypo-icon entypo-icon-flash' => 'Flash' ),
		array( 'entypo-icon entypo-icon-moon' => 'Moon' ),
		array( 'entypo-icon entypo-icon-flight' => 'Flight' ),
		array( 'entypo-icon entypo-icon-paper-plane' => 'Paper Plane' ),
		array( 'entypo-icon entypo-icon-leaf' => 'Leaf' ),
		array( 'entypo-icon entypo-icon-lifebuoy' => 'Lifebuoy' ),
		array( 'entypo-icon entypo-icon-mouse' => 'Mouse' ),
		array( 'entypo-icon entypo-icon-briefcase' => 'Briefcase' ),
		array( 'entypo-icon entypo-icon-suitcase' => 'Suitcase' ),
		array( 'entypo-icon entypo-icon-dot' => 'Dot' ),
		array( 'entypo-icon entypo-icon-dot-2' => 'Dot 2' ),
		array( 'entypo-icon entypo-icon-dot-3' => 'Dot 3' ),
		array( 'entypo-icon entypo-icon-brush' => 'Brush' ),
		array( 'entypo-icon entypo-icon-magnet' => 'Magnet' ),
		array( 'entypo-icon entypo-icon-infinity' => 'Infinity' ),
		array( 'entypo-icon entypo-icon-erase' => 'Erase' ),
		array( 'entypo-icon entypo-icon-chart-pie' => 'Chart Pie' ),
		array( 'entypo-icon entypo-icon-chart-line' => 'Chart Line' ),
		array( 'entypo-icon entypo-icon-chart-bar' => 'Chart Bar' ),
		array( 'entypo-icon entypo-icon-chart-area' => 'Chart Area' ),
		array( 'entypo-icon entypo-icon-tape' => 'Tape' ),
		array( 'entypo-icon entypo-icon-graduation-cap' => 'Graduation Cap' ),
		array( 'entypo-icon entypo-icon-language' => 'Language' ),
		array( 'entypo-icon entypo-icon-ticket' => 'Ticket' ),
		array( 'entypo-icon entypo-icon-water' => 'Water' ),
		array( 'entypo-icon entypo-icon-droplet' => 'Droplet' ),
		array( 'entypo-icon entypo-icon-air' => 'Air' ),
		array( 'entypo-icon entypo-icon-credit-card' => 'Credit Card' ),
		array( 'entypo-icon entypo-icon-floppy' => 'Floppy' ),
		array( 'entypo-icon entypo-icon-clipboard' => 'Clipboard' ),
		array( 'entypo-icon entypo-icon-megaphone' => 'Megaphone' ),
		array( 'entypo-icon entypo-icon-database' => 'Database' ),
		array( 'entypo-icon entypo-icon-drive' => 'Drive' ),
		array( 'entypo-icon entypo-icon-bucket' => 'Bucket' ),
		array( 'entypo-icon entypo-icon-thermometer' => 'Thermometer' ),
		array( 'entypo-icon entypo-icon-key' => 'Key' ),
		array( 'entypo-icon entypo-icon-flow-cascade' => 'Flow Cascade' ),
		array( 'entypo-icon entypo-icon-flow-branch' => 'Flow Branch' ),
		array( 'entypo-icon entypo-icon-flow-tree' => 'Flow Tree' ),
		array( 'entypo-icon entypo-icon-flow-line' => 'Flow Line' ),
		array( 'entypo-icon entypo-icon-flow-parallel' => 'Flow Parallel' ),
		array( 'entypo-icon entypo-icon-rocket' => 'Rocket' ),
		array( 'entypo-icon entypo-icon-gauge' => 'Gauge' ),
		array( 'entypo-icon entypo-icon-traffic-cone' => 'Traffic Cone' ),
		array( 'entypo-icon entypo-icon-cc' => 'Cc' ),
		array( 'entypo-icon entypo-icon-cc-by' => 'Cc By' ),
		array( 'entypo-icon entypo-icon-cc-nc' => 'Cc Nc' ),
		array( 'entypo-icon entypo-icon-cc-nc-eu' => 'Cc Nc Eu' ),
		array( 'entypo-icon entypo-icon-cc-nc-jp' => 'Cc Nc Jp' ),
		array( 'entypo-icon entypo-icon-cc-sa' => 'Cc Sa' ),
		array( 'entypo-icon entypo-icon-cc-nd' => 'Cc Nd' ),
		array( 'entypo-icon entypo-icon-cc-pd' => 'Cc Pd' ),
		array( 'entypo-icon entypo-icon-cc-zero' => 'Cc Zero' ),
		array( 'entypo-icon entypo-icon-cc-share' => 'Cc Share' ),
		array( 'entypo-icon entypo-icon-cc-remix' => 'Cc Remix' ),
		array( 'entypo-icon entypo-icon-github' => 'Github' ),
		array( 'entypo-icon entypo-icon-github-circled' => 'Github Circled' ),
		array( 'entypo-icon entypo-icon-flickr' => 'Flickr' ),
		array( 'entypo-icon entypo-icon-flickr-circled' => 'Flickr Circled' ),
		array( 'entypo-icon entypo-icon-vimeo' => 'Vimeo' ),
		array( 'entypo-icon entypo-icon-vimeo-circled' => 'Vimeo Circled' ),
		array( 'entypo-icon entypo-icon-twitter' => 'Twitter' ),
		array( 'entypo-icon entypo-icon-twitter-circled' => 'Twitter Circled' ),
		array( 'entypo-icon entypo-icon-facebook' => 'Facebook' ),
		array( 'entypo-icon entypo-icon-facebook-circled' => 'Facebook Circled' ),
		array( 'entypo-icon entypo-icon-facebook-squared' => 'Facebook Squared' ),
		array( 'entypo-icon entypo-icon-gplus' => 'Gplus' ),
		array( 'entypo-icon entypo-icon-gplus-circled' => 'Gplus Circled' ),
		array( 'entypo-icon entypo-icon-pinterest' => 'Pinterest' ),
		array( 'entypo-icon entypo-icon-pinterest-circled' => 'Pinterest Circled' ),
		array( 'entypo-icon entypo-icon-tumblr' => 'Tumblr' ),
		array( 'entypo-icon entypo-icon-tumblr-circled' => 'Tumblr Circled' ),
		array( 'entypo-icon entypo-icon-linkedin' => 'Linkedin' ),
		array( 'entypo-icon entypo-icon-linkedin-circled' => 'Linkedin Circled' ),
		array( 'entypo-icon entypo-icon-dribbble' => 'Dribbble' ),
		array( 'entypo-icon entypo-icon-dribbble-circled' => 'Dribbble Circled' ),
		array( 'entypo-icon entypo-icon-stumbleupon' => 'Stumbleupon' ),
		array( 'entypo-icon entypo-icon-stumbleupon-circled' => 'Stumbleupon Circled' ),
		array( 'entypo-icon entypo-icon-lastfm' => 'Lastfm' ),
		array( 'entypo-icon entypo-icon-lastfm-circled' => 'Lastfm Circled' ),
		array( 'entypo-icon entypo-icon-rdio' => 'Rdio' ),
		array( 'entypo-icon entypo-icon-rdio-circled' => 'Rdio Circled' ),
		array( 'entypo-icon entypo-icon-spotify' => 'Spotify' ),
		array( 'entypo-icon entypo-icon-spotify-circled' => 'Spotify Circled' ),
		array( 'entypo-icon entypo-icon-qq' => 'Qq' ),
		array( 'entypo-icon entypo-icon-instagrem' => 'Instagrem' ),
		array( 'entypo-icon entypo-icon-dropbox' => 'Dropbox' ),
		array( 'entypo-icon entypo-icon-evernote' => 'Evernote' ),
		array( 'entypo-icon entypo-icon-flattr' => 'Flattr' ),
		array( 'entypo-icon entypo-icon-skype' => 'Skype' ),
		array( 'entypo-icon entypo-icon-skype-circled' => 'Skype Circled' ),
		array( 'entypo-icon entypo-icon-renren' => 'Renren' ),
		array( 'entypo-icon entypo-icon-sina-weibo' => 'Sina Weibo' ),
		array( 'entypo-icon entypo-icon-paypal' => 'Paypal' ),
		array( 'entypo-icon entypo-icon-picasa' => 'Picasa' ),
		array( 'entypo-icon entypo-icon-soundcloud' => 'Soundcloud' ),
		array( 'entypo-icon entypo-icon-mixi' => 'Mixi' ),
		array( 'entypo-icon entypo-icon-behance' => 'Behance' ),
		array( 'entypo-icon entypo-icon-google-circles' => 'Google Circles' ),
		array( 'entypo-icon entypo-icon-vkontakte' => 'Vkontakte' ),
		array( 'entypo-icon entypo-icon-smashing' => 'Smashing' ),
		array( 'entypo-icon entypo-icon-sweden' => 'Sweden' ),
		array( 'entypo-icon entypo-icon-db-shape' => 'Db Shape' ),
		array( 'entypo-icon entypo-icon-logo-db' => 'Logo Db' ),
	);

	return array_merge( $icons, $entypo_icons );
}

add_filter( 'vc_iconpicker-type-linecons', 'vc_iconpicker_type_linecons' );

/**
 * Linecons icons from fontello.com
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_linecons( $icons ) {
	$linecons_icons = array(
		array( 'vc_li vc_li-heart' => 'Heart' ),
		array( 'vc_li vc_li-cloud' => 'Cloud' ),
		array( 'vc_li vc_li-star' => 'Star' ),
		array( 'vc_li vc_li-tv' => 'Tv' ),
		array( 'vc_li vc_li-sound' => 'Sound' ),
		array( 'vc_li vc_li-video' => 'Video' ),
		array( 'vc_li vc_li-trash' => 'Trash' ),
		array( 'vc_li vc_li-user' => 'User' ),
		array( 'vc_li vc_li-key' => 'Key' ),
		array( 'vc_li vc_li-search' => 'Search' ),
		array( 'vc_li vc_li-settings' => 'Settings' ),
		array( 'vc_li vc_li-camera' => 'Camera' ),
		array( 'vc_li vc_li-tag' => 'Tag' ),
		array( 'vc_li vc_li-lock' => 'Lock' ),
		array( 'vc_li vc_li-bulb' => 'Bulb' ),
		array( 'vc_li vc_li-pen' => 'Pen' ),
		array( 'vc_li vc_li-diamond' => 'Diamond' ),
		array( 'vc_li vc_li-display' => 'Display' ),
		array( 'vc_li vc_li-location' => 'Location' ),
		array( 'vc_li vc_li-eye' => 'Eye' ),
		array( 'vc_li vc_li-bubble' => 'Bubble' ),
		array( 'vc_li vc_li-stack' => 'Stack' ),
		array( 'vc_li vc_li-cup' => 'Cup' ),
		array( 'vc_li vc_li-phone' => 'Phone' ),
		array( 'vc_li vc_li-news' => 'News' ),
		array( 'vc_li vc_li-mail' => 'Mail' ),
		array( 'vc_li vc_li-like' => 'Like' ),
		array( 'vc_li vc_li-photo' => 'Photo' ),
		array( 'vc_li vc_li-note' => 'Note' ),
		array( 'vc_li vc_li-clock' => 'Clock' ),
		array( 'vc_li vc_li-paperplane' => 'Paperplane' ),
		array( 'vc_li vc_li-params' => 'Params' ),
		array( 'vc_li vc_li-banknote' => 'Banknote' ),
		array( 'vc_li vc_li-data' => 'Data' ),
		array( 'vc_li vc_li-music' => 'Music' ),
		array( 'vc_li vc_li-megaphone' => 'Megaphone' ),
		array( 'vc_li vc_li-study' => 'Study' ),
		array( 'vc_li vc_li-lab' => 'Lab' ),
		array( 'vc_li vc_li-food' => 'Food' ),
		array( 'vc_li vc_li-t-shirt' => 'T Shirt' ),
		array( 'vc_li vc_li-fire' => 'Fire' ),
		array( 'vc_li vc_li-clip' => 'Clip' ),
		array( 'vc_li vc_li-shop' => 'Shop' ),
		array( 'vc_li vc_li-calendar' => 'Calendar' ),
		array( 'vc_li vc_li-vallet' => 'Vallet' ),
		array( 'vc_li vc_li-vynil' => 'Vynil' ),
		array( 'vc_li vc_li-truck' => 'Truck' ),
		array( 'vc_li vc_li-world' => 'World' ),
	);

	return array_merge( $icons, $linecons_icons );
}

add_filter( 'vc_iconpicker-type-monosocial', 'vc_iconpicker_type_monosocial' );

/**
 * monosocial icons from drinchev.github.io/monosocialiconsfont
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */
function vc_iconpicker_type_monosocial( $icons ) {
	$monosocial = array(
		array( 'vc-mono vc-mono-fivehundredpx' => 'Five Hundred px' ),
		array( 'vc-mono vc-mono-aboutme' => 'About me' ),
		array( 'vc-mono vc-mono-addme' => 'Add me' ),
		array( 'vc-mono vc-mono-amazon' => 'Amazon' ),
		array( 'vc-mono vc-mono-aol' => 'Aol' ),
		array( 'vc-mono vc-mono-appstorealt' => 'App-store-alt' ),
		array( 'vc-mono vc-mono-appstore' => 'Appstore' ),
		array( 'vc-mono vc-mono-apple' => 'Apple' ),
		array( 'vc-mono vc-mono-bebo' => 'Bebo' ),
		array( 'vc-mono vc-mono-behance' => 'Behance' ),
		array( 'vc-mono vc-mono-bing' => 'Bing' ),
		array( 'vc-mono vc-mono-blip' => 'Blip' ),
		array( 'vc-mono vc-mono-blogger' => 'Blogger' ),
		array( 'vc-mono vc-mono-coroflot' => 'Coroflot' ),
		array( 'vc-mono vc-mono-daytum' => 'Daytum' ),
		array( 'vc-mono vc-mono-delicious' => 'Delicious' ),
		array( 'vc-mono vc-mono-designbump' => 'Design bump' ),
		array( 'vc-mono vc-mono-designfloat' => 'Design float' ),
		array( 'vc-mono vc-mono-deviantart' => 'Deviant-art' ),
		array( 'vc-mono vc-mono-diggalt' => 'Digg-alt' ),
		array( 'vc-mono vc-mono-digg' => 'Digg' ),
		array( 'vc-mono vc-mono-dribble' => 'Dribble' ),
		array( 'vc-mono vc-mono-drupal' => 'Drupal' ),
		array( 'vc-mono vc-mono-ebay' => 'Ebay' ),
		array( 'vc-mono vc-mono-email' => 'Email' ),
		array( 'vc-mono vc-mono-emberapp' => 'Ember app' ),
		array( 'vc-mono vc-mono-etsy' => 'Etsy' ),
		array( 'vc-mono vc-mono-facebook' => 'Facebook' ),
		array( 'vc-mono vc-mono-feedburner' => 'Feed burner' ),
		array( 'vc-mono vc-mono-flickr' => 'Flickr' ),
		array( 'vc-mono vc-mono-foodspotting' => 'Food spotting' ),
		array( 'vc-mono vc-mono-forrst' => 'Forrst' ),
		array( 'vc-mono vc-mono-foursquare' => 'Fours quare' ),
		array( 'vc-mono vc-mono-friendsfeed' => 'Friends feed' ),
		array( 'vc-mono vc-mono-friendstar' => 'Friend star' ),
		array( 'vc-mono vc-mono-gdgt' => 'Gdgt' ),
		array( 'vc-mono vc-mono-github' => 'Github' ),
		array( 'vc-mono vc-mono-githubalt' => 'Github-alt' ),
		array( 'vc-mono vc-mono-googlebuzz' => 'Google buzz' ),
		array( 'vc-mono vc-mono-googleplus' => 'Google plus' ),
		array( 'vc-mono vc-mono-googletalk' => 'Google talk' ),
		array( 'vc-mono vc-mono-gowallapin' => 'Gowallapin' ),
		array( 'vc-mono vc-mono-gowalla' => 'Gowalla' ),
		array( 'vc-mono vc-mono-grooveshark' => 'Groove shark' ),
		array( 'vc-mono vc-mono-heart' => 'Heart' ),
		array( 'vc-mono vc-mono-hyves' => 'Hyves' ),
		array( 'vc-mono vc-mono-icondock' => 'Icondock' ),
		array( 'vc-mono vc-mono-icq' => 'Icq' ),
		array( 'vc-mono vc-mono-identica' => 'Identica' ),
		array( 'vc-mono vc-mono-imessage' => 'I message' ),
		array( 'vc-mono vc-mono-itunes' => 'I-tunes' ),
		array( 'vc-mono vc-mono-lastfm' => 'Lastfm' ),
		array( 'vc-mono vc-mono-linkedin' => 'Linkedin' ),
		array( 'vc-mono vc-mono-meetup' => 'Meetup' ),
		array( 'vc-mono vc-mono-metacafe' => 'Metacafe' ),
		array( 'vc-mono vc-mono-mixx' => 'Mixx' ),
		array( 'vc-mono vc-mono-mobileme' => 'Mobile me' ),
		array( 'vc-mono vc-mono-mrwong' => 'Mrwong' ),
		array( 'vc-mono vc-mono-msn' => 'Msn' ),
		array( 'vc-mono vc-mono-myspace' => 'Myspace' ),
		array( 'vc-mono vc-mono-newsvine' => 'Newsvine' ),
		array( 'vc-mono vc-mono-paypal' => 'Paypal' ),
		array( 'vc-mono vc-mono-photobucket' => 'Photo bucket' ),
		array( 'vc-mono vc-mono-picasa' => 'Picasa' ),
		array( 'vc-mono vc-mono-pinterest' => 'Pinterest' ),
		array( 'vc-mono vc-mono-podcast' => 'Podcast' ),
		array( 'vc-mono vc-mono-posterous' => 'Posterous' ),
		array( 'vc-mono vc-mono-qik' => 'Qik' ),
		array( 'vc-mono vc-mono-quora' => 'Quora' ),
		array( 'vc-mono vc-mono-reddit' => 'Reddit' ),
		array( 'vc-mono vc-mono-retweet' => 'Retweet' ),
		array( 'vc-mono vc-mono-rss' => 'Rss' ),
		array( 'vc-mono vc-mono-scribd' => 'Scribd' ),
		array( 'vc-mono vc-mono-sharethis' => 'Sharethis' ),
		array( 'vc-mono vc-mono-skype' => 'Skype' ),
		array( 'vc-mono vc-mono-slashdot' => 'Slashdot' ),
		array( 'vc-mono vc-mono-slideshare' => 'Slideshare' ),
		array( 'vc-mono vc-mono-smugmug' => 'Smugmug' ),
		array( 'vc-mono vc-mono-soundcloud' => 'Soundcloud' ),
		array( 'vc-mono vc-mono-spotify' => 'Spotify' ),
		array( 'vc-mono vc-mono-squidoo' => 'Squidoo' ),
		array( 'vc-mono vc-mono-stackoverflow' => 'Stackoverflow' ),
		array( 'vc-mono vc-mono-star' => 'Star' ),
		array( 'vc-mono vc-mono-stumbleupon' => 'Stumble upon' ),
		array( 'vc-mono vc-mono-technorati' => 'Technorati' ),
		array( 'vc-mono vc-mono-tumblr' => 'Tumblr' ),
		array( 'vc-mono vc-mono-twitterbird' => 'Twitterbird' ),
		array( 'vc-mono vc-mono-twitter' => 'Twitter' ),
		array( 'vc-mono vc-mono-viddler' => 'Viddler' ),
		array( 'vc-mono vc-mono-vimeo' => 'Vimeo' ),
		array( 'vc-mono vc-mono-virb' => 'Virb' ),
		array( 'vc-mono vc-mono-www' => 'Www' ),
		array( 'vc-mono vc-mono-wikipedia' => 'Wikipedia' ),
		array( 'vc-mono vc-mono-windows' => 'Windows' ),
		array( 'vc-mono vc-mono-wordpress' => 'WordPress' ),
		array( 'vc-mono vc-mono-xing' => 'Xing' ),
		array( 'vc-mono vc-mono-yahoobuzz' => 'Yahoo buzz' ),
		array( 'vc-mono vc-mono-yahoo' => 'Yahoo' ),
		array( 'vc-mono vc-mono-yelp' => 'Yelp' ),
		array( 'vc-mono vc-mono-youtube' => 'Youtube' ),
		array( 'vc-mono vc-mono-instagram' => 'Instagram' ),
	);

	return array_merge( $icons, $monosocial );
}

add_filter( 'vc_iconpicker-type-material', 'vc_iconpicker_type_material' );
/**
 * Material icon set from Google
 * @param $icons
 *
 * @return array
 * @since 5.0
 *
 */
function vc_iconpicker_type_material( $icons ) {
	$material = array(
		array( 'vc-material vc-material-3d_rotation' => '3d rotation' ),
		array( 'vc-material vc-material-ac_unit' => 'ac unit' ),
		array( 'vc-material vc-material-alarm' => 'alarm' ),
		array( 'vc-material vc-material-access_alarms' => 'access alarms' ),
		array( 'vc-material vc-material-schedule' => 'schedule' ),
		array( 'vc-material vc-material-accessibility' => 'accessibility' ),
		array( 'vc-material vc-material-accessible' => 'accessible' ),
		array( 'vc-material vc-material-account_balance' => 'account balance' ),
		array( 'vc-material vc-material-account_balance_wallet' => 'account balance wallet' ),
		array( 'vc-material vc-material-account_box' => 'account box' ),
		array( 'vc-material vc-material-account_circle' => 'account circle' ),
		array( 'vc-material vc-material-adb' => 'adb' ),
		array( 'vc-material vc-material-add' => 'add' ),
		array( 'vc-material vc-material-add_a_photo' => 'add a photo' ),
		array( 'vc-material vc-material-alarm_add' => 'alarm add' ),
		array( 'vc-material vc-material-add_alert' => 'add alert' ),
		array( 'vc-material vc-material-add_box' => 'add box' ),
		array( 'vc-material vc-material-add_circle' => 'add circle' ),
		array( 'vc-material vc-material-control_point' => 'control point' ),
		array( 'vc-material vc-material-add_location' => 'add location' ),
		array( 'vc-material vc-material-add_shopping_cart' => 'add shopping cart' ),
		array( 'vc-material vc-material-queue' => 'queue' ),
		array( 'vc-material vc-material-add_to_queue' => 'add to queue' ),
		array( 'vc-material vc-material-adjust' => 'adjust' ),
		array( 'vc-material vc-material-airline_seat_flat' => 'airline seat flat' ),
		array( 'vc-material vc-material-airline_seat_flat_angled' => 'airline seat flat angled' ),
		array( 'vc-material vc-material-airline_seat_individual_suite' => 'airline seat individual suite' ),
		array( 'vc-material vc-material-airline_seat_legroom_extra' => 'airline seat legroom extra' ),
		array( 'vc-material vc-material-airline_seat_legroom_normal' => 'airline seat legroom normal' ),
		array( 'vc-material vc-material-airline_seat_legroom_reduced' => 'airline seat legroom reduced' ),
		array( 'vc-material vc-material-airline_seat_recline_extra' => 'airline seat recline extra' ),
		array( 'vc-material vc-material-airline_seat_recline_normal' => 'airline seat recline normal' ),
		array( 'vc-material vc-material-flight' => 'flight' ),
		array( 'vc-material vc-material-airplanemode_inactive' => 'airplanemode inactive' ),
		array( 'vc-material vc-material-airplay' => 'airplay' ),
		array( 'vc-material vc-material-airport_shuttle' => 'airport shuttle' ),
		array( 'vc-material vc-material-alarm_off' => 'alarm off' ),
		array( 'vc-material vc-material-alarm_on' => 'alarm on' ),
		array( 'vc-material vc-material-album' => 'album' ),
		array( 'vc-material vc-material-all_inclusive' => 'all inclusive' ),
		array( 'vc-material vc-material-all_out' => 'all out' ),
		array( 'vc-material vc-material-android' => 'android' ),
		array( 'vc-material vc-material-announcement' => 'announcement' ),
		array( 'vc-material vc-material-apps' => 'apps' ),
		array( 'vc-material vc-material-archive' => 'archive' ),
		array( 'vc-material vc-material-arrow_back' => 'arrow back' ),
		array( 'vc-material vc-material-arrow_downward' => 'arrow downward' ),
		array( 'vc-material vc-material-arrow_drop_down' => 'arrow drop down' ),
		array( 'vc-material vc-material-arrow_drop_down_circle' => 'arrow drop down circle' ),
		array( 'vc-material vc-material-arrow_drop_up' => 'arrow drop up' ),
		array( 'vc-material vc-material-arrow_forward' => 'arrow forward' ),
		array( 'vc-material vc-material-arrow_upward' => 'arrow upward' ),
		array( 'vc-material vc-material-art_track' => 'art track' ),
		array( 'vc-material vc-material-aspect_ratio' => 'aspect ratio' ),
		array( 'vc-material vc-material-poll' => 'poll' ),
		array( 'vc-material vc-material-assignment' => 'assignment' ),
		array( 'vc-material vc-material-assignment_ind' => 'assignment ind' ),
		array( 'vc-material vc-material-assignment_late' => 'assignment late' ),
		array( 'vc-material vc-material-assignment_return' => 'assignment return' ),
		array( 'vc-material vc-material-assignment_returned' => 'assignment returned' ),
		array( 'vc-material vc-material-assignment_turned_in' => 'assignment turned in' ),
		array( 'vc-material vc-material-assistant' => 'assistant' ),
		array( 'vc-material vc-material-flag' => 'flag' ),
		array( 'vc-material vc-material-attach_file' => 'attach file' ),
		array( 'vc-material vc-material-attach_money' => 'attach money' ),
		array( 'vc-material vc-material-attachment' => 'attachment' ),
		array( 'vc-material vc-material-audiotrack' => 'audiotrack' ),
		array( 'vc-material vc-material-autorenew' => 'autorenew' ),
		array( 'vc-material vc-material-av_timer' => 'av timer' ),
		array( 'vc-material vc-material-backspace' => 'backspace' ),
		array( 'vc-material vc-material-cloud_upload' => 'cloud upload' ),
		array( 'vc-material vc-material-battery_alert' => 'battery alert' ),
		array( 'vc-material vc-material-battery_charging_full' => 'battery charging full' ),
		array( 'vc-material vc-material-battery_std' => 'battery std' ),
		array( 'vc-material vc-material-battery_unknown' => 'battery unknown' ),
		array( 'vc-material vc-material-beach_access' => 'beach access' ),
		array( 'vc-material vc-material-beenhere' => 'beenhere' ),
		array( 'vc-material vc-material-block' => 'block' ),
		array( 'vc-material vc-material-bluetooth' => 'bluetooth' ),
		array( 'vc-material vc-material-bluetooth_searching' => 'bluetooth searching' ),
		array( 'vc-material vc-material-bluetooth_connected' => 'bluetooth connected' ),
		array( 'vc-material vc-material-bluetooth_disabled' => 'bluetooth disabled' ),
		array( 'vc-material vc-material-blur_circular' => 'blur circular' ),
		array( 'vc-material vc-material-blur_linear' => 'blur linear' ),
		array( 'vc-material vc-material-blur_off' => 'blur off' ),
		array( 'vc-material vc-material-blur_on' => 'blur on' ),
		array( 'vc-material vc-material-class' => 'class' ),
		array( 'vc-material vc-material-turned_in' => 'turned in' ),
		array( 'vc-material vc-material-turned_in_not' => 'turned in not' ),
		array( 'vc-material vc-material-border_all' => 'border all' ),
		array( 'vc-material vc-material-border_bottom' => 'border bottom' ),
		array( 'vc-material vc-material-border_clear' => 'border clear' ),
		array( 'vc-material vc-material-border_color' => 'border color' ),
		array( 'vc-material vc-material-border_horizontal' => 'border horizontal' ),
		array( 'vc-material vc-material-border_inner' => 'border inner' ),
		array( 'vc-material vc-material-border_left' => 'border left' ),
		array( 'vc-material vc-material-border_outer' => 'border outer' ),
		array( 'vc-material vc-material-border_right' => 'border right' ),
		array( 'vc-material vc-material-border_style' => 'border style' ),
		array( 'vc-material vc-material-border_top' => 'border top' ),
		array( 'vc-material vc-material-border_vertical' => 'border vertical' ),
		array( 'vc-material vc-material-branding_watermark' => 'branding watermark' ),
		array( 'vc-material vc-material-brightness_1' => 'brightness 1' ),
		array( 'vc-material vc-material-brightness_2' => 'brightness 2' ),
		array( 'vc-material vc-material-brightness_3' => 'brightness 3' ),
		array( 'vc-material vc-material-brightness_4' => 'brightness 4' ),
		array( 'vc-material vc-material-brightness_low' => 'brightness low' ),
		array( 'vc-material vc-material-brightness_medium' => 'brightness medium' ),
		array( 'vc-material vc-material-brightness_high' => 'brightness high' ),
		array( 'vc-material vc-material-brightness_auto' => 'brightness auto' ),
		array( 'vc-material vc-material-broken_image' => 'broken image' ),
		array( 'vc-material vc-material-brush' => 'brush' ),
		array( 'vc-material vc-material-bubble_chart' => 'bubble chart' ),
		array( 'vc-material vc-material-bug_report' => 'bug report' ),
		array( 'vc-material vc-material-build' => 'build' ),
		array( 'vc-material vc-material-burst_mode' => 'burst mode' ),
		array( 'vc-material vc-material-domain' => 'domain' ),
		array( 'vc-material vc-material-business_center' => 'business center' ),
		array( 'vc-material vc-material-cached' => 'cached' ),
		array( 'vc-material vc-material-cake' => 'cake' ),
		array( 'vc-material vc-material-phone' => 'phone' ),
		array( 'vc-material vc-material-call_end' => 'call end' ),
		array( 'vc-material vc-material-call_made' => 'call made' ),
		array( 'vc-material vc-material-merge_type' => 'merge type' ),
		array( 'vc-material vc-material-call_missed' => 'call missed' ),
		array( 'vc-material vc-material-call_missed_outgoing' => 'call missed outgoing' ),
		array( 'vc-material vc-material-call_received' => 'call received' ),
		array( 'vc-material vc-material-call_split' => 'call split' ),
		array( 'vc-material vc-material-call_to_action' => 'call to action' ),
		array( 'vc-material vc-material-camera' => 'camera' ),
		array( 'vc-material vc-material-photo_camera' => 'photo camera' ),
		array( 'vc-material vc-material-camera_enhance' => 'camera enhance' ),
		array( 'vc-material vc-material-camera_front' => 'camera front' ),
		array( 'vc-material vc-material-camera_rear' => 'camera rear' ),
		array( 'vc-material vc-material-camera_roll' => 'camera roll' ),
		array( 'vc-material vc-material-cancel' => 'cancel' ),
		array( 'vc-material vc-material-redeem' => 'redeem' ),
		array( 'vc-material vc-material-card_membership' => 'card membership' ),
		array( 'vc-material vc-material-card_travel' => 'card travel' ),
		array( 'vc-material vc-material-casino' => 'casino' ),
		array( 'vc-material vc-material-cast' => 'cast' ),
		array( 'vc-material vc-material-cast_connected' => 'cast connected' ),
		array( 'vc-material vc-material-center_focus_strong' => 'center focus strong' ),
		array( 'vc-material vc-material-center_focus_weak' => 'center focus weak' ),
		array( 'vc-material vc-material-change_history' => 'change history' ),
		array( 'vc-material vc-material-chat' => 'chat' ),
		array( 'vc-material vc-material-chat_bubble' => 'chat bubble' ),
		array( 'vc-material vc-material-chat_bubble_outline' => 'chat bubble outline' ),
		array( 'vc-material vc-material-check' => 'check' ),
		array( 'vc-material vc-material-check_box' => 'check box' ),
		array( 'vc-material vc-material-check_box_outline_blank' => 'check box outline blank' ),
		array( 'vc-material vc-material-check_circle' => 'check circle' ),
		array( 'vc-material vc-material-navigate_before' => 'navigate before' ),
		array( 'vc-material vc-material-navigate_next' => 'navigate next' ),
		array( 'vc-material vc-material-child_care' => 'child care' ),
		array( 'vc-material vc-material-child_friendly' => 'child friendly' ),
		array( 'vc-material vc-material-chrome_reader_mode' => 'chrome reader mode' ),
		array( 'vc-material vc-material-close' => 'close' ),
		array( 'vc-material vc-material-clear_all' => 'clear all' ),
		array( 'vc-material vc-material-closed_caption' => 'closed caption' ),
		array( 'vc-material vc-material-wb_cloudy' => 'wb cloudy' ),
		array( 'vc-material vc-material-cloud_circle' => 'cloud circle' ),
		array( 'vc-material vc-material-cloud_done' => 'cloud done' ),
		array( 'vc-material vc-material-cloud_download' => 'cloud download' ),
		array( 'vc-material vc-material-cloud_off' => 'cloud off' ),
		array( 'vc-material vc-material-cloud_queue' => 'cloud queue' ),
		array( 'vc-material vc-material-code' => 'code' ),
		array( 'vc-material vc-material-photo_library' => 'photo library' ),
		array( 'vc-material vc-material-collections_bookmark' => 'collections bookmark' ),
		array( 'vc-material vc-material-palette' => 'palette' ),
		array( 'vc-material vc-material-colorize' => 'colorize' ),
		array( 'vc-material vc-material-comment' => 'comment' ),
		array( 'vc-material vc-material-compare' => 'compare' ),
		array( 'vc-material vc-material-compare_arrows' => 'compare arrows' ),
		array( 'vc-material vc-material-laptop' => 'laptop' ),
		array( 'vc-material vc-material-confirmation_number' => 'confirmation number' ),
		array( 'vc-material vc-material-contact_mail' => 'contact mail' ),
		array( 'vc-material vc-material-contact_phone' => 'contact phone' ),
		array( 'vc-material vc-material-contacts' => 'contacts' ),
		array( 'vc-material vc-material-content_copy' => 'content copy' ),
		array( 'vc-material vc-material-content_cut' => 'content cut' ),
		array( 'vc-material vc-material-content_paste' => 'content paste' ),
		array( 'vc-material vc-material-control_point_duplicate' => 'control point duplicate' ),
		array( 'vc-material vc-material-copyright' => 'copyright' ),
		array( 'vc-material vc-material-mode_edit' => 'mode edit' ),
		array( 'vc-material vc-material-create_new_folder' => 'create new folder' ),
		array( 'vc-material vc-material-payment' => 'payment' ),
		array( 'vc-material vc-material-crop' => 'crop' ),
		array( 'vc-material vc-material-crop_16_9' => 'crop 16 9' ),
		array( 'vc-material vc-material-crop_3_2' => 'crop 3 2' ),
		array( 'vc-material vc-material-crop_landscape' => 'crop landscape' ),
		array( 'vc-material vc-material-crop_7_5' => 'crop 7 5' ),
		array( 'vc-material vc-material-crop_din' => 'crop din' ),
		array( 'vc-material vc-material-crop_free' => 'crop free' ),
		array( 'vc-material vc-material-crop_original' => 'crop original' ),
		array( 'vc-material vc-material-crop_portrait' => 'crop portrait' ),
		array( 'vc-material vc-material-crop_rotate' => 'crop rotate' ),
		array( 'vc-material vc-material-crop_square' => 'crop square' ),
		array( 'vc-material vc-material-dashboard' => 'dashboard' ),
		array( 'vc-material vc-material-data_usage' => 'data usage' ),
		array( 'vc-material vc-material-date_range' => 'date range' ),
		array( 'vc-material vc-material-dehaze' => 'dehaze' ),
		array( 'vc-material vc-material-delete' => 'delete' ),
		array( 'vc-material vc-material-delete_forever' => 'delete forever' ),
		array( 'vc-material vc-material-delete_sweep' => 'delete sweep' ),
		array( 'vc-material vc-material-description' => 'description' ),
		array( 'vc-material vc-material-desktop_mac' => 'desktop mac' ),
		array( 'vc-material vc-material-desktop_windows' => 'desktop windows' ),
		array( 'vc-material vc-material-details' => 'details' ),
		array( 'vc-material vc-material-developer_board' => 'developer board' ),
		array( 'vc-material vc-material-developer_mode' => 'developer mode' ),
		array( 'vc-material vc-material-device_hub' => 'device hub' ),
		array( 'vc-material vc-material-phonelink' => 'phonelink' ),
		array( 'vc-material vc-material-devices_other' => 'devices other' ),
		array( 'vc-material vc-material-dialer_sip' => 'dialer sip' ),
		array( 'vc-material vc-material-dialpad' => 'dialpad' ),
		array( 'vc-material vc-material-directions' => 'directions' ),
		array( 'vc-material vc-material-directions_bike' => 'directions bike' ),
		array( 'vc-material vc-material-directions_boat' => 'directions boat' ),
		array( 'vc-material vc-material-directions_bus' => 'directions bus' ),
		array( 'vc-material vc-material-directions_car' => 'directions car' ),
		array( 'vc-material vc-material-directions_railway' => 'directions railway' ),
		array( 'vc-material vc-material-directions_run' => 'directions run' ),
		array( 'vc-material vc-material-directions_transit' => 'directions transit' ),
		array( 'vc-material vc-material-directions_walk' => 'directions walk' ),
		array( 'vc-material vc-material-disc_full' => 'disc full' ),
		array( 'vc-material vc-material-dns' => 'dns' ),
		array( 'vc-material vc-material-not_interested' => 'not interested' ),
		array( 'vc-material vc-material-do_not_disturb_alt' => 'do not disturb alt' ),
		array( 'vc-material vc-material-do_not_disturb_off' => 'do not disturb off' ),
		array( 'vc-material vc-material-remove_circle' => 'remove circle' ),
		array( 'vc-material vc-material-dock' => 'dock' ),
		array( 'vc-material vc-material-done' => 'done' ),
		array( 'vc-material vc-material-done_all' => 'done all' ),
		array( 'vc-material vc-material-donut_large' => 'donut large' ),
		array( 'vc-material vc-material-donut_small' => 'donut small' ),
		array( 'vc-material vc-material-drafts' => 'drafts' ),
		array( 'vc-material vc-material-drag_handle' => 'drag handle' ),
		array( 'vc-material vc-material-time_to_leave' => 'time to leave' ),
		array( 'vc-material vc-material-dvr' => 'dvr' ),
		array( 'vc-material vc-material-edit_location' => 'edit location' ),
		array( 'vc-material vc-material-eject' => 'eject' ),
		array( 'vc-material vc-material-markunread' => 'markunread' ),
		array( 'vc-material vc-material-enhanced_encryption' => 'enhanced encryption' ),
		array( 'vc-material vc-material-equalizer' => 'equalizer' ),
		array( 'vc-material vc-material-error' => 'error' ),
		array( 'vc-material vc-material-error_outline' => 'error outline' ),
		array( 'vc-material vc-material-euro_symbol' => 'euro symbol' ),
		array( 'vc-material vc-material-ev_station' => 'ev station' ),
		array( 'vc-material vc-material-insert_invitation' => 'insert invitation' ),
		array( 'vc-material vc-material-event_available' => 'event available' ),
		array( 'vc-material vc-material-event_busy' => 'event busy' ),
		array( 'vc-material vc-material-event_note' => 'event note' ),
		array( 'vc-material vc-material-event_seat' => 'event seat' ),
		array( 'vc-material vc-material-exit_to_app' => 'exit to app' ),
		array( 'vc-material vc-material-expand_less' => 'expand less' ),
		array( 'vc-material vc-material-expand_more' => 'expand more' ),
		array( 'vc-material vc-material-explicit' => 'explicit' ),
		array( 'vc-material vc-material-explore' => 'explore' ),
		array( 'vc-material vc-material-exposure' => 'exposure' ),
		array( 'vc-material vc-material-exposure_neg_1' => 'exposure neg 1' ),
		array( 'vc-material vc-material-exposure_neg_2' => 'exposure neg 2' ),
		array( 'vc-material vc-material-exposure_plus_1' => 'exposure plus 1' ),
		array( 'vc-material vc-material-exposure_plus_2' => 'exposure plus 2' ),
		array( 'vc-material vc-material-exposure_zero' => 'exposure zero' ),
		array( 'vc-material vc-material-extension' => 'extension' ),
		array( 'vc-material vc-material-face' => 'face' ),
		array( 'vc-material vc-material-fast_forward' => 'fast forward' ),
		array( 'vc-material vc-material-fast_rewind' => 'fast rewind' ),
		array( 'vc-material vc-material-favorite' => 'favorite' ),
		array( 'vc-material vc-material-favorite_border' => 'favorite border' ),
		array( 'vc-material vc-material-featured_play_list' => 'featured play list' ),
		array( 'vc-material vc-material-featured_video' => 'featured video' ),
		array( 'vc-material vc-material-sms_failed' => 'sms failed' ),
		array( 'vc-material vc-material-fiber_dvr' => 'fiber dvr' ),
		array( 'vc-material vc-material-fiber_manual_record' => 'fiber manual record' ),
		array( 'vc-material vc-material-fiber_new' => 'fiber new' ),
		array( 'vc-material vc-material-fiber_pin' => 'fiber pin' ),
		array( 'vc-material vc-material-fiber_smart_record' => 'fiber smart record' ),
		array( 'vc-material vc-material-get_app' => 'get app' ),
		array( 'vc-material vc-material-file_upload' => 'file upload' ),
		array( 'vc-material vc-material-filter' => 'filter' ),
		array( 'vc-material vc-material-filter_1' => 'filter 1' ),
		array( 'vc-material vc-material-filter_2' => 'filter 2' ),
		array( 'vc-material vc-material-filter_3' => 'filter 3' ),
		array( 'vc-material vc-material-filter_4' => 'filter 4' ),
		array( 'vc-material vc-material-filter_5' => 'filter 5' ),
		array( 'vc-material vc-material-filter_6' => 'filter 6' ),
		array( 'vc-material vc-material-filter_7' => 'filter 7' ),
		array( 'vc-material vc-material-filter_8' => 'filter 8' ),
		array( 'vc-material vc-material-filter_9' => 'filter 9' ),
		array( 'vc-material vc-material-filter_9_plus' => 'filter 9 plus' ),
		array( 'vc-material vc-material-filter_b_and_w' => 'filter b and w' ),
		array( 'vc-material vc-material-filter_center_focus' => 'filter center focus' ),
		array( 'vc-material vc-material-filter_drama' => 'filter drama' ),
		array( 'vc-material vc-material-filter_frames' => 'filter frames' ),
		array( 'vc-material vc-material-terrain' => 'terrain' ),
		array( 'vc-material vc-material-filter_list' => 'filter list' ),
		array( 'vc-material vc-material-filter_none' => 'filter none' ),
		array( 'vc-material vc-material-filter_tilt_shift' => 'filter tilt shift' ),
		array( 'vc-material vc-material-filter_vintage' => 'filter vintage' ),
		array( 'vc-material vc-material-find_in_page' => 'find in page' ),
		array( 'vc-material vc-material-find_replace' => 'find replace' ),
		array( 'vc-material vc-material-fingerprint' => 'fingerprint' ),
		array( 'vc-material vc-material-first_page' => 'first page' ),
		array( 'vc-material vc-material-fitness_center' => 'fitness center' ),
		array( 'vc-material vc-material-flare' => 'flare' ),
		array( 'vc-material vc-material-flash_auto' => 'flash auto' ),
		array( 'vc-material vc-material-flash_off' => 'flash off' ),
		array( 'vc-material vc-material-flash_on' => 'flash on' ),
		array( 'vc-material vc-material-flight_land' => 'flight land' ),
		array( 'vc-material vc-material-flight_takeoff' => 'flight takeoff' ),
		array( 'vc-material vc-material-flip' => 'flip' ),
		array( 'vc-material vc-material-flip_to_back' => 'flip to back' ),
		array( 'vc-material vc-material-flip_to_front' => 'flip to front' ),
		array( 'vc-material vc-material-folder' => 'folder' ),
		array( 'vc-material vc-material-folder_open' => 'folder open' ),
		array( 'vc-material vc-material-folder_shared' => 'folder shared' ),
		array( 'vc-material vc-material-folder_special' => 'folder special' ),
		array( 'vc-material vc-material-font_download' => 'font download' ),
		array( 'vc-material vc-material-format_align_center' => 'format align center' ),
		array( 'vc-material vc-material-format_align_justify' => 'format align justify' ),
		array( 'vc-material vc-material-format_align_left' => 'format align left' ),
		array( 'vc-material vc-material-format_align_right' => 'format align right' ),
		array( 'vc-material vc-material-format_bold' => 'format bold' ),
		array( 'vc-material vc-material-format_clear' => 'format clear' ),
		array( 'vc-material vc-material-format_color_fill' => 'format color fill' ),
		array( 'vc-material vc-material-format_color_reset' => 'format color reset' ),
		array( 'vc-material vc-material-format_color_text' => 'format color text' ),
		array( 'vc-material vc-material-format_indent_decrease' => 'format indent decrease' ),
		array( 'vc-material vc-material-format_indent_increase' => 'format indent increase' ),
		array( 'vc-material vc-material-format_italic' => 'format italic' ),
		array( 'vc-material vc-material-format_line_spacing' => 'format line spacing' ),
		array( 'vc-material vc-material-format_list_bulleted' => 'format list bulleted' ),
		array( 'vc-material vc-material-format_list_numbered' => 'format list numbered' ),
		array( 'vc-material vc-material-format_paint' => 'format paint' ),
		array( 'vc-material vc-material-format_quote' => 'format quote' ),
		array( 'vc-material vc-material-format_shapes' => 'format shapes' ),
		array( 'vc-material vc-material-format_size' => 'format size' ),
		array( 'vc-material vc-material-format_strikethrough' => 'format strikethrough' ),
		array( 'vc-material vc-material-format_textdirection_l_to_r' => 'format textdirection l to r' ),
		array( 'vc-material vc-material-format_textdirection_r_to_l' => 'format textdirection r to l' ),
		array( 'vc-material vc-material-format_underlined' => 'format underlined' ),
		array( 'vc-material vc-material-question_answer' => 'question answer' ),
		array( 'vc-material vc-material-forward' => 'forward' ),
		array( 'vc-material vc-material-forward_10' => 'forward 10' ),
		array( 'vc-material vc-material-forward_30' => 'forward 30' ),
		array( 'vc-material vc-material-forward_5' => 'forward 5' ),
		array( 'vc-material vc-material-free_breakfast' => 'free breakfast' ),
		array( 'vc-material vc-material-fullscreen' => 'fullscreen' ),
		array( 'vc-material vc-material-fullscreen_exit' => 'fullscreen exit' ),
		array( 'vc-material vc-material-functions' => 'functions' ),
		array( 'vc-material vc-material-g_translate' => 'g translate' ),
		array( 'vc-material vc-material-games' => 'games' ),
		array( 'vc-material vc-material-gavel' => 'gavel' ),
		array( 'vc-material vc-material-gesture' => 'gesture' ),
		array( 'vc-material vc-material-gif' => 'gif' ),
		array( 'vc-material vc-material-goat' => 'goat' ),
		array( 'vc-material vc-material-golf_course' => 'golf course' ),
		array( 'vc-material vc-material-my_location' => 'my location' ),
		array( 'vc-material vc-material-location_searching' => 'location searching' ),
		array( 'vc-material vc-material-location_disabled' => 'location disabled' ),
		array( 'vc-material vc-material-star' => 'star' ),
		array( 'vc-material vc-material-gradient' => 'gradient' ),
		array( 'vc-material vc-material-grain' => 'grain' ),
		array( 'vc-material vc-material-graphic_eq' => 'graphic eq' ),
		array( 'vc-material vc-material-grid_off' => 'grid off' ),
		array( 'vc-material vc-material-grid_on' => 'grid on' ),
		array( 'vc-material vc-material-people' => 'people' ),
		array( 'vc-material vc-material-group_add' => 'group add' ),
		array( 'vc-material vc-material-group_work' => 'group work' ),
		array( 'vc-material vc-material-hd' => 'hd' ),
		array( 'vc-material vc-material-hdr_off' => 'hdr off' ),
		array( 'vc-material vc-material-hdr_on' => 'hdr on' ),
		array( 'vc-material vc-material-hdr_strong' => 'hdr strong' ),
		array( 'vc-material vc-material-hdr_weak' => 'hdr weak' ),
		array( 'vc-material vc-material-headset' => 'headset' ),
		array( 'vc-material vc-material-headset_mic' => 'headset mic' ),
		array( 'vc-material vc-material-healing' => 'healing' ),
		array( 'vc-material vc-material-hearing' => 'hearing' ),
		array( 'vc-material vc-material-help' => 'help' ),
		array( 'vc-material vc-material-help_outline' => 'help outline' ),
		array( 'vc-material vc-material-high_quality' => 'high quality' ),
		array( 'vc-material vc-material-highlight' => 'highlight' ),
		array( 'vc-material vc-material-highlight_off' => 'highlight off' ),
		array( 'vc-material vc-material-restore' => 'restore' ),
		array( 'vc-material vc-material-home' => 'home' ),
		array( 'vc-material vc-material-hot_tub' => 'hot tub' ),
		array( 'vc-material vc-material-local_hotel' => 'local hotel' ),
		array( 'vc-material vc-material-hourglass_empty' => 'hourglass empty' ),
		array( 'vc-material vc-material-hourglass_full' => 'hourglass full' ),
		array( 'vc-material vc-material-http' => 'http' ),
		array( 'vc-material vc-material-lock' => 'lock' ),
		array( 'vc-material vc-material-photo' => 'photo' ),
		array( 'vc-material vc-material-image_aspect_ratio' => 'image aspect ratio' ),
		array( 'vc-material vc-material-import_contacts' => 'import contacts' ),
		array( 'vc-material vc-material-import_export' => 'import export' ),
		array( 'vc-material vc-material-important_devices' => 'important devices' ),
		array( 'vc-material vc-material-inbox' => 'inbox' ),
		array( 'vc-material vc-material-indeterminate_check_box' => 'indeterminate check box' ),
		array( 'vc-material vc-material-info' => 'info' ),
		array( 'vc-material vc-material-info_outline' => 'info outline' ),
		array( 'vc-material vc-material-input' => 'input' ),
		array( 'vc-material vc-material-insert_comment' => 'insert comment' ),
		array( 'vc-material vc-material-insert_drive_file' => 'insert drive file' ),
		array( 'vc-material vc-material-tag_faces' => 'tag faces' ),
		array( 'vc-material vc-material-link' => 'link' ),
		array( 'vc-material vc-material-invert_colors' => 'invert colors' ),
		array( 'vc-material vc-material-invert_colors_off' => 'invert colors off' ),
		array( 'vc-material vc-material-iso' => 'iso' ),
		array( 'vc-material vc-material-keyboard' => 'keyboard' ),
		array( 'vc-material vc-material-keyboard_arrow_down' => 'keyboard arrow down' ),
		array( 'vc-material vc-material-keyboard_arrow_left' => 'keyboard arrow left' ),
		array( 'vc-material vc-material-keyboard_arrow_right' => 'keyboard arrow right' ),
		array( 'vc-material vc-material-keyboard_arrow_up' => 'keyboard arrow up' ),
		array( 'vc-material vc-material-keyboard_backspace' => 'keyboard backspace' ),
		array( 'vc-material vc-material-keyboard_capslock' => 'keyboard capslock' ),
		array( 'vc-material vc-material-keyboard_hide' => 'keyboard hide' ),
		array( 'vc-material vc-material-keyboard_return' => 'keyboard return' ),
		array( 'vc-material vc-material-keyboard_tab' => 'keyboard tab' ),
		array( 'vc-material vc-material-keyboard_voice' => 'keyboard voice' ),
		array( 'vc-material vc-material-kitchen' => 'kitchen' ),
		array( 'vc-material vc-material-label' => 'label' ),
		array( 'vc-material vc-material-label_outline' => 'label outline' ),
		array( 'vc-material vc-material-language' => 'language' ),
		array( 'vc-material vc-material-laptop_chromebook' => 'laptop chromebook' ),
		array( 'vc-material vc-material-laptop_mac' => 'laptop mac' ),
		array( 'vc-material vc-material-laptop_windows' => 'laptop windows' ),
		array( 'vc-material vc-material-last_page' => 'last page' ),
		array( 'vc-material vc-material-open_in_new' => 'open in new' ),
		array( 'vc-material vc-material-layers' => 'layers' ),
		array( 'vc-material vc-material-layers_clear' => 'layers clear' ),
		array( 'vc-material vc-material-leak_add' => 'leak add' ),
		array( 'vc-material vc-material-leak_remove' => 'leak remove' ),
		array( 'vc-material vc-material-lens' => 'lens' ),
		array( 'vc-material vc-material-library_books' => 'library books' ),
		array( 'vc-material vc-material-library_music' => 'library music' ),
		array( 'vc-material vc-material-lightbulb_outline' => 'lightbulb outline' ),
		array( 'vc-material vc-material-line_style' => 'line style' ),
		array( 'vc-material vc-material-line_weight' => 'line weight' ),
		array( 'vc-material vc-material-linear_scale' => 'linear scale' ),
		array( 'vc-material vc-material-linked_camera' => 'linked camera' ),
		array( 'vc-material vc-material-list' => 'list' ),
		array( 'vc-material vc-material-live_help' => 'live help' ),
		array( 'vc-material vc-material-live_tv' => 'live tv' ),
		array( 'vc-material vc-material-local_play' => 'local play' ),
		array( 'vc-material vc-material-local_airport' => 'local airport' ),
		array( 'vc-material vc-material-local_atm' => 'local atm' ),
		array( 'vc-material vc-material-local_bar' => 'local bar' ),
		array( 'vc-material vc-material-local_cafe' => 'local cafe' ),
		array( 'vc-material vc-material-local_car_wash' => 'local car wash' ),
		array( 'vc-material vc-material-local_convenience_store' => 'local convenience store' ),
		array( 'vc-material vc-material-restaurant_menu' => 'restaurant menu' ),
		array( 'vc-material vc-material-local_drink' => 'local drink' ),
		array( 'vc-material vc-material-local_florist' => 'local florist' ),
		array( 'vc-material vc-material-local_gas_station' => 'local gas station' ),
		array( 'vc-material vc-material-shopping_cart' => 'shopping cart' ),
		array( 'vc-material vc-material-local_hospital' => 'local hospital' ),
		array( 'vc-material vc-material-local_laundry_service' => 'local laundry service' ),
		array( 'vc-material vc-material-local_library' => 'local library' ),
		array( 'vc-material vc-material-local_mall' => 'local mall' ),
		array( 'vc-material vc-material-theaters' => 'theaters' ),
		array( 'vc-material vc-material-local_offer' => 'local offer' ),
		array( 'vc-material vc-material-local_parking' => 'local parking' ),
		array( 'vc-material vc-material-local_pharmacy' => 'local pharmacy' ),
		array( 'vc-material vc-material-local_pizza' => 'local pizza' ),
		array( 'vc-material vc-material-print' => 'print' ),
		array( 'vc-material vc-material-local_shipping' => 'local shipping' ),
		array( 'vc-material vc-material-local_taxi' => 'local taxi' ),
		array( 'vc-material vc-material-location_city' => 'location city' ),
		array( 'vc-material vc-material-location_off' => 'location off' ),
		array( 'vc-material vc-material-room' => 'room' ),
		array( 'vc-material vc-material-lock_open' => 'lock open' ),
		array( 'vc-material vc-material-lock_outline' => 'lock outline' ),
		array( 'vc-material vc-material-looks' => 'looks' ),
		array( 'vc-material vc-material-looks_3' => 'looks 3' ),
		array( 'vc-material vc-material-looks_4' => 'looks 4' ),
		array( 'vc-material vc-material-looks_5' => 'looks 5' ),
		array( 'vc-material vc-material-looks_6' => 'looks 6' ),
		array( 'vc-material vc-material-looks_one' => 'looks one' ),
		array( 'vc-material vc-material-looks_two' => 'looks two' ),
		array( 'vc-material vc-material-sync' => 'sync' ),
		array( 'vc-material vc-material-loupe' => 'loupe' ),
		array( 'vc-material vc-material-low_priority' => 'low priority' ),
		array( 'vc-material vc-material-loyalty' => 'loyalty' ),
		array( 'vc-material vc-material-mail_outline' => 'mail outline' ),
		array( 'vc-material vc-material-map' => 'map' ),
		array( 'vc-material vc-material-markunread_mailbox' => 'markunread mailbox' ),
		array( 'vc-material vc-material-memory' => 'memory' ),
		array( 'vc-material vc-material-menu' => 'menu' ),
		array( 'vc-material vc-material-message' => 'message' ),
		array( 'vc-material vc-material-mic' => 'mic' ),
		array( 'vc-material vc-material-mic_none' => 'mic none' ),
		array( 'vc-material vc-material-mic_off' => 'mic off' ),
		array( 'vc-material vc-material-mms' => 'mms' ),
		array( 'vc-material vc-material-mode_comment' => 'mode comment' ),
		array( 'vc-material vc-material-monetization_on' => 'monetization on' ),
		array( 'vc-material vc-material-money_off' => 'money off' ),
		array( 'vc-material vc-material-monochrome_photos' => 'monochrome photos' ),
		array( 'vc-material vc-material-mood_bad' => 'mood bad' ),
		array( 'vc-material vc-material-more' => 'more' ),
		array( 'vc-material vc-material-more_horiz' => 'more horiz' ),
		array( 'vc-material vc-material-more_vert' => 'more vert' ),
		array( 'vc-material vc-material-motorcycle' => 'motorcycle' ),
		array( 'vc-material vc-material-mouse' => 'mouse' ),
		array( 'vc-material vc-material-move_to_inbox' => 'move to inbox' ),
		array( 'vc-material vc-material-movie_creation' => 'movie creation' ),
		array( 'vc-material vc-material-movie_filter' => 'movie filter' ),
		array( 'vc-material vc-material-multiline_chart' => 'multiline chart' ),
		array( 'vc-material vc-material-music_note' => 'music note' ),
		array( 'vc-material vc-material-music_video' => 'music video' ),
		array( 'vc-material vc-material-nature' => 'nature' ),
		array( 'vc-material vc-material-nature_people' => 'nature people' ),
		array( 'vc-material vc-material-navigation' => 'navigation' ),
		array( 'vc-material vc-material-near_me' => 'near me' ),
		array( 'vc-material vc-material-network_cell' => 'network cell' ),
		array( 'vc-material vc-material-network_check' => 'network check' ),
		array( 'vc-material vc-material-network_locked' => 'network locked' ),
		array( 'vc-material vc-material-network_wifi' => 'network wifi' ),
		array( 'vc-material vc-material-new_releases' => 'new releases' ),
		array( 'vc-material vc-material-next_week' => 'next week' ),
		array( 'vc-material vc-material-nfc' => 'nfc' ),
		array( 'vc-material vc-material-no_encryption' => 'no encryption' ),
		array( 'vc-material vc-material-signal_cellular_no_sim' => 'signal cellular no sim' ),
		array( 'vc-material vc-material-note' => 'note' ),
		array( 'vc-material vc-material-note_add' => 'note add' ),
		array( 'vc-material vc-material-notifications' => 'notifications' ),
		array( 'vc-material vc-material-notifications_active' => 'notifications active' ),
		array( 'vc-material vc-material-notifications_none' => 'notifications none' ),
		array( 'vc-material vc-material-notifications_off' => 'notifications off' ),
		array( 'vc-material vc-material-notifications_paused' => 'notifications paused' ),
		array( 'vc-material vc-material-offline_pin' => 'offline pin' ),
		array( 'vc-material vc-material-ondemand_video' => 'ondemand video' ),
		array( 'vc-material vc-material-opacity' => 'opacity' ),
		array( 'vc-material vc-material-open_in_browser' => 'open in browser' ),
		array( 'vc-material vc-material-open_with' => 'open with' ),
		array( 'vc-material vc-material-pages' => 'pages' ),
		array( 'vc-material vc-material-pageview' => 'pageview' ),
		array( 'vc-material vc-material-pan_tool' => 'pan tool' ),
		array( 'vc-material vc-material-panorama' => 'panorama' ),
		array( 'vc-material vc-material-radio_button_unchecked' => 'radio button unchecked' ),
		array( 'vc-material vc-material-panorama_horizontal' => 'panorama horizontal' ),
		array( 'vc-material vc-material-panorama_vertical' => 'panorama vertical' ),
		array( 'vc-material vc-material-panorama_wide_angle' => 'panorama wide angle' ),
		array( 'vc-material vc-material-party_mode' => 'party mode' ),
		array( 'vc-material vc-material-pause' => 'pause' ),
		array( 'vc-material vc-material-pause_circle_filled' => 'pause circle filled' ),
		array( 'vc-material vc-material-pause_circle_outline' => 'pause circle outline' ),
		array( 'vc-material vc-material-people_outline' => 'people outline' ),
		array( 'vc-material vc-material-perm_camera_mic' => 'perm camera mic' ),
		array( 'vc-material vc-material-perm_contact_calendar' => 'perm contact calendar' ),
		array( 'vc-material vc-material-perm_data_setting' => 'perm data setting' ),
		array( 'vc-material vc-material-perm_device_information' => 'perm device information' ),
		array( 'vc-material vc-material-person_outline' => 'person outline' ),
		array( 'vc-material vc-material-perm_media' => 'perm media' ),
		array( 'vc-material vc-material-perm_phone_msg' => 'perm phone msg' ),
		array( 'vc-material vc-material-perm_scan_wifi' => 'perm scan wifi' ),
		array( 'vc-material vc-material-person' => 'person' ),
		array( 'vc-material vc-material-person_add' => 'person add' ),
		array( 'vc-material vc-material-person_pin' => 'person pin' ),
		array( 'vc-material vc-material-person_pin_circle' => 'person pin circle' ),
		array( 'vc-material vc-material-personal_video' => 'personal video' ),
		array( 'vc-material vc-material-pets' => 'pets' ),
		array( 'vc-material vc-material-phone_android' => 'phone android' ),
		array( 'vc-material vc-material-phone_bluetooth_speaker' => 'phone bluetooth speaker' ),
		array( 'vc-material vc-material-phone_forwarded' => 'phone forwarded' ),
		array( 'vc-material vc-material-phone_in_talk' => 'phone in talk' ),
		array( 'vc-material vc-material-phone_iphone' => 'phone iphone' ),
		array( 'vc-material vc-material-phone_locked' => 'phone locked' ),
		array( 'vc-material vc-material-phone_missed' => 'phone missed' ),
		array( 'vc-material vc-material-phone_paused' => 'phone paused' ),
		array( 'vc-material vc-material-phonelink_erase' => 'phonelink erase' ),
		array( 'vc-material vc-material-phonelink_lock' => 'phonelink lock' ),
		array( 'vc-material vc-material-phonelink_off' => 'phonelink off' ),
		array( 'vc-material vc-material-phonelink_ring' => 'phonelink ring' ),
		array( 'vc-material vc-material-phonelink_setup' => 'phonelink setup' ),
		array( 'vc-material vc-material-photo_album' => 'photo album' ),
		array( 'vc-material vc-material-photo_filter' => 'photo filter' ),
		array( 'vc-material vc-material-photo_size_select_actual' => 'photo size select actual' ),
		array( 'vc-material vc-material-photo_size_select_large' => 'photo size select large' ),
		array( 'vc-material vc-material-photo_size_select_small' => 'photo size select small' ),
		array( 'vc-material vc-material-picture_as_pdf' => 'picture as pdf' ),
		array( 'vc-material vc-material-picture_in_picture' => 'picture in picture' ),
		array( 'vc-material vc-material-picture_in_picture_alt' => 'picture in picture alt' ),
		array( 'vc-material vc-material-pie_chart' => 'pie chart' ),
		array( 'vc-material vc-material-pie_chart_outlined' => 'pie chart outlined' ),
		array( 'vc-material vc-material-pin_drop' => 'pin drop' ),
		array( 'vc-material vc-material-play_arrow' => 'play arrow' ),
		array( 'vc-material vc-material-play_circle_filled' => 'play circle filled' ),
		array( 'vc-material vc-material-play_circle_outline' => 'play circle outline' ),
		array( 'vc-material vc-material-play_for_work' => 'play for work' ),
		array( 'vc-material vc-material-playlist_add' => 'playlist add' ),
		array( 'vc-material vc-material-playlist_add_check' => 'playlist add check' ),
		array( 'vc-material vc-material-playlist_play' => 'playlist play' ),
		array( 'vc-material vc-material-plus_one' => 'plus one' ),
		array( 'vc-material vc-material-polymer' => 'polymer' ),
		array( 'vc-material vc-material-pool' => 'pool' ),
		array( 'vc-material vc-material-portable_wifi_off' => 'portable wifi off' ),
		array( 'vc-material vc-material-portrait' => 'portrait' ),
		array( 'vc-material vc-material-power' => 'power' ),
		array( 'vc-material vc-material-power_input' => 'power input' ),
		array( 'vc-material vc-material-power_settings_new' => 'power settings new' ),
		array( 'vc-material vc-material-pregnant_woman' => 'pregnant woman' ),
		array( 'vc-material vc-material-present_to_all' => 'present to all' ),
		array( 'vc-material vc-material-priority_high' => 'priority high' ),
		array( 'vc-material vc-material-public' => 'public' ),
		array( 'vc-material vc-material-publish' => 'publish' ),
		array( 'vc-material vc-material-queue_music' => 'queue music' ),
		array( 'vc-material vc-material-queue_play_next' => 'queue play next' ),
		array( 'vc-material vc-material-radio' => 'radio' ),
		array( 'vc-material vc-material-radio_button_checked' => 'radio button checked' ),
		array( 'vc-material vc-material-rate_review' => 'rate review' ),
		array( 'vc-material vc-material-receipt' => 'receipt' ),
		array( 'vc-material vc-material-recent_actors' => 'recent actors' ),
		array( 'vc-material vc-material-record_voice_over' => 'record voice over' ),
		array( 'vc-material vc-material-redo' => 'redo' ),
		array( 'vc-material vc-material-refresh' => 'refresh' ),
		array( 'vc-material vc-material-remove' => 'remove' ),
		array( 'vc-material vc-material-remove_circle_outline' => 'remove circle outline' ),
		array( 'vc-material vc-material-remove_from_queue' => 'remove from queue' ),
		array( 'vc-material vc-material-visibility' => 'visibility' ),
		array( 'vc-material vc-material-remove_shopping_cart' => 'remove shopping cart' ),
		array( 'vc-material vc-material-reorder' => 'reorder' ),
		array( 'vc-material vc-material-repeat' => 'repeat' ),
		array( 'vc-material vc-material-repeat_one' => 'repeat one' ),
		array( 'vc-material vc-material-replay' => 'replay' ),
		array( 'vc-material vc-material-replay_10' => 'replay 10' ),
		array( 'vc-material vc-material-replay_30' => 'replay 30' ),
		array( 'vc-material vc-material-replay_5' => 'replay 5' ),
		array( 'vc-material vc-material-reply' => 'reply' ),
		array( 'vc-material vc-material-reply_all' => 'reply all' ),
		array( 'vc-material vc-material-report' => 'report' ),
		array( 'vc-material vc-material-warning' => 'warning' ),
		array( 'vc-material vc-material-restaurant' => 'restaurant' ),
		array( 'vc-material vc-material-restore_page' => 'restore page' ),
		array( 'vc-material vc-material-ring_volume' => 'ring volume' ),
		array( 'vc-material vc-material-room_service' => 'room service' ),
		array( 'vc-material vc-material-rotate_90_degrees_ccw' => 'rotate 90 degrees ccw' ),
		array( 'vc-material vc-material-rotate_left' => 'rotate left' ),
		array( 'vc-material vc-material-rotate_right' => 'rotate right' ),
		array( 'vc-material vc-material-rounded_corner' => 'rounded corner' ),
		array( 'vc-material vc-material-router' => 'router' ),
		array( 'vc-material vc-material-rowing' => 'rowing' ),
		array( 'vc-material vc-material-rss_feed' => 'rss feed' ),
		array( 'vc-material vc-material-rv_hookup' => 'rv hookup' ),
		array( 'vc-material vc-material-satellite' => 'satellite' ),
		array( 'vc-material vc-material-save' => 'save' ),
		array( 'vc-material vc-material-scanner' => 'scanner' ),
		array( 'vc-material vc-material-school' => 'school' ),
		array( 'vc-material vc-material-screen_lock_landscape' => 'screen lock landscape' ),
		array( 'vc-material vc-material-screen_lock_portrait' => 'screen lock portrait' ),
		array( 'vc-material vc-material-screen_lock_rotation' => 'screen lock rotation' ),
		array( 'vc-material vc-material-screen_rotation' => 'screen rotation' ),
		array( 'vc-material vc-material-screen_share' => 'screen share' ),
		array( 'vc-material vc-material-sd_storage' => 'sd storage' ),
		array( 'vc-material vc-material-search' => 'search' ),
		array( 'vc-material vc-material-security' => 'security' ),
		array( 'vc-material vc-material-select_all' => 'select all' ),
		array( 'vc-material vc-material-send' => 'send' ),
		array( 'vc-material vc-material-sentiment_dissatisfied' => 'sentiment dissatisfied' ),
		array( 'vc-material vc-material-sentiment_neutral' => 'sentiment neutral' ),
		array( 'vc-material vc-material-sentiment_satisfied' => 'sentiment satisfied' ),
		array( 'vc-material vc-material-sentiment_very_dissatisfied' => 'sentiment very dissatisfied' ),
		array( 'vc-material vc-material-sentiment_very_satisfied' => 'sentiment very satisfied' ),
		array( 'vc-material vc-material-settings' => 'settings' ),
		array( 'vc-material vc-material-settings_applications' => 'settings applications' ),
		array( 'vc-material vc-material-settings_backup_restore' => 'settings backup restore' ),
		array( 'vc-material vc-material-settings_bluetooth' => 'settings bluetooth' ),
		array( 'vc-material vc-material-settings_brightness' => 'settings brightness' ),
		array( 'vc-material vc-material-settings_cell' => 'settings cell' ),
		array( 'vc-material vc-material-settings_ethernet' => 'settings ethernet' ),
		array( 'vc-material vc-material-settings_input_antenna' => 'settings input antenna' ),
		array( 'vc-material vc-material-settings_input_composite' => 'settings input composite' ),
		array( 'vc-material vc-material-settings_input_hdmi' => 'settings input hdmi' ),
		array( 'vc-material vc-material-settings_input_svideo' => 'settings input svideo' ),
		array( 'vc-material vc-material-settings_overscan' => 'settings overscan' ),
		array( 'vc-material vc-material-settings_phone' => 'settings phone' ),
		array( 'vc-material vc-material-settings_power' => 'settings power' ),
		array( 'vc-material vc-material-settings_remote' => 'settings remote' ),
		array( 'vc-material vc-material-settings_system_daydream' => 'settings system daydream' ),
		array( 'vc-material vc-material-settings_voice' => 'settings voice' ),
		array( 'vc-material vc-material-share' => 'share' ),
		array( 'vc-material vc-material-shop' => 'shop' ),
		array( 'vc-material vc-material-shop_two' => 'shop two' ),
		array( 'vc-material vc-material-shopping_basket' => 'shopping basket' ),
		array( 'vc-material vc-material-short_text' => 'short text' ),
		array( 'vc-material vc-material-show_chart' => 'show chart' ),
		array( 'vc-material vc-material-shuffle' => 'shuffle' ),
		array( 'vc-material vc-material-signal_cellular_4_bar' => 'signal cellular 4 bar' ),
		array( 'vc-material vc-material-signal_cellular_connected_no_internet_4_bar' => 'signal_cellular_connected_no internet 4 bar' ),
		array( 'vc-material vc-material-signal_cellular_null' => 'signal cellular null' ),
		array( 'vc-material vc-material-signal_cellular_off' => 'signal cellular off' ),
		array( 'vc-material vc-material-signal_wifi_4_bar' => 'signal wifi 4 bar' ),
		array( 'vc-material vc-material-signal_wifi_4_bar_lock' => 'signal wifi 4 bar lock' ),
		array( 'vc-material vc-material-signal_wifi_off' => 'signal wifi off' ),
		array( 'vc-material vc-material-sim_card' => 'sim card' ),
		array( 'vc-material vc-material-sim_card_alert' => 'sim card alert' ),
		array( 'vc-material vc-material-skip_next' => 'skip next' ),
		array( 'vc-material vc-material-skip_previous' => 'skip previous' ),
		array( 'vc-material vc-material-slideshow' => 'slideshow' ),
		array( 'vc-material vc-material-slow_motion_video' => 'slow motion video' ),
		array( 'vc-material vc-material-stay_primary_portrait' => 'stay primary portrait' ),
		array( 'vc-material vc-material-smoke_free' => 'smoke free' ),
		array( 'vc-material vc-material-smoking_rooms' => 'smoking rooms' ),
		array( 'vc-material vc-material-textsms' => 'textsms' ),
		array( 'vc-material vc-material-snooze' => 'snooze' ),
		array( 'vc-material vc-material-sort' => 'sort' ),
		array( 'vc-material vc-material-sort_by_alpha' => 'sort by alpha' ),
		array( 'vc-material vc-material-spa' => 'spa' ),
		array( 'vc-material vc-material-space_bar' => 'space bar' ),
		array( 'vc-material vc-material-speaker' => 'speaker' ),
		array( 'vc-material vc-material-speaker_group' => 'speaker group' ),
		array( 'vc-material vc-material-speaker_notes' => 'speaker notes' ),
		array( 'vc-material vc-material-speaker_notes_off' => 'speaker notes off' ),
		array( 'vc-material vc-material-speaker_phone' => 'speaker phone' ),
		array( 'vc-material vc-material-spellcheck' => 'spellcheck' ),
		array( 'vc-material vc-material-star_border' => 'star border' ),
		array( 'vc-material vc-material-star_half' => 'star half' ),
		array( 'vc-material vc-material-stars' => 'stars' ),
		array( 'vc-material vc-material-stay_primary_landscape' => 'stay primary landscape' ),
		array( 'vc-material vc-material-stop' => 'stop' ),
		array( 'vc-material vc-material-stop_screen_share' => 'stop screen share' ),
		array( 'vc-material vc-material-storage' => 'storage' ),
		array( 'vc-material vc-material-store_mall_directory' => 'store mall directory' ),
		array( 'vc-material vc-material-straighten' => 'straighten' ),
		array( 'vc-material vc-material-streetview' => 'streetview' ),
		array( 'vc-material vc-material-strikethrough_s' => 'strikethrough s' ),
		array( 'vc-material vc-material-style' => 'style' ),
		array( 'vc-material vc-material-subdirectory_arrow_left' => 'subdirectory arrow left' ),
		array( 'vc-material vc-material-subdirectory_arrow_right' => 'subdirectory arrow right' ),
		array( 'vc-material vc-material-subject' => 'subject' ),
		array( 'vc-material vc-material-subscriptions' => 'subscriptions' ),
		array( 'vc-material vc-material-subtitles' => 'subtitles' ),
		array( 'vc-material vc-material-subway' => 'subway' ),
		array( 'vc-material vc-material-supervisor_account' => 'supervisor account' ),
		array( 'vc-material vc-material-surround_sound' => 'surround sound' ),
		array( 'vc-material vc-material-swap_calls' => 'swap calls' ),
		array( 'vc-material vc-material-swap_horiz' => 'swap horiz' ),
		array( 'vc-material vc-material-swap_vert' => 'swap vert' ),
		array( 'vc-material vc-material-swap_vertical_circle' => 'swap vertical circle' ),
		array( 'vc-material vc-material-switch_camera' => 'switch camera' ),
		array( 'vc-material vc-material-switch_video' => 'switch video' ),
		array( 'vc-material vc-material-sync_disabled' => 'sync disabled' ),
		array( 'vc-material vc-material-sync_problem' => 'sync problem' ),
		array( 'vc-material vc-material-system_update' => 'system update' ),
		array( 'vc-material vc-material-system_update_alt' => 'system update alt' ),
		array( 'vc-material vc-material-tab' => 'tab' ),
		array( 'vc-material vc-material-tab_unselected' => 'tab unselected' ),
		array( 'vc-material vc-material-tablet' => 'tablet' ),
		array( 'vc-material vc-material-tablet_android' => 'tablet android' ),
		array( 'vc-material vc-material-tablet_mac' => 'tablet mac' ),
		array( 'vc-material vc-material-tap_and_play' => 'tap and play' ),
		array( 'vc-material vc-material-text_fields' => 'text fields' ),
		array( 'vc-material vc-material-text_format' => 'text format' ),
		array( 'vc-material vc-material-texture' => 'texture' ),
		array( 'vc-material vc-material-thumb_down' => 'thumb down' ),
		array( 'vc-material vc-material-thumb_up' => 'thumb up' ),
		array( 'vc-material vc-material-thumbs_up_down' => 'thumbs up down' ),
		array( 'vc-material vc-material-timelapse' => 'timelapse' ),
		array( 'vc-material vc-material-timeline' => 'timeline' ),
		array( 'vc-material vc-material-timer' => 'timer' ),
		array( 'vc-material vc-material-timer_10' => 'timer 10' ),
		array( 'vc-material vc-material-timer_3' => 'timer 3' ),
		array( 'vc-material vc-material-timer_off' => 'timer off' ),
		array( 'vc-material vc-material-title' => 'title' ),
		array( 'vc-material vc-material-toc' => 'toc' ),
		array( 'vc-material vc-material-today' => 'today' ),
		array( 'vc-material vc-material-toll' => 'toll' ),
		array( 'vc-material vc-material-tonality' => 'tonality' ),
		array( 'vc-material vc-material-touch_app' => 'touch app' ),
		array( 'vc-material vc-material-toys' => 'toys' ),
		array( 'vc-material vc-material-track_changes' => 'track changes' ),
		array( 'vc-material vc-material-traffic' => 'traffic' ),
		array( 'vc-material vc-material-train' => 'train' ),
		array( 'vc-material vc-material-tram' => 'tram' ),
		array( 'vc-material vc-material-transfer_within_a_station' => 'transfer within a station' ),
		array( 'vc-material vc-material-transform' => 'transform' ),
		array( 'vc-material vc-material-translate' => 'translate' ),
		array( 'vc-material vc-material-trending_down' => 'trending down' ),
		array( 'vc-material vc-material-trending_flat' => 'trending flat' ),
		array( 'vc-material vc-material-trending_up' => 'trending up' ),
		array( 'vc-material vc-material-tune' => 'tune' ),
		array( 'vc-material vc-material-tv' => 'tv' ),
		array( 'vc-material vc-material-unarchive' => 'unarchive' ),
		array( 'vc-material vc-material-undo' => 'undo' ),
		array( 'vc-material vc-material-unfold_less' => 'unfold less' ),
		array( 'vc-material vc-material-unfold_more' => 'unfold more' ),
		array( 'vc-material vc-material-update' => 'update' ),
		array( 'vc-material vc-material-usb' => 'usb' ),
		array( 'vc-material vc-material-verified_user' => 'verified user' ),
		array( 'vc-material vc-material-vertical_align_bottom' => 'vertical align bottom' ),
		array( 'vc-material vc-material-vertical_align_center' => 'vertical align center' ),
		array( 'vc-material vc-material-vertical_align_top' => 'vertical align top' ),
		array( 'vc-material vc-material-vibration' => 'vibration' ),
		array( 'vc-material vc-material-video_call' => 'video call' ),
		array( 'vc-material vc-material-video_label' => 'video label' ),
		array( 'vc-material vc-material-video_library' => 'video library' ),
		array( 'vc-material vc-material-videocam' => 'videocam' ),
		array( 'vc-material vc-material-videocam_off' => 'videocam off' ),
		array( 'vc-material vc-material-videogame_asset' => 'videogame asset' ),
		array( 'vc-material vc-material-view_agenda' => 'view agenda' ),
		array( 'vc-material vc-material-view_array' => 'view array' ),
		array( 'vc-material vc-material-view_carousel' => 'view carousel' ),
		array( 'vc-material vc-material-view_column' => 'view column' ),
		array( 'vc-material vc-material-view_comfy' => 'view comfy' ),
		array( 'vc-material vc-material-view_compact' => 'view compact' ),
		array( 'vc-material vc-material-view_day' => 'view day' ),
		array( 'vc-material vc-material-view_headline' => 'view headline' ),
		array( 'vc-material vc-material-view_list' => 'view list' ),
		array( 'vc-material vc-material-view_module' => 'view module' ),
		array( 'vc-material vc-material-view_quilt' => 'view quilt' ),
		array( 'vc-material vc-material-view_stream' => 'view stream' ),
		array( 'vc-material vc-material-view_week' => 'view week' ),
		array( 'vc-material vc-material-vignette' => 'vignette' ),
		array( 'vc-material vc-material-visibility_off' => 'visibility off' ),
		array( 'vc-material vc-material-voice_chat' => 'voice chat' ),
		array( 'vc-material vc-material-voicemail' => 'voicemail' ),
		array( 'vc-material vc-material-volume_down' => 'volume down' ),
		array( 'vc-material vc-material-volume_mute' => 'volume mute' ),
		array( 'vc-material vc-material-volume_off' => 'volume off' ),
		array( 'vc-material vc-material-volume_up' => 'volume up' ),
		array( 'vc-material vc-material-vpn_key' => 'vpn key' ),
		array( 'vc-material vc-material-vpn_lock' => 'vpn lock' ),
		array( 'vc-material vc-material-wallpaper' => 'wallpaper' ),
		array( 'vc-material vc-material-watch' => 'watch' ),
		array( 'vc-material vc-material-watch_later' => 'watch later' ),
		array( 'vc-material vc-material-wb_auto' => 'wb auto' ),
		array( 'vc-material vc-material-wb_incandescent' => 'wb incandescent' ),
		array( 'vc-material vc-material-wb_iridescent' => 'wb iridescent' ),
		array( 'vc-material vc-material-wb_sunny' => 'wb sunny' ),
		array( 'vc-material vc-material-wc' => 'wc' ),
		array( 'vc-material vc-material-web' => 'web' ),
		array( 'vc-material vc-material-web_asset' => 'web asset' ),
		array( 'vc-material vc-material-weekend' => 'weekend' ),
		array( 'vc-material vc-material-whatshot' => 'whatshot' ),
		array( 'vc-material vc-material-widgets' => 'widgets' ),
		array( 'vc-material vc-material-wifi' => 'wifi' ),
		array( 'vc-material vc-material-wifi_lock' => 'wifi lock' ),
		array( 'vc-material vc-material-wifi_tethering' => 'wifi tethering' ),
		array( 'vc-material vc-material-work' => 'work' ),
		array( 'vc-material vc-material-wrap_text' => 'wrap text' ),
		array( 'vc-material vc-material-youtube_searched_for' => 'youtube searched for' ),
		array( 'vc-material vc-material-zoom_in' => 'zoom in' ),
		array( 'vc-material vc-material-zoom_out' => 'zoom out' ),
		array( 'vc-material vc-material-zoom_out_map' => 'zoom out map' ),
	);

	return array_merge( $icons, $material );
}
