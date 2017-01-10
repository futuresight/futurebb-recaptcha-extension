<?php
ExtensionConfig::remove_language_key('captcha', 'English');
ExtensionConfig::remove_language_key('captcha_failmsg', 'English');
ExtensionConfig::remove_page('/admin/captcha');
ExtensionConfig::remove_admin_menu('captcha');
$q = new DBDelete('config', 'c_name IN(\'recaptcha_secret\')', 'Failed to delete config values');
$q->commit();

$files_to_delete = array('app_resources/pages/admin/captcha.php');