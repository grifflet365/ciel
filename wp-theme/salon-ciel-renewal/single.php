<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="sub-hero"><div class="wrap">
    <div class="crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a> / <a href="<?php echo esc_url( ciel_blog_url() ); ?>">ブログ・お知らせ</a></div>
    <span class="meta-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
    <h1 style="font-size:clamp(20px,4vw,30px);line-height:1.6"><?php the_title(); ?></h1>
  </div></div>
  <section>
    <div class="wrap">
      <?php if ( has_post_thumbnail() ) : ?>
      <figure class="photo r169" style="max-width:760px;margin:0 auto 32px"><?php the_post_thumbnail( 'large' ); ?></figure>
      <?php endif; ?>
      <article class="entry"><?php the_content(); ?></article>
      <div class="more"><a href="<?php echo esc_url( ciel_blog_url() ); ?>">一覧に戻る</a></div>
    </div>
  </section>
  <?php get_template_part( 'template-parts/cta' ); ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
