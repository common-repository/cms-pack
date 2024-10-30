<?php                                         


    class tpl1 extends baseTemplate{



        function view($content){        


            //$out='<h1>'.$this->imgText(get_the_title()).'</h1>';

            $img3=get_post_meta(get_the_ID(), '_tpl1_img3', true);

            // this method gets the meta-data of the image
            $meta=$this->getImageMeta($img3);

            $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);
            $bild=$this->getImage($img3,$width,$height,'some alt text',"round");    //generates resized image and imagetag 


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
            $fields->addInputLabel('Choose image');
            $fields->addImageSelectField($post_ID, '_tpl1_img3');     //varname in lowercase please

            return $fields;
        }

    }



    //Add to submenu selector
    $sub->addTemplate(array(
    'class_name'=>'tpl1',
    'desc'=>'Image and text'
    ));



?>
