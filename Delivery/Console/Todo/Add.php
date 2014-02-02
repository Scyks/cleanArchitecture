<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    Delivery/Console/Todo/Add.php
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

namespace Delivery\Console\Todo;

use App\Todo\Request\CreateTodo as CreateTodoRequest;
use App\Todo\Response\Todo as TodoResponse;
use App\Todo\CreateTodo;

class Add {

#pragma mark - properties

	/**
	 * @var CreateTodoRequest
	 */
	private $oRequest;

	/**
	 * @var TodoResponse
	 */
	private $oResponse;

#pragma mark - process

	public function process() {
		$this
			->retrieveName()
			->retrievePriority()
			->retrieveDoneState()
			->retrieveStartDate()
			->retrieveEndDate()

			->createTodo()
		;

		if ($this->hasResponse()) {
			$this->displayState();
		}
	}

#pragma mark - Request / Response

	/**
	 * @return CreateTodoRequest
	 */
	private  function getRequest() {
		if (!($this->oRequest instanceof CreateTodoRequest)) {
			$this->oRequest = new CreateTodoRequest();
		}

		return $this->oRequest;
	}

	/**
	 * @param TodoResponse $oResponse
	 */
	private function setResponse(TodoResponse $oResponse) {
		$this->oResponse = $oResponse;
	}

	/**
	 * @return TodoResponse
	 */
	private function getResponse() {
		return $this->oResponse;
	}

	private function hasResponse() {
		return ($this->getResponse() instanceof TodoResponse);
	}

#pragma mark - get Properties from console

	/**
	 * @return Add
	 */
	private function retrieveName() {
		$this->getRequest()->name = \cli\prompt("Todo's name", false);
		return $this;
	}

	/**
	 * @return Add
	 */
	private function retrievePriority() {
		$iPriority = \cli\prompt("Todo's Priority (1-10)", 1);
		while(!preg_match('/^[1-9]|10$/', $iPriority)) {
			$iPriority = \cli\prompt("Todo's Priority (1-10)", 1);
		}

		$this->getRequest()->priority = (int) $iPriority;

		return $this;
	}

	/**
	 * @return Add
	 */
	private function retrieveDoneState() {
		$done =	\cli\choose("Todo already done");
		$this->getRequest()->done = (('y' == $done) ? true : false);
		return $this;
	}

	/**
	 * @return Add
	 */
	private function retrieveStartDate() {
		$sStartDate = \cli\prompt("Todo's start date (yyyy-mm-dd)", null);
		while(!is_null($sStartDate) && !preg_match('/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $sStartDate)) {
			$sStartDate = \cli\prompt("Todo's start date (yyyy-mm-dd)", null);
		}

		if (!is_null($sStartDate))
			$this->getRequest()->startDate = new \DateTime($sStartDate);

		return $this;
	}

	/**
	 * @return Add
	 */
	private function retrieveEndDate() {
		$sEndDate = \cli\prompt("Todo's end date (yyyy-mm-dd)", null);
		while(!is_null($sEndDate) && !preg_match('/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $sEndDate)) {
			$sEndDate = \cli\prompt("Todo's end date (yyyy-mm-dd)", null);
		}

		if (!is_null($sEndDate))
			$this->getRequest()->endDate = new \DateTime($sEndDate);

		return $this;
	}

#pragma mark - todo creation

	/**
	 * will create a
	 * @return Add
	 */
	private function createTodo() {

		try {

			$oCreateTodoInteractor = new CreateTodo($this->getRequest());
			$oTodoResponse = $oCreateTodoInteractor->processRequest();

			if ($oTodoResponse instanceof TodoResponse)
				$this->setResponse($oTodoResponse);
			else
				throw new \Exception(sprintf('Response is not instanceof of TodoResponse, "%s" given.', gettype($oTodoResponse)));

		} catch (\Exception $e) {
			$this->handleException($e);
		}

		return $this;
	}

#pragma mark - error Handling

	/**
	 * @param \Exception $e
	 */
	private function handleException(\Exception $e) {
		\cli\line();
		\cli\err('%RException: ' . get_class($e));
		\cli\err('%RMessage: ' . $e->getMessage() . '%n');
		\cli\line();
	}

	/**
	 * Will display an error message
	 * @return Add
	 */
	private function displayError() {
		\cli\line();
		\cli\err("%RThere was en error by creating this todo%n");
		\cli\line();
		\cli\line();

		return $this;
	}

#pragma mark - output

	/**
	 * will display a message on screen
	 * @return Add
	 */
	private function displayState() {
		if ($this->getResponse()->hasSucceded() && $this->getResponse()->hasTodo()) {

			\cli\line();
			\cli\line("%G" . sprintf(
				'Todo "%s" with id "%d" created',
				$this->getResponse()->getTodo()->getName(),
				$this->getResponse()->getTodo()->getId()
			) . "%n");

			\cli\line();
			\cli\line();
		} else {
			$this->displayError();
		}

		return $this;
	}
}
