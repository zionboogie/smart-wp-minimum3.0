<?php
/*
パーツ：記事一覧のループ部分
*/
?>
	<!-- entry-header -->
	<div class="entry-header">
		<?php
		// 記事タイトルの出力
		the_title( sprintf( '<h2 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
		?>
		<div class="postmeta">
			<span class="postdate"><?php
			// 日付の出力
			smart_entry_date();
			?></span>
			<span class="category-list"><?php
			// カテゴリの出力
			smart_entry_category();
			?></span>
			<span class="tag"><?php
			// タグの出力
			smart_entry_tag();
			?></span>
		</div>
	</div>
	<!-- /entry-header -->
