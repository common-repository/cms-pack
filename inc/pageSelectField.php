<?php    
    class  pageSelectField {

        function __construct($post_ID,$id,$pObj){
            $this->post_id=$post_ID;
            $this->id=$id;
            $this->pObj=$pObj;

        }




        function select(){


            $args = array(
            'post_type' => 'page',
            'numberposts' => 200,

            );

            $output .='<ul>';


            $myposts = get_posts( $args );
            foreach( $myposts as $post ){   //setup_postdata();


                $post->ID;
                $post->post_content;
                //print_r($post)

                $output .= '<li ><a url="'.get_permalink($post->ID).'"  href="' .  $post->ID.'" >';



                $output .= $post->post_name;


                $output .= '</a></li>';

            }

            $output .='</ul>';



            return $output;



        }

        function render(){


            global $numInput;     //nasty
            $numInput++;

            if(get_post_meta($this->post_id, $this->id, true)){
                $link=   get_permalink(get_post_meta($this->post_id, $this->id, true));
            }
            $this->pObj->js[]=$this->id;

            $out='<a onclick="selectBrowser(\'page\',0,\''.$this->id.'\')" id="button_'.$this->id.'" href="#">[selectPage]</a>
            ';
            //$out.=wp_nav_menu(array('echo'=>false));
            $out.= '<div style="margin-top:6px" class="'.$this->id.'"><span >'.$link.'</span></div>

            <div ><input style="width: 300px; margin-top:5px;" value="'.get_post_meta($this->post_id, $this->id, true).'" id="'.$this->id.'" name="'.$this->id.'" type="hidden" />
            </div>

            ';
            return $out;

        }

        function save($postID){
            if($_POST[$this->id]){
                update_post_meta($postID, $this->id, $_POST[$this->id]);
                /* if ( !update_post_meta($postID, $this->id, $_POST[$this->id]) ){
                add_post_meta($postID, $this->id, $_POST[$this->id]);
                }*/
            }


        }

    }
?>
