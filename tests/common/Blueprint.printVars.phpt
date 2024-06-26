<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


$blueprint = new Latte\Essential\Blueprint;
ob_start();
$blueprint->printVars(['int' => 123, 'unknown' => null]);
$res = ob_get_clean();

Assert::match(
	<<<'XX'
		%A%{varType int $int}
		{varType mixed $unknown}
		%A%
		XX,
	$res,
);
