<?php
    class cmsPackContent{

        function run(){
            add_meta_box('content-meta', 'post on page', array($this,'selectParent'),  'content', 'side');

            add_meta_box('content-meta', 'post on page', array($this,'selectChildrenOnpage'),  'page', 'side');

        }



        function selectChildrenOnpage(){

            global $post;
            global $post_ID;
            $args=array(
            'post_type'=>'content',     
            //'post_status'=>'publish',
            //'cat'=>$catId,
            'orderby'=>'menu_order',
            'order'=>'ASC',
            "post_parent"=>$post_ID,

            //"posts_per_page"=>10
            );

            echo '<a href="post-new.php?post_type=content&post_parent='.$post_ID.'" >New content</a><br>';


            Echo '<h4>Content on page</h4>';
            $my_query = new WP_Query($args);
            if(count($my_query->posts)){
                foreach($my_query->posts as $r){
                    #echo $r->post_parent;
                    echo '<a href="post.php?post='.$r->ID.'&action=edit" >'.$r->post_title.'</a><br>';


                }
            }


        }

        function selectParent() {


            global $post;
            global $post_ID;
            $args=array(
            'post_type'=>'content',     
            //'post_status'=>'publish',
            //'cat'=>$catId,
            'orderby'=>'menu_order',
            'order'=>'ASC',
            "post_parent"=>$post->post_parent,

            #"posts_per_page"=>10
            );
            echo '<a href="post.php?post='.$post->post_parent.'&action=edit" >Go to parent</a><br />';

            Echo '<h4>Content on same page</h4>';
            $my_query = new WP_Query($args);
            if(count($my_query->posts)){
                foreach($my_query->posts as $r){
                    //echo $r->post_parent;
                    echo '<a href="post.php?post='.$r->ID.'&action=edit" >'.$r->post_title.'</a><br>';

                }
            }


            if(!$post->post_parent){
                $post->post_parent=$_GET['post_parent'];
            }
            $pages = wp_dropdown_pages(array('post_type' => 'page', 'exclude_tree' => $post->ID, 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
            if ( ! empty($pages) ) {
            ?>
            <p><strong><?php _e('Parent') ?></strong></p>
            <label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
            <?php echo $pages; ?>
            <?php
            } // end empty pages check
            if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
                $template = !empty($post->page_template) ? $post->page_template : false;
            ?>
            <p><strong><?php _e('Template') ?></strong></p>
            <label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label><select name="page_template" id="page_template">
                <option value='default'><?php _e('Default Template'); ?></option>
                <?php page_template_dropdown($template); ?>
            </select>
            <?php
        } ?>
        <p><strong><?php _e('Order') ?></strong></p>
        <p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
        <p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.' ); ?></p>
        <?php
        }

    }



    function cmsPackContent($content){
        //echo $post_ID;
        $args=array(
        'post_type'=>'content',     
        //'category_name'=>'blog',
        //'post_status'=>'publish',
        //'cat'=>$catId,
        'orderby'=>'menu_order',
        'order'=>'ASC',
        "post_parent"=>get_the_ID(),
        "posts_per_page"=>10
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); 

                // print_r($my_query);
                //  echo $my_query->post->ID;
                $out.= '<h2>'.get_the_title().'</h2>';
                $out.= do_shortcode(get_the_content()) ;
                endwhile; endif; 

        return $content.$out;

    }


    function cmsPackSearch($rg,$obj){

        //ikke lavet
        // array( $search, &$this )
        //print_r($obj->is_search);
        if($obj->is_search){
        }
        return $rg;
    }
    function createContent_contentType(){

       // add_filter('posts_search', 'cmsPackSearch',true,2); 


        add_filter('the_content','cmsPackContent',100); //20 run after other the_content hook

        register_post_type( 'content',
        array(
        'labels' => array(
        'name' => __( 'Contents' ),
        'singular_name' => __( 'Content' )
        ),
        //'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions'),

        'supports' => array( 'editor','title'),
        'public' => true,
        'exclude_from_search'=>true,
        //below to remove from admin menu
        'show_in_menu'=>false, 
        //'taxonomies' => array( 'post_tag', 'category'),
        // 'taxonomies' => array( "gallery_categories"),
        // 'taxonomies' => array( "gallery_categories"),

        )
        );

    }



    add_action( 'init', 'createContent_contentType' );


    $cmsPackContent=new cmsPackContent();
    add_action('admin_menu', array($cmsPackContent,'run'));

?>
