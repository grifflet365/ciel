<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="reserve" class="cta">
  <div class="wrap">
    <span class="en">Reservation</span>
    <h2>まずは、初回お試しから。</h2>
    <a class="btn" href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">初回お試しを予約する</a>
    <span class="btn-sub">オンライン・お電話・LINEで受け付けています</span>
    <div class="contact3">
      <a href="<?php echo esc_url( ciel_tel_href() ); ?>">電話 <?php echo esc_html( ciel_opt( 'phone' ) ); ?></a>
      <a href="<?php echo esc_url( ciel_opt( 'line_url' ) ); ?>">LINEで予約・相談</a>
      <a href="<?php echo esc_url( ciel_opt( 'contact_url' ) ); ?>">メールで問い合わせ</a>
    </div>
  </div>
</section>
