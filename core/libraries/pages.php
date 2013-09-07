<?php

/*
 *
 * This is MOKA, a simple and modern PHP framework
 * Copyright 2013, the authors:
 * - Alfio Emanuele Fresta 	<alfio.emanuele.f@gmail.com>
 * - Angelo Lupo			<angelolupo94@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

/*
 * Constants 
 */
define('STATUS_OK',	null);

define('STATUS_WARNING',	'warning');
define('STATUS_DANGER',		'danger');
define('STATUS_SUCCESS',	'success');
define('STATUS_INFO',		'info');

/**
 * Redirect to a different page, eventually using payload
 * 
 * @param string $page 		The page to be redirected to
 * @param string $status 	Optional. The page state you want to get	
 * @param array  $payload	Optional. The payload you want to tranfer
 */
function redirect ( $page, $status = STATUS_OK, $payload = [] ) {
	global $session;
	if ($status)
		$session->status = $status;
	if ($payload)
		$session->payload = $payload;
	header("Location: {$page}");
	exit(0);
} 

/**
 * Empty the payload at the end of the page
 */
function emptyPayload() {
	global $session;
	$session->status  = null;
	$session->payload = [];
}

/**
 * Get the payload you passed
 */
function getPayload() {
	global $session;
	$payload = $session->payload;
	if (!$payload)
		return null;
	return $payload;
}

/**
 * Get the status of the page
 */
function getStatus() {
	global $session;
	$status = $session->status;
	if (!$status)
		return STATUS_OK;
	return $status;
}

/**
 * Catch a status and generate a boostrap alert
 *
 * @param string 	$status 	The status code to catch
 * @param int 		$type 		Type of alert to display, one of STATUS_* constants
 * @param string 	$line1 		The first line of the message
 * @param string 	$line2		Optional. The second line of the message
 * @param callable 	$callback 	Optional. Some code to execute 
 */
function catchStatus(
	$status 	,
	$type  		= STATUS_SUCCESS,
	$line1 		= "Success!",
	$line2 		= null,
	$callback 	= null
) {
	if ($status != getStatus())
		return false;
	echo "<div class='alert alert-{$type}' data-alert='true' data-status='{$status}'>\n";
	if ( $line2 ) {
		echo "<h4>{$line1}</h4>\n";
		echo "<p>{$line2}</p>\n";
	} else {
		echo "<p>{$line1}</p>\n";
	}
	echo "</div>\n";
	if ($callback && is_callable($callback))
		call_user_func($callback);
	return true;
}
