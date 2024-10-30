<?php

    if(!is_admin()){ //we only want to include for frontend                           
        add_action( 'template_redirect', array('tpl9','include_css_and_js_scripts'));
    }



    class tpl9 extends baseTemplate{

        function include_css_and_js_scripts() {

            wp_enqueue_style('cms-pack-style', WP_CONTENT_URL . '/plugins/cms-pack/subTemplates/examples/style.css');

        }



        function view($content){

            $catId=get_post_meta(get_the_ID(), '_tpl9_c1', true);

            $out.='<div style="margin-left:20px;float:right;width 100px" >';


            global $wp_query;

            $args=array(
                'post_type'=>'post',     
                'cat'=>$catId,
                "posts_per_page"=>4
            );
            $my_query2 = new WP_Query($args);

            $i=0;

            if(count($my_query2->posts)){
                foreach($my_query2->posts as $a){

                    if($i==0){
                        $out.='<div class="cms-pack-box" >
                        <div class="cms-pack-box-left" ></div>

                        <div class="cms-pack-box-center" ></div>
                        <div class="cms-pack-box-right" ></div>


                        <div class="cms-pack-box-content" ><h2 style="margin-top:0px;padding:0px;" >Lates blog post</h2>';

                    }

                    $i++;
                    //print_R($a); die;

                    $out.='<h4 style="font-weight:bold"><a  href="'. get_permalink($a->ID).'">'.$a->post_title.'</a></h4>';

                    $out.=$this->exerpts($a->post_content);
                }

                $out.='







                </div>

                <div class="cms-pack-box-left-bottom" ></div>

                <div class="cms-pack-box-center-bottom" ></div>

                <div class="cms-pack-box-right-bottom" ></div>


                <br style="clear:both" />
                ';
            }
            $out.='</div> ';

            $out.='</div>';
            $out.=$content.'';








            return $out;
        }





        function fields($post_ID){

            $fields= new fields();                             
            $fields->addInputLabel('Select a post category');            
            $fields->addCategorySelectField($post_ID, '_tpl9_c1');
            return $fields;
        }

    }




    //Add to submenu selector

    $sub->addTemplate(array(
        'class_name'=>'tpl9',
        'desc'=>'List of posts'
    ));




?>
