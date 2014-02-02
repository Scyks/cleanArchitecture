<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    App/Todo/CreateTodo.php
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

use App\Common\Interactor\Interactor;
use App\Common\Request\Request;
use App\Common\Request\InvalidRequestException;
use App\Todo\Entity\Todo;
use App\Todo\Request\Filter as FilterRequest;
use App\Todo\Response\Collection as CollectionResponse;

class ListTodos implements Interactor {

#pragma mark - properties

	/**
	 * @var Request
	 */
	private $oRequest;

#pragma mark - construction

	/**
	 * @param FilterRequest $oRequest
	 */
	public function __construct(FilterRequest $oRequest) {
		$this->setRequest($oRequest);
	}

#pragma mark - getters

	/**
	 * @return FilterRequest
	 */
	public function getRequest() {
		return $this->oRequest;
	}

#pragma mark - setters

	/**
	 * @param Request $oRequest
	 *
	 * @return CreateTodo
	 * @throws InvalidRequestException
	 */
	public function setRequest(Request $oRequest) {

		if (!($oRequest instanceof FilterRequest))
			throw new InvalidRequestException(sprintf('The request "%s" isn\'t instanceof \App\Todo\Request\Filter', get_class($oRequest)));

		if (!$oRequest->isValid())
			throw new InvalidRequestException(sprintf('The request "%s" isn\'t valid', get_class($oRequest)));

		$this->oRequest = $oRequest;

		return $this;
	}

#pragma mark - action

	/**
	 * return Response
	 */
	public  function processRequest() {

		/** @var Todo $oTodo */
		$oTodoStorage = EntityFactory::getStorageSystem();

		$oResponse = new CollectionResponse();

		$oResponse
			->setSuccess(true)
			->setTodos($oTodoStorage->listAll())
		;

		return $oResponse;
	}
}