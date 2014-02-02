<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    App/Todo/EntityFactory.php
 *
 * @copyright     Copyright (c) 2014 Ronald Marske, All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in
 *       the documentation and/or other materials provided with the
 *       distribution.
 *
 *     * Neither the name of Ronald Marske nor the names of his
 *       contributors may be used to endorse or promote products derived
 *       from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace App\Todo;

use App\Todo\Entities\Todo as TodoEntity;
use App\Todo\StorageSystem\TodoStorage;

/**
 * @TODO: Maybe resolve this problem by using other mechanisms than this.
 *      This is just a test implementation
 */
class EntityFactory {

#pragma mark - constants

	const MOCK = 'Mock';
	const MEMORY = 'Memory';

#pragma mark - properties

	protected static $sStorageMechanism = self::MEMORY;

	private static $oStorageSystem;

#pragma mark - storage

	public static function setStorageMechanism($sStorageMechanism) {

		if (!in_array($sStorageMechanism, [self::MOCK, self::MEMORY]))
			throw new \InvalidArgumentException('Only self::MOCK or self::MEMORY are allowed as storage mechanisms');

		self::$sStorageMechanism = $sStorageMechanism;
	}

	public static function getStorageMechanism() {
		return self::$sStorageMechanism;
	}

#pragma mark - Storage System

	/**
	 * @return TodoStorage
	 */
	public static function getStorageSystem() {

		if (!(self::$oStorageSystem instanceof TodoStorage)) {
			$sClassName = '\App\Todo\StorageSystem\\' . self::getStorageMechanism() . '\Todo';
			self::setStorageSystem(new $sClassName());
		}

		return self::$oStorageSystem;
	}

	/**
	 * @param TodoStorage $oStorageSystem
	 */
	public static function setStorageSystem(TodoStorage $oStorageSystem) {
		self::$oStorageSystem = $oStorageSystem;
	}


} 