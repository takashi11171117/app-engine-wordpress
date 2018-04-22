<?php
/**
 * Controller
 *
 * @package virtual
 */

/**
 * Controller
 */
class Controller {
	/**
	 * シングルトン用インスタンス
	 *
	 * @var object
	 */
	private static $uniqueInstance;

    public function __construct() {
		add_filter( 'excerpt_more', array( $this, 'excerpt_more') );
    }

	/**
	 * [getInstance シングルトン]
	 *
	 * @return インスタンスを返す
	 */
	public static function getInstance() {
		if ( ! isset( static::$uniqueInstance ) ) {
			static::$uniqueInstance = new Controller();
		}
		return static::$uniqueInstance;
	}

    /**
    * @function get_archive_title
    *
    * @return string
    */
    public static function get_archive_title( $post ) {
        if( mb_strlen( $post->post_title, 'UTF-8' ) > 40 ) {
        	$title= mb_substr( $post->post_title, 0, 40, 'UTF-8' );
        	return $title . '…';
        } else {
        	return $post->post_title;
        }
    }

    /**
    * @function get_archive_title
    *
    * @return string
    */
    public static function get_thumbnail() {
        if( has_post_thumbnail() ) {
            echo '<div class="thumb">';
            the_post_thumbnail('full');
            echo '</div>';
        } else {
            echo '';
        }
    }

    /**
    * @function excerpt_more
    *
    * @return string
    */
    public function excerpt_more($more) {
    	return '…';
    }
}
