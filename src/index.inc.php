<?php
require_once($modules_root."phone/class/PhoneHome.class.php");
if(!$phoneHome)	$phoneHome = new PhoneHome($request);
require_once($modules_root."users/class/UsersHome.class.php");
if(!$usersHome)	$usersHome = new UsersHome($request);

$reservedArray = array('id_gateway', 'id_plint', 'id_room');

// Определения связи домена с подразделениями
if ($item_domen['id_site'] != 1) {
    $site = $phoneHome->getSite($item_domen['id_site']);
    $id_dep = $site['id_dep'];
    $dep_list = $phoneHome->getDepList1($id_dep);
    if ($dep_list) {
        array_push($dep_list, $id_dep);
    } else {
        $dep_list = $id_dep;
    }
}

if($request->hasValue('phone') && !$request->hasValue('phonebook') && $rights == 'write') {
	$level = $request->level - 1;
	if($request->hasValue('add') || $request->hasValue('edit')) $level = $level - 1;
	
	if(in_array($request->variables_level[$level], $reservedArray)) $phoneParam['link'] = $request->variables_level[$level - 1];
	else $phoneParam['link'] = $request->variables_level[$level];
	
	
	if ($request->hasValue('gateway_plint')) {
		$listGatewayPort = $phoneHome->getGatewayPort();
		$listPlintPort = $phoneHome->getPlintPort();
	} elseif ($request->hasValue('tel_gateway')) {
		$listTel = $phoneHome->getTel();
		$listGatewayPort = $phoneHome->getGatewayPort();
	} elseif($request->hasValue('socket')) {
		$listRoom = $phoneHome->getListBy('room', 'is_show', 1, array('id', 'name'), 'name');
	} elseif ($request->hasValue('gateway_port')) {
		$listGatewayPort = $phoneHome->getGatewayPort();
		$listGateway = $phoneHome->getListBy('phone_gateway', false, false, array('id', 'name'), 'name');
	} elseif ($request->hasValue('plint_port')) {
		$listPlintPort = $phoneHome->getPlintPort();
		$listPlint = $phoneHome->getListBy('phone_plint', false, false, array('id', 'name'), 'name');
	} elseif($request->hasValue('plint')) {
		$listRoom = $phoneHome->getListBy('room', 'is_show', 1, array('id', 'name'), 'name');
	} elseif($request->hasValue('gateway')) {
		$listRoom = $phoneHome->getListBy('room', 'is_show', 1, array('id', 'name'), 'name');
	} elseif($request->hasValue('plint_port_socket')) {
		$listPlintPort = $phoneHome->getPlintPort();
		$listRoom = $phoneHome->getListBy('room', 'is_show', 1, array('id', 'name'), 'name');
		//$listSocket = $phoneHome->getListBy('phone_socket', false, false, array('id', 'name'), 'name');
		$listSocket = $phoneHome->getSocket();
	} elseif($request->hasValue('socket_execution')) {
		$listSocket = $phoneHome->getSocket(false,false,$dep_list);
	}
	
	if($request->hasValue('add') || ($request->hasValue('edit') && $request->getValue($phoneParam['link'])) || $level == 0) {
		unset($item);
		if($request->hasValue('plint')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listRoom) $itemPhone['room_name'] = $functions->makeOption($listRoom, $itemPhone['id_room']);
		} elseif($request->hasValue('gateway')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listRoom) $itemPhone['room_name'] = $functions->makeOption($listRoom, $itemPhone['id_room']);
		} elseif($request->hasValue('tel')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
		} elseif ($request->hasValue('gateway_plint')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listGatewayPort) $itemPhone['gateway_port_name'] = $functions->makeOption($listGatewayPort, $itemPhone['id_port_gateway']);
			if($listPlintPort) $itemPhone['plint_port_name'] = $functions->makeOption($listPlintPort, $itemPhone['id_port_plint']);
		} elseif ($request->hasValue('tel_gateway')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listTel) $itemPhone['tel_name'] = $functions->makeOption($listTel, $itemPhone['id_tel']);
			if($listGatewayPort) $itemPhone['gateway_port_name'] = $functions->makeOption($listGatewayPort, $itemPhone['id_port_gateway']);
		} elseif($request->hasValue('socket')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listRoom) $itemPhone['room_name'] = $functions->makeOption($listRoom, $itemPhone['id_room']);
		} elseif($request->hasValue('gateway_port')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			//if($listGatewayPort) $itemPhone['gateway_port_name'] = $functions->makeOption($listGatewayPort, $itemPhone['id']);
			if($listGateway) $itemPhone['gateway_name'] = $functions->makeOption($listGateway, $itemPhone['id_gateway']);
		} elseif($request->hasValue('plint_port')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			//if($listPlintPort) $itemPhone['plint_port_name'] = $functions->makeOption($listPlintPort, $itemPhone['id']);
			if($listPlint) $itemPhone['plint_name'] = $functions->makeOption($listPlint, $itemPhone['id_plint']);
		} elseif($request->hasValue('plint_port_socket')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			if($listPlintPort) $itemPhone['plint_port_name'] = $functions->makeOption($listPlintPort, $itemPhone['id']);
			if($listRoom) $itemPhone['room_name'] = $functions->makeOption($listRoom, $itemPhone['id_room']);
			if($listSocket) $itemPhone['socket_name'] = $functions->makeOption($listSocket, $itemPhone['id_socket']);
		} elseif($request->hasValue('socket_execution')) {
			if($request->getValue($phoneParam['link'])) $itemPhone = $phoneHome->getValue('phone_'.$phoneParam['link'], 'id', $request->getValue($phoneParam['link']), $arrayType);
			/*if($itemPhone) {
				$itemPhone['id'] = $item['id'];
			}*/
			if($listSocket) $itemPhone['socket_name'] = $functions->makeOption($listSocket, $itemPhone['id_socket']);
		}
		$itemPhone['link'] = $phoneParam['link'];
		$module['text'] = $templateHome->parse($modules_root . "phone/tpl/form_" . $phoneParam['link'] . ".tpl", $itemPhone);
	} else {
		/*if(in_array($request->variables_level[$level], $reservedArray)) $phoneParam['link_add'] = $request->variables_level[$level];
		echo $phoneParam['link_add'].'=';
		if($phoneParam['link_add']) {
			$par_add = $phoneParam['link_add'];
			$val_add = $request->getValue($phoneParam['link_add']);
		} else $par_add = $val_add = 0;*/
		if(!$listParam) $listParam = $phoneHome->getListBy('phone_'.$phoneParam['link'], false, false, $arrayType, $order);
		$i = 0;
		if($listParam && is_array($listParam)) {
			foreach ($listParam as $item) {
				if($request->hasValue('edit')) $item['edit'] = true;
				$item['num'] = ++$i;
				if($i == 1) $item['editform'] = true;
				else $item['editform'] = false;
				if ($request->hasValue('tel')) {
					//$item['room_name'] = $phoneHome->getValue($item['id_room']);
				} elseif ($request->hasValue('gateway')) {
					if($request->hasValue('edit')) {
						if ($listRoom) $item['room_name'] = $functions->makeOption($listRoom, $item['id_room']);
					} else {
						$item['room_name'] = $phoneHome->getValue('room', 'id', $item['id_room'], array('id', 'name'))['name'];
					}
				} elseif ($request->hasValue('plint')) {
					if($request->hasValue('edit')) {
						if ($listRoom) $item['room_name'] = $functions->makeOption($listRoom, $item['id_room']);
					} else {
						$item['room_name'] = $phoneHome->getValue('room', 'id', $item['id_room'], array('id', 'name'))['name'];
					}
				} elseif ($request->hasValue('socket')) {
					if($request->hasValue('edit')) {
						if($listRoom) $item['room_name'] = $functions->makeOption($listRoom, $item['id_room']);
					} else {
						$item['room_name'] = $phoneHome->getValue('room', 'id', $item['id_room'], array('id', 'name'))['name'];
					}
				} elseif ($request->hasValue('tel_gateway')) {
					if($request->hasValue('edit')) {
						if($listTel) $item['tel_name'] = $functions->makeOption($listTel, $item['id_tel']);
						if($listGatewayPort) $item['gateway_port_name'] = $functions->makeOption($listGatewayPort, $item['id_port_gateway']);
					} else {
						$item['tel_name'] = $phoneHome->getValue('phone_tel', 'id', $item['id_tel'], array('number'))['number'];
						$portGateway = $phoneHome->getValue('phone_gateway_port', 'id', $item['id_port_gateway'], array('id_gateway', 'name'));
						$gateway = $phoneHome->getValue('phone_gateway', 'id', $portGateway['id_gateway'], array('name', 'ip_out'));
						$item['gateway_port_name'] = $gateway['name'] .' '.$gateway['ip_out'].' / ' . $portGateway['name'];
					}
				} elseif ($request->hasValue('gateway_plint')) {
					if($request->hasValue('edit')) {
						if($listGatewayPort) $item['gateway_port_name'] = $functions->makeOption($listGatewayPort, $item['id_port_gateway']);
						if($listPlintPort) $item['plint_port_name'] = $functions->makeOption($listPlintPort, $item['id_port_plint']);
					} else {
						$portGateway = $phoneHome->getValue('phone_gateway_port', 'id', $item['id_port_gateway'], array('id_gateway', 'name'));
						$gateway = $phoneHome->getValue('phone_gateway', 'id', $portGateway['id_gateway'], array('name'));
						$tel = $phoneHome->getTelByPort($item['id_port_gateway']);
						$item['gateway_port_name'] = $gateway['name'] . ' / ' . $portGateway['name'];
						if($tel['number']) $item['gateway_port_name'] .= ' ['.$tel['number'].']';
						$socket = $phoneHome->getSocketByPort($item['id_port_plint']);
						$portPlint = $phoneHome->getValue('phone_plint_port', 'id', $item['id_port_plint'], array('id_plint', 'name'));
						$plint = $phoneHome->getValue('phone_plint', 'id', $portPlint['id_plint'], array('name'));
						$item['plint_port_name'] = $plint['name'] . ' / ' . $portPlint['name'];
						if($socket) $item['plint_port_name'] .= ' ['.$socket['name'].']';
					}
				} elseif ($request->hasValue('plint_port')) {
					if($request->hasValue('edit')) {
						//if($listPlintPort) $item['plint_port_name'] = $functions->makeOption($listPlintPort, $item['id']);
						if($listPlint) $item['plint_name'] = $functions->makeOption($listPlint, $item['id_plint']);
					} else {
						$item['plint_name'] = $phoneHome->getValue('phone_plint', 'id', $item['id_plint'], array('name'))['name'];
						$portPlint = $phoneHome->getValue('phone_plint_port', 'id', $item['id'], array('id_plint', 'name'));
						$plint = $phoneHome->getValue('phone_plint', 'id', $portPlint['id_plint'], array('name'));
						$item['plint_port_name'] = $plint['name'] . ' / ' . $portPlint['name'];
					}
				} elseif ($request->hasValue('gateway_port')) {
					if($request->hasValue('edit')) {
						//if($listGatewayPort) $item['gateway_port_name'] = $functions->makeOption($listGatewayPort, $item['id']);
						if($listGateway) $item['gateway_name'] = $functions->makeOption($listGateway, $item['id_gateway']);
					} else {
						$item['gateway_name'] = $phoneHome->getValue('phone_gateway', 'id', $item['id_gateway'], array('name'))['name'];
						$portGateway = $phoneHome->getValue('phone_gateway_port', 'id', $item['id'], array('id_gateway', 'name'));
						$gateway = $phoneHome->getValue('phone_gateway', 'id', $portGateway['id_gateway'], array('name'));
						$item['gateway_port_name'] = $gateway['name'] . ' / ' . $portGateway['name'];
					}
				} elseif ($request->hasValue('plint_port_socket')) {
					if($request->hasValue('edit')) {
						if($listPlintPort) $item['plint_port_name'] = $functions->makeOption($listPlintPort, $item['id_port_plint']);
						$socket = $phoneHome->getValue('phone_socket', 'id', $item['id_socket'], array('id', 'name', 'id_room'));
						$item['room_name'] = $phoneHome->getValue('room', 'id', $socket['id_room'], array('id', 'name'))['name'];
						if($listSocket) $item['socket_name'] = $functions->makeOption($listSocket, $item['id_socket']);
					} else {
						$portPlint = $phoneHome->getValue('phone_plint_port', 'id', $item['id_port_plint'], array('id_plint', 'name'));
						$plint = $phoneHome->getValue('phone_plint', 'id', $portPlint['id_plint'], array('name'));
						$item['plint_port_name'] = $plint['name'] . ' / ' . $portPlint['name'];
						$socket = $phoneHome->getValue('phone_socket', 'id', $item['id_socket'], array('id', 'name', 'id_room'));
						$item['socket_name'] = $socket['name'];
						$room = $phoneHome->getValue('room', 'id', $socket['id_room'], array('id', 'name'));
						$item['room_name'] = $room['name'];
						$item['id_room'] = $room['id'];
					}
				} elseif ($request->hasValue('socket_execution')) {
					if($request->hasValue('edit')) {
						if($listSocket) $item['socket_name'] = $functions->makeOption($listSocket, $item['id_socket']);
					} else {
						$socket = $phoneHome->getValue('phone_socket', 'id', $item['id_socket'], array('id', 'name', 'id_room'));
						$room_item = $phoneHome->getValue('room', 'id', $socket['id_room'], array('id', 'name', 'id_dep'));
						if($dep_list && !in_array($room_item['id_dep'], $dep_list)) continue;
						$room['name'] = $room_item['name'];
						$item['socket_name'] = $room['name'].' / '.$socket['name'];
						//if($rights == 'write') {
							$tel = $phoneHome->getTelBySocket('phone_socket.id', $item['id_socket']);
							if($tel) $item['socket_name'] .= ' / '.$tel['number'];
							//var_dump($tel);
						//}
						
						if($item['id_execution']) {
							$user = $phoneHome->getByExec($item['id_execution']);
							$item['user_name'] = $user['name'] . ' (' . $user['name_department'] . ', '.$user['position_name'].')';
							$item['id_user'] = $user['id'];
						} else $item['user_name'] = 'Не назначен';
					}
				} else {
				
				}
				//var_dump($item);
				$item['link'] = $phoneParam['link'];
				$listParam['rows'] .= $templateHome->parse($modules_root . "phone/tpl/row_" . $phoneParam['link'] . ".tpl", $item);
			}
		} else $listParam = array();
		$listParam[$phoneParam['link']] = true;
		$listParam['link'] = $phoneParam['link'];
		if($request->hasValue('edit')) $listParam['edit'] = true;
		$module['text'] = $templateHome->parse($modules_root . "phone/tpl/table.tpl", $listParam);
	}
} elseif($request->hasValue('phone') && ($request->hasValue('phonebook') || $rights!='write')) {
	$phonebookList = $phoneHome->getPhonebook($rights, $dep_list);
	if($rights == 'write') $phonebookList['admin'] = true;
	$module['text'] = $templateHome->parse($modules_root . "phone/tpl/table_phonebook.tpl", $phonebookList);
}


?>