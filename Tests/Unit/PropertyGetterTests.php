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

trait PropertyGetterTests {

#pragma mark - abstract methods

	use AbstractProperty;
	abstract public function dataProviderGetterSetterProperties();

#pragma mark - tests for properties getter

	/**
	 * @test
	 * @dataProvider dataProviderGetterSetterProperties
	 */
	public function propertyGetterDefaultValue($sPropertyName, $type, $default, $sName = null) {

		$this->assertEquals($default, $this->createClass()->{$this->getGetterName($sPropertyName, $sName)}());
	}

	/**
	 * @test
	 * @dataProvider dataProviderGetterSetterProperties
	 */
	public function propertyGetterDefinedValue($sPropertyName, $type, $default, $sName = null) {

		$oClass = $this->createClass();

		$oReflection = new \ReflectionClass($oClass);

		$oProperty = $oReflection->getProperty($sPropertyName);
		$oProperty->setAccessible(true);

		$oProperty->setValue($oClass, 'Foobar');

		$this->assertEquals('Foobar', $oClass->{$this->getGetterName($sPropertyName, $sName)}());
	}
}