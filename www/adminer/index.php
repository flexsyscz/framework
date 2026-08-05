<?php

declare(strict_types=1);

if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) || !isset($_SERVER['REMOTE_ADDR']) ||
	!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', '89.24.73.90'], true)) {
	header('HTTP/1.1 403 Forbidden');
	echo 'Adminer is available only from localhost';
	for ($i = 2e3; $i; $i--) {
		echo substr(" \t\r\n", rand(0, 3), 1);
	}
	exit;
}


$root = __DIR__ . '/../../vendor/dg/adminer-custom';

if (!is_file($root . '/index.php')) {
	echo "Install Adminer using `composer install`\n";
	exit(1);
}

$css = __DIR__ . '/adminer.css';
if (!file_exists($css)) {
	$defaultCss = $root . '/adminer.css';
	if (file_exists($defaultCss)) {
		file_put_contents($css, file_get_contents($defaultCss));
	} else {
		touch($css);
	}
}

require $root . '/index.php';
