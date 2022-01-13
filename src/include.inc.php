<?php
require_once($modules_root."phone/class/PhoneHome.class.php");
if(!$phoneHome)	$phoneHome = new PhoneHome($request);

$level = $request->level - 1;
if($request->hasValue('add') || $request->hasValue('edit')) $level = $level - 1;
$link = $request->variables_level[$level];

if($request->hasValue('phonebook')) {
	$module['title'] = 'Телефонный справочник ПГУ';
	$mass = array();
	if (! is_array ( $module ['url'] )) $module ['url'] = array ();
	$mass['title'] = $module['title'];
	$mass['link'] = '/phone/phonebook';
	array_push($module['url'], $mass);
} elseif($rights == 'write') {
	if ($request->hasValue('phone') && $level == 0) {
	
	} elseif ($request->hasValue('tel')) {
		$title = ". Телефоны";
		$arrayType = $phoneHome->item_tel;
		$order = 'number';
	} elseif ($request->hasValue('gateway')) {
		$title = ". Шлюзы";
		$arrayType = $phoneHome->item_gateway;
		$order = 'name';
	} elseif ($request->hasValue('plint')) {
		$title = ". Плинты";
		$arrayType = $phoneHome->item_plint;
		$order = 'name';
	} elseif ($request->hasValue('socket')) {
		$title = ". Розетки";
		$arrayType = $phoneHome->item_socket;
		$order = 'name';
	} elseif ($request->hasValue('tel_gateway')) { //связка телефона с порта шлюза
		$title = ". Телефоны к портам шлюзов";
		$arrayType = $phoneHome->item_tel_gateway;
		$order = 'id_tel';
	} elseif ($request->hasValue('gateway_plint')) { //связка порта шлюза с портом плинта
		$title = ". Порт шлюза к порту плинта";
		$arrayType = $phoneHome->item_gateway_plint;
		$order = 'id_port_gateway';
	} elseif ($request->hasValue('plint_port_socket')) { //связка порта плинта с розеткой в комнате
		$title = ". Связь портов плинтов и розеток";
		$arrayType = $phoneHome->item_plint_port_socket;
		$order = 'id_port_plint';
	} elseif ($request->hasValue('socket_room')) { //связка розеток с комнатами
		$title = ". Розетка/Комната";
		$arrayType = $phoneHome->item_socket_room;
		$order = 'name';
	} elseif ($request->hasValue('plint_port')) { //связка порта плинта и плинта
		$title = '. Связь портов плинтов и плинтов';
		$arrayType = $phoneHome->item_plint_port;
		$order = 'id_plint, name';
	} elseif ($request->hasValue('gateway_port')) { //связка порта шлюза и шлюза
		$title = '. Связь портов шлюзов и шлюзов';
		$arrayType = $phoneHome->item_gateway_port;
		$order = 'id_gateway, name';
	} elseif ($request->hasValue('socket_execution')) { //Связь розеток с исполнениями пользователей
		$title = '. Связь розеток с исполнениями пользователей';
		$arrayType = $phoneHome->item_socket_execution;
		$order = 'id_socket';
	}
	$module['title'] = $module['description'].$title;
	if ($request->getValue($link) && $request->hasValue('edit')) {
		$module['title'] .= ". Редактировние связки";
	} elseif ($request->hasValue($link) && $request->hasValue('add')) {
		$module['title'] .= ". Добавление связки";
	}
	
} else {
	$module['text'] = 'У вас нет прав для редактирования или просмотра данного раздела. Обратитесь к Администратору.';
}

?>