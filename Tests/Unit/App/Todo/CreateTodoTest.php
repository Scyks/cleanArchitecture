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
use App\Todo\Request\CreateTodo as CreateTodoRequest;
use App\Todo\CreateTodo;
use App\Todo\EntityFactory;
use Tests\Unit\TestCase;
use Tests\Unit\App\InteractorTests;

/**
 * @group Todo
 */
class CreateTodoTest extends TestCase {

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
		return 'App\Todo\CreateTodo';
	}

	/**
	 * @param bool $bValidRequest
	 *
	 * @return CreateTodoRequest
	 */
	protected function createRequest($bValidRequest = true) {
		$oRequest = new CreateTodoRequest();

		if (true == $bValidRequest) {
			$oRequest->name = 'Foobar';
			$oRequest->priority = 4;
			$oRequest->done = true;
			$oRequest->startDate = new \DateTime('2014-01-01');
			$oRequest->endDate = new \DateTime('2014-02-01');
		}

		return $oRequest;

	}

	/**
	 * @param bool $bValidRequest
	 *
	 * @return CreateTodo
	 */
	protected function createClass($bValidRequest = true) {
		return new CreateTodo($this->createRequest($bValidRequest));
	}

#pragma mark - dataProvider

	public function dataProviderCompareValuesFromRequestToEntity() {
		return [
			['name', 'getName'],
			['priority', 'getPriority'],
			['done', 'isDone'],
			['startDate', 'getStartDate'],
			['endDate', 'getEndDate'],
		];
	}

#pragma mark - processRequest

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse() {
		$oCreateTodo = $this->createClass();
		$this->assertInstanceOf('App\Todo\Response\Todo', $oCreateTodo->processRequest());
	}

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse_SuccessIsTrue() {
		$oCreateTodo = $this->createClass();
		$this->assertTrue($oCreateTodo->processRequest()->hasSucceded());
	}

	/**
	 * @test
	 */
	public function processRequest_ReturnsTodoResponse_WitchTodoEntity() {
		$oCreateTodo = $this->createClass();
		$this->assertInstanceOf('App\Todo\Entity\Todo', $oCreateTodo->processRequest()->getTodo());
	}

	/**
	 * @test
	 */
	public function processRequest_entityContainsAllProperties() {
		$oCreateTodo = $this->createClass();
		$oTodo = $oCreateTodo->processRequest()->getTodo();

		$this->assertEquals(1, $oTodo->getId());

	}

	/**
	 * @test
	 * @dataProvider dataProviderCompareValuesFromRequestToEntity
	 */
	public function processRequest_entityContainsValueFromRequest($sRequestProperty, $sEntityGetter) {
		$oCreateTodo = $this->createClass();
		$oRequest  =$oCreateTodo->getRequest();
		$oTodo = $oCreateTodo->processRequest()->getTodo();

		$this->assertEquals($oRequest->{$sRequestProperty}, $oTodo->{$sEntityGetter}());

	}
}