<?php

    if(!is_admin()){ //we only want to include for frontend                           
        //  add_action('wp_print_scripts',array('tpl11','javascript_and_css'));

        add_action( 'template_redirect', array('tpl11','include_css_and_js_scripts'));
    }
    class tpl11 extends baseTemplate{


        function javascript_and_css(){


            $out.=' <script type="text/javascript">
            jQuery(function() {
            jQuery("#slider-posts").cycle({
            fx:      "fade",
            timeout:  5000,
            prev:    "#prev",
            next:    "#next",
            pager:   "#slider-nav"
            });
            });
            </script>';

            // echo $out;
        }




        function include_css_and_js_scripts() {
            // wp_enqueue_script('jquery');
            wp_enqueue_script('shade-cms-pack-fjs', WP_CONTENT_URL . '/plugins/cms-pack/subTemplates/examples/jquery.cycle.min.js',array('jquery'));

        }

        
        /**
        * Get only posts with attached images
        * 
        */
        function getPostsAndPAgesWithImages(){
            global $wpdb;
            $result=$wpdb->get_results( "SELECT * FROM $wpdb->posts as thePost  WHERE (SELECT COUNT(*) FROM $wpdb->posts where post_parent=thePost.ID AND post_type='attachment')>0  ORDER BY post_date desc" ,'OBJECT');
            //print_r($my_query2);
            return $result;

        }

        function view($content){
            
            

            $out.=' <script type="text/javascript">
            jQuery(function() {
            jQuery("#slider-posts").cycle({
            fx:      "fade",
            timeout:  5000,
            prev:    "#prev",
            next:    "#next",
            pager:   "#slider-nav"
            });
            });
            </script>';

            $out.='
            <ul id="slider-nav"></ul>

            <div id="slider-posts">';



            $my_query2=$this->getPostsAndPAgesWithImages();


            if(count($my_query2)){
                foreach($my_query2 as $a){

                    //echo $a->ID;

                    $children = array(
                    'post_parent' => $a->ID,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => $order,
                    'orderby' => $orderby,
                    'numberposts' => 1,
                    );


                    $width=$this->getWebPageWidth();
                    /* Get image attachments. If none, return. */
                    $attachments = get_children( $children );

                    foreach ( $attachments as $id => $attachment ){
                        $img=$this->getImage( $id, $width, 400,'somealt');

                    }                      



                    $out.='<div class="slide" >
                    <div class="slide-thumbnail">
                    <a href="'.get_permalink($a->ID).'" title="hh">'.$img.'</a>                </div>

                    <div class="slide-details" style="width:'.($width-2*24).'px">
                    <h2><a href="'.get_permalink($a->ID).'" rel="bookmark" title="Permanent Link to hh">'.$a->post_title.'</a></h2>
                    <div class="description" >
                    <p>'.$this->exerpts($a->post_content).'</p>
                    </div>
                    </div>
                    <div class="clear"></div>
                    </div>';



                }
            }



            $out.='</div>';



            return $out.$content;
        }





        function fields($post_ID){

            $fields= new fields();

            $fields->addInputLabel('Choose left image');
            $fields->addImageSelectField($post_ID, '_tpl8_img3');     //varname in lowercase please

            $fields->addInputLabel('Choose left page');
            $fields->addpageSelectField($post_ID, '_tpl8_p1');

            $fields->addInputLabel('Left text');
            $fields->addTextField($post_ID, '_tpl8_t1');


            $fields->addColumn();

            $fields->addInputLabel('Choose right image');
            $fields->addImageSelectField($post_ID, '_tpl8_img4');

            $fields->addInputLabel('Choose right page');
            $fields->addpageSelectField($post_ID, '_tpl8_p2');

            $fields->addInputLabel('Right text');
            $fields->addTextField($post_ID, '_tpl8_t2');

            $fields->addColumn();

            $fields->addInputLabel('Choose top image');
            $fields->addImageSelectField($post_ID, '_tpl8_img5'); 

            $fields->addInputLabel('Choose post category');
            $fields->addCategorySelectField($post_ID, '_tpl8_c2');
            return $fields;
        }

    }




    //Add to submenu selector

    $sub->addTemplate(array(
    'class_name'=>'tpl11',
    'desc'=>'FP Post slider'
    ));



?>
