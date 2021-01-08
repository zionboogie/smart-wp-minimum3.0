<?php
/*
パーツ：パンくず
*/
?>
<div class="breadcrumb-container">
	<a href="<?php echo esc_url( home_url() ); ?>">Home</a>
	<?php
	if ( !$cat ) $cat = get_the_category();
	echo get_category_parents($cat, true, '');
	?>
</div>
