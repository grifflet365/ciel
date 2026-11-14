<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$home = home_url( '/' );
?>
<footer>
  <a class="logo" href="<?php echo esc_url( $home ); ?>">Salon Ciel.</a><br>
  <div class="flinks" style="margin-top:14px">
    <a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">施術メニュー・料金</a>
    <a href="<?php echo esc_url( ciel_news_category_url() ); ?>">お知らせ</a>
    <a href="<?php echo esc_url( ciel_blog_url() ); ?>">ブログ</a>
    <a href="<?php echo esc_url( ciel_opt( 'contact_url' ) ); ?>">お問い合わせ</a>
  </div>
  <?php echo esc_html( ciel_opt( 'address' ) ); ?> / TEL <?php echo esc_html( ciel_opt( 'phone' ) ); ?><br>
  <small>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Salon Ciel. Chiba</small>
</footer>

<div class="bar">
  <a class="main" href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">予約する</a>
  <a href="<?php echo esc_url( ciel_tel_href() ); ?>">電話</a>
  <a href="<?php echo esc_url( ciel_opt( 'line_url' ) ); ?>">LINE</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
