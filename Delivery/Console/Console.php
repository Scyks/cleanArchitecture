<?php

/**
 * When PHPUnit constant is defined break here
 * because console app start running when phpunit
 * is running
 */
if (defined('PHPUNIT')) {
	return;
}

chdir(dirname(dirname(__DIR__)));

require_once 'vendor/autoload.php';

$menu = array(
	'\Delivery\Console\Todo\ListTodos' => 'List Todo\'s',
	'\Delivery\Console\Todo\Add' => 'Add a new Todo',
	'quit' => 'Quit',
);

while (true) {
	$choice = \cli\menu($menu, null, 'Choose an example');
	\cli\line();

	if ($choice == 'quit') {
		break;
	}

	(new $choice())->process();

}
