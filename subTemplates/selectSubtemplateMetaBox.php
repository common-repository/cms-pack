<?php
    


    class selectSubtemplateMetaBox{

        public $rg;
        public $templates;

        function addTemplate($template){
            $this->templates[]=$template;
        }

        function getTemplates(){
            return $this->templates;
        }

        function subTemplate(){


            global $post_ID;
            $subtemplate= get_post_meta($post_ID, '_subTemplate', true); 
            $out.='<select name="_subTemplate">';                
            $out.='<option  value="" >--select--</option>';

            foreach($this->templates as $template){

                if($subtemplate==$template['class_name']){
                    $selected=' selected="selected" ';
                }else{

                    $selected=' ';

                }

                $out.='<option '.$selected.' value="'.$template['class_name'].'">'.$template['desc'].'</option>';

            }

            $out.='</select>';
            echo $out;
        }



        function treePage(){

            if(function_exists('cms_tpv_print_common_tree_stuff')){
                cms_tpv_print_common_tree_stuff('page');
            }

        }


        function run(){


            $subtemplate= get_post_meta($post_ID, '_subTemplate', true); 
            add_meta_box("template-sims-sub", "select subtemplate", array($this,"subTemplate"), "page", "advanced");
          //  add_meta_box("template-sims-sub", "select subtemplate", array($this,"subTemplate"), "content", "side");




            if(function_exists('cms_tpv_print_common_tree_stuff')){

                add_meta_box("tree-page", "Pages", array($this,"treePage"), "page", "side");
            }


        }

        function save(){
            global $post_ID;     

            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            //sims look here for complete guide on what to do when saving
            //http://codex.wordpress.org/Function_Reference/add_meta_box
            //maybee look here about duplicate entries in custom fields
            //http://wordpress.stackexchange.com/questions/12056/automatically-set-post-title-to-same-value-as-a-meta-box
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
                return $post_ID;   

            update_post_meta($post_ID, '_subTemplate', $_POST['_subTemplate']) ;


        }
    }
    $sub=new selectSubtemplateMetaBox();
    add_action('admin_menu', array($sub,'run'));
    add_action('save_post',array($sub,'save'));

?>
