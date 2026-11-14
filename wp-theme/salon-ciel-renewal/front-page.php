<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$worry = array(
	array( 'neck-shoulder', '肩こり・首', 'NECK / SHOULDER' ),
	array( 'waist-back', '腰・背中', 'BACK' ),
	array( 'knees-foot', '膝・足首', 'KNEE / ANKLE' ),
	array( 'hip', '股関節', 'HIP' ),
	array( 'elbow-wrist', '肘・手首', 'ELBOW / WRIST' ),
);
$prices = ciel_get_prices();
$faqs   = ciel_get_faqs();
$news   = new WP_Query( array(
	'category_name'       => 'news',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => true,
) );
?>
<main id="top">
  <div class="hero">
    <div class="wrap">
      <div class="hero-grid">
        <div class="txt">
          <span class="en">Private Body Care Salon</span>
          <h1>からだの不調に、<br><em>ていねいに</em>向き合う。</h1>
          <p class="lead">JR蘇我駅西口 徒歩1分の完全個室サロン。<br>お話をじっくり伺い、一人ひとりに合わせた整体をご提供します。</p>
          <a class="btn" href="<?php echo esc_url( ciel_opt( 'reserve_url' ) ); ?>">初回お試しを予約する</a>
          <span class="btn-sub">オンライン予約はこちらから</span>
        </div>
        <figure class="photo r43" data-label="メイン写真"><img src="<?php echo esc_url( ciel_image_url( 'hero', 'hero.jpg' ) ); ?>" alt="Salon Ciel. Chiba 店内"></figure>
      </div>
      <div class="stats">
        <div><b><?php echo esc_html( ciel_opt( 'trial_price' ) ); ?><small style="font-size:.5em">円</small></b><span>初回お試し(60分×2回)</span></div>
        <div><b>1<small style="font-size:.5em">分</small></b><span>蘇我駅西口より徒歩</span></div>
        <div><b>PRIVATE</b><span>完全個室</span></div>
      </div>
    </div>
  </div>

  <section id="feature" class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Feature</span><h2>当店が選ばれる3つの理由</h2></div>
      <div class="split">
        <figure class="photo r43"><img src="<?php echo esc_url( ciel_image_url( 'feature1', 'feature1.jpg' ) ); ?>" alt="カウンセリングの様子"></figure>
        <div><span class="no">01</span><h3>ていねいな対話から、<br>原因を見極める</h3><p>お悩みや生活習慣をじっくり伺い、原因を見極めてから施術を組み立てます。</p></div>
      </div>
      <div class="split rev">
        <figure class="photo r43"><img src="<?php echo esc_url( ciel_image_url( 'feature2', 'feature2.jpg' ) ); ?>" alt="施術の様子"></figure>
        <div><span class="no">02</span><h3>固まった体を、<br>使える体へ</h3><p>VIM療法を軸に、固まって動かなくなった筋肉や靭帯を使える状態へ。痛みの原因を探し、体全体のバランスを整えます。</p></div>
      </div>
      <div class="split">
        <figure class="photo r43"><img src="<?php echo esc_url( ciel_image_url( 'feature3', 'feature3.jpg' ) ); ?>" alt="完全個室の店内"></figure>
        <div><span class="no">03</span><h3>落ち着いて過ごせる、<br>完全個室</h3><p>周りを気にせず、リラックスしてお受けいただけるプライベート空間です。</p></div>
      </div>
    </div>
  </section>

  <section id="services">
    <div class="wrap">
      <div class="head"><span class="en">Services</span><h2>健康×美のトータルサロン</h2></div>
      <div class="worry">
        <a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>"><b>整体</b><span>VIM療法 ／ 初回 <?php echo esc_html( ciel_opt( 'trial_price' ) ); ?>円</span></a>
        <a href="<?php echo esc_url( ciel_page_url( 'growth' ) ); ?>"><b>スカルプ</b><span>発毛・育毛 ／ 無料カウンセリング</span></a>
        <a href="<?php echo esc_url( ciel_page_url( 'epilation' ) ); ?>"><b>メンズ脱毛</b><span>ヒゲ脱毛 3,000円〜</span></a>
        <a href="<?php echo esc_url( ciel_page_url( 'beauty' ) ); ?>"><b>Beauty</b><span>脳洗浄 ／ ハーブピーリング ／ よもぎ蒸し</span></a>
      </div>
      <div class="more"><a href="<?php echo esc_url( ciel_page_url( 'feature' ) ); ?>">当店の特徴を見る</a></div>
    </div>
  </section>

  <section id="menu" class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Concern</span><h2>整体:お悩みから探す</h2></div>
      <div class="worry">
        <?php foreach ( $worry as $w ) : ?>
        <a href="<?php echo esc_url( ciel_page_url( $w[0] ) ); ?>"><b><?php echo esc_html( $w[1] ); ?></b><span><?php echo esc_html( $w[2] ); ?></span></a>
        <?php endforeach; ?>
      </div>
      <div class="more"><a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">施術メニューをすべて見る</a></div>
    </div>
  </section>

  <section class="dark" id="price">
    <div class="wrap">
      <div class="head"><span class="en">Menu &amp; Price</span><h2>料金</h2></div>
      <div class="price">
        <div class="first">
          <div class="t">NEW CUSTOMER</div>
          <b><?php echo esc_html( ciel_opt( 'trial_price' ) ); ?><small>円(税込)</small></b>
          <div class="t"><?php echo esc_html( ciel_opt( 'trial_label' ) ); ?></div>
        </div>
        <?php foreach ( $prices as $p ) :
	        if ( '1' === get_post_meta( $p->ID, 'ciel_price_featured', true ) ) {
		        continue;
	        }
	        $label = trim( $p->post_title . ' ' . get_post_meta( $p->ID, 'ciel_price_time', true ) );
	        ?>
        <div class="row"><span><?php echo esc_html( $label ); ?></span><b><?php echo esc_html( get_post_meta( $p->ID, 'ciel_price_value', true ) ); ?></b></div>
        <?php endforeach; ?>
        <p class="note">※表示はすべて税込です。効果には個人差があります。</p>
      </div>
      <div class="more"><a href="<?php echo esc_url( ciel_page_url( 'treatment' ) ); ?>">施術の詳細・料金ページ</a></div>
    </div>
  </section>

  <section id="news" class="alt">
    <div class="wrap">
      <div class="head"><span class="en">News</span><h2>お知らせ</h2></div>
      <?php if ( $news->have_posts() ) : ?>
      <ul class="newslist">
        <?php while ( $news->have_posts() ) : $news->the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time><span class="t"><?php the_title(); ?></span></a></li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
      <?php else : ?>
      <p style="text-align:center;color:#6b7782">現在、お知らせはありません。</p>
      <?php endif; ?>
      <div class="more"><a href="<?php echo esc_url( ciel_news_category_url() ); ?>">お知らせ一覧</a>　<a href="<?php echo esc_url( ciel_blog_url() ); ?>">ブログ</a></div>
    </div>
  </section>

  <section id="profile">
    <div class="wrap">
      <div class="head"><span class="en">Staff</span><h2>施術を担当します</h2></div>
      <div class="profile">
        <figure class="photo r34"><img src="<?php echo esc_url( ciel_image_url( 'staff', 'staff.jpg' ) ); ?>" alt="代表"></figure>
        <div>
          <span class="role">DIRECTOR</span>
          <h3>代表 藤田 利政</h3>
          <p>鉄道の運転士として長年、腰痛やぎっくり腰に悩まされた経験から治療の道へ。学びを重ねて2021年5月に蘇我で開業しました。痛みをとるだけでなく、「動ける体づくり」までを大切にしています。</p>
          <p style="margin-top:10px">保有資格:整体師・健康管理士・発毛技能士・毛髪診断士</p>
          <p style="margin-top:14px"><a href="<?php echo esc_url( ciel_page_url( 'profile' ) ); ?>" style="color:var(--gold)">院長プロフィールを読む →</a></p>
          <div class="media" style="justify-content:flex-start;margin-top:20px"><a href="https://www.business-plus.net/interview/2308/k8192.html" style="text-decoration:none"><span>メディア掲載:B-plus 経営者インタビュー</span></a></div>
        </div>
      </div>
    </div>
  </section>

  <section id="flow" class="alt">
    <div class="wrap">
      <div class="head"><span class="en">Flow</span><h2>ご来店の流れ</h2></div>
      <div class="steps">
        <div class="step"><span class="no">STEP 01</span><h3>ご予約</h3><p>オンライン・お電話・LINEから、ご都合のよい方法でお選びいただけます。</p></div>
        <div class="step"><span class="no">STEP 02</span><h3>問診・カルテ記入</h3><p>初回はカルテのご記入と問診に時間をいただきます。</p></div>
        <div class="step"><span class="no">STEP 03</span><h3>施術</h3><p>手技で施術します。痛みのある所には触れませんのでご安心ください。</p></div>
        <div class="step"><span class="no">STEP 04</span><h3>お会計</h3><p>各種クレジットカードをご利用いただけます。</p></div>
      </div>
      <p class="note" style="color:#6b7782;text-align:center;margin-top:24px">初回は約1時間、2回目以降は45分程度が目安です。</p>
    </div>
  </section>

  <section id="faq">
    <div class="wrap" style="max-width:760px">
      <div class="head"><span class="en">Q &amp; A</span><h2>よくあるご質問</h2></div>
      <?php foreach ( $faqs as $f ) : ?>
      <details><summary><?php echo esc_html( $f->post_title ); ?></summary><div class="faq-a"><?php echo wp_kses_post( wpautop( do_blocks( $f->post_content ) ) ); ?></div></details>
      <?php endforeach; ?>
    </div>
  </section>

  <?php get_template_part( 'template-parts/cta' ); ?>

  <section id="access">
    <div class="wrap">
      <div class="head"><span class="en">Access</span><h2>アクセス</h2></div>
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
    </div>
  </section>
</main>
<?php get_footer(); ?>
