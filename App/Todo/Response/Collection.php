<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    App/Todo/Response/Collection.php
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

namespace App\Todo\Response;

use App\Common\Response\Response;

class Collection implements Response {

#pragma mark - properties
	/**
	 * @var bool
	 */
	private $bSuccess;

	/**
	 * @var array
	 */
	private $todos;


#pragma mark - Response interface implementation

	/**
	 * set response success state
	 *
	 * @param bool $bSuccess
	 * @throws \InvalidArgumentException
	 * @return Response
	 */
	public function setSuccess($bSuccess) {
		if (!is_bool($bSuccess))
			throw new \InvalidArgumentException('success have to be an boolean value.');

		$this->bSuccess = $bSuccess;

		return $this;
	}

	/**
	 * checks if response have succeded
	 *
	 * @return bool
	 */
	public function hasSucceded() {
		return $this->bSuccess;
	}

#pragma mark - todos

	/**
	 * @param array $todos
	 * @return Response
	 */
	public function setTodos(array $todos) {
		$this->todos = $todos;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getTodos() {
		return $this->todos;
	}

	/**
	 * check if this response object has a todo list
	 * @return bool
	 */
	public function hasTodos() {
		return (!empty($this->todos));
	}

}