<?php
if ($futurebb_user['language'] != 'English') {
	$error = 'This extension only works in English. Please change your language.';
	return;
}
if (!ini_get('allow_url_fopen')) {
	$error = 'allow_url_fopen is not allowed in your PHP settings. This means that referencing the database at StopForumSpam.com will not work.';
	return;
}
ExtensionConfig::add_language_key('captcha', 'CAPTCHA', 'English');
ExtensionConfig::add_language_key('captcha_failmsg', 'CAPTCHA was invalid. Please try again.', 'English');
ExtensionConfig::add_page('/admin/captcha', array('file' => 'admin/captcha.php', 'template' => true, 'nocontentbox' => true, 'admin' => true));
ExtensionConfig::add_admin_menu('captcha', 'captcha');
$q = new DBInsert('config', array('c_name' => 'recaptcha_secret', 'c_value' => ''), 'Failed to insert new config entry: recaptcha_secret');
$q->commit();

$q = new DBInsert('config', array('c_name' => 'recaptcha_pubkey', 'c_value' => ''), 'Failed to insert new config entry: recaptcha_pubkey');
$q->commit();