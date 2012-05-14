<?php

/**
 * When you set a theme... the 'functions.php' (this file)
 * will ALWAYS be autoloaded.
 * So template specific function go in here
 */

if (!function_exists('bootstrap_messages'))
{
	function bootstrap_messages( $messages = array() )
	{
		foreach($messages as $message)
		{
			echo '<div class="alert alert-' .$message['type'] . '">';
			echo htmlspecialchars($message['message']);
			echo '</div>';
		}
	}
}

?>