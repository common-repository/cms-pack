<?php                                         

    if(!is_admin()){ //we only want to include for frontend                           
        add_action( 'template_redirect', array('tpl6','include_css_and_js_scripts'));
    }


    class tpl6 extends baseTemplate{



        function include_css_and_js_scripts() {

            //    wp_enqueue_style('shade-cms-pack', WP_CONTENT_URL . '/plugins/cms-pack/shadow/shades/shadeImg2.css');

        }


        function view($content){        


            $img3=get_post_meta(get_the_ID(), '_tpl1_img3', true);

            $meta=$this->getImageMeta($img3);

            
            
            $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);
            
            $bild=$this->getImage($img3,$width,$height,'some alt text','kant');    //generates resized image and imagetag 



            $out.= '<div style="margin-right:20px;margin-bottom:20px;float:left;font-size:70%"  class="">';



            $out.=$bild; 

            $out.='<div><b>'.$meta->post_title.'</b></div>';
            $out.='<div style="font-style:italic;line-height:10px;height:10px">'.$meta->post_content.'</div>';
            $out.='</div>';

            $out.=$content;   

            return $out;
        }


        function fields($post_ID){

            $fields= new fields();
            $fields->addInputLabel('Choose Image');
            $fields->addImageSelectField($post_ID, '_tpl1_img3');     //varname in lowercase please

            return $fields;
        }

    }



    //Add to submenu selector
    $sub->addTemplate(array(
    'class_name'=>'tpl6',
    'desc'=>'image w. shadow and text'
    ));



?>
