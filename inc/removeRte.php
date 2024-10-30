<?php      class  removeRte{

        function __construct($post_ID,$id){
            $this->post_id=$post_ID;
            $this->id=$id;

        }




        function render(){


            $out.='

            <script type="text/javascript">
            jQuery("#editorcontainer").hide();
            jQuery("#post-status-info").hide();

            jQuery("#edButtonPreview").hide();

            jQuery("#edButtonHTML").hide();


            </script>

            ';
            return $out;

        }

        function save($postID){
            if($_POST[$this->id]){

                update_post_meta($postID, $this->id, $_POST[$this->id]);
                /*if ( !update_post_meta($postID, $this->id, $_POST[$this->id]) ){
                add_post_meta($postID, $this->id, $_POST[$this->id]);
                }

                */
            }


        }

    }
?>