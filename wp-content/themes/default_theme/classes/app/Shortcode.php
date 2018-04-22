<?php
/**
 * ショートコード
 *
 * @package virtual
 */

/**
 * Shortcode
 */
class Shortcode {
	/**
	 * シングルトン用インスタンス
	 *
	 * @var object
	 */
	private static $uniqueInstance;

	/**
	 * [__construct 初期化処理]
	 */
	private function __construct() {
        add_shortcode( 'youtube', array( $this, 'youtube' ) );
        add_shortcode( 'gmap', array( $this, 'gmap' ) );
        add_shortcode( 'imglist', array( $this, 'imglist' ) );
        add_shortcode( 'itemlist', array( $this, 'itemlist' ) );
	}

	/**
	 * [getInstance シングルトン]
	 *
	 * @return インスタンスを返す
	 */
	public static function getInstance() {
		if ( ! isset( static::$uniqueInstance ) ) {
			static::$uniqueInstance = new Shortcode();
		}
		return static::$uniqueInstance;
	}

	/**
	 * [youtube プラスのyoutubeショートコード]
	 *
	 * @param  array $atts ショートコードの引数
	 * @return string       返すコンテンツ
	 */
	public function youtube( $atts = array() ) {
		extract( shortcode_atts( array(
			'code' => '',
		), $atts ) );

		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = explode( ',', $value );
		}

		$rtn = '<div class="youtube"><iframe width="810" height="532" src="//www.youtube.com/embed/' . $atts['code'][0] . '?autoplay=0" frameborder="0" allowfullscreen></iframe></div>';
		return $rtn;
	}

	/**
	 * [gmap プラスのgooglemapショートコード]
	 *
	 * @param  array $atts ショートコードの引数
	 * @return string       返すコンテンツ
	 */
	public function gmap( $atts = array() ) {
		extract( shortcode_atts( array(
			'code' => '',
		), $atts ) );

		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = explode( ',', $value );
		}

		$rtn = '<div class="ggmap">' . $atts['code'][0] . '</div>';
		return $rtn;
	}

	/**
	 * [imglist プラスの画像のリストのショートコード]
	 *
	 * @param  array $atts ショートコードの引数
	 * @return string       返すコンテンツ
	 */
	public function imglist( $atts = array() ) {
		global $post;
		extract( shortcode_atts( array(
			'src' => '',
			'caption' => '',
			'title' => '',
			'link' => '',
			'line' => 1,
			'align' => 'left',
		), $atts ) );

		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = explode( ',', $value );
		}

		$class = 'line' . $atts['line'][0];
		isset( $atts['align'][0] ) ? $ali = $atts['align'][0] : $ali = '';
		$html2 = '';
		foreach ( $atts['src'] as $key => $value ) {
			if ( isset( $atts['title'] ) ) {
				'' === $atts['title'][ $key ] ? $title = $post->post_title : $title = $atts['title'][ $key ];
			} else {
				$title = $post->post_title;
			}
			if ( isset( $atts['link'][ $key ] ) ) {
				$link = $atts['link'][ $key ];
			} else {
				$link = '';
			}
			$src = $value;
			$cap = '';
			if ( isset( $atts['caption'][ $key ] ) && '' !== $atts['caption'][ $key ] ) {
				$cap = '<div class="cap" style="text-align:' . $ali . ';">' . $atts['caption'][ $key ] . '</div>';
			}
			if ( '' !== $link ) {
				$body = '<a href="' . $link . '"><img src="' . $src . '" alt="' . $title . '" title="' . $title . '" /></a>';
			} else {
				$body = '<img src="' . $src . '" alt="' . $title . '" title="' . $title . '" />';
			}
$html2 .= <<< EOM
<div class="box $class">
	$body
	$cap
</div>
EOM;
		}

		$html = '';
$html .= <<< EOM
<div class="img_list">
	<div class="row">
	$html2
	</div>
</div>
EOM;

		return $html;
	}

    /**
	 * [itemlist アイテムのリストのショートコード]
	 *
	 * @param  array $atts ショートコードの引数
	 * @return string       返すコンテンツ
	 */
	public function itemlist( $atts = array() ) {
		extract( shortcode_atts( array(
			'src' => '',
			'caption' => '',
			'title' => '',
			'link' => '',
            'ritz' => '',
			'line' => 1,
			'align' => 'left',
		), $atts ) );

		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = explode( ',', $value );
		}

		$class = 'line' . $atts['line'][0];
		$html2 = '';
		foreach ( $atts['src'] as $key => $value ) {
			$title = $atts['title'][ $key ];
			$src = $value;
            $link = '';
            $ritz = '';
			if ( isset( $atts['link'][ $key ] ) ) {
				$link = '<a class="button amazon_buy" href="' . $atts['link'][ $key ] . '" target="_blank"><i class="icon-shoppingcartalt icon"></i><i>amazonで購入</i></a>';
			}
			if ( isset( $atts['ritz'][ $key ] ) ) {
				$ritz = '<a class="button ritz_buy" href="' . $atts['ritz'][ $key ] . '" target="_blank"><i class="icon-shoppingcartalt icon"></i><i>Ritzで購入</i></a>';
			}
			$cap = '';
			if ( isset( $atts['caption'][ $key ] ) && '' !== $atts['caption'][ $key ] ) {
				$cap = '<div class="con">' . $atts['caption'][ $key ] . '</div>';
			}
$html2 .= <<< EOM
<div class="item $class">
	<div class="left"><img src="$src" alt="$title" title="$title" /></div>
	<div class="right">
		<div class="title">$title</div>
		$cap
        $link
		$ritz
	</div>
</div>
EOM;
		}

		$html = '';
$html .= <<< EOM
<div class="img_list">
	<div class="row">
	$html2
	</div>
</div>
EOM;

		return $html;
	}
}
