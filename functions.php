<?php
/*
* テーマのための関数
* @package WordPress
* @subpackage smart
* @since 3.0.0
*/

/*#########################################################

基本設定

#########################################################*/

if ( ! function_exists( 'smart_theme_support' ) ) {
	add_action( 'after_setup_theme', 'smart_theme_support' );
	function smart_theme_support() {
	
		/* ========================================================
		セキュリティ
		=========================================================*/
		// WordPressのバージョンを非表示
		remove_action('wp_head','wp_generator');
	
		// プラグインのバージョン情報非表示
		function remove_cssjs_ver2( $src ) {
			// テーマ内のファイルは対象外
			if ( strpos( $src, 'ver=' ) && !strpos( $src, get_template() ) )
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
	
		// コメント用のフィードを停止
		if ( is_comment_feed() ) {
			remove_action('do_feed_rdf', 'do_feed_rdf');
			remove_action('do_feed_rss', 'do_feed_rss');
			remove_action('do_feed_rss2', 'do_feed_rss2');
			remove_action('do_feed_atom', 'do_feed_atom');
			remove_action('wp_head', 'feed_links_extra', 3);
		}

		// 絵文字削除
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles' );
		remove_action('admin_print_styles', 'print_emoji_styles');

		// Microsoftが提供するブログエディター「Windows Live Writer」を使用する際のマニフェストファイル
		remove_action( 'wp_head', 'wlwmanifest_link' );
	
		// RSD用のxml（外部サービスを使ってサイトを運営する予定がある場合はコメントアウト）
		remove_action('wp_head', 'rsd_link');

		// oEmbed 機能に必要なリンク
		remove_action('wp_head','rest_output_link_wp_head');
		remove_action('wp_head','wp_oembed_add_discovery_links');
		remove_action('wp_head','wp_oembed_add_host_js');

		/* ========================================================
		基本設定
		=========================================================*/
		// フィードのlink要素を自動出力する
		add_theme_support( 'automatic-feed-links' );
		
		// ドキュメントのタイトルをWordPressに管理させる
		// ドキュメントヘッドにハードコードされた<title>タグを使用しません。
		// WordPressが提供してくれます。
		add_theme_support( 'title-tag' );

		// WordPressコアから出力されるHTMLタグをHTML5のフォーマットにする
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
			'search-form',
		) );

		// アイキャッチ画像のサポート
		add_theme_support( 'post-thumbnails' );

		// ブロックスタイルのサポート
		// テーマで定義するためコメントアウト
		// add_theme_support( 'wp-block-styles' );

		// 管理画面のエディタ用スタイルのサポート
		add_theme_support( 'editor-styles' );
		$editor_stylesheet_path = './src/asset/css/style-editor.css';
		add_editor_style( $editor_stylesheet_path );

		// 投稿ページにてアイキャッチ画像の欄を表示
		// add_theme_support( 'post-thumbnails' );
	
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
	

	
	}
}





/*#########################################################

汎用関数

#########################################################*/

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
ウィジェットの追加
=========================================================*/
function smart_widgets_init() {
	// 管理画面左カラムにウィジェット追加
	register_sidebar(array(
		'id'			=> 'sidebar-1',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	));
}
add_action( 'widgets_init', 'smart_widgets_init' );


/* ========================================================
CSSとJSの読み込み
=========================================================*/
function smart_enqueue_files() {
/*
ディレクトリ単位でCSSを変更したい場合のサンプル
*/
/*
	// CSSディレクトリ
	$uri = get_template_directory_uri() . "/common/css/";

	// クエリパラメータを削除
	$url = preg_replace( '/\?.+$/', '', $_SERVER["REQUEST_URI"] );
	$handle = parse_url($url, PHP_URL_PATH);
	// /で配列作成
	$handle = explode('/', $handle);
	$uri .= $handle[1] . "/style.css";

	*/

/*
テンプレートの種類毎にCSSを変更したい場合のサンプル
*/
/*
	// CSSディレクトリ
	$uri = get_template_directory_uri() . "/common/css/";

	// トップページの場合
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
*/


	// CSSディレクトリ
	$uri = get_template_directory_uri() . "/style.css";
	
	// スタイルの出力
	wp_enqueue_style("smart-style", $uri, array(), wp_get_theme()->get( 'Version' ));




	// JSディレクトリ
	$uri = get_template_directory_uri() . "/common/js/";

	if( is_home() ){
		$uri .= 'index.js';

	// 詳細ページの場合
	} else if( is_single() ){
		$uri .= "single.js";

	// カテゴリかタグ、カスタムタクソノミーのアーカイブページの場合
	} else if( is_category() || is_tag() || is_tax() ){
		$uri .= "category.js";

	// エラーページの場合
	} else if ( is_404() ){
		$uri .= "error.js";

	// 該当なし
	} else {
		$uri .= "common.js";
	}
	wp_enqueue_script('smart-script', $uri, array(), wp_get_theme()->get( 'Version' ), true);
}
// ページ毎にCSSを変更したい場合
add_action('wp_enqueue_scripts', 'smart_enqueue_files');


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


/* ========================================================
ページを表示する直前に実行
=========================================================*/
function smart_template_redirect() {
	// フロントページが表示される前に行う処理
	if ( is_front_page() ) {
	// ブログメインページが表示される前に行う処理
	} else if ( is_home() ) {
	// カテゴリかタグ、カスタムタクソノミーのアーカイブページが表示される前に行う処理
	} else if( is_category() || is_tag() || is_tax() ){
	// 投稿ページが表示される前に行う処理
	} else if ( is_single() ) {
	// 固定ページが表示される前に行う処理
	} else if ( is_page() ) {
	// それ以外のページが表示される前に行う処理
	} else {
	}
}
add_action( 'template_redirect', 'smart_template_redirect' );


/* ========================================================
メインクエリの設定
=========================================================*/
function change_posts($query) {
	/* 管理画面、メインクエリ以外に干渉しない */
	if( is_admin() || ! $query->is_main_query() ) return;

	/* TOPページ */
	if ( $query->is_home() ) {
		return;

	/* Musicカテゴリーページ */
	} else if ( $query->is_category($MUSIC_ID) ){
		return;

	/* HTMLやCSSなど親カテゴリーページ */
	} else if ( $query->is_category($CATEGORY_PARENT) ){
		return;

	/* カテゴリーページ */
	} else if ( $query->is_category() ){
		return;

	/* タグページ */
	} else if ( $query->is_tag() ){
		return;

	/* タクソノミーページ */
	} else if ( $query->is_tax() ){
		return;

	/* 詳細ページ */
	} else if ( $query->is_single() ){
		return;

	/* 検索ページ */
	} else if ( $query->is_search() ){
		return;

	/* 固定ページ */
	} else if ( $query->is_page() ){
		return;

 	}
}
add_action( 'pre_get_posts', 'change_posts' );
