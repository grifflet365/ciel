<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main>
  <div class="sub-hero"><div class="wrap"><h1>ページが見つかりません</h1></div></div>
  <section>
    <div class="wrap" style="text-align:center">
      <p>お探しのページは移動または削除された可能性があります。</p>
      <div class="more"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a></div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
