<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    MemoryStorageTest.php
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

namespace Tests\Unit\App\StorageSystem;

use App\Todo\StorageSystem\Memory\Todo;
use App\Todo\Entity\Todo as TodoEntity;
use Tests\Unit\PropertyTestCase;
use Tests\Unit\PropertyDefaultTests;
use Tests\Unit\PropertyGetterTests;
use Tests\Unit\PropertySetterTests;
/**
 * @group Todo
 */
class MemoryStorageTest extends PropertyTestCase {

	use PropertyDefaultTests;

#pragma mark - Property Test Case implementation

	public function dataProviderGetterSetterProperties() {
		return [
			['aTodos', self::T_ARRAY, []],
		];
	}

	protected function createClass() {
		return new Todo();
	}

#pragma mark - interface Implementation

	/**
	 * @test
	 */
	public function checkIfStorageImplementsTodoStorage() {
		$this->assertInstanceOf('\App\Todo\StorageSystem\TodoStorage', $this->createClass());
	}

#pragma mark - save

	/**
	 * @test
	 * @expectedException \PHPUnit_Framework_Error
	 */
	public function save_notTodoEntity_throwsException() {
		$this->createClass()->save('foobar');
	}

	/**
	 * @test
	 */
	public function save_TodoEntity_IdSettedToOne() {

		$oClass = $this->createClass();

		$oReflection = new \ReflectionClass($oClass);

		$oProperty = $oReflection->getProperty('aTodos');
		$oProperty->setAccessible(true);

		$oTodo = new TodoEntity();
		$oClass->save($oTodo);

		$this->assertEquals(1, $oTodo->getId());
	}

	/**
	 * @test
	 */
	public function save_TodoEntity_IdSettedToTwo() {

		$oClass = $this->createClass();

		$oReflection = new \ReflectionClass($oClass);

		$oProperty = $oReflection->getProperty('aTodos');
		$oProperty->setAccessible(true);

		$oClass->save(new TodoEntity);

		$oTodo = new TodoEntity();
		$oClass->save($oTodo);

		$this->assertEquals(2, $oTodo->getId());
	}

	/**
	 * @test
	 */
	public function save_TodoEntity_returnsTrue() {

		$oClass = $this->createClass();

		$this->assertTrue($oClass->save(new TodoEntity()));
	}

#pragma mark - getList

	/**
	 * @test
	 */
	public function listAll_nothingSaved_returnEmptyArray() {
		$this->assertEmpty($this->createClass()->listAll());
	}

	/**
	 * @test
	 */
	public function listAll_oneSaved_returnArrayIncludingEntity() {
		$oClass = $this->createClass();

		$oTodo = new TodoEntity();
		$oClass->save($oTodo);

		$this->assertEquals([1 => $oTodo], $oClass->listAll());
	}
	/**
	 * @test
	 */
	public function listAll_twoSaved_returnArrayIncludingBothEntities() {
		$oClass = $this->createClass();

		$oTodo1 = new TodoEntity();
		$oClass->save($oTodo1);

		$oTodo2 = new TodoEntity();
		$oClass->save($oTodo2);

		$this->assertEquals([1 => $oTodo1, 2 => $oTodo2], $oClass->listAll());
	}
} 