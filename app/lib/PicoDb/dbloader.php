<?php

spl_autoload_register(function ($className) {
	static $classMap = array(
		'PicoDb\\Condition' => 'Condition.php',
		'PicoDb\\Database' => 'Database.php',
		'PicoDb\\Hashtable' => 'Hashtable.php',
		'PicoDb\\Schema' => 'Schema.php',
		'PicoDb\\SQLException' => 'SQLException.php',
		'PicoDb\\Table' => 'Table.php',
		'PicoDb\\Driver\\Base' => 'Driver/Base.php',
		'PicoDb\\Driver\\Mysql' => 'Driver/Mysql.php',
		'PicoDb\\Driver\\Mssql' => 'Driver/Mssql.php',
		'PicoDb\\Driver\\Sqlite' => 'Driver/Sqlite.php',
		'PicoDb\\Driver\\Postgres' => 'Driver/Postgres.php'
	);

	if (isset($classMap[$className])) {
		require __DIR__ . '/' . $classMap[$className];
	}
});
