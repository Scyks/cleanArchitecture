<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    InteractorTests.php
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

namespace Tests\Unit\App;

use App\Common\Request\Request;
use App\Common\Interactor\Interactor;

trait InteractorTests {

#pragma mark - abstract methods

	/**
	 * @param bool $bValidRequest
	 *
	 * @return Request
	 */
	abstract protected function createRequest($bValidRequest = true) ;

	/**
	 * @param bool $bValidRequest
	 *
	 * @return Interactor
	 */
	abstract protected function createClass($bValidRequest = true);

	/**
	 * @return Interactor
	 */
	abstract protected function getInteractorClassName();

#pragma mark - construction

	/**
	 * @test
	 * @expectedException \PHPUnit_Framework_Error
	 */
	public function __construct_noRequest_FatalError() {
		$sClassNme = $this->getInteractorClassName();
		new $sClassNme("foobar");
	}

	/**
	 * @test
	 */
	public function __construct_requestSetted_RequestObjectsAreTheSame() {
		$oRequest = $this->createRequest();
		$sClassNme = $this->getInteractorClassName();
		$oCreateTodo = new $sClassNme($oRequest);

		$this->assertSame($oRequest, $oCreateTodo->getRequest());
	}

	#pragma mark - Interactor interface

	/**
	 * @test
	 */
	public function CheckInteractorInterfaceImplementation() {
		$this->assertInstanceOf('App\Common\Interactor\Interactor', $this->createClass());
	}


	#pragma mark - properties

	/**
	 * @test
	 */
	public function oRequestExists() {
		$this->assertClassHasAttribute('oRequest', get_class($this->createClass()));
	}

	/**
	 * @test
	 */
	public function getRequest_returnsFromRequestVariable_returnsFoobar() {

		$oClass = $this->createClass();

		$oReflection = new \ReflectionClass($oClass);

		$oProperty = $oReflection->getProperty('oRequest');
		$oProperty->setAccessible(true);

		$oProperty->setValue($oClass, 'Foobar');

		$this->assertEquals('Foobar', $oClass->getRequest());
	}

	#pragma mark - set Request

	/**
	 * @test
	 * @expectedException \PHPUnit_Framework_Error
	 */
	public function setRequest_string_FatalError() {
		$this->createClass()->setRequest("foobar");
	}

	/**
	 * @test
	 * @expectedException \App\Common\Request\InvalidRequestException
	 */
	public function setRequest_NoInstanceFromCreateTodoRequest_FatalError() {
		$this->createClass()->setRequest(new RequestMock());
	}

	/**
	 * @test
	 * @expectedException \App\Common\Request\InvalidRequestException
	 */
	public function setRequest_InvalidRequestObject_FatalError() {
		$this->createClass()->setRequest($this->createRequest(false));
	}

	/**
	 * @test
	 */
	public function setRequest_validRequestObject_ObjectSetted() {
		$oRequest = $this->createRequest();
		$oClass = $this->createClass();
		$oClass->setRequest($oRequest);

		$this->assertSame($oRequest, $oClass->getRequest());
	}

}
