<?php


    class simsmenu{

        public function __construct() {

            add_filter('wp_nav_menu_args', array($this, 'wp_nav_menu_args' ), 15, 1);

            // filter to show portions of nav menus
            add_filter('wp_get_nav_menu_items', array($this, 'wp_get_nav_menu_items' ), 15, 3);



        }

        function findCurrentMenuId($items){
            global $wp_query;

            foreach($items as $item){
                if($wp_query->queried_object->term_id==$item->object_id || $wp_query->post->ID==$item->object_id){

                    return $item->db_id;
                }

            }
        }

        /**
        * find menu_item_parent_id to a current menu db_id
        *
        * @param mixed $items
        * @param mixed $cur
        */

        function myParent($items,$cur){

            foreach($items as $item){

                if($item->db_id==$cur)
                {
                    return $item->menu_item_parent;

                }
            }

        }



        /**
        * put your comment there...
        *
        * @param mixed $items
        * @param mixed $cur
        * @return array
        */

        function isGrandFather($items,$cur){

            $parent_id=$this->myParent($items,$cur);

            $rgParent[]=$parent_id;

            if($parent_id!=0){
                $r= $this->isGrandFather($items,$parent_id);
            }
            if($r){
                $rgParent=array_merge($rgParent,$r);
            }
            return $rgParent;
        }




        function findSiblings($items,$pageId,$count=0){




            $rr=$this->rr;
            foreach($items as $item){

                if($item->menu_item_parent==$pageId)
                {


                    //hvis vi start fra f.eks level 2 vil vi ikke have current level
                    if($count){
                        $rg[]=$item->db_id;
                    }else{
                        $rg=array();
                    }


                    if($s){
                        $rg=array_merge($s,$rg);
                    }

                    // kun sibling hvis vi er i rootline
                    // eller på side
                    if( $item->db_id==$this->findCurrentMenuId($items)||@in_array($item->db_id,$rr)
                    ){
                        $count++;
                        global $endLevel;
                        global $startLevel;

                        if($count<=($endLevel+1)){
                            $p=$this->findSiblings($items,$item->db_id,$count);
                        }


                    }
                    if($p){

                        $rg=array_merge($rg,$p);
                    }
                }
            }

            return $rg;
        }  


        var $count;

        /**
        * filter menu args to get theme location for defining the menu to alter
        *
        * @param mixed $args
        */


        function wp_nav_menu_args($args){
            if($args['theme_location']=="submenu"){
                $this->t=1;

                return $args;
            }   else{
                $this->t=0;
                return $args;
            }        

        }
        public function wp_get_nav_menu_items($items, $menu, $args) {
            $this->count++;



            if (!$this->t) return $items;

            global $wp_query;

            $curr=$this->findCurrentMenuId($items);

            //rootline array // hvis samme side bruges flere steder er der problemer
            $this->rr=$this->isGrandFather($items,$curr);

            $this->level=array_reverse($this->rr);
            global $startLevel;
            global $endLevel; //attention endlevel means depth
            $offset=$startLevel;
            foreach($this->level as $level=>$pageId){
                if($offset<=$level and $endlevel<=$level){
                    $levels[$level]=$pageId;
                }
            }             

            $this->rr=$levels;

            $pageId=$this->level[$offset];
            $itemsChildren=$this->findSiblings($items,$pageId);



            $itemsInSub=array();
            //sorter
            foreach($items as $item){

                if( @in_array($item->db_id,$itemsChildren))
                {

                    if($item->menu_item_parent!=0){
                        $itemsInSub[]=$item;

                    }
                }
            }





            return $itemsInSub;
        }

    }               
    $startLevel;
    $endLevel;

    new simsmenu();

    include('cms-pack-submenu-widget.php');

?>
