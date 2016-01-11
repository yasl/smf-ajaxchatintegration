<?php

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
   require_once(dirname(__FILE__) . '/SSI.php');
else if(!defined('SMF'))
   die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');

if((SMF == 'SSI') && !$user_info['is_admin'])
   die('Admin priveleges required.');

//remove previous version's tabales
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_chat_online', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_chat_messages', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_chat_bans', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_chat_invitations', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_shout_online', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_shout_messages', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_shout_bans', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS ajax_shout_invitations', array());

$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxchat_online', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxchat_messages', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxchat_bans', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxchat_invitations', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxchat_online (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxchat_messages (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime TIMESTAMP NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxchat_bans (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxchat_invitations (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime TIMESTAMP NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxshout_online', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxshout_messages', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxshout_bans', array());
$smcFunc['db_query']('', 'DROP TABLE IF EXISTS {db_prefix}ajaxshout_invitations', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxshout_online (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxshout_messages (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxshout_bans (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

$smcFunc['db_query']('', 'CREATE TABLE {db_prefix}ajaxshout_invitations (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin', array());

if(SMF == 'SSI')
   echo 'Database changes are complete!';

?>