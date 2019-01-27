<?php
  /**
   * @package Boss Child Theme
   * The parent theme functions are located at /boss/buddyboss-inc/theme-functions.php
   * Add your own functions in this file.
   */

  /**
   * Sets up theme defaults
   *
   * @since Boss Child Theme 1.0.0
   */
  function boss_child_theme_setup()
  {
    /**
     * Makes child theme available for translation.
     * Translations can be added into the /languages/ directory.
     * Read more at: http://www.buddyboss.com/tutorials/language-translations/
     */

    // Translate text from the PARENT theme.
    load_theme_textdomain( 'boss', get_stylesheet_directory() . '/languages' );

    // Translate text from the CHILD theme only.
    // Change 'boss' instances in all child theme files to 'boss_child_theme'.
    // load_theme_textdomain( 'boss_child_theme', get_stylesheet_directory() . '/languages' );

  }
  add_action( 'after_setup_theme', 'boss_child_theme_setup' );

  /**
   * Enqueues scripts and styles for child theme front-end.
   *
   * @since Boss Child Theme  1.0.0
   */
  function boss_child_theme_scripts_styles()
  {
    /**
     * Scripts and Styles loaded by the parent theme can be unloaded if needed
     * using wp_deregister_script or wp_deregister_style.
     *
     * See the WordPress Codex for more information about those functions:
     * http://codex.wordpress.org/Function_Reference/wp_deregister_script
     * http://codex.wordpress.org/Function_Reference/wp_deregister_style
     **/

    /*
     * Styles & scripts
     */
    $rand = rand( 1, 99999999999 );
    wp_enqueue_style( 'font-overpass', 'https://fonts.googleapis.com/css?family=Overpass', '', $rand); 
    wp_enqueue_style( 'youzer-override', get_stylesheet_directory_uri().'/css/youzer-overrides.css', '', $rand);
    wp_enqueue_style( 'boss-child-custom', get_stylesheet_directory_uri().'/css/custom.css', '', $rand);
    
    wp_register_script( 'child-script', get_stylesheet_directory_uri() . '/js/custom.js', array(), $rand, true );

    $is_activity_dir_page = bp_is_activity_directory();
    $translation_array = array(
        'is_activity_dir' => $is_activity_dir_page,
    );
    wp_localize_script( 'child-script', 'js_data', $translation_array );
    wp_enqueue_script( 'child-script' );
  }
  add_action( 'wp_enqueue_scripts', 'boss_child_theme_scripts_styles', 9999 );


  /****************************** CUSTOM FUNCTIONS ******************************/

  // Add your own custom functions here

  function wpb_image_editor_default_to_gd( $editors ) {
      $gd_editor = 'WP_Image_Editor_GD';
      $editors = array_diff( $editors, array( $gd_editor ) );
      array_unshift( $editors, $gd_editor );
      return $editors;
  }
  add_filter( 'wp_image_editors', 'wpb_image_editor_default_to_gd' );


  add_filter( 'registration_redirect', 'my_redirect_home' );
  function my_redirect_home( $registration_redirect ) {
    return home_url();
  }

  add_action( 'woocommerce_checkout_before_customer_details', function() {
    echo do_shortcode('[woocommerce_social_login_buttons]');
  });

  // Remove zooming in on products
  function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
  }
  add_action( 'wp', 'remove_image_zoom_support', 100 );

  // Remove product image link
  add_filter('woocommerce_single_product_image_thumbnail_html','wc_remove_link_on_thumbnails' );
  function wc_remove_link_on_thumbnails( $html ) {
       return strip_tags( $html,'<img>' );
  }


  /**
   * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment
   * Tutorial: https://www.skyverge.com/blog/how-to-simplify-free-woocommerce-checkout/
   */
  function sv_free_checkout_fields() {
    
    // Bail we're not at checkout, or if we're at checkout but payment is needed
    if ( function_exists( 'is_checkout' ) && ( ! is_checkout() || ( is_checkout() && WC()->cart->needs_payment() ) ) ) {
      return;
    }
    
    // remove coupon forms since why would you want a coupon for a free cart??
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    
    // Remove the "Additional Info" order notes
    add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

    // Unset the fields we don't want in a free checkout
    /*function unset_unwanted_checkout_fields( $fields ) {
    
      // add or remove billing fields you do not want
      // list of fields: http://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/#section-2
      $billing_keys = array(
        'billing_company',
        'billing_phone',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_postcode',
        'billing_country',
        'billing_state',
      );

      // unset each of those unwanted fields
      foreach( $billing_keys as $key ) {
        unset( $fields['billing'][$key] );
      }
      
      return $fields;
    }
    add_filter( 'woocommerce_checkout_fields', 'unset_unwanted_checkout_fields' );*/
    
    // A tiny CSS tweak for the account fields; this is optional
    function print_custom_css() {
      echo '<style>.create-account { margin-top: 6em; }</style>';
    }
    add_action( 'wp_head', 'print_custom_css' );
  }
  add_action( 'wp', 'sv_free_checkout_fields' );

  // Free instead of $0.00
  add_filter( 'woocommerce_get_price_html', 'bbloomer_price_free_zero_empty', 100, 2 );
    
  function bbloomer_price_free_zero_empty( $price, $product ){
    if ( '' === $product->get_price() || 0 == $product->get_price() ) {
      $price = '<span class="woocommerce-Price-amount amount">FREE</span>';
    } 
    return $price;
  }

  // Paid memberships pro hook to add social login on checkout
  // echo do_shortcode( '[woocommerce_social_login_buttons return_url="http://dev.specialtactics.global/membership-account/membership-checkout"]' );
  // function pmp_social_login() {
  //   $previousPage = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //   echo do_shortcode( '[woocommerce_social_login_buttons return_url="' . $previousPage . '"]' );
  // }
  // add_action( 'pmpro_checkout_after_level_cost', 'pmp_social_login' );

  // Login page styles
  add_action( 'login_enqueue_scripts', 'wpse_login_styles' );
  function wpse_login_styles() {
      wp_enqueue_style( 'wpse-custom-login', get_stylesheet_directory_uri() . '/css/style-login.css' );
  }

  // // Adding social login to WP login form
  // function login_form_social_login() {
  //   $previousPage = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //   $defaultPage = "https://specialtactics.global";

  //   if ( is_user_logged_in() ) {
  //     echo do_shortcode( '[woocommerce_social_login_buttons return_url="' . $previousPage . '"]' );
  //   } else {
  //     echo do_shortcode( '[woocommerce_social_login_buttons return_url="' . $defaultPage . '"]' );
  //   }
  // }
  // add_action('login_form', 'login_form_social_login');


  // Logout Redirect
  add_action('wp_logout','auto_redirect_after_logout');
  function auto_redirect_after_logout(){
    wp_redirect( home_url() );
    exit();
  }


  // Buddypress - Users adding groups
  function buddypress_group_setup_nav() {
    if( bp_is_active( 'groups' ) ) {  
        global $bp;
        bp_core_new_subnav_item( array( 
            'parent_id' => 'groups',
            'name' => __( 'Create a Group', 'buddypress' ),
            'slug' => 'create',
            'parent_url' => $bp->loggedin_user->domain . $bp->groups->slug . '/',
            'parent_slug' => $bp->groups->slug,
            'screen_function' => 'group_document_list_function_to_show_screen',
            'position' => 55
        ) );
      }
  }
  add_action( 'bp_setup_nav', 'buddypress_group_setup_nav', PHP_INT_MAX );


  // Change register link on login page
  add_filter( 'register', 'sjaved_register_link' );
  function sjaved_register_link( $link ) {
    /*Required: Replace Register_URL with the URL of registration*/
    $custom_register_link = '/memberships';
    /*Optional: You can optionally change the register text e.g. Signup*/
    $register_text = 'Register';
    $link = '<a href="'.$custom_register_link.'">'.$register_text.'</a>';
      return $link;
  }

  /**
   * @snippet       Hide Price & Add to Cart for Logged Out Users
   * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
   * @sourcecode    https://businessbloomer.com/?p=299
   * @author        Rodolfo Melogli
   * @testedwith    WooCommerce 3.3.4
   * TODO: Add category of courses so no add to cart button on courses. Only on books. 
   */
   
  /*add_action( 'init', 'bbloomer_hide_price_add_cart_not_logged_in' );
   

  function bbloomer_hide_price_add_cart_not_logged_in() { 
    if ( !is_user_logged_in() ) {    

     remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
     remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
     add_action( 'woocommerce_single_product_summary', 'bbloomer_print_login_to_see', 31 );
     add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_print_login_to_see', 11 );
    }
  }
   
  function bbloomer_print_login_to_see() {
    echo '<a class="button add_to_cart_button" href="/memberships">' . __('Login or Sign up to see prices', 'boss_child') . '</a>';
  }
*/

  // Buddypress member types on register
  // Src: https://gist.github.com/strangerstudios/0086715ba551238b958f
  function changeMemberType($level_id, $user_id){
    //get user object
    $wp_user_object = new WP_User($user_id);
    if($level_id == 1 || $level_id == 2){
      //New member of level #1. Give them "Individual" BuddyPress Member Type.
      bp_set_member_type( $user_id, 'individual' );
    }
    elseif($level_id == 0){
      //Cancelling. Remove their member type.
      bp_set_member_type( $user_id, 'individual' );
    }
  }
  add_action("pmpro_after_change_membership_level", "changeMemberType", 10, 2);

function boss_bp_is_group_forum() {
      $retval = false;

      // At a forum URL.
      if ( bp_is_single_item() && bp_is_groups_component() && bp_is_current_action( 'forum' ) ) {
          $retval = true;

          // If at a forum URL, set back to false if forums are inactive, or not
          // installed correctly.
          if ( ! bp_is_active( 'forums' ) || ! bp_forums_is_installed_correctly() ) {
              $retval = false;
          }
      }

      return $retval;
}

// Enable visual editor for BBpress
function bbp_enable_visual_editor( $args = array() ) {
  $args['tinymce'] = true;
  $args['quicktags'] = false;
  $args['teeny'] = true;
  return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );


function buddyboss_remove_boss_main_script(){
    wp_dequeue_script( 'buddyboss-main' );
    wp_dequeue_script( 'boss-main-min' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_remove_boss_main_script', 999 );

function buddyboss_scripts_styles_child_customize(){
    global $bp;
    /**
     * Assign the Boss version to a var
     */
    $theme       = wp_get_theme( 'boss' );
    $boss_version  = $theme[ 'Version' ];
    // Used in js file to detect if we are using only mobile layout
    $only_mobile = false;
    // Main stylesheet
    if ( !is_admin() ) {
        // Switch between mobile and desktop
        if ( isset( $_COOKIE[ 'switch_mode' ] ) && ( boss_get_option( 'boss_layout_switcher' ) ) ) {
            if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
                $only_mobile = true;
            } else {
            }
            // Defaults
        } else {
            if ( is_phone() ) {
                $only_mobile = true;
            } elseif ( wp_is_mobile() ) {
                if ( boss_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
                } else {
                    $only_mobile = true;
                }
            } else {
                if ( boss_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
                    $only_mobile = true;
                } else {
                }
            }

        }

    }
    /*
     * Adds mobile JavaScript functionality.
     */
    if ( !is_admin() ) {
        wp_enqueue_script( 'idangerous-swiper', get_template_directory_uri() . '/js/swiper.jquery.js', array( 'jquery' ), '3.4.2', true );
    }

    $user_profile = null;

    if ( is_object( $bp ) && is_object( $bp->displayed_user ) && !empty( $bp->displayed_user->domain ) ) {
        $user_profile = $bp->displayed_user->domain;
    }

    /*
     * Adds UI scripts.
     */
    if ( !is_admin() ) {
        $translation_array = array(
            'only_mobile'      => $only_mobile,
            'comment_placeholder'  => __( 'Your Comment...', 'boss' ),
            'view_desktop'       => __( 'View as Desktop', 'boss' ),
            'view_mobile'      => __( 'View as Mobile', 'boss' )
        );
        $buddyboss_js_vars = array(
            'select_label'    => __( 'Show:', 'boss' ),
            'post_in_label'   => __( 'Post in:', 'boss' ),
            'tpl_url'     => get_template_directory_uri(),
            'child_url'     => get_stylesheet_directory_uri(),
            'user_profile'    => $user_profile,
            'excluded_inputs' => boss_get_option('boss_excluded_inputs'),
            'days'        => array( __( 'Monday', 'boss' ), __( 'Tuesday', 'boss' ), __( 'Wednesday', 'boss' ), __( 'Thursday', 'boss' ), __( 'Friday', 'boss' ), __( 'Saturday', 'boss' ), __( 'Sunday', 'boss' ) )
        );

        $buddyboss_js_vars = apply_filters( 'buddyboss_js_vars', $buddyboss_js_vars );

        /* Adds custom BuddyBoss JavaScript functionality. */

        wp_register_script( 'buddyboss-main-child', get_stylesheet_directory_uri() . '/js/buddyboss.js', array( 'jquery' ), $boss_version, true );

        wp_localize_script( 'buddyboss-main-child', 'translation', $translation_array );
        wp_localize_script( 'buddyboss-main-child', 'BuddyBossOptions', $buddyboss_js_vars );
        wp_enqueue_script( 'buddyboss-main-child' );
    }
}
add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_styles_child_customize', 999 );
