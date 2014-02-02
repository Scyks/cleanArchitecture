<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    PropertyDefaultTests.php
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

trait PropertySetterTests {

#pragma mark - abstract methods

	use AbstractProperty;
	abstract public function dataProviderGetterSetterProperties();

#pragma mark - check Setter

	/**
	 * @test
	 * @dataProvider dataProviderGetterSetterProperties
	 */
	public function propertySetterWrongType($sPropertyName, $type, $default, $sName = null) {

		$aValues = $this->valueTypes();
		if (is_int($type)) {
			unset($aValues[$type]);
		}

		if (is_int($type) && self::T_ARRAY !== $type)
			$this->setExpectedException('\InvalidArgumentException');
		else
			$this->setExpectedException('\PHPUnit_Framework_Error');

		foreach ($aValues as $value) {
			$this->createClass()->{$this->getSetterName($sPropertyName, $sName)}($value);
		}
	}

	/**
	 * @test
	 * @dataProvider dataProviderGetterSetterProperties
	 */
	public function propertySetterValueSetted($sPropertyName, $type, $default, $sName = null) {

		$aValues = $this->valueTypes();
		if (is_int($type)) {
			$value = $aValues[$type];
		} else {
			$value = new $type();
		}

		$oClass = $this->createClass();
		$oClass->{$this->getSetterName($sPropertyName, $sName)}($value);


		$this->assertClassAttributeEquals($oClass, $sPropertyName, $value);
	}
}