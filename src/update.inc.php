<?php
require_once($modules_root."phone/class/PhoneHome.class.php");
if(!$phoneHome)	$phoneHome = new PhoneHome($request);

$level = $request->level - 1;
if($request->hasValue('add') || $request->hasValue('edit') || $request->hasValue('del')) $level = $level - 1;
$link = $request->variables_level[$level];

if($loggedIn && $rights=="write") {
	if ($request->hasValue('save_gateway')) {
		$id = $request->getValue('id');
		if($id && is_array($id)) {
			unset($item);
			foreach ($id as $key => $value) {
				$item['id'] = $id[$value];
				$item['name'] = $request->getValue('name')[$value];
				$item['ip'] = $request->getValue('ip')[$value];
				$item['ip_out'] = $request->getValue('ip_out')[$value];
				$item['count_port'] = $request->getValue('count_port')[$value];
				$item['id_room'] = $request->getValue('id_room')[$value];
				$phoneHome->save('phone_gateway', $item, $phoneHome->item_gateway);
				
				$listPortGateway = $phoneHome->getListBy('phone_gateway_port', 'id_gateway', $item['id'], array('id'));
				if(count($listPortGateway) < $item['count_port']) {
					$new_port = $item['count_port'] - $listPortGateway;
					for($i = 0; $i < $new_port; $i++) {
						$item_port['name'] = $i+1;
						$item_port['id_gateway'] = $item['id'];
						$phoneHome->save('phone_gateway_port', $item_port, $phoneHome->item_gateway_port);
					}
				}
			}
		} else {
			$item = $functions->getForm($phoneHome->item_gateway);
			$id = $phoneHome->save('phone_gateway', $item, $phoneHome->item_gateway);
			if($id) {
				for($i = 0; $i < $item['count_port']; $i++) {
					$item_port['name'] = $i+1;
					$item_port['id_gateway'] = $id;
					$phoneHome->save('phone_gateway_port', $item_port, $phoneHome->item_gateway_port);
				}
			}
		}
		$response->redirect('/phone/gateway');
	} elseif ($request->hasValue('save_tel')) {
		$id = $request->getValue('id');
		if($id && is_array($id)) {
			unset($item);
			foreach ($id as $key => $value) {
				$item['id'] = $id[$value];
				$item['number'] = $request->getValue('number')[$value];
				$item['inner_number'] = $request->getValue('inner_number')[$value];
				if ($request->getValue('is_cell')[$value]) $item['is_cell'] = 1;
				else $item['is_cell'] = 0;
				if ($request->getValue('is_intercity')[$value]) $item['is_intercity'] = 1;
				else $item['is_intercity'] = 0;
				if ($request->getValue('is_hidden')[$value]) $item['is_hidden'] = 1;
				else $item['is_hidden'] = 0;
				//var_dump($item);
				//echo '***'.$request->getValue('is_intercity')[1206].'***';
				
				$phoneHome->save('phone_tel', $item, $phoneHome->item_tel);
			}
			//var_dump($request);
		} else {
			$item = $functions->getForm($phoneHome->item_tel);
			if ($request->getValue('is_cell')) $item['is_cell'] = 1;
			else $item['is_cell'] = 0;
			if ($request->getValue('is_intercity')) $item['is_intercity'] = 1;
			else $item['is_intercity'] = 0;
			if ($request->getValue('is_hidden')) $item['is_hidden'] = 1;
			else $item['is_hidden'] = 0;
			if(!$item['inner_number']) $item['inner_number'] = '';
			$phoneHome->save('phone_tel', $item, $phoneHome->item_tel);
		}
		$response->redirect('/phone/tel');
	} elseif ($request->hasValue('save_plint')) {
		$id = $request->getValue('id');
		if($id && is_array($id)) {
			unset($item);
			foreach ($id as $key => $value) {
				$item['id'] = $id[$value];
				$item['name'] = $request->getValue('name')[$value];
				$item['count_port'] = $request->getValue('count_port')[$value];
				$item['id_room'] = $request->getValue('id_room')[$value];
				$phoneHome->save('phone_plint', $item, $phoneHome->item_plint);
				$listPortPlint = $phoneHome->getListBy('phone_plint_port', 'id_plint', $item['id'], array('id'));
				if(count($listPortPlint) < $item['count_port']) {
					$new_port = $item['count_port'] - $listPortPlint;
					for($i = 0; $i < $new_port; $i++) {
						$item_port['name'] = $i+1;
						$item_port['id_plint'] = $item['id'];
						$phoneHome->save('phone_plint_port', $item_port, $phoneHome->item_plint_port);
					}
				}
			}
		} else {
			$item = $functions->getForm($phoneHome->item_plint);
			$id = $phoneHome->save('phone_plint', $item, $phoneHome->item_plint);
			if($id) {
				for($i = 0; $i < $item['count_port']; $i++) {
					$item_port['name'] = $i+1;
					$item_port['id_plint'] = $id;
					$phoneHome->save('phone_plint_port', $item_port, $phoneHome->item_plint_port);
				}
			}
		}
		$response->redirect('/phone/plint');
	} elseif ($request->hasValue('save_socket')) {
		$id = $request->getValue('id');
		if($id && is_array($id)) {
			unset($item);
			foreach ($id as $key => $value) {
				$item['id'] = $id[$value];
				$item['name'] = $request->getValue('name')[$value];
				$item['id_room'] = $request->getValue('id_room')[$value];
				$phoneHome->save('phone_socket', $item, $phoneHome->item_socket);
			}
		} else {
			$item = $functions->getForm($phoneHome->item_socket);
			if(!$item['id_room'] && $request->getValue('name_room')) {
			    $room = array();
			    $room['name'] = $room['number'] = $request->getValue('name_room');
			    $item['id_room'] =  $phoneHome->save('room', $room, array('name', 'number'));
			}
			$socket = $phoneHome->save('phone_socket', $item, $phoneHome->item_socket);
			if($socket) {
				if($request->getValue('id_port_plint')) {
					$itemPort['id_socket'] = $socket;
					$itemPort['id_port_plint'] = $request->getValue('id_port_plint');
					$phoneHome->save('phone_plint_port_socket', $itemPort, $phoneHome->item_plint_port_socket);
				}
			}
		}
		if($request->hasValue('save_from_ajax')) $response->redirect('/phone/plint_port_socket');
		else $response->redirect('/phone/socket');
	} elseif($request->hasValue('save_gateway_plint')) {
		//var_dump($request);
		$id = $request->getValue('id');
		if($id) {
			unset($item);
			foreach ($id as $key => $value) {
				if($value) $item['id'] = $id[$value];
				else $value = 0;
				$item['id_port_gateway'] = $request->getValue('id_port_gateway')[$value];
				$item['id_port_plint'] = $request->getValue('id_port_plint')[$value];
				$resp = $phoneHome->save('phone_gateway_plint', $item, $phoneHome->item_gateway_plint);
			}
			if($resp) $response->redirect('/phone/gateway_plint');
		}
		/*$id = $request->getValue('id');
		if($id && is_array($id)) {
			unset($item);
			foreach ($id as $key => $value) {
				$item['id'] = $id[$value];
				$item['id_port_gateway'] = $request->getValue('id_port_gateway')[$value];
				$item['id_port_plint'] = $request->getValue('id_port_plint')[$value];
				$phoneHome->save('phone_gateway_plint', $item, $phoneHome->item_gateway_plint);
			}
		} else {
			$item = $functions->getForm($phoneHome->item_gateway_plint);
			$phoneHome->save('phone_gateway_plint', $item, $phoneHome->item_gateway_plint);
			//if($id) $response->redirect('/'.$link);
		}*/
	} elseif($request->hasValue('save_tel_gateway')) {
		$id = $request->getValue('id');
		if($id) {
			unset($item);
			foreach ($id as $key => $value) {
				if($value) $item['id'] = $id[$value];
				else $value = 0;
				$item['id_port_gateway'] = $request->getValue('id_port_gateway')[$value];
				$item['id_tel'] = $request->getValue('id_tel')[$value];
				$resp = $phoneHome->save('phone_tel_gateway', $item, $phoneHome->item_tel_gateway);
			}
			if($resp) $response->redirect('/phone/tel_gateway');
		}
	} elseif($request->hasValue('save_plint_port_socket')) {
		$id = $request->getValue('id');
		if($id) {
			unset($item);
			foreach ($id as $key => $value) {
				if($value) $item['id'] = $id[$value];
				else $value = 0;
				$item['id_port_plint'] = $request->getValue('id_port_plint')[$value];
				$item['id_socket'] = $request->getValue('id_socket')[$value];
				$resp = $phoneHome->save('phone_plint_port_socket', $item, $phoneHome->item_plint_port_socket);
			}
			if($resp) $response->redirect('/phone/plint_port_socket');
		}
	} elseif ($request->hasValue('save_gateway_port')) {
		if ($request->hasValue('save_gateway_port')) {
			$id = $request->getValue('id');
			if ($id && is_array($id)) {
				unset($item);
				foreach ($id as $key => $value) {
					$item['id'] = $id[$value];
					$item['name'] = $request->getValue('name')[$value];
					$item['id_gateway'] = $request->getValue('id_gateway')[$value];
					$phoneHome->save('phone_gateway_port', $item, $phoneHome->item_gateway_port);
				}
			} else {
				$item = $functions->getForm($phoneHome->item_gateway_port);
				$phoneHome->save('phone_gateway_port', $item, $phoneHome->item_gateway_port);
			}
			$response->redirect('/phone/gateway_port');
		}
	} elseif ($request->hasValue('plint_port')) {
		if($request->hasValue('save_plint_port')) {
			$id = $request->getValue('id');
			if($id && is_array($id)) {
				unset($item);
				foreach ($id as $key => $value) {
					$item['id'] = $id[$value];
					$item['name'] = $request->getValue('name')[$value];
					$item['id_plint'] = $request->getValue('id_plint')[$value];
					$phoneHome->save('phone_plint_port', $item, $phoneHome->item_plint_port);
				}
			} else {
				$item = $functions->getForm($phoneHome->item_plint_port);
				$phoneHome->save('phone_plint_port', $item, $phoneHome->item_plint_port);
			}
			$response->redirect('/phone/plint_port');
		}
	} elseif ($request->hasValue('socket_execution')) {
		if ($request->hasValue('save_socket_execution')) {
			$id = $request->getValue('id');
			if ($id && is_array($id)) {
				unset($item);
				foreach ($id as $key => $value) {
					$item['id'] = $id[$value];
					$item['id_execution'] = $request->getValue('id_execution')[$value];
					$item['id_socket'] = $request->getValue('id_socket')[$value];
					$item['text'] = $request->getValue('text')[$value];
					$phoneHome->save('phone_socket_execution', $item, $phoneHome->item_socket_execution);
				}
			} else {
				$item = $functions->getForm($phoneHome->item_socket_execution);
				if ($request->getValue('selected_user')) {
					$tmpArray = explode(' # ', $request->getValue('selected_user'));
					$item['id_execution'] = $tmpArray['3'];
				}
				//var_dump($item);
				$phoneHome->save('phone_socket_execution', $item, $phoneHome->item_socket_execution);
				$response->redirect('/phone/socket_execution');
			}
			$response->redirect('/phone/socket_execution');
		}
	}
	if($request->hasValue('del')) {
		$phoneHome->delete('phone_'.$link, $request->getValue($link));
		$response->redirect('/phone/'.$link);
	}
}

?>