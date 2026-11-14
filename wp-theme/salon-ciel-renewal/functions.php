<?php
/**
 * Salon Ciel Renewal theme functions.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CIEL_VERSION', '1.1.0' );

require_once get_template_directory() . '/inc/seed-pages.php';
require_once get_template_directory() . '/inc/contact.php';

/* ---------- 基本設定 ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	register_nav_menus( array( 'primary' => 'ヘッダーメニュー' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ciel-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Noto+Serif+JP:wght@400;500;700&family=Noto+Sans+JP:wght@300;400;500&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'ciel-style', get_stylesheet_uri(), array( 'ciel-fonts' ), CIEL_VERSION );
} );

/** ヘッダーのメニューを <a> だけで出力する */
class Ciel_Plain_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$output .= '<a href="' . esc_url( $data_object->url ) . '">' . esc_html( $data_object->title ) . '</a>';
	}
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}

/* ---------- 設定値の取得 ---------- */
function ciel_defaults() {
	return array(
		'phone'         => '043-309-6500',
		'line_url'      => 'https://lin.ee/z3pU5tS',
		'reserve_url'   => 'https://ssv.onemorehand.jp/salonciel_chiba/',
		'contact_url'   => home_url( '/contact/' ),
		'contact_mail'  => '',
		'zip'           => '260-0834',
		'address'       => '千葉県千葉市中央区今井2-4-7 新月ビル503',
		'access'        => 'JR蘇我駅 西口 徒歩1分(ローソン入居ビル5階)',
		'hours_weekday' => '平日 10:00〜21:00',
		'hours_weekend' => '土日祝 10:00〜18:00',
		'trial_price'   => '4,980',
		'trial_label'   => '新規お試し 60分 × 2回',
		'noindex'       => 1,
	);
}

function ciel_opt( $key ) {
	$d = ciel_defaults();
	$v = get_theme_mod( 'ciel_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return ( '' === $v || null === $v ) ? ( isset( $d[ $key ] ) ? $d[ $key ] : '' ) : $v;
}

function ciel_tel_href() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', ciel_opt( 'phone' ) );
}

/** 写真: カスタマイザーで設定があればそれ、なければテーマ同梱の画像 */
function ciel_image_url( $key, $default_file ) {
	$id = get_theme_mod( 'ciel_img_' . $key );
	if ( $id ) {
		$url = is_numeric( $id ) ? wp_get_attachment_image_url( (int) $id, 'large' ) : esc_url_raw( $id );
		if ( $url ) {
			return $url;
		}
	}
	return get_template_directory_uri() . '/assets/images/' . $default_file;
}

function ciel_page_url( $slug ) {
	$p = get_page_by_path( $slug );
	return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
}

function ciel_news_category_url() {
	$term = get_category_by_slug( 'news' );
	return $term ? get_category_link( $term ) : home_url( '/category/news/' );
}

function ciel_blog_url() {
	$id = (int) get_option( 'page_for_posts' );
	return $id ? get_permalink( $id ) : home_url( '/blog/' );
}

/** サイト全体のメニュー(ヘッダー・スマホメニュー・フッターで共通) */
function ciel_nav_items() {
	return array(
		array( '当店の特徴', ciel_page_url( 'feature' ) ),
		array( '施術・料金', ciel_page_url( 'treatment' ) ),
		array( 'スカルプ', ciel_page_url( 'growth' ) ),
		array( '脱毛', ciel_page_url( 'epilation' ) ),
		array( 'Beauty', ciel_page_url( 'beauty' ) ),
		array( '院長紹介', ciel_page_url( 'profile' ) ),
		array( 'お知らせ', ciel_news_category_url() ),
		array( 'ブログ', ciel_blog_url() ),
		array( 'アクセス', ciel_page_url( 'access' ) ),
	);
}

/** フッター用のそのほかのリンク */
function ciel_footer_items() {
	return array(
		array( '店舗概要', ciel_page_url( 'about' ) ),
		array( 'お客様の声', ciel_page_url( 'customer' ) ),
		array( 'よくあるご質問', ciel_page_url( 'faq' ) ),
		array( 'お問い合わせ', ciel_opt( 'contact_url' ) ),
	);
}

/* ---------- noindex (公開前) ---------- */
add_filter( 'wp_robots', function ( $robots ) {
	if ( ciel_opt( 'noindex' ) ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	}
	return $robots;
} );

/* ---------- カスタマイザー ---------- */
add_action( 'customize_register', function ( $wp_customize ) {
	$d = ciel_defaults();

	$wp_customize->add_panel( 'ciel_panel', array(
		'title'    => 'サロン情報(Salon Ciel)',
		'priority' => 30,
	) );

	$wp_customize->add_section( 'ciel_info', array(
		'title' => '基本情報・営業時間',
		'panel' => 'ciel_panel',
	) );
	$text_fields = array(
		'phone'         => '電話番号(表示用)',
		'hours_weekday' => '営業時間(平日)',
		'hours_weekend' => '営業時間(土日祝)',
		'zip'           => '郵便番号',
		'address'       => '住所',
		'access'        => 'アクセス案内',
		'trial_price'   => '新規お試し料金(数字のみ)',
		'trial_label'   => '新規お試しの説明',
		'contact_mail'  => '問い合わせメールの送信先(空欄なら管理者メール)',
	);
	foreach ( $text_fields as $key => $label ) {
		$wp_customize->add_setting( 'ciel_' . $key, array(
			'default'           => $d[ $key ],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'ciel_' . $key, array(
			'label'   => $label,
			'section' => 'ciel_info',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_section( 'ciel_links', array(
		'title' => 'リンク(予約・LINE・問い合わせ)',
		'panel' => 'ciel_panel',
	) );
	$url_fields = array(
		'reserve_url' => '予約ページのURL',
		'line_url'    => 'LINEのURL',
		'contact_url' => '問い合わせページのURL',
	);
	foreach ( $url_fields as $key => $label ) {
		$wp_customize->add_setting( 'ciel_' . $key, array(
			'default'           => $d[ $key ],
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'ciel_' . $key, array(
			'label'   => $label,
			'section' => 'ciel_links',
			'type'    => 'url',
		) );
	}

	$wp_customize->add_section( 'ciel_images', array(
		'title'       => '写真の差し替え',
		'panel'       => 'ciel_panel',
		'description' => '設定しない場合は、テーマ付属の写真が表示されます。',
	) );
	$img_fields = array(
		'hero'     => 'トップのメイン写真',
		'feature1' => '特徴① 写真(カウンセリング)',
		'feature2' => '特徴② 写真(施術)',
		'feature3' => '特徴③ 写真(個室)',
		'staff'    => '代表の写真',
		'access'   => 'アクセスの写真',
	);
	foreach ( $img_fields as $key => $label ) {
		$wp_customize->add_setting( 'ciel_img_' . $key, array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'ciel_img_' . $key, array(
			'label'     => $label,
			'section'   => 'ciel_images',
			'mime_type' => 'image',
		) ) );
	}

	$wp_customize->add_section( 'ciel_seo', array(
		'title' => '公開設定',
		'panel' => 'ciel_panel',
	) );
	$wp_customize->add_setting( 'ciel_noindex', array(
		'default'           => 1,
		'sanitize_callback' => function ( $v ) {
			return $v ? 1 : 0;
		},
	) );
	$wp_customize->add_control( 'ciel_noindex', array(
		'label'       => '検索エンジンに表示しない(公開前はオン)',
		'description' => '本番公開するときにオフにしてください。',
		'section'     => 'ciel_seo',
		'type'        => 'checkbox',
	) );
} );

/* ---------- カスタム投稿: 料金・FAQ ---------- */
add_action( 'init', function () {
	register_post_type( 'ciel_price', array(
		'labels'       => array(
			'name'          => '料金メニュー',
			'singular_name' => '料金メニュー',
			'add_new_item'  => '料金メニューを追加',
			'edit_item'     => '料金メニューを編集',
			'menu_name'     => '料金メニュー',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-money-alt',
		'menu_position'=> 21,
		'supports'     => array( 'title', 'page-attributes' ),
		'show_in_rest' => false,
	) );
	register_post_type( 'ciel_faq', array(
		'labels'       => array(
			'name'          => 'よくある質問',
			'singular_name' => 'よくある質問',
			'add_new_item'  => '質問を追加',
			'edit_item'     => '質問を編集',
			'menu_name'     => 'よくある質問',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-editor-help',
		'menu_position'=> 22,
		'supports'     => array( 'title', 'editor', 'page-attributes' ),
		'show_in_rest' => true,
	) );
} );

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'ciel_price_box', '料金の設定', 'ciel_price_box_render', 'ciel_price', 'normal', 'high' );
} );

function ciel_price_box_render( $post ) {
	wp_nonce_field( 'ciel_price_save', 'ciel_price_nonce' );
	$time     = get_post_meta( $post->ID, 'ciel_price_time', true );
	$price    = get_post_meta( $post->ID, 'ciel_price_value', true );
	$desc     = get_post_meta( $post->ID, 'ciel_price_desc', true );
	$featured = get_post_meta( $post->ID, 'ciel_price_featured', true );
	?>
	<p><label>時間・回数(例: 60分)<br><input type="text" name="ciel_price_time" value="<?php echo esc_attr( $time ); ?>" class="widefat"></label></p>
	<p><label>料金(税込・例: 6,000円)<br><input type="text" name="ciel_price_value" value="<?php echo esc_attr( $price ); ?>" class="widefat"></label></p>
	<p><label>説明(任意)<br><textarea name="ciel_price_desc" rows="3" class="widefat"><?php echo esc_textarea( $desc ); ?></textarea></label></p>
	<p><label><input type="checkbox" name="ciel_price_featured" value="1" <?php checked( $featured, '1' ); ?>> 目立たせる(新規お試し用)</label></p>
	<p class="description">並び順は、右側の「順序」の数字(小さいほど上)で変えられます。</p>
	<?php
}

add_action( 'save_post_ciel_price', function ( $post_id ) {
	if ( ! isset( $_POST['ciel_price_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ciel_price_nonce'] ) ), 'ciel_price_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'ciel_price_time', isset( $_POST['ciel_price_time'] ) ? sanitize_text_field( wp_unslash( $_POST['ciel_price_time'] ) ) : '' );
	update_post_meta( $post_id, 'ciel_price_value', isset( $_POST['ciel_price_value'] ) ? sanitize_text_field( wp_unslash( $_POST['ciel_price_value'] ) ) : '' );
	update_post_meta( $post_id, 'ciel_price_desc', isset( $_POST['ciel_price_desc'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ciel_price_desc'] ) ) : '' );
	update_post_meta( $post_id, 'ciel_price_featured', ! empty( $_POST['ciel_price_featured'] ) ? '1' : '0' );
} );

function ciel_get_prices() {
	return get_posts( array(
		'post_type'      => 'ciel_price',
		'posts_per_page' => 50,
		'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
		'post_status'    => 'publish',
	) );
}

function ciel_get_faqs() {
	return get_posts( array(
		'post_type'      => 'ciel_faq',
		'posts_per_page' => 50,
		'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
		'post_status'    => 'publish',
	) );
}

/* ---------- 抜粋・日付 ---------- */
add_filter( 'excerpt_length', function () {
	return 60;
} );

/* ---------- 初期コンテンツの自動作成(テーマ有効化時に1回だけ) ---------- */
add_action( 'after_switch_theme', 'ciel_seed_content' );

function ciel_seed_content() {
	if ( get_option( 'ciel_seeded' ) ) {
		return;
	}

	// お知らせカテゴリ
	if ( ! get_category_by_slug( 'news' ) ) {
		wp_insert_term( 'お知らせ', 'category', array( 'slug' => 'news' ) );
	}

	$make_page = function ( $title, $slug, $content, $template = '' ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			return $existing->ID;
		}
		$id = wp_insert_post( array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		) );
		if ( $id && ! is_wp_error( $id ) && $template ) {
			update_post_meta( $id, '_wp_page_template', $template );
		}
		return $id;
	};

	$vim = "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">VIM療法とは</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>VIM(Voluntary Inhibition Method)は、痛みのある側ではなく、反対側へアプローチする施術法です。たとえば左の股関節がつらいときは、右の股関節を調整します。痛い部分に直接触れない、やさしい施術です。</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>当店は、この療法の認定院です。</p>\n<!-- /wp:paragraph -->";

	$parts = array(
		'neck-shoulder' => array( '肩こり・首の痛み', array(
			'<h3>首・肩がつらくなる理由</h3><p>首の筋肉は細くて薄いのに、前後左右や回旋など多くの動きを担っています。一部の筋肉だけに負担が集中すると、痛みとして信号を出します。スマホを見る姿勢で起こる「スマホ首」も、首の一部に負担がかかった結果です。</p><p>負担のかかった筋肉を守るために、まわりの筋肉も固まり、動かさないよう痛みを出すことがあります。</p>',
			'<h3>むち打ちについて</h3><p>軽い衝撃でも、頭を支えようと筋肉が一瞬で固まり、わずかにずれたまま緊張が続くことがあります。直後は無症状でも、数日たつと重だるさとして現れる場合があります。</p>',
		) ),
		'waist-back'    => array( '腰・背中の痛み', array(
			'<h3>腰・背中の痛みについて</h3><p>ぎっくり腰を繰り返す方は、日ごろから負担のかかっている筋肉があります。そうした筋肉は、休むための「緩めて」という神経の信号がうまく届かないことがあります。</p><p>限界が来たとき、筋肉が傷つかないよう周囲の筋肉を一瞬で固めるため、強い痛みとして現れます。この信号に働きかけて筋肉を緩めていくのが、当店のVIM療法です。</p>',
		) ),
		'knees-foot'    => array( '膝の痛み・捻挫', array(
			'<h3>膝の痛みについて</h3><p>膝は曲げ伸ばしやわずかなひねりを担う関節で、太ももの前後・内外、ひざ下、足首を動かす筋肉の影響も受けます。猫背やお尻が落ちる姿勢でも負担が変わります。</p><p>関節に負担がかかり、水がたまる前に、正しい体の使い方を覚えて予防することも大切です。再発しないための生活指導は無料で行っています。</p>',
		) ),
		'hip'           => array( '股関節の痛み', array(
			'<h3>股関節の痛みについて</h3><p>股関節は、足を上げる・開く・閉じるなど多くの動きができる関節で、安定させる筋肉も大小さまざまです。痛みの原因が股関節とは限らず、足首、膝、腰が関わっていることもあります。</p><p>全身の筋肉は助け合って動いているため、一部の不調が全身に広がることもあります。そこでまず全体の動きをつくり、そのうえで股関節の調整を行います。この調整にもVIM療法を使います。</p>',
		) ),
		'elbow-wrist'   => array( '肘・手首の痛み', array(
			'<h3>肘・手首の痛みについて</h3><p>肘や手首の痛みは、そのうち治るだろうと放っておくと、字が書けない、物が持てないなど、日常生活に影響することがあります。</p><p>手指のこわばりやしびれは、手首や肘まわりの筋肉・腱・靭帯が緊張していることが一因の場合があります。当店では、肘や手首だけでなく腕全体、体全体を見てVIM療法を行います。肘が上がらない・曲がらないときは、肩へのアプローチも含めて調整します。</p>',
		) ),
	);
	foreach ( $parts as $slug => $data ) {
		$body = '';
		foreach ( $data[1] as $html ) {
			$body .= "<!-- wp:html -->\n" . $html . "\n<!-- /wp:html -->\n\n";
		}
		$body .= $vim . "\n\n<!-- wp:paragraph {\"className\":\"disc\"} -->\n<p class=\"disc\">※効果・感じ方には個人差があります。医療行為ではありません。</p>\n<!-- /wp:paragraph -->";
		$make_page( $data[0], $slug, $body );
	}

	$make_page( '施術メニュー・料金', 'treatment', $vim . "\n\n<!-- wp:paragraph -->\n<p>※料金はすべて税込です。効果・感じ方には個人差があります。</p>\n<!-- /wp:paragraph -->" );

	$home_id = $make_page( 'ホーム', 'home', '' );
	$blog_id = $make_page( 'ブログ', 'blog', '' );
	if ( $home_id && $blog_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'page_for_posts', $blog_id );
	}

	// 料金
	$prices = array(
		array( '新規お試し整体', '60分 × 2回', '4,980円', '初回限定。通常60分6,000円のところ、60分×2回でお試しいただけます。', 1, 1 ),
		array( '各種整体', '40分', '5,000円', '首・肩・腰・膝などの不調に。お子様から年配の方まで、ダイエットやパフォーマンスアップにも。', 0, 2 ),
		array( '全身本格整体', '60分', '6,000円', 'VIM療法をメインに体全体を調整します。首・肩の不調でも足首から診ます。自宅でできる簡単な運動もお伝えします。', 0, 3 ),
		array( '全身スポーツ整体', '80分', '7,000円', 'パフォーマンスが落ちてきた方、不調が続いている方に。筋肉を回復させ、体をつなげていきます。', 0, 4 ),
		array( '学生・65歳以上', '40分', '3,500円', '65歳以上・学生のお客様限定のプランです。', 0, 5 ),
		array( 'VIM体操指導', '90分', '5,000円', '', 0, 6 ),
	);
	foreach ( $prices as $p ) {
		$id = wp_insert_post( array(
			'post_type'   => 'ciel_price',
			'post_title'  => $p[0],
			'post_status' => 'publish',
			'menu_order'  => $p[5],
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'ciel_price_time', $p[1] );
			update_post_meta( $id, 'ciel_price_value', $p[2] );
			update_post_meta( $id, 'ciel_price_desc', $p[3] );
			update_post_meta( $id, 'ciel_price_featured', (string) $p[4] );
		}
	}

	// FAQ
	$faqs = array(
		array( 'どんな服装で行けばよいですか?', 'なるべく動きやすい服装がおすすめです。スカートやタイトなジーンズは向きません。' ),
		array( '年齢制限はありますか?', '特に制限はありません。ただし、お子様お一人での施術は受け付けておりません。' ),
		array( '女性でも安心して受けられますか?', '多くの女性のお客様にご来店いただいています。手技での施術のためお体に触れますが、お声がけをしながら細心の配慮で施術します。' ),
		array( '痛みがあったり、ポキポキしたりしませんか?', '基本的に、痛みのあるところには触りませんのでご安心ください。' ),
		array( '施術時間はどれくらいですか?', '初回はカルテ記入と問診を含めて1時間程度、2回目以降は45分程度です。' ),
		array( '保険は使えますか?', '整体は保険適用外となります。' ),
		array( '駐車場はありますか?', '近くに多数のコインパーキングがございますので、そちらをご利用ください。' ),
		array( 'クレジットカードは使えますか?', 'VISA、Mastercard、JCB、AMEX、Dinersがご利用いただけます。' ),
	);
	foreach ( $faqs as $i => $f ) {
		wp_insert_post( array(
			'post_type'    => 'ciel_faq',
			'post_title'   => $f[0],
			'post_content' => '<!-- wp:paragraph --><p>' . $f[1] . '</p><!-- /wp:paragraph -->',
			'post_status'  => 'publish',
			'menu_order'   => $i + 1,
		) );
	}

	// お知らせ(サンプル)
	$news = get_category_by_slug( 'news' );
	wp_insert_post( array(
		'post_title'    => '新しいホームページを公開しました(サンプル記事)',
		'post_content'  => '<!-- wp:paragraph --><p>これはサンプルのお知らせです。管理画面の「投稿」から、お知らせやブログを追加できます。このサンプルは削除して構いません。</p><!-- /wp:paragraph -->',
		'post_status'   => 'publish',
		'post_category' => $news ? array( $news->term_id ) : array(),
	) );

	update_option( 'ciel_seeded', 1 );
	flush_rewrite_rules();
}
