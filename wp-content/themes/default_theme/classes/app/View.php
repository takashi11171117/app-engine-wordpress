<?php
/**
 * View
 *
 * @package virtual
 */

/**
 * View
 */
class View {
    /**
    * @function get_post_type_month_link
    *
    * @param post_type(string) / year(Y)
    * @return string
    */
    public static function get_post_type_month_link($post_type, $year = '', $month = ''){
    	global $wp_rewrite;
    	$post_type_obj = get_post_type_object( $post_type );
    	if ( !$post_type_obj ) {
    		return false;
    	}
    	if ( !$post_type_obj->has_archive ) {
    		return false;
    	}
    	if ( !$year ) {
    		$year = gmdate('Y', current_time('timestamp'));
    	}
    	if ( !$month ) {
    		$month = gmdate('m', current_time('timestamp'));
    	}
    	$month = zeroise(intval($month), 2);
    	if ( get_option('permalink_structure') && is_array($post_type_obj->rewrite) ){
    		if ( $post_type_obj->has_archive === true ){
    			$struct = $year.'/'.$month.'/'.$post_type_obj->rewrite['slug'];
    		} else {
    			$struct = $year.'/'.$month.'/'.$post_type_obj->has_archive;
    		}

    		if ( $post_type_obj->rewrite['with_front'] ) {
    			$struct = $wp_rewrite->front.$struct;
    		} else {
    			$struct = $wp_rewrite->root.$struct;
    		}

    		$link = home_url( user_trailingslashit( $struct, 'post_type_archive' ) );
    	} else {
    		$link = home_url( '?year=' . $year . '&month=' . $month . '&post_type=' . $post_type );
    	}

    	return apply_filters('post_type_year_link', $link, $post_type);
    }

    /**
    * @function get_archives_array
    *
    * @param post_type(string) / period(string) / year(Y) / limit(int)
    * @return array
    */
    public static function get_archives_array($args = ''){
        global $wpdb, $wp_locale;

        $defaults = array(
            'post_type' => '',
            'period'    => 'monthly',
            'year'      => '',
            'limit'     => ''
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        if ( '' === $post_type ) {
            $post_type = 'post';
        } elseif ( 'any' === $post_type ){
            $post_types = get_post_types(array('public'=>true, '_builtin'=>false, 'show_ui'=>true));
            $post_type_ary = array();
            foreach ( $post_types as $post_type ) {
                $post_type_obj = get_post_type_object($post_type);
                if ( !$post_type_obj ) {
                    continue;
                }

                if ( $post_type_obj->has_archive === true ) {
                    $slug = $post_type_obj->rewrite['slug'];
                } else {
                    $slug = $post_type_obj->has_archive;
                }

                array_push($post_type_ary, $slug);
            }

            $post_type = join("', '", $post_type_ary);
        } else {
            if ( !post_type_exists($post_type) ) {
                return false;
            }
        }
        if ( '' === $period ) {
            $period = 'monthly';
        }
        if ( '' !== $year ) {
            $year = intval($year);
            $year = " AND DATE_FORMAT(post_date, '%Y') = ".$year;
        }
        if ( '' !== $limit ) {
            $limit = absint($limit);
            $limit = ' LIMIT '.$limit;
        }

        $where  = "WHERE post_type IN ('".$post_type."') AND post_status = 'publish'{$year}";
        $join   = "";
        $where  = apply_filters('getarchivesary_where', $where, $args);
        $join   = apply_filters('getarchivesary_join' , $join , $args);

        if ( 'monthly' === $period ) {
            $query = "SELECT YEAR(post_date) AS 'year', MONTH(post_date) AS 'month', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
        } elseif ( $period == 'yearly' ) {
            $query = "SELECT YEAR(post_date) AS 'year', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
        }

        $key = md5($query);
        $cache = wp_cache_get('get_archives_array', 'general');
        if ( !isset($cache[$key]) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[$key] = $arcresults;
            wp_cache_set('get_archives_array', $cache, 'general');
        } else {
            $arcresults = $cache[$key];
        }
        if ( $arcresults ) {
            $output = (array)$arcresults;
        }

        if ( empty($output) ) {
            return false;
        }

        return $output;
    }

    /**
     * パンくず関数
     *
     * @return string $str
     */
    public static function breadcrumb( $post, $temp, $query ){
        $str = '';
        if ( 'admin' !== $temp ) {
            $str .= '
            <div class="pankuzu">
                <div class="pankuzu_inner wr" class="clearfix">
                    <span><a href="'. esc_url( home_url() ) .'/">トップページ</a></span>';
            if ( 'ssearch' === $temp ) {
                $str.='<span>「'. get_search_query() .'」で検索した結果</span>';
            } elseif ( 'tag' === $temp ) {
                $str.='<span>タグ : '. single_tag_title( '' , false ). '</span>';
            } elseif ( '404' === $temp ) {
                $str.='<span>404 Not found</span>';
            } elseif ( 'date' === $temp ) {
                /*パーマリンクの設定によってはこっち
                $m = isset($_GET['m']) ? $_GET['m'] : '';
                $year = substr($m, 0, 4);
                $month = substr($m, 4, 2);
                $str .= '<li><a href="'.get_year_link($year).'">'.$year.'年</a></span>';
                $str .= '<li><a href="'.get_month_link($year, $month).'">'.$month.'月</a></span>';
                $str .= '<li>'.date('d日', strtotime($m)).'</span>';
                */

                if ( get_query_var('day') != 0 ){
                    $str .= '<span><a href="'. get_month_link( get_query_var('year'), get_query_var('monthnum') ) . '">' . get_query_var('monthnum') . '月</a></span>';
                    $str .= '<span>' . get_query_var('day') . '日</span>';
                } elseif(get_query_var('monthnum') != 0){
                    $str .= '<span>' . get_query_var('monthnum') . '月</span>';
                } else {
                    $str .= '<span>' . get_query_var('year') . '年</span>';
                }
            } elseif ( 'tax' === $temp ) {
                $taxs = array( "item_cat" => "製品情報" , "userreport_cat" => "ユーザーレポート", "fishing_cat" => "釣り情報", "hotnews_cat" => "お知らせ", "fishing_tag" => "釣り情報", "hotnews_tag" => "お知らせ" );
                foreach ( $taxs as $key => $tax ) {
                    if ( is_tax( $key ) ) {
                        $var = get_query_var($key);
                        $term = get_term_by( 'slug', $var, $key );
                        $str .= '<span><a href="' . esc_url(site_url()) . '/' . preg_replace( "/_cat|_tag/", '', $key ) . '">' . $tax . '</a></span>';
                        $str .= '<span class="active"><a href="">' . $term->name . '</a></span>';
                        break;
                    }
                }
            } elseif ( 'author' === $temp ) {
                $str .= '<span>投稿者 : ' . get_the_author_meta( 'display_name', get_query_var('author') ) . '</span>';
            } elseif ( 'page' === $temp ) {
                $post_title = $post->post_title;
                $str.= '<span class="active"><a href="">' . $post_title . '</a></span>';
            } elseif ( 'attachment' === $temp ) {
                if ( $post -> post_parent != 0 ){
                    $str .= '<span><a href="' . get_permalink($post -> post_parent) . '">' . get_the_title($post -> post_parent) . '</a></span>';
                }
                $str .= '<span>' . $post -> post_title . '</span>';
            } elseif ( 'single' === $temp ){
                $categories = get_the_terms( $post->ID, 'category' );
                foreach ( $categories as $cat ) {
                    $str .= '<span><a href="' . get_category_link($cat->term_id) . '">'. $cat->name . '</a></span>';
                }

                $str .= '<span class="active"><a href="#">' . Controller::get_archive_title( $post ) . '</a></span>';

            } else {
                $str.='<span><a href="#">'. wp_title('', false) .'</a></span>';
            }
            $str .= '</div>
            </div>';
        }
        echo $str;
    }

    /**
     * [cat_tag_list カテゴリとタグのリスト]
     *
     * @param  object $post ポストオブジェクト
     * @return string       htmlを返す
     */
    public static function cat_tag_list( $post ) {
        $cats = get_the_terms( $post->ID, 'category' );
        $tags = get_the_terms( $post->ID, 'post_tag' );?>
            <p class="time_cat">
                <?php
                    if ( isset( $cats ) && $cats ) {
                        foreach ( $cats as $value ) {
                            echo '<a href="" class="cat">' . esc_html( $value->name ) . '</a>';
                        }
                    }
                    if ( isset( $tags ) && $tags ) {
                        foreach ( $tags as $value ) {
                            echo '<a href="" class="tag">' . esc_html( $value->name ) . '</a>';
                        }
                    }
                ?>
            </p>
        <?php
    }
}
