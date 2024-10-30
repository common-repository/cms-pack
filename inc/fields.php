<?php    
    class fields{

        private $fields;
        public $js;


        function addInputLabel($label){

            $this->fields[]= new inputLabel($label);

        }



        function addRemoveRte($post_id,$id='dummy'){
            $this->fields[]= new removeRte($post_id,$id);

        }

        function addColumn($post_id='dummy',$id='dummy'){
            $this->fields[]= new column($post_id,$id);

        }

        function addTextField($post_id,$id){

            $this->fields[]= new textField($post_id,$id,$this);

        }

        function addCategorySelectField($post_id,$id){

            $this->fields[]= new categorySelectField($post_id,$id,$this);

        }

        function addImageSelectField($post_id,$id){

            $this->fields[]= new  imageSelectField($post_id,$id,$this);

        }


        function addpageSelectField($post_id,$id){

            $this->fields[]= new  pageSelectField($post_id,$id,$this);

        }



        function addTextareaField($post_id,$id){

            $this->fields[]= new textareaField($post_id,$id);

        }


        function addRelationField($post_id,$id){

            $this->fields[]=new relationField($post_id,$id);


        }

        function addImageField($post_id,$id){

            $this->fields[]= new imageField($post_id,$id);


        }


        function renderLabel($text){
            return '<br style="clear:both"/><p><label for="p75-thumbnail">'.__($text).':</label></p>'; 
        }


        function render(){

            if(is_array($this->fields)){

                $out.='<div style="float:left;margin-right:20px" >';
                foreach($this->fields as $field){        
                    $out.=$field->render($post_id,$id);

                }                         


                $out.='<p style="margin:10px 0 0 0;"><input id="publish" class="button-primary" type="submit" value="'. __("Update Post").'" accesskey="p" tabindex="5" name="save"/></p>';


                $out.='</div><div class="clear"></div>';
            }

            $j='<script type="text/javascript">

            var h=Array("';  

            if(is_array($this->js)){     

                foreach($this->js as $js){
                    $j.=$js.'","';

                }
            }


            $j.='k");</script>';


            return $j.$out;
        }


        function save($post_id){
            

            
            foreach($this->fields as $field){
                $field->save($post_id);

            }         
        }


    }
    
?>
