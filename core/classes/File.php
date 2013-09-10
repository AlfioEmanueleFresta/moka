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
 * Represents a file. It can be an uploaded file,
 * has a disk and database presence
 */
class File extends BindableCollection {

	/**
	 * Create a File object from a file upload form.
	 * Returns a File instance.
	 */
	public static function upload( $theFile ) {
		if ( !is_readable($theFile['tmp_name']) )
			throw new Exception('An error has occured while uploading the file.');

		$fileName = static::generateUniqueFileName();
		if ( !move_uploaded_file($theFile['tmp_name'], $fileName) )
			throw new Exception('An error has occured while moving the file to the datastore.');
		$file = new static;
		$file->name = $theFile['name'];
		$file->path = $fileName;
		$file->analyse();
		$file->expire((new DateTime)->modify("+1 day"));
		return $file;
	}

	/**
	 * Generate a file from its string content
	 */
	public static function createFromContent( $content ) {
		$fileName = static::generateUniqueFileName();
		file_put_contents($fileName, $content);
		$file = new static;
		$file->name = $theFile['name'];
		$file->path = $fileName;
		$file->analyse();
		$file->expire((new DateTime)->modify("+1 day"));
		return $file;
	}

	public function makeEmptyFile() {
		if ( $this->path ) {
			$this->unlink();
		} else {
			$this->path = static::generateUniqueFileName();
		}
		file_put_contents('', $this->path);
		$this->analyse();
	}

	public function expire(DateTime $when) {
		$this->expires = $when->getTimestamp();
	}

	public static function expiredFiles() {
		$f = static::find([
			'expire' => [
				'$lte' => time()
			]
		]);
	}

	protected static function generateUniqueFileName() {
		$randomHash = sha1(
			microtime() . rand(1, 999999)
		).md5(
			( microtime(true) + rand(1, 40) )
		);
		return "./upload/files/{$randomHash}";
	}

	protected static function generateUniqueToken() {
		$randomHash = sha1(
			microtime() . rand(1, 999999)
		).md5(
			( microtime(true) + rand(1, 40) )
		).sha1( rand(1000, 99999) + microtime(true) );
		return $randomHash;
	}

	protected function analyse() {
		$file = $this->path;
		$finfo = finfo_open(FILEINFO_MIME);
		$this->mime = finfo_file($finfo, $this->path);
		finfo_close($finfo);
		$this->size = filesize($this->path);
		$this->token = static::generateUniqueToken();
		return true;
	}

	public function onPreDelete() {
		$this->onPreDeleteFile();
		$this->unlink();
		$this->onPostDeleteFile();
	}

	protected function unlink() {
		@unlink($this->path);
	}

	/**
	 * Redirects the user to the download page
	 */
	public function download() {
		header("Location: {$this->downloadLink()}");
		exit(0);
	}

	public function downloadLink() {
		return "/download.php?token={$this->token}";
	}

	/**
	 * Get a File object from the download token
	 */
	public static function fromToken( $token ) {
		$f = File::findOne(['token' => $token]);
		return File::object($f);
	}


	// EVENTS
	public function onPostUpload() 				{}
	public function onPostCreateFromContent()	{}
	public function onPreDeleteFile()			{}
	public function onPostDeleteFile()			{}

}
