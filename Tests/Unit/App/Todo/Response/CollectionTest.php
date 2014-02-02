<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    TodoTest.php
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

namespace Tests\Unit\App\Todo\Response;

use App\Todo\Entity\Todo;
use App\Todo\Response\Collection;
use Tests\Unit\PropertyDefaultTests;
use Tests\Unit\PropertyGetterTests;
use Tests\Unit\PropertySetterTests;
use Tests\Unit\PropertyIsHasTests;
use Tests\Unit\PropertyTestCase;

/**
 * @group Todo
 */
class CollectionTest extends PropertyTestCase {

#pragma mark - implement Traits

	use PropertyDefaultTests;
	use PropertyGetterTests;
	use PropertySetterTests;
	use PropertyIsHasTests;

#pragma mark - Property Test Case implementation

	public function dataProviderGetterSetterProperties() {
		return [
			['bSuccess', self::T_BOOL, null, ['hasSucceded', 'setSuccess']],
			['todos', self::T_ARRAY, null],
		];
	}

	public function dataProviderIsHasProperties() {
		return [
			['todos', [[], [new Todo()]], 'hasTodos']
		];
	}

	/**
	 * @return CreateTodo
	 */
	protected function createClass() {
		return new Collection();
	}

} 