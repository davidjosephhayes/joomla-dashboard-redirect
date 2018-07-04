<?php defined('_JEXEC') or die;

// http://docs.joomla.org/Plugin/Events/System
// http://docs.joomla.org/J2.5:Creating_a_System_Plugin_to_augment_JRouter
// http://docs.joomla.org/J3.x:Creating_a_Plugin_for_Joomla
//~ 
//~ function pre($var) { return "<pre>".print_r($var,true)."</pre>"; }
//~ error_reporting(E_ALL&~E_NOTICE);
//~ ini_set('display_errors',1);

class PlgSystemDashboardRedirect extends JPlugin {
		
	public function __construct(&$subject, $config) {
		
		parent::__construct($subject, $config);

		//~ echo 'subject',pre($subject);
		//~ echo 'config',pre($config);
		//~ echo 'paramps',pre($this->params);
		//~ exit;		
	}

	public function onAfterRoute() {

		$app = JFactory::getApplication(); 
		$user = JFactory::getUser();
		
		$redirecturl = $this->params->get('redirecturl');
		
		$option = $app->input->get('option');
		$task = $app->input->get('task');
		$view = $app->input->get('view');
		$layout = $app->input->get('layout');

		// redirect front end login to backend
		// if (!$app->isAdmin() && $option=='com_users' && $view=='login') {
		// 	$app->redirect(JUri::root().'/administrator');
		// 	return;
		// }
		
		$usergroups = $this->params->get('usergroups',array(),'array');
		
		$authgroups = $user->getAuthorisedGroups();
		$intersect = array_intersect($usergroups,$authgroups);
		
		if (!$app->isAdmin()||empty($redirecturl)||!empty($option)||!empty($task)||empty($intersect)) return;
		
		$app->redirect(JRoute::_($redirecturl,false));
	}
}
