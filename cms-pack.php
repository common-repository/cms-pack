<?php
    /*
    Plugin Name: Cms Pack
    Plugin URI: 
    Description: 
    Version: 1.8
    Author: Simon Hansen
    Author URI: http://simonhans.dk/
    */


    $pos = strpos(WP_CONTENT_URL, $_SERVER['HTTP_HOST']) + strlen($_SERVER['HTTP_HOST']);

    define("CMS_PACK_CACHE", WP_CONTENT_DIR . '/uploads/cms-pack-cache/'); // thumbnail url
    define("CMS_PACK_CACHE_URL", substr(WP_CONTENT_URL, $pos)  . '/uploads/cms-pack-cache/'); // thumbnail url


    define("URL_THIS_FOLDER",dirname(WP_CONTENT_URL . '/plugins/'.plugin_basename(__FILE__)))  ;

    include_once(dirname(__file__).'/SimpleImage.php'); 
    include_once(dirname(__file__).'/remove_metaboxes.php');
    include_once(dirname(__file__).'/add_custom_content_type.php');
    include_once(dirname(__file__).'/inc/fields.php');
    include_once(dirname(__file__).'/inc/textField.php');
    include_once(dirname(__file__).'/inc/column.php');
    include_once(dirname(__file__).'/inc/imageField.php');
    include_once(dirname(__file__).'/inc/relationField.php');
    include_once(dirname(__file__).'/inc/textareaField.php');
    include_once(dirname(__file__).'/inc/imageSelectField.php');
    include_once(dirname(__file__).'/inc/pageSelectField.php');
    include_once(dirname(__file__).'/inc/inputLabel.php');
    include_once(dirname(__file__).'/inc/selectBrowser.php');
    include_once(dirname(__file__).'/inc/categorySelectField.php');
    include_once(dirname(__file__).'/inc/removeRte.php');
    include_once(dirname(__file__).'/submenu/submenu.php');
    include_once(dirname(__file__).'/warnings.php');            //fix the warnings
    include_once(dirname(__file__).'/gdShade.php');






    //skal includes efter da vi skal bruge getTimThumb

    //automatic inclusion of files in examples and your_templates folders

    // include_once(dirname(__file__).'/content/content.php'); //august 2012 ..muted this. post content on page. Not good idea.
    include_once(dirname(__file__).'/subTemplates/baseTemplate.php');
    include_once(dirname(__file__).'/subTemplates/selectSubtemplateMetaBox.php');
    $cpdir=dirname(__file__).'/subTemplates/examples/';
    if ($handle = opendir($cpdir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {

                if(strpos($file ,'.php')){
                    include_once(dirname(__file__).'/subTemplates/examples/'.$file );
                }
            }
        }
        closedir($handle);
    }


    $cpdir=dirname(__file__).'/subTemplates/your_templates/';
    if ($handle = opendir($cpdir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if(strpos($file ,'.php')){

                    include_once(dirname(__file__).'/subTemplates/examples/'.$file );

                }

            }
        }
        closedir($handle);
    }



    include_once(dirname(__file__).'/subTemplates/tplController.php');

    //include scripts for backend
    if(is_Admin()){
        $plugin_directory = dirname(plugin_basename(__FILE__)); 
        wp_enqueue_script('forside', URL_THIS_FOLDER .'/js.js', array('jquery'));


        require_once(  dirname(__FILE__). '/admin.php' );

    }


    





?>
