<?php
class Queries {

    public function getSearchList($title, $types, $exclude, $draft, $published, $start=1) {
        global $wpdb;

        $results=array();

        $title=stripslashes($title);
        $like = "post_title LIKE '%$title%'";
        if (!empty($exclude)) {
            $post_exclude=" and ID not in (";
            $separator='';
            foreach($exclude as $key => $type) {
                $post_exclude .= $separator . "'" . $key . "'";
                $separator=',';
            }
            $post_exclude .= ")";
        } else
            $post_exclude='';

        $post_types="(";
        $separator='';
        foreach($types as $key => $type) {
            $post_types .= $separator . "'" . $type . "'";
            $separator=',';
        }
        $post_types .= ")";

        if ($draft) {
            if ($published)
                $status = "and post_status in ('draft','publish')";
            else
                $status = "and post_status in ('draft')";
        } else {
            if ($published)
                $status = "and post_status in ('publish')";
            else
                $status = '';
        }

        $start=($start-1)*CUSTOM_REFERENCEFIELD_POSTPERPAGE;
        $limit = " limit $start,".CUSTOM_REFERENCEFIELD_POSTPERPAGE;

        $querystr = "FROM $wpdb->posts wposts
                WHERE $like AND
                post_type IN $post_types $status $post_exclude";

        $countquery="select count(*) as n ".$querystr;
        $selectquery="select * ".$querystr.$limit;

        $row_count = $wpdb->get_row($countquery);
        $row_count = $row_count->n;

        $rows = $wpdb->get_results($selectquery);
        foreach($rows as $row) {
            $results[$row->ID]=$row;
        }

        return array('results'=>$results, 'info' => array('start'=>$start, 'records'=>$row_count));
    }

    public function getResults($types, $options) {

        return $this->getSearchList('', $types, $options['posts'], true, true);

    /*        $result=array();
        $args=array(
           'post_type'=> $types,
           'post__not_in' => $options['posts']
        );
        $the_query = new WP_Query($args);
        if ( $the_query->have_posts() ) {
            $result=$the_query->get_posts();
        }
        return $result;
     * */

    }

    public function getPost($post, $types) {
        $result=array();
        $args=array(
           'post_type'=> $types,
           'post__in' => array($post)
        );
        $the_query = new WP_Query($args);
        if( $the_query->have_posts())  {
            $result[$the_query->post->ID]=$the_query->get_posts();
        }
        return $result;
    }


}

?>
