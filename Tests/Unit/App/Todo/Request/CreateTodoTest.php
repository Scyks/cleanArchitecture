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

namespace Tests\Unit\App\Todo\Request;

use App\Todo\Request\CreateTodo;
use Tests\Unit\PropertyDefaultTests;
use Tests\Unit\PropertyTestCase;

/**
 * @group Todo
 */
class CreateTodoTest extends PropertyTestCase {

#pragma mark - implement Traits

	use PropertyDefaultTests;

#pragma mark - Property Test Case implementation

	public function dataProviderGetterSetterProperties() {
		return [
			['name', self::T_STRING, null],
			['done', self::T_BOOL, null],
			['priority', self::T_INT, null],
			['startDate', '\DateTime', null],
			['endDate', '\DateTime', null],
		];
	}

	/**
	 * @return CreateTodo
	 */
	protected function createClass() {
		return new CreateTodo();
	}

#pragma mark - interface impleemntation

	/**
	 * @test
	 */
	public function CreateTodo_implementsRequest_returnsTrue() {
		$this->assertInstanceOf('\App\Common\Request\Request', $this->createClass());
	}

#pragma mark - isValid

	/**
	 * @test
	 */
	public function isValid_nameInvalid_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 4;

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_doneInValid_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = 'Foobar';

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_priorityInValid_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 'Foobar';

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_prioritylowerThanZero_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = -1;

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_priorityupperThanNine_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 10;

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 * @group Todo
	 */
	public function isValid_startDateInValid_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 4;
		$oRequest->startDate = 'Foobar';

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_endDateInValid_returnsFalse() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 4;
		$oRequest->startDate = new \DateTime();
		$oRequest->startDate = 'Foobar';

		$this->assertFalse($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_allValidNoStartDateNoEndDate_returnsTrue() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 4;

		$this->assertTrue($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_allValidNoEndDate_returnsTrue() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 4;
		$oRequest->startDate = new \DateTime();

		$this->assertTrue($oRequest->isValid());
	}

	/**
	 * @test
	 */
	public function isValid_allValid_returnsTrue() {
		$oRequest = $this->createClass();
		$oRequest->name = 'Foobar';
		$oRequest->done = true;
		$oRequest->priority = 4;
		$oRequest->startDate = new \DateTime();
		$oRequest->endDate = new \DateTime();

		$this->assertTrue($oRequest->isValid());
	}
} 