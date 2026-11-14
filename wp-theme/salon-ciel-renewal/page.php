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
$services = array(
	'growth'       => 'スカルプ(発毛・育毛)',
	'epilation'    => 'メンズ脱毛',
	'beauty'       => 'Beauty Salon',
	'small-face'   => '脳洗浄®',
	'herb-peeling' => 'ハーブピーリング',
	'yomogi'       => 'よもぎ蒸し',
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
  <section class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Other Menu</span><h2>そのほかのメニュー</h2></div>
      <div class="others">
        <?php foreach ( $services as $s => $t ) : ?>
        <a href="<?php echo esc_url( ciel_page_url( $s ) ); ?>"><?php echo esc_html( $t ); ?></a>
        <?php endforeach; ?>
      </div>
    </div>
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

  <?php elseif ( isset( $services[ $slug ] ) ) : ?>
  <section>
    <div class="wrap"><div class="entry"><?php the_content(); ?></div></div>
  </section>
  <section class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Other Menu</span><h2>そのほかのメニュー</h2></div>
      <div class="others">
        <a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">整体メニュー・料金</a>
        <?php foreach ( $services as $s => $t ) :
	        if ( $s === $slug ) {
		        continue;
	        }
	        ?>
        <a href="<?php echo esc_url( ciel_page_url( $s ) ); ?>"><?php echo esc_html( $t ); ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php elseif ( 'faq' === $slug ) : ?>
  <section>
    <div class="wrap" style="max-width:760px">
      <?php foreach ( ciel_get_faqs() as $f ) : ?>
      <details><summary><?php echo esc_html( $f->post_title ); ?></summary><div class="faq-a"><?php echo wp_kses_post( wpautop( do_blocks( $f->post_content ) ) ); ?></div></details>
      <?php endforeach; ?>
      <div class="entry"><?php the_content(); ?></div>
    </div>
  </section>

  <?php elseif ( 'contact' === $slug ) : ?>
  <section>
    <div class="wrap">
      <div class="entry"><?php the_content(); ?></div>
      <div class="contact3 contact3-light">
        <a href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">オンライン予約</a>
        <a href="<?php echo esc_url( ciel_tel_href() ); ?>">電話 <?php echo esc_html( ciel_opt( 'phone' ) ); ?></a>
        <a href="<?php echo esc_url( ciel_opt( 'line_url' ) ); ?>">LINEで相談</a>
      </div>
      <?php ciel_render_contact_form(); ?>
    </div>
  </section>

  <?php elseif ( 'access' === $slug ) : ?>
  <section>
    <div class="wrap">
      <div class="access">
        <figure class="photo r43"><img src="<?php echo esc_url( ciel_image_url( 'access', 'salon1.jpg' ) ); ?>" alt="サロン内の様子"></figure>
        <dl>
          <dt>SALON</dt><dd class="serif">Salon Ciel. Chiba</dd>
          <dt>ADDRESS</dt><dd>〒<?php echo esc_html( ciel_opt( 'zip' ) ); ?> <?php echo esc_html( ciel_opt( 'address' ) ); ?></dd>
          <dt>ACCESS</dt><dd><?php echo esc_html( ciel_opt( 'access' ) ); ?></dd>
          <dt>HOURS</dt><dd><?php echo esc_html( ciel_opt( 'hours_weekday' ) ); ?> ／ <?php echo esc_html( ciel_opt( 'hours_weekend' ) ); ?></dd>
          <dt>TEL</dt><dd><a href="<?php echo esc_url( ciel_tel_href() ); ?>"><?php echo esc_html( ciel_opt( 'phone' ) ); ?></a></dd>
        </dl>
      </div>
      <div class="map"><iframe title="地図" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=<?php echo rawurlencode( '千葉県千葉市中央区今井2-4-7 新月ビル' ); ?>&amp;hl=ja&amp;z=17&amp;output=embed"></iframe></div>
      <div class="entry" style="margin-top:32px"><?php the_content(); ?></div>
    </div>
  </section>

  <?php elseif ( 'about' === $slug ) : ?>
  <section>
    <div class="wrap">
      <dl class="shopinfo">
        <dt>店舗名</dt><dd>そが西口整体Ciel(Salon Ciel. Chiba)</dd>
        <dt>資格</dt><dd>整体師 ／ 健康管理士 ／ 発毛技能士 ／ 毛髪診断士</dd>
        <dt>住所</dt><dd>〒<?php echo esc_html( ciel_opt( 'zip' ) ); ?> <?php echo esc_html( ciel_opt( 'address' ) ); ?></dd>
        <dt>アクセス</dt><dd><?php echo esc_html( ciel_opt( 'access' ) ); ?></dd>
        <dt>電話番号</dt><dd><a href="<?php echo esc_url( ciel_tel_href() ); ?>"><?php echo esc_html( ciel_opt( 'phone' ) ); ?></a></dd>
        <dt>FAX番号</dt><dd>043-400-2221</dd>
        <dt>営業時間</dt><dd><?php echo esc_html( ciel_opt( 'hours_weekday' ) ); ?><br><?php echo esc_html( ciel_opt( 'hours_weekend' ) ); ?></dd>
      </dl>
      <div class="entry" style="margin-top:32px"><?php the_content(); ?></div>
      <div class="more"><a href="<?php echo esc_url( ciel_page_url( 'access' ) ); ?>">地図・アクセスを見る</a></div>
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
