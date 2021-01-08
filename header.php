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

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

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
