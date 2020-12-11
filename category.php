<?php
/*
カテゴリ用テンプレート
*/
// ヘッダの出力
get_header(); ?>

<!-- main -->
<main class="main-container">

<?php
// パンくずリストの出力
get_template_part( 'template-parts/breadcrumb' );
?>

	<!-- entrylist-contaier -->
	<article class="entrylist-contaier">
		<header class="categorytitle">
			<h1><?php
// カテゴリタイトルの出力
echo single_cat_title( '', false )
			?></h1>
			<?php
// カテゴリ説明の出力
$categorydesc = category_description();
if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archivemeta">' . $categorydesc . '</div>' );
			?>
		</header>

<?php
if ( have_posts() ) :
?>
		<ul class="category-list">

<?php
	while ( have_posts() ):
		the_post();
		// 記事タイトルの出力
?>

			<li><a href="<?php echo the_permalink()?>"><?php echo the_title()?></a></li>

<?php
	endwhile;
?>

		</ul>

<?php
// ページネーションの出力
get_template_part( 'template-parts/pagination' );
?>

<?php
endif;
?>


	</article>
	<!-- /entrylist-contaier -->
<?php
// サイドバーの出力
get_sidebar();
?>

</main>
<!-- /main -->

<?php
// フッタの出力
get_footer();
?>
