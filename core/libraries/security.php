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


/**
 * Forbids logged in users to access a page 
 * 
 * @param string $go Optional. Where to redirect the user. Default is public/home
 * @param string $status Optional. The status to pass to the page. Default is "security"
 */
function publicPage( $go = '/public/home', $status = "security" ) {
	global $me;
	if ( $me )
		redirect($go, $status);
}

/**
 * Forbids anonymous users to access a page 
 * 
 * @param string $go Optional. Where to redirect the user. Default is public/login
 * @param string $status Optional. The status to pass to the page. Default is "security"
 */
function privatePage( $go = '/auth/login', $status = "security" ) {
	global $me, $page;
	if ( !$me )
		redirect($go, $status, ['back' => '/' . $page]);
}

