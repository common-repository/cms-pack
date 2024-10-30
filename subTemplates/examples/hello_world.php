<?php
    class newTpl extends baseTemplate{



        function view($content){



            $img3=get_post_meta(get_the_ID(), '_newtpl_img1', true);


            $width=$this->getWebPageWidth()/2-20;
            $height=floor($width/1.3);


            $out.=$this->getImage($img3,$width,$height,'some alt text',"round");    //generates resized image and imagetag 
            $out.=$this->getImage($img3,$width,$height,'some alt text',"kant");    //generates resized image and imagetag 
            $out.=$this->getImage($img3,$width,$height,'some alt text',"old");    //generates resized image and imagetag 
            $out.=$this->getImage($img3,$width,$height,'some alt text',"normal");    //generates resized image and imagetag 
            $out.=$this->getImage($img3,$width,$height,'some alt text',"");    //generates resized image and imagetag 






            return $out;


        }


        function fields($post_ID){

            $fields= new fields();
            $fields->addInputLabel('Select image');
            $fields->addImageSelectField($post_ID,'_newtpl_img1');   //varname in lowercase please

            return $fields;
        }

    }


    //Add to submenu selector

    $sub->addTemplate(array(
    'class_name'=>'newTpl',
    'desc'=>'Hello world'
    ));


?>
