<?php
    /**
    * Administration functions for loading and displaying the settings page and saving settings 
    * are handled in this file.
    *
    * @package cms-pack
    */

    /* Initialize the theme admin functionality. */
    add_action( 'init', 'cms_pack_init' );
    define('cms_pack_DIR',dirname(__FILE__).'/');

    function cms_pack_init() {
        add_action( 'admin_menu', 'cms_pack_settings_page_init' );

        add_action( 'cms_pack_update_settings_page', 'cms_pack_save_settings' );
    }

    /**
    * Sets up the cms pack settings page and loads the appropriate functions when needed.
    *
    * @since 0.8
    */
    function cms_pack_settings_page_init() {
        global $cms_pack;

        /* Create the theme settings page. */
        $cms_pack->settings_page = add_theme_page( __( 'CMS Pack', 'cms-pack' ), __( 'CMS Pack', 'cms-pack' ), 'edit_theme_options', 'cms-pack', 'cms_pack_settings_page' );



        /* Register the default theme settings meta boxes. */
        add_action( "load-{$cms_pack->settings_page}", 'cms_pack_create_settings_meta_boxes' );

        /* Make sure the settings are saved. */
        add_action( "load-{$cms_pack->settings_page}", 'cms_pack_load_settings_page' );

        /* Load the JavaScript and stylehsheets needed for the theme settings. */
        add_action( "load-{$cms_pack->settings_page}", 'cms_pack_settings_page_enqueue_script' );
        add_action( "load-{$cms_pack->settings_page}", 'cms_pack_settings_page_enqueue_style' );
        add_action( "admin_head-{$cms_pack->settings_page}", 'cms_pack_settings_page_load_scripts' );
    }

    /**
    * Returns an array with the default plugin settings.
    *
    * @since 0.8
    */
    function cms_pack_settings() {
        $settings = array(
        'cms_pack_width'=>false,
        );
        return apply_filters( 'cms_pack_settings', $settings );
    }

    /**
    * Function run at load time of the settings page, which is useful for hooking save functions into.
    *
    * @since 0.8
    */
    function cms_pack_load_settings_page() {

        /* Get theme settings from the database. */
        $settings = get_option( 'cms_pack_settings' );

        /* If no settings are available, add the default settings to the database. */
        if ( empty( $settings ) ) {
            add_option( 'cms_pack_settings', cms_pack_settings(), '', 'yes' );

            /* Redirect the page so that the settings are reflected on the settings page. */
            wp_redirect( admin_url( 'themes.php?page=cms-pack' ) );
            exit;
        }

        /* If the form has been submitted, check the referer and execute available actions. */
        elseif ( isset( $_POST['cms-pack-settings-submit'] ) ) {

            /* Make sure the form is valid. */
            check_admin_referer( 'cms-pack-settings-page' );

            /* Available hook for saving settings. */
            do_action( 'cms_pack_update_settings_page' );

            /* Redirect the page so that the new settings are reflected on the settings page. */
            wp_redirect( admin_url( 'themes.php?page=cms-pack&updated=true' ) );
            exit;
        }
    }




    function cms_pack_validateHexcode($hexCode){


        if(preg_match('/^#[a-f0-9]{6}$/i', $hexCode) || preg_match('/^[a-f0-9]{6}$/i', $hexCode) ){

  
        }elseif(preg_match('/^#[a-f0-9]{3}$/i', $hexCode)|| preg_match('/^[a-f0-9]{3}$/i', $hexCode)){

            //if it is only 3 numbers double the length
            $hexCode=trim($hexCode,'#').trim($hexCode,'#');
        }else{

            $hexCode='ffffff';
        }

        return $hexCode; 


    }

    /**
    * Validates the plugin settings.
    *
    * @since 0.8
    */
    function cms_pack_save_settings() {

        /* Get the current theme settings. */
        $settings = get_option( 'cms_pack_settings' );

        $settings['cms_pack_width'] = esc_html( $_POST['cms_pack_width'] ); 

        $hexCode=cms_pack_validateHexcode( esc_html($_POST['cms_pack_bg_color'] )); 

        $settings['cms_pack_bg_color'] = $hexCode;



        /* Update the theme settings. */
        $updated = update_option( 'cms_pack_settings', $settings );



    }

    /**
    * Registers the plugin meta boxes for use on the settings page.
    *
    * @since 0.8
    */
    function cms_pack_create_settings_meta_boxes() {
        global $cms_pack;

        add_meta_box( 'cms-pack-about-meta-box', __( 'About CMS Pack', 'cms-pack' ), 'cms_pack_about_meta_box', $cms_pack->settings_page, 'normal', 'high' );

        add_meta_box( 'cms-pack-general-meta-box2', __( 'Cms Pack Setttings', 'cms-pack' ), 'cms_pack_general_meta_box', $cms_pack->settings_page, 'normal', 'high' );

    }

    /**
    * Displays the about meta box.
    *
    * @since 0.8
    */
    function cms_pack_about_meta_box() {
        $plugin_data = get_plugin_data( cms_pack_DIR . 'cms-pack.php' ); 
        echo 'Made by Simon Hansen. ';

    }

    /**
    * Displays the gallery settings meta box.
    *
    * @since 0.8
    */
    function cms_pack_general_meta_box() {

        $settings=get_option( 'cms_pack_settings' );


    ?>

    <table class="form-table">

        <tr>
            <th><?php _e( 'Content area Width:', 'cms-pack' ); ?></th>
            <td>
                <input id="cms-pack_width" name="cms_pack_width" type="input"  value="<?php echo $settings['cms_pack_width' ]; ?>" /> 
                <label for="cms-pack_width"><?php _e( 'Set width of content area', 'cms-pack' ); ?></label>
            </td>
        </tr>

        <tr>
            <th><?php _e( 'Background color of content area (HEX Code):', 'cms-pack' ); ?></th>
            <td>
                <input id="cms-pack_bg_color" name="cms_pack_bg_color" type="input"  value="<?php echo $settings['cms_pack_bg_color' ]; ?>" /> 
                <label for="cms-pack_width_bg_color"><?php _e( 'Set background color of content area', 'cms-pack' ); ?></label>
            </td>
        </tr>

    </table><!-- .form-table --><?php
    }




    /**
    * Displays a settings saved message.
    *
    * @since 0.8
    */
    function cms_pack_settings_update_message() { ?>
    <p class="updated fade below-h2" style="padding: 5px 10px;">
        <strong><?php _e( 'Settings saved.', 'cms-pack' ); ?></strong>
    </p><?php
    }

    /**
    * Outputs the HTML and calls the meta boxes for the settings page.
    *
    * @since 0.8
    */
    function cms_pack_settings_page() {
        global $cms_pack;

        $plugin_data = get_plugin_data( cms_pack_DIR . 'cms-pack.php' ); ?>

    <div class="wrap">

        <h2><?php _e( 'Cms Pack Settings', 'cms-pack' ); ?></h2>

        <?php if ( isset( $_GET['updated'] ) && 'true' == esc_attr( $_GET['updated'] ) ) cms_pack_settings_update_message(); ?>

        <div id="poststuff">

            <form method="post" action="<?php admin_url( 'themes.php?page=cms-pack' ); ?>">

                <?php wp_nonce_field( 'cms-pack-settings-page' ); ?>
                <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
                <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

                <div class="metabox-holder">
                    <div class="post-box-container column-1 normal"><?php do_meta_boxes( $cms_pack->settings_page, 'normal', $plugin_data ); ?></div>
                    <div class="post-box-container column-2 advanced"><?php do_meta_boxes( $cms_pack->settings_page, 'advanced', $plugin_data ); ?></div>
                    <div class="post-box-container column-3 side"><?php do_meta_boxes( $cms_pack->settings_page, 'side', $plugin_data ); ?></div>
                </div>

                <p class="submit" style="clear: both;">
                    <input type="submit" name="Submit"  class="button-primary" value="<?php _e( 'Update Settings', 'cms-pack' ); ?>" />
                    <input type="hidden" name="cms-pack-settings-submit" value="true" />
                </p><!-- .submit -->

            </form>

        </div><!-- #poststuff -->

    </div><!-- .wrap --><?php
    }

    /**
    * Loads the scripts needed for the settings page.
    *
    * @since 0.8
    */
    function cms_pack_settings_page_enqueue_script() {
        wp_enqueue_script( 'common' );
        wp_enqueue_script( 'wp-lists' );
        wp_enqueue_script( 'postbox' );
    }

    /**
    * Loads the stylesheets needed for the settings page.
    *
    * @since 0.8
    */
    function cms_pack_settings_page_enqueue_style() {
        wp_enqueue_style( 'cms-pack-admin', cms_pack_URL . 'admin.css', false, 0.7, 'screen' );
    }

    /**
    * Loads the metabox toggle JavaScript in the settings page head.
    *
    * @since 0.8
    */
    function cms_pack_settings_page_load_scripts() {
        global $cms_pack; ?>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
            postboxes.add_postbox_toggles( '<?php echo $cms_pack->settings_page; ?>' );
        });
        //]]>
    </script><?php
    }

?>