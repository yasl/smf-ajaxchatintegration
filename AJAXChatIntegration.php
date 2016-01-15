<?php

if (!defined('SMF'))
	die('Hacking attempt...');


function ajaxchat_getOnlineUsers()
{
	global $smcFunc;

	$result = $smcFunc['db_query']('', '
		SELECT userID
			FROM {db_prefix}ajaxchat_online
			WHERE NOW() <= DATE_ADD(dateTime, interval 2 MINUTE)' ,
		array()
	);

	$userIDs = array();
	while($row = $smcFunc['db_fetch_assoc']($result)) {
		array_push($userIDs, $row['userID']);
	}
	$smcFunc['db_free_result']($result);

	return array_unique($userIDs);
}

function ajaxchat_getOnlineUserLinks($userIDs = null)
{
	global $scripturl, $smcFunc;

	$userIDs = (!is_null($userIDs) ? $userIDs : ajaxchat_getOnlineUsers());
	if (empty($userIDs))
		return array();

	$result = $smcFunc['db_query']('', '
		SELECT mem.ID_MEMBER, mem.real_name, mem.ID_GROUP, mg.online_color, mg.ID_GROUP
			FROM {db_prefix}members AS mem
			LEFT JOIN {db_prefix}membergroups AS mg
				ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
			WHERE mem.ID_MEMBER' . (count($userIDs) == 1 ? ' = {int:user_ids}' : ' IN ({array_int:user_ids})'),
		array(
			'user_ids' => (count($userIDs) == 1 ? $userIDs[0] : $userIDs),
			)
	);

	$user_links = array();
	while ($row = $smcFunc['db_fetch_assoc']($result)) {
		$link = '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'];
		if($row['online_color']) {
			$link .= '" style="color: ' . $row['online_color'];
		}
		$link .= '">' . $row['real_name'] . '</a>';
		array_push($user_links, $link);
	}
	$smcFunc['db_free_result']($result);

	return $user_links;
}

function ajaxchat_modifySettings($return_config = false)
{
	global $txt, $scripturl, $context, $settings, $sc, $modSettings;

	$config_vars = array(
		array('check', 'enableShoutBox'),
		array('check', 'anyPageShoutBox'),
		array('check', 'enableChatButtonNo'),
	);

	if ($return_config)
		return $config_vars;

	$context['post_url'] = $scripturl . '?action=admin;area=modsettings;save;sa=chat';
	$context['settings_title'] = $txt['chat'];

	// No removing this line you, dirty unwashed mod authors. :p
	if (empty($config_vars)) {
		$context['settings_save_dont_show'] = true;
		$context['settings_message'] = '<div style="text-align: center">' . $txt['modification_no_misc_settings'] . '</div>';

		return prepareDBSettingContext($config_vars);
	}

	// Saving?
	if (isset($_GET['save'])) {
		checkSession();
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		redirectexit('action=admin;area=modsettings;sa=chat');
	}

	prepareDBSettingContext($config_vars);
}

function ajaxchat_getShoutBoxContent($mini = false)
{
	global $scripturl, $modSettings;

	// Get the URL to the chat directory:
	if (!defined('AJAX_CHAT_URL'))
		define('AJAX_CHAT_URL', str_replace("index.php", "chat/", $scripturl));

	// Get the real path to the chat directory:
	if (!defined('AJAX_CHAT_PATH'))
		define('AJAX_CHAT_PATH', dirname(dirname(__FILE__)) . '/chat/');

	// Validate the path to the chat:
	if (@is_file(AJAX_CHAT_PATH . 'lib/classes.php')) {
		// Include Class libraries:
		require_once(AJAX_CHAT_PATH.'lib/classes.php');

		// Initialize the shoutbox:
		$ajaxChat = new CustomAJAXChatShoutBox();

		// Parse and return the shoutbox template content:
		return $ajaxChat->getShoutBoxContent($mini);
	}
	return null;
}

?>
