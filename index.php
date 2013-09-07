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

require 'core/core.php';

/*
 * Set caching on...
 */
ob_start('ob_gzhandler');
ob_start('_template_replace');

/*
 * Gets the current session from the user cookie
 * and persists it creating a new one!
 */
$session = new Session(@$_COOKIE['sid']);
setcookie('sid', (string) $session);

/*
 * Now set the $me global variable, if I'm in!
 */
if ( $user = $session->user() ) {
	$me = $user;
}

/*
 * Load the frontend template...
 */
require 'templates/frontend/defaults.php';
require 'templates/frontend/header.php';

/*
 * Routing logic
 */
$page = $_SERVER['REQUEST_URI'];
if ( strpos($page, '?') !== false ) {
	$page = strstr($page, '?', true);
}
$page = explode('/', $page);
$page = array_diff($page, ['']);
$page = implode('/', $page);
if ( !$page ) { $page = 'public/home'; }
$file = "pages/{$page}.php";
if ( !is_readable($file) ) {
	$file = 'pages/error/404.php';
}

require $file;
require 'templates/frontend/footer.php';

emptyPayload();

/*
 * Finally, go flush everything out
 */
ob_end_flush(); 
header("Content-length: {ob_get_length()}"); 
ob_end_flush();