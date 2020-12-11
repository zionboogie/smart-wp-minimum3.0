<?php
/*
パーツ：フッター
*/
?>
<!-- ページフッタ -->
<footer class="site-footer">
		<p class="copyright">&copy; ... Ltd. All Rights Reserved.</p>
</footer>
<!-- /ページフッタ -->

<?php wp_footer(); ?>
<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
</body>
</html>
