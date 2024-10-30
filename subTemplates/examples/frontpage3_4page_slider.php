<?php

    if(!is_admin()){ //we only want to include for frontend                           
        //  add_action('wp_print_scripts',array('tpl11','javascript_and_css'));

        add_action( 'template_redirect', array('tpl11','include_css_and_js_scripts'));
    }
    class tpl12 extends baseTemplate{


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



        function view($content){
            $t1=get_post_meta(get_the_ID(), '_tpl8_t1', true);
            $t2=get_post_meta(get_the_ID(), '_tpl8_t2', true);


            $p1=get_post_meta(get_the_ID(), '_tpl8_p1', true);

            $catId=get_post_meta(get_the_ID(), '_tpl8_c2', true);

            $p2=get_post_meta(get_the_ID(), '_tpl8_p2', true);

            $img3=get_post_meta(get_the_ID(), '_tpl8_img3', true);
            $img4=get_post_meta(get_the_ID(), '_tpl8_img4', true);

            $rgPostRoll=array();
            $rgPostRoll[1]['img']=get_post_meta(get_the_ID(), '_tpl8_img5', true);
            $rgPostRoll[1]['page']=get_post_meta(get_the_ID(), '_tpl8_p5', true);

            $rgPostRoll[2]['img']=get_post_meta(get_the_ID(), '_tpl8_img6', true);
            $rgPostRoll[2]['page']=get_post_meta(get_the_ID(), '_tpl8_p6', true);

            $rgPostRoll[3]['img']=get_post_meta(get_the_ID(), '_tpl8_img7', true);
            $rgPostRoll[3]['page']=get_post_meta(get_the_ID(), '_tpl8_p7', true);

            $rgPostRoll[4]['img']=get_post_meta(get_the_ID(), '_tpl8_img9', true);
            $rgPostRoll[4]['page']=get_post_meta(get_the_ID(), '_tpl8_p9', true);


            //  $bild3=$this->getImgById($img5,270,200,'some alt text');    //generates resized image and imagetag 






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

            $width=$this->getWebPageWidth();
           
           



            if(count($rgPostRoll)){
                foreach($rgPostRoll as $page){





                    $img=$this->getImage( $page['img'], $width, 400,'somealt');

                    $a=get_post($page['page']);


                    $out.='<div class="slide" >
                    <div class="slide-thumbnail">
                    <a href="'.get_permalink($page['page']).'" title="hh">'.$img.'</a>                </div>


                    <div class="slide-details" style="width:'.($width-2*24).'px">
                    <h2><a href="'.get_permalink($page['page']).'" rel="bookmark" title="Permanent Link to hh">'.$a->post_title.'</a></h2>
                    <div class="description">
                    <p>'.$this->exerpts($a->post_content).'</p>
                    </div>
                    </div>
                    <div class="clear"></div>
                    </div>';



                }
            }



            $out.='</div>';






 $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);




            $meta=$this->getImageMeta($img3);  
            $out.='<div style="float:left">'.$content.'</div>';   
            $out.='<div style="margin-bottom:40px;clear:both" ></div>';



            $bild=$this->getImgById($img3,$width,$height,'some alt text');    //generates resized image and imagetag 

            $bild2=$this->getImgById($img4,$width,$height,'some alt text');  //generates resized image and imagetag 



            $text1=$t1;
            $text2=$t2;

            $bild_w_link.='<a  href="'. get_permalink($p1).'">'.$bild.'</a>'; 



            $bild2_w_link.='<a  href="'. get_permalink($p2).'">'.$bild2.'</a>';  


            $out.='<div style="float:left;width:'.$width.'px">'.$bild_w_link;
            $out.='<br/><a  href="'. get_permalink($p1).'">'.$text1.'</a></div>';
            $out.='<div style="float:left;width:'.$width.'px">'.$bild2_w_link;
            $out.='<div  ><a  href="'. get_permalink($p2).'">'.$text2.'</a></div></div>
            <br style="clear:both" />';









            global $wp_query;



            $args=array(
            'post_type'=>'post',     
            //'category_name'=>'blog',
            //   'post_status'=>'publish',
            'cat'=>$catId,
            "posts_per_page"=>4
            );
            $my_query2 = new WP_Query($args);

            $i=0;

            if(count($my_query2->posts)){  

                foreach($my_query2->posts as $a){

                    if($i==0){
                        $out.='<div style="padding:10px;border:solid 10px #ccc;margin-top:10px;background-color:#bbb"><h2 >Lates blog post</h2><div style="width:240px;float:left">';

                    }
                    if($i==2){
                        $out.='</div><div style="width:250px;float:left">';

                    }
                    $i++;
                    //print_R($a); die;

                    $out.='<h4 style="font-weight:bold"><a  href="'. get_permalink($a->ID).'">'.$a->post_title.'</a></h4>';

                    $out.=$this->exerpts($a->post_content);
                }

                $out.='</div>
                <br style="clear:both" />
                </div>';
            }







            return $out;
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

            $fields->addInputLabel('Choose image');
            $fields->addImageSelectField($post_ID, '_tpl8_img5'); 
            $fields->addpageSelectField($post_ID, '_tpl8_p5');

            $fields->addInputLabel('Choose image');
            $fields->addImageSelectField($post_ID, '_tpl8_img6'); 
            $fields->addpageSelectField($post_ID, '_tpl8_p6');
            $fields->addColumn();


            $fields->addInputLabel('Choose image');
            $fields->addImageSelectField($post_ID, '_tpl8_img7'); 
            $fields->addpageSelectField($post_ID, '_tpl8_p7');

            $fields->addInputLabel('Choose image');
            $fields->addImageSelectField($post_ID, '_tpl8_img9'); 
            $fields->addpageSelectField($post_ID, '_tpl8_p9');



            $fields->addInputLabel('Choose post category');
            $fields->addCategorySelectField($post_ID, '_tpl8_c2');
            return $fields;
        }

    }




    //Add to submenu selector

    $sub->addTemplate(array(
    'class_name'=>'tpl12',
    'desc'=>'FP 4page slider'
    ));



?>
