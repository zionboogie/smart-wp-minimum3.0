<?php
/*
トップページ用テンプレート
*/
// ヘッダの出力
get_header(); ?>


<!-- main -->
<main class="main-container">

<?php if ( have_posts() ) : ?>

	<!-- entrylist-contaier -->
	<article class="entrylist-contaier">
	<?php
	while ( have_posts() ) {
		the_post();
		// 記事の出力
		get_template_part( 'template-parts/content' );
	}
	?>

	<?php
	// ページネーションの出力
	get_template_part( 'template-parts/pagination' );
	?>

	</article>
	<!-- /entrylist-contaier -->

<?php endif; ?>

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
