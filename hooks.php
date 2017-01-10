<?php
//the hooks file for the CAPTCHA extension
$hooks = array();
$hooks['review_registration'] = array( 
	function($args) {
		global $errors, $futurebb_config;
		if ($futurebb_config['recaptcha_pubkey'] == '' || $futurebb_config['recaptcha_secret'] == '') {
			//don't do anything if the keys aren't set
			return true;
		}
		
		$postdata = http_build_query(
			array(
				'secret' => $futurebb_config['recaptcha_secret'],
				'response' => $_POST['g-recaptcha-response'],
				'remoteip' => $_SERVER['REMOTE_ADDR'],
			)
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		
		if (strstr($response, 'invalid-input-secret')) {
			$errors[] = 'The CAPTCHA plugin is not set up properly (invalid private/secret key). Please contact the forum owner.';
			return false;
		}
		
		if (!strstr($response, '"success": true')) {
			$errors[] = translate('captcha_failmsg');
			return false;
		}
	}
);

$hooks['load_header'] = array(
	function($args) {
		global $dirs;
		if (isset($dirs[1]) && $dirs[1] == 'register') {
			?>
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<?php
		}
	}
);

$hooks['show_captcha'] = array(
	function($args) {
		global $futurebb_config;
		if ($futurebb_config['recaptcha_pubkey'] == '' || $futurebb_config['recaptcha_secret'] == '') {
			echo '<p>You must configure your CAPTCHA extension with a public and secret key for it to work. Go to the administration panel and open the "CAPTCHA" page to set those options.</p>';
		} else {
			?>
			<div class="g-recaptcha" data-sitekey="<?php echo $futurebb_config['recaptcha_pubkey']; ?>"></div>
			<?php
		}
	}
);