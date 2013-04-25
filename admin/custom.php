<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		bhavya@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


$app = JFactory::getApplication();
$input = $app->input;
$view  = $input->getWord('view');
$task  = $input->getWord('task');

if(include_once __DIR__."/views/$view/controller.php"){
	//do nothing
}else{
	echo "file name [$view] not exist";
	exit;
}