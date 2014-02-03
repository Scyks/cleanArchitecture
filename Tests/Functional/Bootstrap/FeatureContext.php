<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    AbstractFeaturecontext.php
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

namespace Tests\Functional\Bootstrap;

require_once 'PHPUnit/Autoload.php';

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;

class FeatureContext extends BehatContext {

	private $aRequests = [
		'CreateTodo' => 'App\Todo\Request\CreateTodo',
	];


	private $oRequest;
	private $oResponse;
	private $oTodo;

	/**
	 * @Given /^I create a "([^"]*)" Request$/
	 */
	public function iCreateARequest($arg1) {
		if (array_key_exists($arg1, $this->aRequests)) {
			$sClassName = $this->aRequests[$arg1];

			$this->oRequest = new $sClassName();
		} else {
			throw new PendingException();
		}
	}

	/**
	 * @Given /^I fill in "([^"]*)" as "([^"]*)"$/
	 */
	public function iFillInAs($arg1, $arg2) {
		$this->oRequest->{$arg2} = $arg1;
	}

	/**
	 * @Given /^I fill in (\d+) as "([^"]*)"$/
	 */
	public function iFillInAs2($arg1, $arg2) {
		$this->iFillInAs((int) $arg1, $arg2);
	}

	/**
	 * @Given /^I fill in true as "([^"]*)"$/
	 */
	public function iFillInTrueAs($arg1) {
		$this->iFillInAs(true, $arg1);
	}

	/**
	 * @Given /^I fill in false as "([^"]*)"$/
	 */
	public function iFillInFalseAs($arg1) {
		$this->iFillInAs(false, $arg1);
	}

	/**
	 * @Given /^I fill in DateTime "([^"]*)" as "([^"]*)"$/
	 */
	public function iFillInDatetimeAs($arg1, $arg2) {
		if (!empty($arg1))
			$this->oRequest->{$arg2} = new \DateTime($arg1);
	}

	/**
	 * @When /^I create and recieve this todo$/
	 */
	public function iCreateAndRecieveThisTodo() {
		$oCreateTodo = new \App\Todo\CreateTodo($this->oRequest);
		$this->oResponse = $oCreateTodo->processRequest();
		$this->oTodo = $this->oResponse->getTodo();
	}

	/**
	 * @Then /^I should have "([^"]*)" as "([^"]*)"$/
	 */
	public function iShouldHaveAs($arg1, $arg2) {

		$sGetter = 'get' . ucFirst($arg2);

		\PHPUnit_Framework_Assert::assertEquals($arg1, $this->oTodo->$sGetter());

	}

	/**
	 * @Given /^I should have true as done$/
	 */
	public function iShouldHaveTrueAsDone() {
		\PHPUnit_Framework_Assert::assertTrue($this->oTodo->isDone());
	}

	/**
	 * @Given /^I should have false as done$/
	 */
	public function iShouldHaveFalseAsDone() {
		\PHPUnit_Framework_Assert::assertFalse($this->oTodo->isDone());
	}

	/**
	 * @Given /^I should have DateTime "([^"]*)" as "([^"]*)"$/
	 */
	public function iShouldHaveDatetimeAs($arg1, $arg2) {

		$sGetter = 'get' . ucFirst($arg2);
		if (empty($arg1))
			\PHPUnit_Framework_Assert::assertEmpty($this->oTodo->$sGetter());
		else
			\PHPUnit_Framework_Assert::assertEquals(new \DateTime($arg1), $this->oTodo->$sGetter());
	}
}