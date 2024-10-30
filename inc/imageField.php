<?php

    class imageField  {



        function __construct($post_ID,$id){
            $this->post_id=$post_ID;
            $this->id=$id;

        }




        function GetThumbnail($id,$postID)     {

            $width =200;
            $height=150;
            $filetype='jpg';

            if ( $thumb = get_post_meta($postID, $id, true) ){

                $resize= new SimpleImage();
                $resize->cacheDir=CMS_PACK_CACHE;
                $resize->cacheDirUrl=CMS_PACK_CACHE_URL;
                
                $img=$resize->get(CMS_PACK_CACHE.$thumb,100,100);

                return  $img;
            }
        }


        function render(){

            $thumb = $this->GetThumbnail($this->id,$this->post_id);
            if ( $thumb )
            {
                $out='<div style="float: left; margin-right: 10px;">
                <img style="border: 1px solid #ccc; padding: 3px;" src="'.$thumb . '" alt="Thumbnail preview" />
                </div>
                ';
            }
            else
            {
                $out='<div style="float: left; margin-right: 10px; width: 200px; height: 150px; line-height: 150px; border: solid 1px #ccc; text-align: center;">Thumbnail preview</div>';
            } 



            $out.='<p>
            <input id="p75-thumbnail" type="file" name="'.$this->id.'" />
            </p>
            <p><input id="p75-thumb-delete" type="checkbox" name="delete_'.$this->id.'"> <label for="p75-thumb-delete">'. __("Delete thumbnail").'</label></p><br style="clear:both"/>';

            return $out;



        }


        function save($postID){





            if ( $_POST['delete_'.$this->id] )
            {
                @unlink(CMS_PACK_CACHE . get_post_meta($postID, $this->id, true));
                delete_post_meta($postID, $this->id);
            }
            elseif ( !empty($_FILES[$this->id]['tmp_name']) )
            {
                if ( !empty($_FILES[$this->id]['name']) ){
                    preg_match("/(\.(?:jpg|jpeg|png|gif))$/i", $_FILES[$this->id]['name'], $matches);
                }
                $thumbFileName =time().$postID.'_'.$this->id. strtolower($matches[0]);

                // Location of thumbnail on server.
                $loc = CMS_PACK_CACHE . $thumbFileName;

                $thumbUploaded = false;


                // Attempt to move the uploaded thumbnail to the thumbnail directory.
                if ( !empty($_FILES[$this->id]['tmp_name']) && move_uploaded_file($_FILES[$this->id]['tmp_name'], $loc) )
                    $thumbUploaded = true;

                if ( $thumbUploaded )
                {

                    update_post_meta($postID, $this->id, $thumbFileName);

                    /*
                    if ( !update_post_meta($postID, $this->id, $thumbFileName) )
                    add_post_meta($postID, $this->id, $thumbFileName);
                    */
                }







            }





        }

    }

?>
