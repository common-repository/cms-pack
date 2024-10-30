<?php
      /**
    * FooWidget Class
    */
    class cmsPackSubMenuWiget extends WP_Widget {
        /** constructor */
        function cmsPackSubMenuWiget() {
            parent::WP_Widget(false, $name = 'cms-pack submenu');    
        }

        /** @see WP_Widget::widget */
        function widget($args, $instance) {        
            extract( $args );
            $title = apply_filters('widget_title', $instance['title']);
        ?>
        <?php echo $before_widget; ?>
        <?php if ( $title )
                echo $before_title . $title . $after_title; 

            global   $startLevel;
            global $endLevel;

            $startLevel=esc_attr($instance['startLevel']);
            $endLevel   =esc_attr($instance['endLevel']);



            $menu      = isset( $instance['menu'] ) ? $instance['menu'] : '';

            $menu_args = array(
            'menu'     => $menu  ,
            'fallback_cb'=>'',
            'theme_location'=>'submenu',       //used to tell when to filter
            'container' => '',
            'menu_class'=> 'sister-pages',

            );

            wp_nav_menu($menu_args);



        ?>

        <?php echo $after_widget;




        ?>
        <?php
        }

        /** @see WP_Widget::update */
        function update($new_instance, $old_instance) {                


            $instance = $old_instance;

            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
            $instance['menu']  = (int) $new_instance['menu'];
            $instance['startLevel'] = strip_tags( stripslashes($new_instance['startLevel']) );
            $instance['endLevel'] = strip_tags( stripslashes($new_instance['endLevel']) );




            return $instance;
        }

        /** @see WP_Widget::form */
        function form($instance) {                
            $title = esc_attr($instance['title']);
            $menu      = isset( $instance['menu'] ) ? $instance['menu'] : '';
            $startLevel=esc_attr($instance['startLevel']);

            $endLevel=esc_attr($instance['endLevel']);
            // Get menus
            $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
            //            print_r($menus); 





        ?>
        <label for="<?php echo $this->get_field_id('menu'); ?>"><?php _e('Select menu:'); ?></label><br />   
        <select id="<?php echo $this->get_field_id('menu'); ?>" name="<?php echo $this->get_field_name('menu'); ?>"  >
            <?php 
                echo '<option value="">' . __('Select') . '</option>';


                foreach ( $menus as $_menu ) {

                    $selected = $menu == $_menu->term_id ? ' selected="selected"' : '';
                    echo '<option'. $selected .' value="'. $_menu->term_id .'">'. $_menu->name .'</option>';

                }    
            ?>
        </select></p>


        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            <label for="<?php echo $this->get_field_id('startLevel'); ?>"><?php _e('Start level:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('startLevel'); ?>" name="<?php echo $this->get_field_name('startLevel'); ?>" type="text" value="<?php echo $startLevel; ?>" />
            <label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('Depth'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('endLevel'); ?>" name="<?php echo $this->get_field_name('endLevel'); ?>" type="text" value="<?php echo $endLevel; ?>" />

        </p>
        <?php 




        }  

    } // class FooWidget
    add_action('widgets_init', create_function('', 'return register_widget("cmsPackSubMenuWiget");'));

?>
