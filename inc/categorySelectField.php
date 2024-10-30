<?php      class  categorySelectField{

        function __construct($post_ID,$id,$pObj){
            $this->post_id=$post_ID;
            $this->id=$id;
            $this->pObj=$pObj;

        }




        
        function render(){


            

            $out.='<select name="'.$this->id.'" >';

            $categories = get_categories('type=post&orderby=name&hide_empty=0');

            if ($categories) {


                foreach($categories as $category){

                    if(get_post_meta($this->post_id, $this->id, true)==$category->cat_ID){
                        $out.='<option value="'.$category->cat_ID.'" selected="selected" >'. $category->cat_name.'</option>';
                    }else{
                        $out.='<option value="'.$category->cat_ID.'" >'. $category->cat_name.'</option>';
                    }
                
                }

                $out.='</select>';

            }

            return $out;

        }

        function save($postID){
            if($_POST[$this->id]){
                if ( !update_post_meta($postID, $this->id, $_POST[$this->id]) ){
                    add_post_meta($postID, $this->id, $_POST[$this->id]);
                }

            }


        }

    }
?>
