<?php

    if(!is_admin()){ //we only want to include for frontend                           
        add_action( 'template_redirect', array('tpl5','include_css_and_js_scripts'));
    }



    class tpl5 extends baseTemplate{


        function include_css_and_js_scripts() {

            //    wp_enqueue_style('shade-cms-pack', WP_CONTENT_URL . '/plugins/cms-pack/shadow/shades/shadeImg2.css');

        }



        function view($content){

            $p1=get_post_meta(get_the_ID(), '_tpl5_p1', true);
            $p2=get_post_meta(get_the_ID(), '_tpl5_p2', true);

            $img3=get_post_meta(get_the_ID(), '_tpl5_img3', true);
            $img4=get_post_meta(get_the_ID(), '_tpl5_img4', true);

            $meta=$this->getImageMeta($img3);
            $out.=$content;   



            $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);




            $src=wp_get_attachment_image_src($img3,'full'); 
            $bild=$this->getImage($src[0],$width,$height,'some alt text','normal');    //generates resized image and imagetag 

            $src=wp_get_attachment_image_src($img4,'full'); 
            $bild2=$this->getImage($src[0],$width,$height,'some alt text','normal');  //generates resized image and imagetag 



            $text1="Simple coverflow";
            $text2="Billeder";




            $bild_w_shade.='<a  href="'. get_permalink($p1).'">'.$bild.'</a>'; 




            $bild2_w_shade.='<a  href="'. get_permalink($p2).'">'.$bild2.'</a>';  



            $out.='<div style="float:left;width:'.$width.'px">'.$bild_w_shade;
            $out.='<br/><a  href="'. get_permalink($p1).'">'.$text2.'</a></div>';
            $out.='<div style="float:left;width:'.$width.'px">'.$bild2_w_shade;
            $out.='<div  ><a  href="'. get_permalink($p2).'">'.$text1.'</a></div></div>';

            return $out;
        }


        function fields($post_ID){

            $fields= new fields();

            $fields->addInputLabel('Choose left image');
            $fields->addImageSelectField($post_ID, '_tpl5_img3');     //varname in lowercase please

            $fields->addInputLabel('Choose left page');
            $fields->addpageSelectField($post_ID, '_tpl5_p1');

            $fields->addColumn();

            $fields->addInputLabel('Choose right image');
            $fields->addImageSelectField($post_ID, '_tpl5_img4');

            $fields->addInputLabel('Choose right page');
            $fields->addpageSelectField($post_ID, '_tpl5_p2');




            $fields->addColumn();


            return $fields;
        }

    }



    //Add to submenu selector
    $sub->addTemplate(array(
    'class_name'=>'tpl5',
    'desc'=>'two img with link and shadow'
    ));  


?>
