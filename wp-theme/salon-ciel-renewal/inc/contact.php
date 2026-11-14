<?php
/**
 * お問い合わせフォーム(メール送信)。
 * 送信先は、カスタマイザーの「問い合わせメールの送信先」。未設定なら、WordPressの管理者メール。
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_nopriv_ciel_contact', 'ciel_handle_contact' );
add_action( 'admin_post_ciel_contact', 'ciel_handle_contact' );

function ciel_handle_contact() {
	$back = wp_get_referer();
	$back = $back ? remove_query_arg( array( 'sent', 'err' ), $back ) : ciel_page_url( 'contact' );

	$go = function ( $arg, $val ) use ( $back ) {
		wp_safe_redirect( add_query_arg( $arg, $val, $back ) . '#form' );
		exit;
	};

	if ( ! isset( $_POST['ciel_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ciel_nonce'] ) ), 'ciel_contact' ) ) {
		$go( 'err', 'nonce' );
	}
	if ( ! empty( $_POST['website'] ) ) { // 迷惑送信よけ(人には見えない欄)
		$go( 'sent', '1' );
	}

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'ciel_ct_' . md5( $ip );
	if ( get_transient( $key ) ) {
		$go( 'err', 'wait' );
	}

	$name  = isset( $_POST['c_name'] ) ? sanitize_text_field( wp_unslash( $_POST['c_name'] ) ) : '';
	$kana  = isset( $_POST['c_kana'] ) ? sanitize_text_field( wp_unslash( $_POST['c_kana'] ) ) : '';
	$tel   = isset( $_POST['c_tel'] ) ? sanitize_text_field( wp_unslash( $_POST['c_tel'] ) ) : '';
	$mail  = isset( $_POST['c_mail'] ) ? sanitize_email( wp_unslash( $_POST['c_mail'] ) ) : '';
	$mail2 = isset( $_POST['c_mail2'] ) ? sanitize_email( wp_unslash( $_POST['c_mail2'] ) ) : '';
	$type  = isset( $_POST['c_type'] ) ? sanitize_text_field( wp_unslash( $_POST['c_type'] ) ) : '';
	$msg   = isset( $_POST['c_msg'] ) ? sanitize_textarea_field( wp_unslash( $_POST['c_msg'] ) ) : '';

	if ( '' === $name || '' === $msg || ! is_email( $mail ) || $mail !== $mail2 || empty( $_POST['c_agree'] ) ) {
		$go( 'err', 'input' );
	}
	if ( mb_strlen( $msg ) > 5000 ) {
		$go( 'err', 'input' );
	}

	$to = ciel_opt( 'contact_mail' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = '[' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . '] ホームページからのお問い合わせ(' . ( $type ? $type : 'その他' ) . ')';
	$body    = "ホームページからお問い合わせがありました。\n\n"
		. "お名前: {$name}\nふりがな: {$kana}\n電話番号: {$tel}\nメール: {$mail}\n種類: {$type}\n\n"
		. "【内容】\n{$msg}\n";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . str_replace( array( "\r", "\n", ',' ), '', $name ) . ' <' . $mail . '>' );

	$ok = wp_mail( $to, $subject, $body, $headers );
	if ( ! $ok ) {
		$go( 'err', 'mail' );
	}
	set_transient( $key, 1, 30 );
	$go( 'sent', '1' );
}

/** フォームを表示する */
function ciel_render_contact_form() {
	$sent = isset( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
	$err  = isset( $_GET['err'] ) ? sanitize_key( wp_unslash( $_GET['err'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$msgs = array(
		'input' => '入力内容をご確認ください。必須項目が空か、メールアドレスが一致していません。',
		'nonce' => '送信に失敗しました。ページを再読み込みして、もう一度お試しください。',
		'wait'  => '続けて送信されています。少し時間をおいて、もう一度お試しください。',
		'mail'  => 'メールを送信できませんでした。お手数ですが、お電話かLINEでお問い合わせください。',
	);
	echo '<div id="form" class="cform-wrap">';
	if ( $sent ) {
		echo '<p class="cform-ok">お問い合わせを受け付けました。内容を確認のうえ、ご連絡いたします。</p>';
	} else {
		if ( $err && isset( $msgs[ $err ] ) ) {
			echo '<p class="cform-err">' . esc_html( $msgs[ $err ] ) . '</p>';
		}
		?>
		<form class="cform" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		  <input type="hidden" name="action" value="ciel_contact">
		  <?php wp_nonce_field( 'ciel_contact', 'ciel_nonce' ); ?>
		  <div style="position:absolute;left:-9999px" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
		  <p><label>お名前 <em>必須</em><input type="text" name="c_name" required maxlength="100" autocomplete="name"></label></p>
		  <p><label>ふりがな<input type="text" name="c_kana" maxlength="100"></label></p>
		  <p><label>お電話番号<input type="tel" name="c_tel" maxlength="30" autocomplete="tel"></label></p>
		  <p><label>メールアドレス <em>必須</em><input type="email" name="c_mail" required maxlength="200" autocomplete="email"></label></p>
		  <p><label>メールアドレス(確認) <em>必須</em><input type="email" name="c_mail2" required maxlength="200"></label></p>
		  <p><label>お問い合わせの種類
		    <select name="c_type">
		      <option>ご予約について</option>
		      <option>施術について</option>
		      <option>当院について</option>
		      <option>その他</option>
		    </select></label></p>
		  <p><label>お問い合わせ内容 <em>必須</em><textarea name="c_msg" rows="7" required maxlength="5000"></textarea></label></p>
		  <p class="agree"><label><input type="checkbox" name="c_agree" value="1" required> 上記の内容をご確認のうえ、チェックしてください。</label></p>
		  <p><button type="submit" class="btn">送信する</button></p>
		</form>
		<?php
	}
	echo '</div>';
}
