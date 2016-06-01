<?php

/**
 * Test: dynamic snippets test.
 */

use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$latte = new Latte\Engine;
$latte->setLoader(new Latte\Loaders\StringLoader);

$template = <<<'EOD'
	{snippet outer}
	{foreach array(1,2,3) as $id}
		{snippet inner-$id}
				#{$id}
		{/snippet}
	{/foreach}
	{/snippet outer}
EOD;

Assert::matchFile(
	__DIR__ . '/expected/macros.snippet.dynamic.phtml',
	$latte->compile($template)
);