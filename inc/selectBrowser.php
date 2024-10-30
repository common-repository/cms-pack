<?php
    session_start();


    add_action('wp_ajax_sims_action', 'simon_ajax_callback');





    // Act on AJAX-call
    function simon_ajax_callback() {

        //header("Content-type: application/json");
        global $wpdb; // this is how you get access to the database

        //$whatever = $_POST['whatever'];

        echo selectBrowser::select($_POST['offset']);
        //echo json_encode($rg);
        //echo 'dddddddddd';
        //exit;
        exit;
    }



    class selectBrowser{

        function selectPage($offset){

            $numPrPage=34;

            if($_POST['searching']){
                $_SESSION['cms-pack-searchword']=$_POST['searchword'];  
            }
            if($_SESSION['cms-pack-searchword']){ 

                $like=" AND post_title LIKE '%".$_SESSION['cms-pack-searchword']."%'";
            }

            $output .=  '<a style="float:right" onclick="jQuery(\'#browser\').css(\'display\',\'none\')" >close</a><br/>';
            $output .=  "Use the searchform to limit search";
            // $wpdb->query("SELECT id FROM $wpdb->posts WHERE post_type='page' " );

            $output .=  '<form name="search" method="post"><input id="inputVal" name="searchword" type="text" value="'.$_SESSION['cms-pack-searchword'].'" /><input onclick="selectBrowserSearch(\'page\',\'search\',0);return false" type="submit" value="search" /></form><br/>';


            global $wpdb;

            //number of rowws in db
            $rg=$wpdb->get_results( "SELECT id FROM $wpdb->posts WHERE post_type='page'  ".$like   );
            $num =count($rg);
            unset($rg);
            //current page to underline
            $currentpage=($offset/$numPrPage);

            for($i=0;$i<=(ceil($num /$numPrPage)-1);$i++){

                if($i==$currentpage){
                    $pagination.='<a style="cursor:pointer;text-decoration:underline;color:red" onclick="selectBrowser(\'page\','.($i*$numPrPage).',0)">['.$i.']</a>';

                }else{
                    $pagination.='<a style="cursor:pointer" onclick="selectBrowser(\'page\','.($i*$numPrPage).',0)">['.$i.']</a>';
                }
            }



            $output .=$pagination.'<ul><div style="border-bottom:solid 1px red;padding-bottom:4px;margin-bottom:6px"></div>';




            $myposts=$wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_type='page' ".$like." ORDER BY post_title LIMIT $numPrPage OFFSET $offset " );

            $i=0;
            foreach( $myposts as $post ){   //setup_postdata();




                if($i==0){

                    $output .='<ul style="float:left;width:360px;margin-right:40px " >';      
                }


                if(ceil($numPrPage/2)==$i){


                    $output .='</ul>';  } 
                if(ceil($numPrPage/2)==$i){

                    $output .='<ul style="float:left;width:360px " >';
                }

                $i++;



                $post->ID;
                $post->post_content;



                $info='<div><b>'.$post->post_title.'</b></div>';
                //$info.='<div>'.$post->post_excerpt.'</div>';
                //$info.='<div>'.$post->post_content.'</div>';
                //$info.='<div>'.$post->post_date.'</div>';  


                //print_r($post)

                $output .= '<li style="clear:both" ><div style="float:right">'.$info.'</div><a url="'.get_permalink($post->ID).'"  href="' .  $post->ID.'" >';



                $output .= $post->post_name;


                $output .= '</a></li>';

            }

            $output .='</ul>';



            return $output;



        }



        function selectImage($offset){

            $numPrPage=12;



            if($_POST['searching']){
                $_SESSION['cms-pack-searchword']=$_POST['searchword'];  
            }
            if($_SESSION['cms-pack-searchword']){ 

                $like=" AND post_title LIKE '%".$_SESSION['cms-pack-searchword']."%'";
            }

            $output .=  '<a style="float:right" onclick="jQuery(\'#browser\').css(\'display\',\'none\')" >close</a><br/>';
            $output .=  "Use the searchform to limit search";
            // $wpdb->query("SELECT id FROM $wpdb->posts WHERE post_type='page' " );

            $output .=  '<form name="search" method="post"><input id="inputVal" name="searchword" type="text" value="'.$_SESSION['cms-pack-searchword'].'" /><input onclick="selectBrowserSearch(\'image\',\'search\',0);return false" type="submit" value="search" /></form><br/>';





            /*
            * I had to use $wpdb->query  In the page select maybe its wrong here too
            */

            $children = array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $order,
            'orderby' => $orderby,
            'exclude' => $exclude,
            'include' => $include,
            'numberposts' => $numPrPage,
            'offset' => $offset,
            );

            /*
            $all= array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            );

            $num = count(get_children( $all));

            */
            global $wpdb;

            //number of rowws in db
            $rg=$wpdb->get_results( "SELECT id FROM $wpdb->posts WHERE post_type='attachment' and post_mime_type LIKE '%image%'  ".$like   );
            $num =count($rg);

            /* Get image attachments. If none, return. */

            $attachments =$wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_type='attachment' and post_mime_type LIKE '%image%'  ".$like ." ORDER BY id LIMIT $numPrPage OFFSET $offset ");

            //$attachments = get_children( $children );
            //current page to underline
            $currentpage=($offset/$numPrPage);



            for($i=0;$i<ceil($num /$numPrPage);$i++){

                ;  

                if($i==$currentpage){
                    $pagination.='<a style="cursor:pointer;text-decoration:underline;color:red" onclick="selectBrowser(\'image\','.($i*$numPrPage).',0)">['.$i.']</a>';

                }else{
                    $pagination.='<a style="cursor:pointer" onclick="selectBrowser(\'image\','.($i*$numPrPage).',0)">['.$i.']</a>';

                }

            }


            $output .=$pagination.'<div style="border-bottom:solid 1px red;padding-bottom:4px;margin-bottom:6px"></div>';

            $i=0;
            foreach ($attachments as  $attachment ) {



                if($i==0){

                    $output .='<ul style="float:left;width:360px;margin-right:40px " >';      
                }


                if(ceil($numPrPage/2)==$i){


                    $output .='</ul>';  } 
                if(ceil($numPrPage/2)==$i){

                    $output .='<ul style="float:left;width:360px " >';
                }

                $i++;
                $img = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
                $size = wp_get_attachment_image_src( $attachment->ID, 'full');
                
                

                $info='<div><b>'.$attachment->post_title.'</b></div>';
                // $info.='<div>'.$attachment->post_excerpt.'</div>';
                // $info.='<div>'.$attachment->post_content.'</div>';
                // $info.='<div>'.$attachment->post_date.'</div>';   
                /* Output the link. */
                $output .= '<div style="clear:both"><div style="float:right">'.$info.'<div style="float:right">'.$size[1].'x'.$size[2].'</div></div><a  url="'.$img['0'].'" href="' .  $attachment->ID.'" title="' . $title . '"' . $attributes . '>';



                $output .= '<img width="60px" height="60px" src="' .   $img['0'] . '" alt="' . $title . '" style="" title="' . $title . '" />';


                $output .= '</a>';                   
                $output.='</li>';






            }

            $output .='</ul>';

            //$this->cache($offset,$output);



            return $output;




        }   


        function cache($offset,$output){

            //cache fordi wordperess er langsom

            $filename = "ajax_".$offset.".txt";
            $path=dirname(__file__).'/../cache/'.$filename;
            $fh = fopen($path, 'w') or die("can't open file");
            $stringData = $output;
            fwrite($fh, $stringData);
            fclose($fh);


        }

        function select($offset=0){


            if( $_POST['mode']=='page'){
                echo self::selectPage($offset); die();
            }


            if( $_POST['mode']=='image'){
                echo self::selectImage($offset); die();
            }



        }


    }


    /*cache
    selectBrowser::selectImage(0);
    selectBrowser::selectImage(7);
    selectBrowser::selectImage(14);
    selectBrowser::selectImage(21);
    */

?>
