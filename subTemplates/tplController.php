<?php
    class tplcontroller{

        function Id(){

            global $post;       
            global $post_ID; //I think $post_ID is backend use and $post->ID is frontend

            if($post_ID==''){
                $post_ID=$post->ID;
            }
            return $post_ID;

        }

        /**
        * backend controller
        * 
        */
        function backendController(){    


            $subtemplate= get_post_meta($this->Id(), '_subTemplate', true);
            if($subtemplate and class_exists($subtemplate)){
                $tpl=new  $subtemplate();
            }


            if(is_object($tpl)){
                add_action('admin_menu', array($tpl,'setupMetaboxes'));
                add_action('save_post',array($tpl,'save'));
            }

                 
        }

        /**
        * Controller that decides what subtemplate to display
        * 
        * @param mixed $content
        */


        function controllerFrontend($content){


            $subtemplate= get_post_meta(get_the_ID(), '_subTemplate', true);
            if($subtemplate and class_exists($subtemplate)){
                $tpl=new  $subtemplate();
            }

           # global $post;
           # echo $post->ID;
            if(is_object($tpl)){

                return '<div class="cms-pack" >'.$tpl->view($content).'</div>';

            }else{
                return $content;

            }

        }


        /**
        * Frontend entrypoint
        * the controller must first be run in the hook "the_content" because we neew post ids 
        * 
        */
        function runController(){

            add_filter('the_content',array($this,'controllerFrontend'));



        }

    }


    $tplCtrl=new tplcontroller();
    if(is_admin()){
        add_action('init', array($tplCtrl,'backendController'));
    }else{
        add_action('template_redirect',array($tplCtrl,'runController'));

    }


?>
