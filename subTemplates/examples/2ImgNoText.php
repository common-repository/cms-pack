<?php                                         


    class tpl2 extends baseTemplate{



        function view($content){
            
            
            
            $width=$this->getWebPageWidth()/2;
            $height=floor($width/1.3);

            $thumb = get_post_meta(get_the_ID(), '_tpl2_bild', true);
            $out.=$this->getImage(CMS_PACK_CACHE.$thumb,$width,$height,'some alt text',"kant");    //generates resized image and imagetag 

            $thumb = get_post_meta(get_the_ID(), '_tpl2_bild2', true);
            $out.=$this->getImage(CMS_PACK_CACHE.$thumb,$width,$height,'some alt text',"kant");    //generates resized image and imagetag 



                

            
            

            return $out;
        }


        function fields($post_ID){

            $fields= new fields();
            $fields->addInputLabel('Add images');
            $fields->addImageField($post_ID, '_tpl2_bild'); //varname in lowercase please
            $fields->addColumn();
            $fields->addInputLabel('Add images');
            $fields->addImageField($post_ID, '_tpl2_bild2');
            $fields->addRemoveRte($post_ID);
            return $fields;
        }

    }


    //Add to submenu selector
  
    $sub->addTemplate(array(
    'class_name'=>'tpl2',
    'desc'=>'2 img, no text'
    ));



?>
