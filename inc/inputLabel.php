<?php
    class inputLabel{


        function __construct($id){

            $this->id=$id;               

        }

                                 


                                                    
        function render(){


            $out.='<div style="margin-bottom:6px;margin-top:10px;font-weight:bold" >'.    $this->id.'</div/>';

                                                    
            return $out;

        }

        function save($postID){
        

        }
    }
?>
