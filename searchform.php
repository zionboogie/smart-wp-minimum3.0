<?php
/*
パーツ：検索フォーム
*/
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="field" placeholder="検索したいワードを入力してください" value="<?php echo get_search_query(); ?>" name="s" title="検索" />
	<button type="submit" class="default-button">検索</button>
</form>
