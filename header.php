<?php
/*
パーツ：ヘッダ
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- タイトル（プラグイン出力する場合は削除） -->
	<title><?php wp_title(); ?></title>

	<!-- ファビコン -->
	<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.ico">
	<link rel="apple-touch-icon-precomposed" href="/favicon-152.png">

	<!-- スタイルシート -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<!-- ページヘッダ -->
	<header class="site-header">
		<!-- ロゴ -->
		<?php if ( is_front_page() && is_home() ) : ?>
		<h1 class="sitelogo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
		<p class="sitelogo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
		<!-- /ロゴ -->

		<!-- 検索フォーム -->
		<?php get_search_form(); ?>
		<!-- /検索フォーム -->
	</header>
	<!-- /ページヘッダ -->
