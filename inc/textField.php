<?php      class  textField {

        function __construct($post_ID,$id,$pObj){
            $this->post_id=$post_ID;
            $this->id=$id;
            $this->pObj=$pObj;

        }




        function select(){

            $args=array(
            'post_type'=>'attechment',
            );


            $children = array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $order,
            'orderby' => $orderby,
            'exclude' => $exclude,
            'include' => $include,
            'numberposts' => $numberposts,
            'offset' => $offset,
            );


            /* Get image attachments. If none, return. */
            $attachments = get_children( $children );

            $output .='<ul>';
            foreach ($attachments as $id => $attachment ) {
                $img = wp_get_attachment_image_src( $id, 'thumbnail');

                /* Output the link. */
                $output .= '<li >'.$title.'<a  href="' .  $img['0'].'" title="' . $title . '"' . $attributes . '>';



                $output .= '<img width="30px" src="' .   $img['0'] . '" alt="' . $title . '" style="float:left" title="' . $title . '" />';


                $output .= '</a></li>';

            }

            $output .='</ul>';



            return $output;



        }

        function render(){


            global $numInput;     //nasty
            $numInput++;


            //$this->pObj->js[]=$this->id;

            //$out='<a id="button_'.$this->id.'" href="#">[*]</a><div style="display:none" id="link_'.$this->id.'">';
            //$out.=wp_nav_menu(array('echo'=>false));
            // $out.=$this->select();
            //$out.='</div >';
            $out.='<p>
            <br />
            <input style="width: 300px; margin-top:5px;" value="'.get_post_meta($this->post_id, $this->id, true).'" id="'.$this->id.'" name="'.$this->id.'" type="text" />


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
