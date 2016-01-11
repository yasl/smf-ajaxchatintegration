<?php

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
   require_once(dirname(__FILE__) . '/SSI.php');
else if(!defined('SMF'))
   die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php and SSI.php files.');

if((SMF == 'SSI') && !$user_info['is_admin'])
   die('Admin priveleges required.');

//remove previous version's tabales
db_query("DROP TABLE IF EXISTS ajax_chat_online", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_chat_messages", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_chat_bans", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_chat_invitations", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_shout_online", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_shout_messages", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_shout_bans", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS ajax_shout_invitations", __FILE__, __LINE__);

db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxchat_online", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxchat_messages", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxchat_bans", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxchat_invitations", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxchat_online (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxchat_messages (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxchat_bans (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxchat_invitations (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxshout_online", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxshout_messages", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxshout_bans", __FILE__, __LINE__);
db_query("DROP TABLE IF EXISTS {$db_prefix}ajaxshout_invitations", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxshout_online (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxshout_messages (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxshout_bans (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

db_query("
CREATE TABLE {$db_prefix}ajaxshout_invitations (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
", __FILE__, __LINE__);

if(SMF == 'SSI')
   echo 'Database changes are complete!';
?>