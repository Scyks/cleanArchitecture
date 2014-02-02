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

use App\Todo\Request\Filter as FilterRequest;
use App\Todo\Response\Collection as CollectionResponse;
use App\Todo\ListTodos as ListTodosInteractor;
use App\Todo\Entities\Todo;

class ListTodos {

#pragma mark - properties

	/**
	 * @var FilterRequest
	 */
	private $oRequest;

	/**
	 * @var CollectionResponse
	 */
	private $oResponse;

#pragma mark - process

	public function process() {

		$this
			->loadTodos()
			->displayTodoList()
		;
	}

#pragma mark - Request / Response

	/**
	 * @return FilterRequest
	 */
	private  function getRequest() {
		if (!($this->oRequest instanceof FilterRequest)) {
			$this->oRequest = new FilterRequest();
		}

		return $this->oRequest;
	}

	/**
	 * @param CollectionResponse $oResponse
	 */
	private function setResponse(CollectionResponse $oResponse) {
		$this->oResponse = $oResponse;
	}

	/**
	 * @return CollectionResponse
	 */
	private function getResponse() {
		return $this->oResponse;
	}

	private function hasResponse() {
		return ($this->getResponse() instanceof CollectionResponse);
	}


#pragma mark - load todos

	/**
	 * will create a
	 * @return ListTodos
	 */
	private function loadTodos() {

		try {

			$oListTodoInteractor = new ListTodosInteractor($this->getRequest());
			$oTodoResponse = $oListTodoInteractor->processRequest();

			if ($oTodoResponse instanceof CollectionResponse)
				$this->setResponse($oTodoResponse);
			else
				throw new \Exception(sprintf('Response is not instanceof of CollectionResponse, "%s" given.', gettype($oTodoResponse)));

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
		$this->displayError();
	}

	/**
	 * Will display an error message
	 * @return ListTodos
	 */
	private function displayError() {
		\cli\line();
		\cli\err("%RThere was en error by retrieving all todos%n");
		\cli\line();

		return $this;
	}

#pragma mark - output

	/**
	 * will display a message on screen
	 * @return ListTodos
	 */
	private function displayTodoList() {
		if ($this->hasResponse() && $this->getResponse()->hasSucceded()) {

			if ($this->getResponse()->hasTodos()) {

				\cli\line("%GList of available Todos:%n");

				$oTable = new \cli\Table();
				$oTable->setHeaders(array('id', 'name', 'priority', 'done', 'start', 'end'));

				/** @var Todo $oTodo */
				foreach($this->getResponse()->getTodos() as $oTodo) {
					$oTable->addRow(array(
						$oTodo->getId(),
						$oTodo->getName(),
						$oTodo->getPriority(),
						((true == $oTodo->isDone()) ? 'Yes' : 'No'),
						(($oTodo->getStartDate() instanceof \DateTime) ? $oTodo->getStartDate()->format('Y-m-d') : '-'),
						(($oTodo->getEndDate() instanceof \DateTime) ? $oTodo->getEndDate()->format('Y-m-d') : '-'),
					));
				}

				$oTable->display();
			} else {
				\cli\line("%Bthere are currently no todos%n");
			}

			\cli\line();
			\cli\line();
		} else {
			$this->displayError();
		}

		return $this;
	}
}
