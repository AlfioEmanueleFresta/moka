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

publicPage();

catchStatus(
	'already_registered',
	STATUS_DANGER,
	"You are already registered",
	"Please login instead."
);

catchStatus(
	'empty_fields',
	STATUS_WARNING,
	"Empty fields",
	"Please fill everything!"
);

$payload = getPayload();
if ( $payload && isset($payload['back']) ) {
	$back = $payload['back'];
}

?>

<form class="form-signin" method="POST" action="/auth/register_ok">
	<h2 class="form-signin-heading">Register</h2>
	<input name="name" type="text" class="form-control" placeholder="Full name" required autocomplete="off" />
	<input name="email" type="email" class="form-control" placeholder="Email address" autofocus required autocomplete="off" />
	<input name="password" type="password" class="form-control" placeholder="Password" required autocomplete="off" />

	<button class="btn btn-lg btn-warning btn-block" type="submit">
		<i class="icon-asterisk"></i>
		Register
	</button>
</form>
