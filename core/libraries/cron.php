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
 * The cron stacks
 */
define('CRON_STACK_HOURLY',		10);
define('CRON_STACK_DAILY',		20);
define('CRON_STACK_WEEKLY',		30);
define('CRON_STACK_MONTHLY',	40);

/**
 * The stack!
 */
$_cron_stack = [];