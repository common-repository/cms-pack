<?php                                         


    class baseTemplate{

        public $forPageId;
        public $subTplId;


        function getWebPageWidth(){
            $settings = get_option( 'cms_pack_settings' );

            if(!$settings['cms_pack_width']){
                return 500;
            }else{
                return $settings['cms_pack_width'];
            }
        }

        function getImageMeta($img3){


            $args = array(
            'post_type' => 'attachment',
            'numberposts' => null,
            'post_status' => null,
            'post__in'=>  array($img3)
            );

            $metas= get_posts($args);
            if ($metas) {
                foreach ($metas as  $meta) {

                }
            }        

            return $meta;

        }

        function convertUrlToServerPath($src){

            $srcRg= split('uploads',$src);
            $uploads=  wp_upload_dir();
            $src=$uploads['basedir'].$srcRg[1];
            return $src;


        }


        /**
        * use get image instead
        * specifie both width and height will cropscale. Only specifying one will scale
        * 
        * @param mixed $src
        * @param mixed $width
        * @param mixed $height
        * @param mixed $alt
        */

        function getImg($src,$width,$height, $alt=""){

            return $this->getImage($src,$width, $height, $alt="");

        }

        /**
        * specifie both width and height will cropscale. Only specifying one will scale
        * 
        * @param mixed $src  can be id or path
        * @param mixed $width
        * @param mixed $height
        * @param mixed $alt
        * @param mixed $style can be kant, old, normal or round
        */

        function getImage($src,$width,$height, $alt="",$style="", $dontCache=0){

            if(is_numeric($src)){
                $src=get_attached_file( $src,'full'); 
            }

            if(strstr($src,'http://')){        
                $src=$this->convertUrlToServerPath($src);
            }

            $image = new SimpleImage();
            $image->cacheDir=CMS_PACK_CACHE;
            $image->cacheDirUrl=CMS_PACK_CACHE_URL;
            return '<img src="'.$image->get($src,$width,$height,$style,$dontCache).'" alt="'.$alt.'" />';


        }


        /**
        * You shoud use getImage instead
        * 
        * @param mixed $id
        * @param mixed $width
        * @param mixed $height
        * @param mixed $alt
        */

        function getImgById($id,$width,$height, $alt=""){

            return $this->getImage($id,$width, $height, $alt);

        }


        /**
        * we want to strip some tags and preseve a tags
        * 
        * @param mixed $str
        */
        function exerpts($str){

            $str=preg_replace('/(\[.+?)+(\])/i', '', $str);  //remove wordpress shortcodes
            $text= substr(strip_tags($str,'<br/>'),0,100);  
            $out=$text.'...<br /><br />';
            return $out;

        }

        function imgText($text,$size){

            ob_start();

            if(function_exists('the_ttftext')){
                the_ttftext($text,'true',"basic",'font_size='.$size);
            }else{
                echo 'ttftext plugin not installed';
                return $text;
            }
            $text2=ob_get_contents();

            ob_end_clean();
            return $text2;
        }


        /**
        * method to decide when to use the subtemplate
        * 
        * @param mixed $id
        */

        /* function indcludeIf($id){
        $subtemplate= get_post_meta($id, '_subTemplate', true); 
        if($subtemplate==$this->subTplId){
        return true;
        }else{
        return true;
        }


        }

        function contentModOld_deprecated($content){


        if($this->indcludeIf(get_the_ID())){

        return '<div class="cms-pack" >'.$this->view($content).'</div>';

        }else{
        return $content;

        }

        }
        */
        /*
        function contentMod($content){


        $subtemplate= get_post_meta(get_the_ID(), '_subTemplate', true);
        if($subtemplate and class_exists($subtemplate)){
        $tpl=new  $subtemplate();
        }

        if(is_object($tpl)){

        return '<div class="cms-pack" >'.$tpl->view($content).'</div>';

        }else{
        return $content;

        }

        }
        */




        /**
        * You will replace this in your template when you extend the basetemplate
        * 
        * @param mixed $content
        */

        function view($content){



            return $content;
        }


        /**
        * You will replace this in your template when you extend the basetemplate
        * 
        * @param mixed $content
        */
        function fields(){

        }




        /**
        * setup metaboxes
        * 
        */

        function setupMetaboxes(){

            if( function_exists("add_meta_box") ){


                add_meta_box("cmsPackSubTemplate", "Subtemplate", array($this,"renderMeta"),"page", "advanced");

                //    add_meta_box("cmsPackSubTemplate", "Subtemplate", array($this,"renderMeta"),"content", "advanced");






            }

        }



        /**
        * Code for the meta box.
        */
        function renderMeta(){
            global $post_ID;

            global $fields;

            $out.='<script type="text/javascript">


            document.getElementById("post").setAttribute("enctype","multipart/form-data");
            document.getElementById("post").setAttribute("encoding","multipart/form-data");


            </script>';

            $out.=$this->fields->render();

            echo $out;

        }





        function save( $postID ){

            global $wpdb;

            // Get the correct post ID if revision.
            if ( $wpdb->get_var("SELECT post_type FROM $wpdb->posts WHERE ID=$postID")=='revision'){
                $postID = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE ID=$postID"); 
            }

            $this->fields->save($postID);


        }


        function print_r(){


            echo '<pre>';
            print_r($mylink);
            echo '</pre>';

        }

        function currentUrl(){
            return 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];


        }


        function addFields(){

            global $post_ID;

            $this->fields=$this->fields($post_ID);

        }

        function __construct($pageId=0){

            $this->forPageId=$pageId;
            $this->addFields();
        }

    }











?>
