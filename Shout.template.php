<?php

function template_shout_above(){
	global $modSettings, $context, $options, $settings, $txt, $boardurl;

	if (!empty($modSettings['enableShoutBox']) && allowedTo('chat_access')) {
		echo '
		<link rel="stylesheet" type="text/css" href="', $boardurl, '/chat/css/shoutbox.css" />';
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
			<h3 class="catbg" class="catbg centertext"><span class="left"></span>
				<span class="floatleft"><a rel="nofollow" href="#" onclick="ajax_shoutBox_collapse(!sb_current_header)"><img id="ajax_shoutbox_collapse" src="', $settings['images_url'], empty($options['sb_collapsed']) ? '/collapse.gif' : '/expand.gif','" alt="*" style="margin-right: 5px;padding-top:7px"  /></span></a>', $txt['shoutBox'], '
				<span class="floatright"><font size="1"><a href="https://blueimp.net/ajax/">AJAX Chat &copy; blueimp.net</a></font>
			</h3>
			<div id="ShoutBox"', empty($options['sb_collapsed']) ? '' : ' style="display: none;"', '>
			<span class="upperframe" style="height:18px;"><span>&nbsp;</span></span>
			<div class="roundframe"><div style="margin:-5px;">
			', ajaxchat_getShoutBoxContent() ,'
			</div></div>
			<span class="lowerframe"><span>&nbsp;</span></span>
			</div><br class="clear" />';
		}
	}
}

function template_shout_below(){
}

?>
