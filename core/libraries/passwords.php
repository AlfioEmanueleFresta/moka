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
 * Creates a secure hash for the password
 *
 * @param string $input The password
 * @return string The hashed password
 */
function hashPassword( $input ) {
	return password_hash($input, PASSWORD_BCRYPT);
}


/**
 * Check a password against a password hash
 *
 * @param string $input The password to try
 * @param string $hash The hash to verify against
 * @return bool True for ok, false for go away
 */
function checkPassword( $input, $hash ) {
	return password_verify($input, $hash);
}