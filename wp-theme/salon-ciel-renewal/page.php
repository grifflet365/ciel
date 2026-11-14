<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$parts = array(
	'neck-shoulder' => '肩こり・首の痛み',
	'waist-back'    => '腰・背中の痛み',
	'knees-foot'    => '膝の痛み・捻挫',
	'hip'           => '股関節の痛み',
	'elbow-wrist'   => '肘・手首の痛み',
);
?>
<main>
<?php
while ( have_posts() ) :
	the_post();
	$slug = get_post_field( 'post_name', get_the_ID() );
	?>
  <div class="sub-hero"><div class="wrap">
    <div class="crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a> / <?php the_title(); ?></div>
    <h1><?php the_title(); ?></h1>
  </div></div>

  <?php if ( 'treatment' === $slug ) : ?>
  <section>
    <div class="wrap">
      <div class="head"><span class="en">Menu &amp; Price</span><h2>整体メニューと料金</h2></div>
      <div class="plan">
        <?php foreach ( ciel_get_prices() as $p ) :
	        $first = ( '1' === get_post_meta( $p->ID, 'ciel_price_featured', true ) );
	        $desc  = get_post_meta( $p->ID, 'ciel_price_desc', true );
	        ?>
        <div class="p<?php echo $first ? ' first' : ''; ?>">
          <h3><?php echo esc_html( $p->post_title ); ?></h3>
          <span class="en" style="letter-spacing:.14em"><?php echo esc_html( get_post_meta( $p->ID, 'ciel_price_time', true ) ); ?></span>
          <div class="pr"><?php echo esc_html( get_post_meta( $p->ID, 'ciel_price_value', true ) ); ?><small style="font-size:12px;color:#6b7782">(税込)</small></div>
          <?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Concern</span><h2>お悩み別の施術</h2></div>
      <div class="worry">
        <?php foreach ( $parts as $s => $t ) : ?>
        <a href="<?php echo esc_url( ciel_page_url( $s ) ); ?>"><b><?php echo esc_html( $t ); ?></b></a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section>
    <div class="wrap"><div class="entry"><?php the_content(); ?></div></div>
  </section>
  <?php elseif ( isset( $parts[ $slug ] ) ) : ?>
  <section>
    <div class="wrap"><div class="entry"><?php the_content(); ?></div></div>
  </section>
  <section class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Other Menu</span><h2>ほかのお悩み</h2></div>
      <div class="others">
        <?php foreach ( $parts as $s => $t ) :
	        if ( $s === $slug ) {
		        continue;
	        }
	        ?>
        <a href="<?php echo esc_url( ciel_page_url( $s ) ); ?>"><?php echo esc_html( $t ); ?></a>
        <?php endforeach; ?>
        <a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">施術メニュー・料金</a>
      </div>
    </div>
  </section>
  <?php else : ?>
  <section>
    <div class="wrap"><div class="entry"><?php the_content(); ?></div></div>
  </section>
  <?php endif; ?>

  <?php get_template_part( 'template-parts/cta' ); ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
