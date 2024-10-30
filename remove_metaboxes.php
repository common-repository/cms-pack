<?php
    class removeMetas{
        public function __construct(){
            add_action('do_meta_boxes', array($this, 'removeMetaBoxes'), 10, 3);
        }

        public function removeMetaBoxes($type, $context, $post){
            /**
            * usages
            * remove_meta_box($id, $page, $context)
            * add_meta_box($id, $title, $callback, $page, $context = 'advanced', $priority = 'default')
            */
            $boxes = array(    'slugdiv', 'postexcerpt', 'passworddiv', 'categorydiv',
            'tagsdiv', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv',
            'authordiv', 'revisionsdiv', 'postcustom','postimagediv','postdivrich');

            foreach ($boxes as $box){
                foreach (array('link', 'post', 'page') as $page){
                    foreach (array('normal', 'advanced', 'side') as $context){
                        remove_meta_box($box, $type, $context);
                    }
                }
            }
        }
    }

    $post_ID = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta($post_ID,'_wp_page_template',TRUE);


    if ($template_file == 'home.php')
    {
        $removeMetas = new removeMetas();
    }

?>
