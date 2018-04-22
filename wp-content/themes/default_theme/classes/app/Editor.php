<?php
/**
 * Editor
 *
 * plugin Markdown Editorが必要
 *
 * @package virtual
 */

/**
 * Editor
 */
class Editor {
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
		add_theme_support( 'post-thumbnails' );
        add_action( 'admin_menu', array( $this, 'meta_box_output' ) );
        add_action( 'admin_head', array( $this, 'my_head' ), 11 );
        add_action( 'wp_footer', array( $this, 'plus_single_link' ), 11 );
		add_action( 'init', array( $this, 're_register_post_tag_taxonomy' ), 1 );
	}

	/**
	 * [getInstance シングルトン]
	 *
	 * @return インスタンスを返す
	 */
	public static function getInstance() {
		if ( ! isset( static::$uniqueInstance ) ) {
			static::$uniqueInstance = new Editor();
		}
		return static::$uniqueInstance;
	}

	/**
	 * [meta_box_output metaboxを追加する関数]
	 */
	public function meta_box_output() {
		add_meta_box( 'meta_post_page', 'マークダウンの書き方', array( $this, 'meta_box_inside' ), 'post', 'normal', 'low' );
		add_meta_box( 'meta_post_page2', 'メディア編集', array( $this, 'meta_box_inside2' ), 'post', 'normal', 'low' );
	}

	/**
	 * [meta_box_inside2 markdownの説明]
	 */
	public function meta_box_inside() {
		global $post;
		$query = new WP_Query( 'orderby=date&order=ASC&post_status=inherit&posts_per_page=-1&post_type=attachment&post_parent=' . $post->ID );
		$posts = $query->get_posts();
		echo "<div class='border: 1px solid #000;'>";
echo <<<EOT
<p style="word-wrap: break-word;">
    ●見出し<br>

    　先頭に#一段目は###二段目は####<br><br>

    　*例<br>
	　　### サビキ釣りは釣り入門の基本！サビキ釣りを徹底解説！<br>
	　　#### サビキ釣りとは?<br><br><br>

    ●段落<br>
    　文字列の間に空行を挟む<br><br>

    　*例<br>
    　　ああああああああ<br>
    　　<br>
    　　ああああああああああああああ<br><br><br>

    ●リスト<br>
    　普通のリスト: 先頭に「- 」をつけるネストする際は、Tabでインデント<br>
    　番号付きリスト: 先頭に数字(「1. 」)を順につけるネストする際は、Tabでインデント<br><br>

    　*例<br>
	　　- あ行<br>
	　　　- あ<br>
	　　　- い<br>
	　　　- う<br>
	　　- か行<br>
	　　　- か<br>
	　　　- き<br>
	　　　- く<br><br><br>

    ●テキストリンク<br>
    　[テキスト](URL)<br><br>

    　*例<br>
	　　[Google](https://www.google.co.jp/)<br><br><br>

    ●強調<br>
    　*二つで挟む<br><br>

    　*例<br>
	　　**bold**<br><br><br>

    ●色付き強調<br>
    　*ーつで挟む<br><br>

    　*例<br>
	　　*bold*<br><br><br>

    ●引用<br>
    　先頭に「> 」をつける<br><br>

    　*例<br>
	　　> 引用です。<br><br><br>

    ●間隔をあける<br>
    　---<br><br>

    　*例<br>
	　　●間隔をあける<br>
    　　---<br>
    　　●間隔をあける<br><br><br>

    ●テーブル<br>
    　列を分けるときは「 | 」<br>
    　一行目に、列の最上段に記載する項目を記入。<br>
    　二行目に、その列のテキストの寄せを決定。<br>
    　　左寄せ　「 | 」の中に :---<br>
    　　中央寄せ「 | 」の中に :---:<br>
    　　右寄せ　「 | 」の中に ---:<br>
    　三行目から、各項目を書く。<br><br>

    　*例<br>
    　　|ここに|項目を|入れます|<br>
    　　|:---|---:|:---:|<br>
    　　|ここから|テキストを|入れていきます|<br>
    　　|昨日|今日|明日|<br>
    　　|ボールペン|シャープペン|万年筆|<br>
    　　|iPhone|iPad|MacBook|<br>
    　　|テキストがながーくなっても|大丈夫なように出来ているので|レスポンシブでも安心|
</p>
EOT;
		echo '</div>';
	}

	/**
	 * [meta_box_inside2 メディア関連の説明]
	 */
	public function meta_box_inside2() {
		global $post;
		$query = new WP_Query( 'orderby=date&order=ASC&post_status=inherit&posts_per_page=-1&post_type=attachment&post_parent=' . $post->ID );
		$posts = $query->get_posts();
		echo "<div class='border: 1px solid #000;'>";
echo <<<EOT
<p style="word-wrap: break-word;">
    ●GOOGLE MAP<br>

    　*例<br>
    　[gmap code='']<br><br>

    　※オプションの説明<br>
    　　シングルクオート使う、iframeの中に中にダブルクオート入るので
    　　code: iframeをそのままコピペ<br><br>

    ●YOUTUBE<br>

    　*例<br>
    　[youtube code="vqOAmVHthn0"]<br><br>

    　※オプションの説明<br>
    　　code: https://www.youtube.com/watch?v=Po9DF4jq93Yの?v以下をcode内に入力<br><br>

    ●アフィ用画像貼付<br>
    　[itemlist src=“” caption =“” title=“” link=“” line=“”]<br>
    ●普通の画像貼付<br>
    　[imglist src=“” caption =“” title=“” link=“” line=“” align=“”]<br><br>

    　*例<br>
    　　[imglist src="http://fishing.ne.jp/a.jpg,http://fishing.ne.jp/b.jpg,http://fishing.ne.jp/c.jpg" caption="アジ,イワシ,サバ" title="アジ,イワシ,サバ" src="http://fishing.ne.jp/a,http://fishing.ne.jp/b,http://fishing.ne.jp/c" line=3 align="center" ]<br><br>

    　※オプションの説明<br>
    　　src: 画像のURL(wordpressに画像アップ後、コピペ)<br>
    　　caption: 画像の説明<br>
    　　title: 画像のタイトル(seo用)<br>
    　　link: リンクのURL<br>
    　　(カンマ区切りで複数の画像を表示が可能。上記の項目は全て同じ要素数にする。)<br><br>

    　　line: 列の数の変更<br>
    　　align: captionの文字揃え right,left,centerのいずれかを指定
</p>
EOT;
		foreach ( $posts as $value ) {
			echo "<p class='fwb' style='font-size:14px;margin-bottom:0px;'>" . urldecode( $value->post_name ) . '</p>';
			echo "<p  style='font-size:14px;margin-top:5px;'><a href='" . str_replace( array( 'https://fishing.ne.jp', '/wp-content/uploads/' ),array( '', KANPARI_MEDIA_URL ), $value->guid ) . "'>" . str_replace( array( 'https://fishing.ne.jp', '/wp-content/uploads/' ), array( '', KANPARI_MEDIA_URL ), $value->guid ) . '</a></p>';
		}
		echo '</div>';
	}

	/**
	 * [管理画面のカスタムcss]
	 */
    public function my_head() {
        ?>
        <style type="text/css">
            #poststuff .editor-preview h3,
            #poststuff .editor-preview-side h3 {
            	font-size: 20px;
            	background-color: #e2e2e2;
            	padding: 15px 20px;
            	border-radius: 10px;
            	margin-bottom: 20px;
            	font-weight: bold;
            	margin-top: 40px;
            	position: relative;
            	line-height: 1.2;
            }
            #poststuff .editor-preview h3:before,
            #poststuff .editor-preview-side h3:before {
            	content: "";
            	position: absolute;
            	bottom: -32px;
            	left: 20px;
            	width: 0;
            	height: 0;
            	border: 20px solid transparent;
            	border-top: 20px solid #e2e2e2;
            }
            #poststuff .editor-preview h4,
            #poststuff .editor-preview-side h4 {
            	font-size: 18px;
            	position: relative;
            	height: 50px;
            	line-height: 1.3;
            	padding-left: 15px;
            	margin-bottom: 20px;
            	font-weight: bold;
            }
            #poststuff .editor-preview h4:before,
            #poststuff .editor-preview-side h4:before {
            	content: "";
            	position: absolute;
            	top: 0;
            	left: 0;
            	width: 1px;
            	height: 50px;
            	background-color: #999;
            }
            #poststuff .editor-preview a,
            #poststuff .editor-preview-side a {
            	color: #E14D70 !important;
            	text-decoration: underline !important;
            }
            #poststuff .editor-preview p,
            #poststuff .editor-preview-side p {
            	margin-bottom: 20px !important;
            }
            #poststuff .editor-preview em,
            #poststuff .editor-preview-side em {
            	color: #ff0000 !important;
            }
            #poststuff .editor-preview table,
            #poststuff .editor-preview-side table {
            	width: 100%;
            	margin-bottom: 20px;
                border-collapse: collapse;
            }
            #poststuff .editor-preview table th,
            #poststuff .editor-preview table td,
            #poststuff .editor-preview-side table th,
            #poststuff .editor-preview-side table td {
            	border: 1px solid #ddd;
            	padding: 10px;
            }
            #poststuff .editor-preview table th,
            #poststuff .editor-preview-side table th {
            	font-weight: bold;
            	background-color: #ededed;
            }
            #poststuff .editor-preview ul,
            #poststuff .editor-preview-side ul {
            	margin-bottom: 20px;
            }
            #poststuff .editor-preview ul li,
            #poststuff .editor-preview-side ul li {
            	margin: 0 0 7px;
            	line-height: 1.7;
            	position: relative;
            	padding-left: 20px;
            }
            #poststuff .editor-preview ul li:before,
            #poststuff .editor-preview-side ul li:before {
            	display: block;
            	width: 7px;
            	height: 7px;
            	content: "";
            	position: absolute;
            	left: 5px;
            	top: 12px;
            	background: #000;
            	border-radius: 50%;
            }
            #poststuff .editor-preview blockquote,
            #poststuff .editor-preview-side blockquote {
                position: relative;
                padding: 10px 15px 10px 55px;
                box-sizing: border-box;
                font-style: italic;
                background: #f9f9f9;
                color: #555;
                margin: 0;
                margin-bottom: 20px;
            }
            #poststuff .editor-preview blockquote:before,
            #poststuff .editor-preview-side blockquote:before {
                display: inline-block;
                position: absolute;
                top: 10px;
                left: 10px;
                vertical-align: middle;
                content: "“";
                font-family: sans-serif;
                color: #80C421;
                font-size: 90px;
                line-height: 1;
            }
            #poststuff .editor-preview blockquote p,
            #poststuff .editor-preview-side blockquote p {
                padding: 0;
                margin: 10px 0;
                line-height: 1.7;
            }
            #poststuff .editor-preview blockquote cite,
            #poststuff .editor-preview-side blockquote cite {
                display: block;
                text-align: right;
                color: #888888;
                font-size: 0.9em;
            }
            #poststuff .editor-preview hr,
            #poststuff .editor-preview-side hr {
                border-top: none;
                border-bottom: none;
                padding-bottom: 20px;
                padding-top: 20px;
            }
        </style>
        <?php
    }

	/**
	 * [markdownのリンクをすべてtarget_blankに]
	 */
    public function plus_single_link() {
        if ( is_single() ) {
            global $post;
            if ( 'plus' === get_post_type( $post ) ) {
                ?>
                <script type="text/javascript">
                jQuery(function($) {
                    $("#post_content a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
                });
                </script>
                <?php
            }
        }
    }

	public function re_register_post_tag_taxonomy() {
		global $wp_rewrite;
		$rewrite = array(
		'slug' => get_option('tag_base') ? get_option('tag_base') : 'tag',
		'with_front' => ! get_option('tag_base') || $wp_rewrite->using_index_permalinks(),
		'ep_mask' => EP_TAGS,
		);

		$labels = array(
		'name' => _x( 'Tags', 'taxonomy general name' ),
		'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
		'search_items' => __( 'Search Tags' ),
		'popular_items' => __( 'Popular Tags' ),
		'all_items' => __( 'All Tags' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Tag' ),
		'view_item' => __( 'View Tag' ),
		'update_item' => __( 'Update Tag' ),
		'add_new_item' => __( 'Add New Tag' ),
		'new_item_name' => __( 'New Tag Name' ),
		'separate_items_with_commas' => __( 'Separate tags with commas' ),
		'add_or_remove_items' => __( 'Add or remove tags' ),
		'choose_from_most_used' => __( 'Choose from the most used tags' ),
		'not_found' => __( 'No tags found.' )
		);

		register_taxonomy( 'post_tag', 'post', array(
		'hierarchical' => true,
		'query_var' => 'tag',
		'rewrite' => $rewrite,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'_builtin' => true,
		'labels' => $labels
		) );
	}
}
