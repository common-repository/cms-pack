<?php      class  textareaField {

        function __construct($post_ID,$id){
            $this->post_id=$post_ID;
            $this->id=$id;               

        }




        function render(){




            $out.='</div >';
            $out.='<p>
            <br />
            <textarea style="width: 500px;height:300px; margin-top:5px;"  id="'.$this->id.'" name="'.$this->id.'"  >'.get_post_meta($this->post_id, $this->id, true).'</textarea>


            </p>    
            ';
            return $out;

        }

        function save($postID){
            if($_POST[$this->id]){
                update_post_meta($postID, $this->id, $_POST[$this->id]);
                /*if ( !update_post_meta($postID, $this->id, $_POST[$this->id]) ){
                add_post_meta($postID, $this->id, $_POST[$this->id]);
                }*/

            }


        }

    }
?>
