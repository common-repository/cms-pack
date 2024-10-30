<?php
    class relationField{


        function __construct($post_ID,$id){
            $this->post_id=$post_ID;
            $this->id=$id;

        }


        function render(){

            $args=array(
            'post_type'=>'page',
            );
            $r= new WP_Query($args);
            $out.='<p><select name="'.$this->id.'">';

            $selected=' selected="selected" ';
            $saved=get_post_meta($this->post_id, $this->id, true);
            if ($r->have_posts()) : while ($r->have_posts()) : $r->the_post();

                    if(get_permalink()==$saved){
                        $out.='<option '.$selected.' value="'.get_permalink().'">'.
                        get_the_title().'</option>';


                    }else{

                        $out.='<option value="'.get_permalink().'">'.
                        get_the_title().'</option>';

                    }
                    EndWhile; 

                EndIf;
            $out.='</select></p>';

            // RESET THE QUERY
            wp_reset_query();

            return $out;



        }


        function save($postID){
            if($_POST[$this->id]){
                
                update_post_meta($postID, $this->id, $_POST[$this->id]) ;
                /*if ( !update_post_meta($postID, $this->id, $_POST[$this->id]) ){
                    add_post_meta($postID, $this->id, $_POST[$this->id]);
                }*/

            }


        }



    }
?>
