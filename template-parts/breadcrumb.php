<?php
/*
パーツ：パンくず
*/
?>
<div class="breadcrumb">
	<a href="<?php bloginfo('url'); ?>">Home</a>
	<?php
	if ( !$cat ) $cat = get_the_category();
	echo get_category_parents($cat, true, '');
	?>
</div>