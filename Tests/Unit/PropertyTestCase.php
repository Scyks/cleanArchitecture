<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    Tests/Unit/TestCase.php
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

namespace Tests\Unit;

abstract class PropertyTestCase extends TestCase {

#pragma mark - constants

	const T_INT		= 1;
	const T_STRING	= 2;
	const T_FLOAT	= 4;
	const T_ARRAY	= 8;
	const T_BOOL	= 16;
	const T_OBJECT	= 32;

#pragma mark - helper methods - method generation

	protected function getGetterName($sPropertyName, $name = null) {
		if (is_null($name)) {
			$sName = 'get' . ucfirst($sPropertyName);
		} else {
			$sName = $name[0];
		}

		return $sName;
	}

	protected function getSetterName($sPropertyName, $name = null) {
		if (is_null($name)) {
			$sName = 'set' . ucfirst($sPropertyName);
		} else {
			$sName = $name[1];
		}

		return $sName;
	}

	protected function valueTypes() {
		return array(
			self::T_INT => 2,
			self::T_STRING => 'Foobar',
			self::T_FLOAT => 3.8,
			self::T_ARRAY => array('foo' => 'bar'),
			self::T_BOOL => false,
		);
	}
}