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

if (empty($_POST['email']) 	|| empty($_POST['password']))
	redirect("/auth/login", "empty_fields");

$user = User::findOne([
		'email' => $_POST['email']
	],
	['password']
);

if (!$user)
	redirect("/auth/login", "login_error");

$password = $user['password'];

if (!checkPassword($_POST['password'], $password))
	redirect("/auth/login", "login_error");

$session->login(User::object($user));

if ( isset($_POST['back']) ) {
	redirect($_POST['back'], "just_logged");
}

redirect('/public/home', "just_logged");