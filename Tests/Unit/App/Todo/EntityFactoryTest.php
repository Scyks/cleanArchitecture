<?php
/**
 * @author        Ronald Marske <scyks@ceow.de>
 * @filesource    EntityFactoryTest.php
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

namespace Tests\Unit\App\Todo;

use App\Todo\EntityFactory;
use App\Todo\StorageSystem\Mock\Todo;
use Tests\Unit\TestCase;

/**
 * @group Todo
 */
class EntityFactoryTest extends TestCase {

	public function tearDown() {
		$oClass = new EntityFactory;
		$oReflection = new \ReflectionClass($oClass);

		$oProp = $oReflection->getProperty('sStorageMechanism');
		$oProp->setAccessible(true);

		$oProp->setValue(null, EntityFactory::MEMORY);

		$oProp = $oReflection->getProperty('oStorageSystem');
		$oProp->setAccessible(true);
		$oProp->setValue(null, null);

		parent::tearDown();
	}

#pragma mark - dataProvider

	public function dataProviderStaticProperty() {
		return [
			['sStorageMechanism'], ['oStorageSystem']
		];
	}

#pragma mark - property_check

	/**
	 * @test
	 * @dataProvider dataProviderStaticProperty
	 */
	public function propertyExists($sPropertyName) {
		$this->assertClassHasStaticAttribute($sPropertyName, get_class(new EntityFactory));
	}

#pragma mark - setStorageMechanism

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function setStorageMechanism_wrongValue_throwsInvalidArgumentException() {
		EntityFactory::setStorageMechanism('Foobar');
	}

	/**
	 * @test
	 */
	public function setStorageMechanism_Mock_MockSetted() {
		EntityFactory::setStorageMechanism(EntityFactory::MOCK);

		$this->assertEquals(EntityFactory::MOCK, EntityFactory::getStorageMechanism());
	}

	/**
	 * @test
	 */
	public function setStorageMechanism_Memory_MockSetted() {
		EntityFactory::setStorageMechanism(EntityFactory::MEMORY);

		$this->assertEquals(EntityFactory::MEMORY, EntityFactory::getStorageMechanism());
	}

#pragma mark - getStorageMechanism

	/**
	 * @test
	 */
	public function getStorageMechanism_DefaultMechanism_MemoryisDefault() {
		$this->assertEquals(EntityFactory::MEMORY, EntityFactory::getStorageMechanism());
	}

	/**
	 * @test
	 */
	public function getStorageMechanism_Mock_ReturnsMock() {
		EntityFactory::setStorageMechanism(EntityFactory::MOCK);
		$this->assertEquals(EntityFactory::MOCK, EntityFactory::getStorageMechanism());
	}

#pragma mark - getStorageSystem

	/**
	 * @test
	 */
	public function getStorageSystem_MockMechanism_returnMockStorage() {
		EntityFactory::setStorageMechanism(EntityFactory::MOCK);
		$this->assertInstanceOf('\App\Todo\StorageSystem\Mock\Todo', EntityFactory::getStorageSystem());
	}

	/**
	 * @test
	 */
	public function getStorageSystem_MemoryMechanism_returnMockStorage() {
		$this->assertInstanceOf('\App\Todo\StorageSystem\Memory\Todo', EntityFactory::getStorageSystem());
	}

#pragma mark - setStorageSystem

	/**
	 * @test
	 * @expectedException \PHPUnit_Framework_Error
	 */
	public function setStorageSystem_InvalidParam_raiseFatalError() {
		EntityFactory::setStorageSystem('Foo');
	}

	/**
	 * @test
	 */
	public function setStorageSystem_validStorageSystem_systemDefined() {
		$oMock = new Todo;
		EntityFactory::setStorageSystem($oMock);
		$this->assertSame($oMock, EntityFactory::getStorageSystem());
	}
}
