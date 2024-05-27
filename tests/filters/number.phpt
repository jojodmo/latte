<?php

/**
 * Test: Latte\Essential\Filters::number()
 */

declare(strict_types=1);

use Latte\Essential\Filters;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('no locale', function () {
	$filters = new Filters;

	Assert::same('0', $filters->number(0));
	Assert::same('0.00', $filters->number(0, 2));
	Assert::same('1,234', $filters->number(1234));
	Assert::same('123.46', $filters->number(123.456, 2));
	Assert::same('123.457', $filters->number(123.4567, 3));
	Assert::same('1 234.56', $filters->number(1234.56, 2, '.', ' '));
	Assert::same('1.234,56', $filters->number(1234.56, 2, ',', '.'));
	Assert::same('-1,234', $filters->number(-1234));
	Assert::same('-1,234.57', $filters->number(-1234.5678, 2));
	Assert::same('nan', $filters->number(NAN, 2));

	// negative decimals means rounding
	Assert::same('100', $filters->number(123.456, -2));
});


test('with locale', function () {
	$filters = new Filters;
	$filters->locale = 'cs_CZ';

	Assert::same('0', $filters->number(0));
	Assert::same('0,00', $filters->number(0, 2));
	Assert::same('1 234', $filters->number(1234));
	Assert::same('123,46', $filters->number(123.456, 2));
	Assert::same('123,457', $filters->number(123.4567, 3));
	Assert::same('-1 234', $filters->number(-1234));
	Assert::same('-1 234,57', $filters->number(-1234.5678, 2));
	Assert::same('NaN', $filters->number(NAN, 2));

	// negative decimals is invalid, prints all digits
	Assert::same('0', $filters->number(0.0, -2));
	Assert::same('123,456', $filters->number(123.456, -2));

	// pattern
	Assert::same('00 123,4560', $filters->number(123.456, '00,000.0000'));
});


test('disabled locale', function () {
	$filters = new Filters;
	$filters->locale = 'cs_CZ';

	Assert::same('1 234.56', $filters->number(1234.56, 2, '.', ' '));
	Assert::same('1.234,56', $filters->number(1234.56, 2, ',', '.'));
});
