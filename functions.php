<?php
/*
テーマのための関数
*/

/*#########################################################

基本設定

#########################################################*/
add_action( 'after_setup_theme', 'smart_theme_support' );
function smart_theme_support() {

	/* ========================================================
	セキュリティ
	=========================================================*/
	// WordPressのバージョンを非表示
	remove_action('wp_head','wp_generator');

	// プラグインのバージョン情報非標示
	function remove_cssjs_ver2( $src ) {
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}
	add_filter( 'style_loader_src', 'remove_cssjs_ver2', 9999 );
	add_filter( 'script_loader_src', 'remove_cssjs_ver2', 9999 );

	// headタグのmeta（generator）タグを取り除く
	foreach ( array( 'rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header',
		'atom_head', 'comments_atom_head', 'opml_head', 'app_head' ) as $action ) {
		if ( has_action( $action, 'the_generator' ) )
			remove_action( $action, 'the_generator' );
	}


	/* ========================================================
	基本設定
	=========================================================*/
	// フィードのlink要素を自動出力する
	add_theme_support( 'automatic-feed-links' );

	// コメント用のフィードを停止
	if ( is_comment_feed() ) {
		remove_action('do_feed_rdf', 'do_feed_rdf');
		remove_action('do_feed_rss', 'do_feed_rss');
		remove_action('do_feed_rss2', 'do_feed_rss2');
		remove_action('do_feed_atom', 'do_feed_atom');
		remove_action('wp_head', 'feed_links_extra', 3);
	}

	// WordPressコアから出力されるHTMLタグをHTML5のフォーマットにする
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// 投稿ページにてアイキャッチ画像の欄を表示
	// add_theme_support( 'post-thumbnails' );

	// 絵文字削除
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles' );
	remove_action('admin_print_styles', 'print_emoji_styles');

	// 投稿フォーマットのサポート
	// add_theme_support( 'post-formats', array(
	// 	'aside',	//アサイド
	// 	'gallery',	//ギャラリー
	// 	'image',	//画像
	// 	'link',		//リンク
	// 	'quote',	//引用
	// 	'status',	//ステータス
	// 	'video',	//動画
	// 	'audio',	//音声
	// 	'chat',		//チャット
	// ) );

	// 記事の自動整形（ダブルクオーテーションなどの引用符など）を無効にする
	add_filter( 'run_wptexturize', '__return_false' );

	// 管理画面左カラムにウィジェット追加
	register_sidebar(array(
		'id'			=> 'sidebar-1',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	));

}




/*#########################################################

汎用関数

#########################################################*/

// TITLE要素用
function my_wp_title($title) {
	if( is_front_page() && is_home() ){
		return get_bloginfo('name');
	} else {
		return $title."|". get_bloginfo('name');
	}
}
add_filter( 'wp_title', 'my_wp_title');

// 日付の出力
function smart_entry_date() {
	// 日付
	printf( '<time class="entrydate" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( ) ),
		get_the_date()
	);
}

// カテゴリの出力
function smart_entry_category($pretag="", $endtag="") {
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
		printf( $pretag.'%1$s'.$endtag,
			$categories_list
		);
	}
}

// タグの出力
function smart_entry_tag($pretag="", $endtag="") {
	$tags_list = get_the_tag_list( '', ', ' );
	if ( $tags_list ) {
		printf( $pretag.'%1$s'.$endtag,
			$tags_list
		);
	}
}


/*#########################################################

テーマ専用処理

#########################################################*/

/* ========================================================
CSSの読み込み
=========================================================*/
function my_enqueue_files() {
	// CSSディレクトリ
	$uri =  "https://".$_SERVER["HTTP_HOST"]."/common/css/";

/*
ディレクトリ単位でCSSを変更したい場合
*/
/*
	// クエリを削除
	$url = preg_replace( '/\?.+$/', '', $_SERVER["REQUEST_URI"] );
	$handle = parse_url($url, PHP_URL_PATH);
	// /で配列作成
	$handle = explode('/',  $handle);
*/

	if ( is_home() ) {
		$uri .= "top.css";

	// 詳細ページの場合
	} else if( is_single() ){

		$uri .= "single.css";

	// カテゴリかタグ、カスタムタクソノミーのアーカイブページの場合
	} else if( is_category() || is_tag() || is_tax() ){
		$uri .= "category.css";

	// エラーページの場合
	} else if ( is_404() ){
		$uri .= "error.css";

	// 該当なし
	} else {
		$uri .= "common.css";

	}
	wp_enqueue_style("style", $uri);
}
// ページ毎にCSSを変更したい場合
// add_action('wp_enqueue_scripts', 'my_enqueue_files');

/* ========================================================
JSの読み込み
=========================================================*/
function custom_inline_script() {
	// JSディレクトリ
	$uri = "https://".$_SERVER["HTTP_HOST"]."/common/js/";
	if( is_home() ){
		$uri .= 'top-dist.js';

	// 詳細ページの場合
	} else if( is_single() ){

		$uri .= "single-dist.js";

	// カテゴリかタグ、カスタムタクソノミーのアーカイブページの場合
	} else if( is_category() || is_tag() || is_tax() ){
		$uri .= "category-dist.js";

	// エラーページの場合
	} else if ( is_404() ){
		$uri .= "error-dist.js";


	// 該当なし
	} else {
		$uri .= "common-dist.js";
	}
	if( $uri !== null ){
		echo '<script src="' . $uri . '"></script>';
	}
}
add_action( 'wp_footer' , 'custom_inline_script' );


/* ========================================================
デフォルト読み込みのCSS・JSの読み込み制御
=========================================================*/
function my_deregister_styles() {
	//管理画面系CSSの読み込み制限
	if ( !is_admin() ){
		wp_deregister_style( 'dashicons' );
		wp_deregister_style( 'aioseop-toolbar-menu' );
	}

	//投稿用プラグインのCSS
	if ( !is_single() ){
		wp_deregister_style( 'toc-screen' );
		wp_deregister_style( 'liquid-block-speech' );
		wp_deregister_style( 'tablepress-default' );
		wp_deregister_style( 'post-views-counter-frontend' );
	}

	// 固定ページとシングルページはjQueryを読み込まない
	// if ( is_page() || is_single() ) {
		wp_deregister_script( 'jquery' );
	// }
}
add_action( 'wp_enqueue_scripts', 'my_deregister_styles', 100 );
