<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    CreateTodoTest.php
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

namespace Tests\Unit\App\Todo;

use App\Common\Interactor\Interactor;
use App\Todo\ListTodos;
use App\Todo\EntityFactory;
use App\Todo\Entity\Todo as TodoEntity;
use App\Todo\Request\Filter;
use Tests\Unit\TestCase;
use Tests\Unit\App\InteractorTests;

/**
 * @group Todo
 */
class ListTodosTest extends TestCase {

	use InteractorTests;

	public function tearDown() {
		$oClass = new EntityFactory;
		$oReflection = new \ReflectionClass($oClass);

		$oProp = $oReflection->getProperty('oStorageSystem');
		$oProp->setAccessible(true);
		$oProp->setValue(null, null);

		parent::tearDown();
	}

#pragma mark - InteractorTests Implemntation

	/**
	 * @return Interactor
	 */
	protected function getInteractorClassName() {
		return 'App\Todo\ListTodos';
	}

	/**
	 * @param bool $bValidRequest
	 *
	 * @return Filter
	 */
	protected function createRequest($bValidRequest = true) {

		if (true == $bValidRequest) {
			return new Filter();
		} else {
			return new Mock\InvalidFilterRequestMock();
		}

	}

	/**
	 * @param bool $bValidRequest
	 *
	 * @return CreateTodo
	 */
	protected function createClass($bValidRequest = true) {
		return new ListTodos($this->createRequest($bValidRequest));
	}

#pragma mark - create inMemory Todos

	private function createTodosInMemory() {
		EntityFactory::setStorageMechanism(EntityFactory::MEMORY);

		$oTodo1 = new TodoEntity();
		$oTodo1
			->setName('Foobar 1')
			->setPriority(4)
			->setDone(false)
			->save()
		;

		$oTodo2 = new TodoEntity();
		$oTodo2
			->setName('Foobar 2')
			->setPriority(4)
			->setDone(false)
			->save()
		;

		return [$oTodo1, $oTodo2];
	}

#pragma mark - processRequest

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse() {
		$oCreateTodo = $this->createClass();
		$this->assertInstanceOf('App\Todo\Response\Collection', $oCreateTodo->processRequest());
	}

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse_SuccessIsTrue() {
		$oListTodos = $this->createClass();
		$this->assertTrue($oListTodos->processRequest()->hasSucceded());
	}

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse_WithEmptyCollection() {
		$oListTodos = $this->createClass();
		$this->assertEmpty($oListTodos->processRequest()->getTodos());
	}

	/**
	 * @test
	 */
	public function processRequest_Todo1inCollection() {
		$oListTodos = $this->createClass();

		$aInMemoryTodos = $this->createTodosInMemory();

		$aTodos = $oListTodos->processRequest()->getTodos();

		$this->assertEquals($aInMemoryTodos[0], $aTodos[1]);

	}

	/**
	 * @test
	 */
	public function processRequest_Todo2inCollection() {
		$oListTodos = $this->createClass();

		$aInMemoryTodos = $this->createTodosInMemory();

		$aTodos = $oListTodos->processRequest()->getTodos();

		$this->assertEquals($aInMemoryTodos[1], $aTodos[2]);

	}

}