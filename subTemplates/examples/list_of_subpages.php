<?php

    if(!is_admin()){ //we only want to include for frontend                           
        add_action( 'template_redirect', array('tpl3','include_css_and_js_scripts'));
    }



    class tpl10 extends baseTemplate{

        function include_css_and_js_scripts() {

            //wp_enqueue_style('shade-cms-pack', WP_CONTENT_URL . '/plugins/cms-pack/shadow/shades/shadeImg2.css');

        }



        function view($content){

            $text=get_post_meta(get_the_ID(), '_tpl10_t1', true);

            $out.='<div style="margin-left:20px;float:right;width 100px" >';



            $defaults = array( 
            'post_parent' => get_the_ID(),
            'post_type'   => 'page', 
            'numberposts' => -1,
            'post_status' => 'publish'
            );
            $children = get_children($defaults);






            if(count($children)){     
                $out.='<div style="padding:10px;border:solid 10px #ccc;margin-top:10px;background-color:#bbb"><h2 >'.$text.'</h2><div style="width:240px;float:left">';


                foreach($children  as $a){

                    //   print_R($a);

                    $out.='<h4 style="font-weight:bold"><a  href="'. get_permalink($a->ID).'">'.$a->post_title.'</a></h4>';


                }

                $out.='</div>
                <br style="clear:both" />
                ';
            
            $out.='</div>';
            }

            $out.='</div>';
            $out.=$content;








            return $out;
        }





        function fields($post_ID){

            $fields= new fields();                             
            $fields->addInputLabel('You will have a list of subtemplates');
            $fields->addTextField($post_ID, '_tpl10_t1');            
            return $fields;
        }

    }




    //Add to submenu selector

    $sub->addTemplate(array(
    'class_name'=>'tpl10',
    'desc'=>'List subpages'
    ));




?>
