<?php      



    class  imageSelectField {

        function __construct($post_ID,$id,$pObj){
            $this->post_id=$post_ID;
            $this->id=$id;
            $this->pObj=$pObj;

        }




        function select($offset=0){







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
            'numberposts' => 10,
            'offset' => $offset,
            );


            $all= array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            );

            if(isset($this)){
                $this->num = count(get_children( $all));
            }
            #global $wpdb;
            #echo $wpdb->num_rows;die();

            /* Get image attachments. If none, return. */
            $attachments = get_children( $children );

            $output .='<ul>';

            foreach ($attachments as $id => $attachment ) {
                $img = wp_get_attachment_image_src( $id, 'thumbnail');

                /* Output the link. */
                $output .= '<li >'.$title.'<a  url="'.$img['0'].'" href="' .  $id.'" title="' . $title . '"' . $attributes . '>';



                $output .= '<img width="60px" src="' .   $img['0'] . '" alt="' . $title . '" style="" title="' . $title . '" />';


                $output .= '</a></li>';

            }

            $output .='</ul>';





            return $output;



        }

        function render(){


            global $numInput;     //nasty
            $numInput++;


            $this->pObj->js[]=$this->id;
            //   echo $this->select();

            $list=$this->select();

            for($i=0;$i<=ceil($this->num/10);$i++){

                $pagination.='<a  onclick="getImg('.($i*10).',\''.$this->id.'\')">['.$i.']</a>';

            }

            $out='<a onclick="selectBrowser(\'image\',0,\''.$this->id.'\')" id="button_'.$this->id.'" href="#">[select image]</a>';




            $img = wp_get_attachment_image_src( get_post_meta($this->post_id, $this->id, true), 'thumbnail');
            $out.= '<div  class="'.$this->id.'"> <img width="100px" src="' .   $img['0'] . '" alt="' . $title . '" style="float:left" title="' . $title . '" /></div>';


            $out.='<p><input style="width: 300px; margin-top:5px;" value="'.get_post_meta($this->post_id, $this->id, true).'" id="'.$this->id.'" name="'.$this->id.'" type="hidden" />


            </p><br style="clear:both" />    
            ';
            return $out;

        }

        function save($postID){
            if($_POST[$this->id]){



                update_post_meta($postID, $this->id, $_POST[$this->id]);

                /*
                // To create new meta
                if(!get_post_meta($postID, $this->id)){
                    add_post_meta($postID, $this->id, $_POST[$this->id]);
                }else{
                    // or to update existing meta
                    update_post_meta($postID, $this->id, $_POST[$this->id]);
                }*/




            }


        }

    }
?>
