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
 * BindableCollection allows you to bind your code to some
 * events in a collection.
 */
abstract class BindableCollection extends Collection {

	public function __construct( $id = null ) {
		$this->onPreLoad();
		parent::__construct($id);
		$this->onPostLoad();
	}

	protected static function create() {
		static::onPreCreate();
		$x = parent::create();
		(new static($x))->onPostCreate();
		return $x;
	}

	public function delete() {
		$this->onPreDelete();
		$x = parent::delete();
		$this->onPostDelete();
		return $x;
	}

	public function __set($_name, $_value) {
		$this->onPreUpdate($_name, $_value);
		parent::__set($_name, $_value);
		$this->onPostUpdate($_name, $_value);
	}

	public function onPreLoad() 	{}
	public function onPostLoad()	{}
	
	public static function onPreCreate() 	{}
	public function onPostCreate() 	{}

	public function onPreDelete() 	{}
	public function onPostDelete() 	{}

	public function onPreUpdate($_name, $_value) 	{}
	public function onPostUpdate($_name, $_value) 	{}

}