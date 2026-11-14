<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$home = home_url( '/' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
  <div class="wrap">
    <a class="logo" href="<?php echo esc_url( $home ); ?>">Salon Ciel.<small>CHIBA / SOGA</small></a>
    <nav>
      <?php
      if ( has_nav_menu( 'primary' ) ) {
	      wp_nav_menu( array(
		      'theme_location' => 'primary',
		      'container'      => false,
		      'items_wrap'     => '%3$s',
		      'walker'         => new Ciel_Plain_Walker(),
		      'depth'          => 1,
	      ) );
      } else {
	      ?>
      <a href="<?php echo esc_url( $home . '#feature' ); ?>">特徴</a>
      <a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">施術・料金</a>
      <a href="<?php echo esc_url( $home . '#news' ); ?>">お知らせ</a>
      <a href="<?php echo esc_url( $home . '#faq' ); ?>">FAQ</a>
      <a href="<?php echo esc_url( $home . '#access' ); ?>">アクセス</a>
      <a href="<?php echo esc_url( ciel_blog_url() ); ?>">ブログ</a>
      <?php } ?>
    </nav>
    <a class="hbtn" href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">ご予約</a>
  </div>
</header>
