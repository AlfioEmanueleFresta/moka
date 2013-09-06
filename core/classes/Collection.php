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
 * Represents a general data collection in the database.
 */
abstract class Collection {

	public 
		$_objectId		= null,
		$collection 	= null;

	public static function _collection() {
		global $db;
		$name = strtolower( get_called_class() );
		return $db->{$name};
	}

	public function __construct( $id = null ) {
		$this->collection = static::_collection();
		if ( !$id ) {
			try {
				$obj = ['_created'	=>	time()];
				$ret = $this->collection->insert($obj);
				$this->_objectId = $obj['_id'];
				$id = $this->_objectId;
			} catch ( MongoException $e ) {
				die("Error creating object in the {$this->collection} collection.\n
						Error message: {$e}\n");
			}
		}
		if ( !static::hasId($id) ) {
			die ("There is no object with id {$id} in the {$this->collection} collection.\n");
		}
		$this->_objectId = new MongoId($id);
	}

	public static function hasId( $objectId ) {
		return (bool) static::_collection()->findOne(['_id' => new MongoId($objectId)]);
	}

	public static function count( $query = [], $limit = 0, $skip = 0 ) {
		return (int) static::_collection()->count(
			$query, $limit, $skip
		);
	}

	/**
	 * Find objects in the collection using a query
	 *
	 * @param array 		$query 		The query
	 * @param array 		$fields 	What you need to get
	 * @return MongoCursor 	The result of the query
	 */
	public static function find( $query = [], $fields = [] ) {
		return static::_collection()->find($query, $fields);
	}

	/**
	 * Find the first object in the collection using a query
	 *
	 * @param array 		$query 		The query
	 * @param array 		$fields 	What you need to get
	 * @return array|null	The first result or NULL
	 */
	public static function findOne( $query = [], $fields = [] ) {
		return static::_collection()->findOne($query, $fields);
	}

	/**
	 * Remove from the collections where $query
	 *
	 * @param array 		$query 		The query
	 * @param array 		$options 	Other options
	 * @return bool 		ok?
	 */
	public static function remove( $query = [], $options = [] ) {
		return static::_collection()->findOne($query, $options);
	}

	public function __get( $_name ) {
		$o = $this->collection->findOne(
			['_id' => $this->_objectId],
			[$_name]
		);
		if ( !$o ) 					{ return null; }
		if ( !isset($o[$_name]) ) 	{ return null; }
		return $o[$_name];
	}

	public function __set( $_name, $_value ) {
		$this->collection->update(
			['_id' 	=> $this->_objectId],
			[
				'$set' => [
					$_name	=> $_value
				]
			],
			[
				'upsert'	=>	false
			]
		);
	}

	/**
	 * Deletes an object from the collection
	 */
	public function delete() {
		return $this->collection->remove(
			['_id' 	=> $this->_objectId]
		);
	}

	public static function object( $arrayOrID ) {
		if ( is_array($arrayOrID) ) {
			if ( !isset($arrayOrID["_id"]) ) {
				throw new Exception;
			}
			$id = (string) $arrayOrID["_id"];
		} else {
			$id = (string) $arrayOrID;
		}
		return new static($id);
	}

}
