<?php
/**
 * ブログ一覧・カテゴリ(お知らせ)一覧・その他のアーカイブ
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

if ( is_category() ) {
	$title = single_cat_title( '', false );
} elseif ( is_home() ) {
	$title = 'ブログ';
} elseif ( is_search() ) {
	$title = '検索結果';
} else {
	$title = get_the_archive_title();
}
?>
<main>
  <div class="sub-hero"><div class="wrap">
    <div class="crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a> / <?php echo esc_html( $title ); ?></div>
    <h1><?php echo esc_html( $title ); ?></h1>
  </div></div>
  <section>
    <div class="wrap">
      <?php if ( have_posts() ) : ?>
      <ul class="newslist">
        <?php while ( have_posts() ) : the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time><span class="t"><?php the_title(); ?></span></a></li>
        <?php endwhile; ?>
      </ul>
      <div class="pager">
        <?php
        echo wp_kses_post( paginate_links( array(
	        'prev_text' => '‹',
	        'next_text' => '›',
	        'type'      => 'plain',
        ) ) );
        ?>
      </div>
      <?php else : ?>
      <p style="text-align:center;color:#6b7782">記事がまだありません。</p>
      <?php endif; ?>
    </div>
  </section>
  <?php get_template_part( 'template-parts/cta' ); ?>
</main>
<?php get_footer(); ?>
