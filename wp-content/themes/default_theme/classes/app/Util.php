<?php
class Util {
	private function __construct() {}

    public static function get_query() {
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query, $param);

        return $query;
    }

    public static function which_temp() {
        $temp = 'other';
        if ( !is_admin() ) {
	        if ( is_search() ) {
	            $temp = 'search';
		    } elseif ( is_tag() ) {
	            $temp = 'tag';
		    } elseif ( is_404() ) {
	            $temp = '404';
		    } elseif ( is_date() ) {
	            $temp = 'date';
	        } elseif ( is_tax() ) {
	            $temp = 'tax';
	        } elseif ( is_author() ) {
	            $temp = 'author';
	        } elseif ( is_page() ) {
	            $temp = 'page';
	        } elseif ( is_attachment() ) {
	            $temp = 'attachment';
	        } elseif ( is_post_type_archive() ) {
	            $temp = 'archive';
	        } elseif ( is_single() ) {
	            $temp = 'single';
	        }
		} else {
	        $temp = 'admin';
		}

        return $temp;
    }

}
