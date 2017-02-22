<?php
/**
 * @author Richard Fussenegger <fleshgrinder@users.noreply.github.com>
 * @license http://unlicense.org/ Unlicense
 */

namespace Fleshgrinder\Core;

use PHPUnit\Framework\TestCase;

final class ValueTest extends TestCase {
	public static function provideValues() {
		$closed_resource = \fopen('php://memory', 'rb');
		\fclose($closed_resource);

		return [
			'array'             => ['array', []],
			'bool'              => ['boolean', \true],
			'float'             => ['float', 1.0],
			'int'               => ['integer', 1],
			'null'              => ['null', \null],
			'stdClass'          => ['stdClass', new \stdClass],
			'DateTimeImmutable' => ['DateTimeImmutable', new \DateTimeImmutable],
			'resource'          => ['resource', \fopen('php://memory', 'rb')],
			'closed resource'   => ['closed resource', $closed_resource],
			'string'            => ['string', ''],
		];
	}

	/**
	 * @covers       \Fleshgrinder\Core\Value::getType()
	 * @dataProvider provideValues()
	 */
	public static function test($expected_type_name, $value) {
		static::assertSame($expected_type_name, Value::getType($value));
	}
}
