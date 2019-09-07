<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'one';
$query_builder = TRUE;

$db['one'] = array(
	'dsn'	=> '',
	'hostname' => 'cloud.gongsoft.com',
	'username' => 'gongsoft',
	'password' => 'gongsoft2016go',
	'database' => 'OLINDB',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['two'] = array(
	'dsn'	=> '',
	'hostname' => 'cloud.gongsoft.com',
	'username' => 'gongsoft',
	'password' => 'gongsoft2016go',
	'database' => 'OLINDBAG1',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'postgres',
	'password' => 'admin',
	'database' => 'OLINDBX',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

