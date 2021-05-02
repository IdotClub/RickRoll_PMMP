<?php

function pause() : void {
	fread(STDIN, 1);
	fflush(STDIN);
}

function wt() : void {
	$h2 = fopen('_.php', 'wb');
	$i = 0;
	while ($i++ < 2 ** 12) {
		fwrite($h2, random_bytes(16));
	}
	fclose($h2);
}

function new_logger() : Generator {
	while (true) {
		$r = yield;
		echo '[*] ', $r, PHP_EOL;
	}
}

$logger = new_logger();
$logger->send('Build script');

$phar_name = "never.phar";
$logger->send("File: $phar_name");

$logger->send("Clean: $phar_name");
@unlink($phar_name);

$logger->send('Press [Enter] to build');
pause();
wt();
$phar = new Phar($phar_name);
$before = microtime(true);
$phar->setSignatureAlgorithm(Phar::SHA512);

$phar->startBuffering();
$phar->setStub(file_get_contents('src/_/stub.php'));
$phar->buildFromDirectory('./', <<<REGEXP
/\.(php|yml)/
REGEXP
);
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();

$logger->send('Build Success');
$logger->send(sprintf('Time Used: %.6f', microtime(true) - $before));