<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.0.10.0
* @ Author			:	DeZender
* @ Release on		:	09.04.2020
* @ Official site	:	http://DeZender.Net
*
*/

class AdminDispatcher2
{
	public function dispatch($action, $parameters)
	{
		if (!$action) {
			$action = 'index';
		}

		$controller = new Controller2();

		if (is_callable([$controller, $action])) {
			return $controller->$action($parameters);
		}

		return '<p>Invalid action requested. Please go back and try again.</p> ' . "\n" . '            ' . "\n\n" . '<p>' . "\n" . '    <a href="addonmodules.php?module=xtreamdashboard" class="btn btn-info">' . "\n" . '        <i class="fa fa-arrow-left"></i>' . "\n" . '        Back to home' . "\n" . '    </a>' . "\n" . '</p>';
	}
}

?>