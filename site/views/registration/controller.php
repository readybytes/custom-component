<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		bhavya@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$task  = $input->getWord('task');

//echo "[$task]";
$fields = array('profiletype','name','email','password','mobile','city');

switch($task){
	case 'register':
		if($input->get('register_save',0)){
			$data = array();
			
			foreach($fields as $name){
				$data[$name]=$input->get($name, NULL);
			}
			
			registration_save($data);
		}else{
			include 'tmpl/default.php';
		}
		break;
		
		
	default :
		echo __FILE__.':No such task exist';
		break;
}


function registration_save($data)
{
	// try joomla registration
	if(!_user_register($data['email'])){
		// some error
		include 'tmpl/default.php';
		return;	
	}
	
}

function _user_exists($what, $value)
{
	$db = JFactory::getDBO();
	$query = 'SELECT id FROM #__users WHERE '.$db->nameQuote($what).' = ' . $db->Quote( $value );
	$db->setQuery($query, 0, 1);
	if($db->loadResult()){
		return true;
	}
	
	return false;
}
	
function _user_register($email)
{
	require_once  JPATH_ROOT.DS.'components'.DS.PAYPLANS_COM_USER.DS.'models'.DS.'registration.php';
	
	$model = new UsersModelRegistration();		
	jimport('joomla.mail.helper');
	
	if(!JMailHelper::isEmailAddress($email)){
		$app->enqueueMessage('Invalid Email address');
		return false;
	}
	
	if(_user_exists('email', $email)){
		$app->enqueueMessage('An account already exist with this email');
		return false;
	}
	

	// load user helper
	jimport('joomla.user.helper');
	$password = JUserHelper::genRandomPassword();
	$temp = array(	'username'=>$username,'name'=>$username,'email1'=>$email,
					'password1'=>$password, 'password2'=>$password, 'block'=>0 );
			
	$config = JFactory::getConfig();
	$params = JComponentHelper::getParams('com_users');

	// Initialise the table with JUser.
	$user = new JUser;
	
	$data = (array)$model->getData();
	// Merge in the registration data.
	foreach ($temp as $k => $v) {
		$data[$k] = $v;
	}

	// Prepare the data for the user object.
	$data['email']		= $data['email1'];
	$data['password']	= $data['password1'];

	// Bind the data.
	if (!$user->bind($data)) {
		$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));			
		return false;
	}

	// Load the users plugin group.
	JPluginHelper::importPlugin('user');

	// Store the data.
	if (!$user->save()) {
		$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
		return false;
	}

	// Compile the notification mail values.
	$data = $user->getProperties();
	$data['fromname']	= $config->get('fromname');
	$data['mailfrom']	= $config->get('mailfrom');
	$data['sitename']	= $config->get('sitename');
	$data['siteurl']	= JUri::base();

	
	$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);

	// Send the registration email.
	$mail = new JMail();
	$return = $mail->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);
	
		
	// Check for an error.
	if ($return !== true) {
		$this->setError(JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));
	}
	
	// Show what will happen to registration
	$app->enqueueMessage('Your account have been created, password have been sent to your email address. Please login using your email and passwords.');
	
	// how to find user id 
	return $user->id;
}
	