<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    App/Todo/Entity/Todo.php
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

namespace App\Todo\Entity;

use \App\Todo\EntityFactory;

class Todo {

#pragma mark - properties

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var boolean
	 */
	private $done;

	/**
	 * @var int
	 */
	private $priority;

	/**
	 * @var \DateTime
	 */
	private $startDate;

	/**
	 * @var \DateTime
	 */
	private $endDate;

#pragma mark - getter

	/**
	 * @return int
	 */
	public function getId() {

		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * @return boolean
	 */
	public function isDone() {

		return $this->done;
	}

	/**
	 * @return int
	 */
	public function getPriority() {

		return $this->priority;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartDate() {

		return $this->startDate;
	}

	/**
	 * @return \DateTime
	 */
	public function getEndDate() {

		return $this->endDate;
	}

#pragma mark - setter

	/**
	 * @param int $id
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setId($id) {
		if (!is_int($id))
			throw new \InvalidArgumentException('id have to be an integer value.');

		$this->id = $id;

		return $this;
	}

	/**
	 * @param string $name
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setName($name) {

		if (!is_string($name))
			throw new \InvalidArgumentException('name have to be an string value.');

		$this->name = $name;

		return $this;
	}

	/**
	 * @param boolean $done
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setDone($done) {

		if (!is_bool($done))
			throw new \InvalidArgumentException('done have to be an beoolean value.');

		$this->done = $done;

		return $this;
	}

	/**
	 * @param int $priority
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setPriority($priority) {

		if (!is_int($priority))
			throw new \InvalidArgumentException('priority have to be an integer value.');

		$this->priority = $priority;

		return $this;
	}

	/**
	 * @param \DateTime $startDate
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setStartDate(\DateTime $startDate) {

		$this->startDate = $startDate;

		return $this;
	}

	/**
	 * @param \DateTime $endDate
	 * @throws \InvalidArgumentException
	 * @return Todo
	 */
	public function setEndDate(\DateTime $endDate) {

		$this->endDate = $endDate;

		return $this;
	}

#pragma mark - storage methods

	public function save() {
		EntityFactory::getStorageSystem()->save($this);
	}

}