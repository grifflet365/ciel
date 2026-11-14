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
	      foreach ( ciel_nav_items() as $it ) {
		      echo '<a href="' . esc_url( $it[1] ) . '">' . esc_html( $it[0] ) . '</a>';
	      }
      }
      ?>
    </nav>
    <a class="hbtn" href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">ご予約</a>
    <details class="mnav">
      <summary aria-label="メニュー"><span></span><span></span><span></span></summary>
      <div class="mpanel">
        <?php
        foreach ( ciel_nav_items() as $it ) {
	        echo '<a href="' . esc_url( $it[1] ) . '">' . esc_html( $it[0] ) . '</a>';
        }
        foreach ( ciel_footer_items() as $it ) {
	        echo '<a class="sub" href="' . esc_url( $it[1] ) . '">' . esc_html( $it[0] ) . '</a>';
        }
        ?>
      </div>
    </details>
  </div>
</header>
