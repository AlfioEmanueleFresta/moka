<?php

/*
 * The code in this page will be executed every night.
 * All the system maintenance should reside here.
 */

/* Expired sessions */
$expired = Session::expiredSessions();
foreach ( $expired as $session ) {
	$session = Session::object($session);
	$session->delete();
}
$log .= "Deleted {$expired->count()} expired sessions\n";



/* Removes expired files */
cron_register(CRON_STACK_DAILY, function() {
	$expired = File::expiredFiles();
	foreach ( $expired as $file ) {
		$file = Session::object($file);
		$file->File();
	}
	return "Deleted {$expired->count()} expired files";
});


cron_register(MONTHLY_STACK, function() {


	return "Ciao ho finito";
});