<?php
if (!$futurebb_user['g_mod_privs'] && !$futurebb_user['g_admin_privs']) {
	httperror(403);
}
translate('<addfile>', 'admin');
$page_title = 'reCAPTCHA Configuration';
include FORUM_ROOT . '/app_resources/includes/admin.php';
if (isset($_POST['form_sent'])) {
	set_config('recaptcha_secret', $_POST['recaptcha_secret']);
	set_config('recaptcha_pubkey', $_POST['recaptcha_pubkey']);
}
?>
<div class="container">
<?php make_admin_menu(); ?>
    <div class="forum_content rightbox admin">
        <form action="<?php echo $base_config['baseurl']; ?>/admin/captcha" method="post" enctype="multipart/form-data">
			<p>You can obtain these keys <a href="https://www.google.com/recaptcha/intro/index.html">here</a>. These must be set properly for this to work.</p>
        	<p>Secret key: <input type="text" name="recaptcha_secret" value="<?php echo htmlspecialchars($futurebb_config['recaptcha_secret']); ?>" /></p>
			<p>Public (site) key: <input type="text" name="recaptcha_pubkey" value="<?php echo htmlspecialchars($futurebb_config['recaptcha_pubkey']); ?>" /></p>
		   	<p><input type="submit" value="Save" name="form_sent" /></p>
        </form>
    </div>
</div>