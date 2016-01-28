<?php

function template_shout_above(){
	global $modSettings, $context, $options, $settings, $txt, $boardurl;

	if (!empty($modSettings['enableShoutBox']) && allowedTo('chat_access')) {
		echo '
		<link rel="stylesheet" type="text/css" href="', $boardurl, '/chat/css/shoutbox.css" />
		<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/shout.css" />';
		// We'll have to use the cookie to remember the shoutBox header...
		if ($context['user']['is_guest'])
			$options['sb_collapsed'] = !empty($_COOKIE['sb_collapsed']);

		echo '
		<script language="JavaScript" type="text/javascript">
			var sb_current_header = ', empty($options['sb_collapsed']) ? 'false' : 'true', ';

			function ajax_shoutBox_collapse(mode)
			{';

		if ($context['user']['is_guest'])
			echo '
				document.cookie = "sb_collapsed=" + (mode ? 1 : 0);';
		else
			echo '
				smf_setThemeOption("sb_collapsed", mode ? 1 : 0, null, "', $context['session_id'], '");';

		echo '
				document.getElementById("ajax_shoutbox_collapse").src = smf_images_url + (mode ? "/expand.gif" : "/collapse.gif");

				document.getElementById("ShoutBox").style.display = mode ? "none" : "";

				sb_current_header = mode;
				}
		</script>';
/******************************************************************************
Please retain the full copyright notice below including the link to blueimp.net.
This not only gives respect to the amount of time given freely by the developer
but also helps build interest, traffic and use of AJAX Chat.
Thanks,
Sebastian Tschan
*******************************************************************************/
		if (!empty($modSettings['anyPageShoutBox']) || isset($context['chat_isHome'])) {
			echo'
			<div class="cat_bar">
				<h3 class="catbg" class="catbg centertext">
					<a rel="nofollow" href="#" onclick="ajax_shoutBox_collapse(!sb_current_header)">', $txt['shoutBox'], '</a>
					<span class="floatright">
						<a rel="nofollow" href="#" onclick="ajax_shoutBox_collapse(!sb_current_header)">
							<img id="ajax_shoutbox_collapse" style="padding:10px 5px 0 1em"
								src="', $settings['images_url'], empty($options['sb_collapsed']) ? '/collapse.gif' : '/expand.gif','" alt="*" />
						</a>
					</span>
					<span class="floatright">
						<font size="1"><a href="https://blueimp.net/ajax/">AJAX Chat &copy; blueimp.net</a></font>
					</span>
				</h3>
			</div>
			<div id="ShoutBox"', empty($options['sb_collapsed']) ? '' : ' style="display: none;"', '>
			<span class="upperframe" style="height:18px;"><span>&nbsp;</span></span>
			<div class="roundframe"><div style="margin:-5px;"><div id="ajaxChatContent">
			', ajaxchat_getShoutBoxContent() ,'
			<div id="ajaxChatCopyright" style="position: relative;">
				<a href="' . AJAX_CHAT_URL . '"><button type="button" class="chatlinkbutton">Join Chat</button></a>
				<a href="' . AJAX_CHAT_URL . '../index.php?topic=871.0"><button type="button" class="chathelpbutton">Chat Help</button></a>
				<p>', call_user_func($context['chat_links_txt_fn'], $context['chat_links'], ': '), '</p>
			</div>
			</div></div></div>
			<span class="lowerframe"><span>&nbsp;</span></span>
			</div><br class="clear" />';
		}
	}
}

function template_shout_below(){
}

?>
