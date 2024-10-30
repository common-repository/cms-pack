<?php

    if(!is_admin()){ //we only want to include for frontend                           
        add_action( 'template_redirect', array('tpl3','include_css_and_js_scripts'));
    }



    class tpl8 extends baseTemplate{

        function include_css_and_js_scripts() {

            //wp_enqueue_style('shade-cms-pack', WP_CONTENT_URL . '/plugins/cms-pack/shadow/shades/shadeImg2.css');

        }



        function view($content){

            $t1=get_post_meta(get_the_ID(), '_tpl8_t1', true);
            $t2=get_post_meta(get_the_ID(), '_tpl8_t2', true);


            $p1=get_post_meta(get_the_ID(), '_tpl8_p1', true);

            $catId=get_post_meta(get_the_ID(), '_tpl8_c2', true);

            $p2=get_post_meta(get_the_ID(), '_tpl8_p2', true);

            $img3=get_post_meta(get_the_ID(), '_tpl8_img3', true);
            $img4=get_post_meta(get_the_ID(), '_tpl8_img4', true);

            $img5=get_post_meta(get_the_ID(), '_tpl8_img5', true);

            
            $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);
            
            $bild3=$this->getImage($img5,$width,$height,'some alt text',"round");    //generates resized image and imagetag 


            $meta=$this->getImageMeta($img3);  
            $out.='<div style="width:258px;float:left">'.$content.'</div>';   
            $out.='<div style="width:'.$width.'px;padding-right:4px;float:right">'.$bild3.'</div><div style="margin-bottom:40px;clear:both" ></div>';




            $bild=$this->getImage($img3,$width,$height,'some alt text',"");    //generates resized image and imagetag 

            $bild2=$this->getImage($img4,$width,$height,'some alt text',"");  //generates resized image and imagetag 



            $text1=$t1;//$this->imgText($t1,12);
            $text2=$t2;//$this->imgText($t2,12);

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
                        $out.='<div style="padding:10px;border:solid 10px #ccc;margin-top:10px;background-color:#bbb"><h2 >Latest blog post</h2><div style="width:'.($width-15).'px;float:left">';

                    }
                    if($i==2){
                        $out.='</div><div style="width:'.($width-15).'px;float:left">';

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

            $fields->addInputLabel('Choose top image');
            $fields->addImageSelectField($post_ID, '_tpl8_img5'); 

            $fields->addInputLabel('Choose post category');
            $fields->addCategorySelectField($post_ID, '_tpl8_c2');
            return $fields;
        }

    }




    //Add to submenu selector

    $sub->addTemplate(array(
    'class_name'=>'tpl8',
    'desc'=>'Frontpage'
    ));



?>
