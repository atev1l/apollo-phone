<?php
require_once($modules_root."phone/class/PhoneHome.class.php");
if(!$phoneHome)	$phoneHome = new PhoneHome($request);
//require_once($modules_root."cars/class/CarsHome.class.php");
//if(!$carsHome)	$carsHome = new CarsHome($request);

if($request->hasValue('xml')) {
    $phonebookList = $phoneHome->getPhonebook(false,false,false,true);
    $html = $templateHome->parse($modules_root . "phone/tpl/table_phonebook_xml.tpl", $phonebookList);
    echo $html;
}

if($request->hasValue("dataPhoneBook")){
    $phoneBook = $phoneHome->Uwowo();

    $data = array(
        'draw' =>(5),
        'recordsFiltered' => $phoneBook['countRecords'],
        'recordsTotal' => $phoneBook['countRecords'],
        'data'=>
            array()
    );

    foreach($phoneBook['dataPhone'] as $row) {
        $photoUser = $templateHome->parse($modules_root."phone/tpl/table/row_photo_user.tpl", $row);
        if ($row['id_user'] == null){
            $worker = $templateHome->parse($modules_root."phone/tpl/table/row_comment.tpl", $row);
        } else {
            $worker = $templateHome->parse($modules_root."phone/tpl/table/row_worker.tpl", $row);
        }
        $phone = $templateHome->parse($modules_root."phone/tpl/table/row_phone.tpl", $row);
        $gateway = $templateHome->parse($modules_root."phone/tpl/table/row_gateway.tpl", $row);

        array_push( $data['data'], array("Телефон" =>  $phone,"Фото"=> $photoUser,"Сотрудник"=>$worker,
            "Подразделение"=>$row['dep_name'], "Аудитория/розетка"=>$row['room_name']. " / " .$row['socket_name'], "IP шлюза/порт"=>$gateway,
            "Плинт"=>$row['plint_name']. " / " .$row['plint_port_name'], "ID"=>$row['id_socket_execution'], "is_hidden" => $row['is_hidden']));

    }
    echo json_encode($data);
}
//if($request->hasValue("dataPhoneBook")){
//    $phoneBook = $phoneHome->getPhonebookAjax();
//    $valuesPagination = $phoneHome->getValuesPagination($phoneBook);
//
//    $data = array(
//        'draw' =>($valuesPagination['draw']),
//        'recordsFiltered' => $phoneBook['countRecords'],
//        'recordsTotal' => $phoneBook['countRecords'],
//        'data'=>
//            array()
//    );
//
//    foreach($phoneBook['dataPhone'] as $row) {
//        $photoUser = $templateHome->parse($modules_root."phone/tpl/table/row_photo_user.tpl", $row);
//        if ($row['id_user'] == null){
//            $worker = $templateHome->parse($modules_root."phone/tpl/table/row_comment.tpl", $row);
//        } else {
//            $worker = $templateHome->parse($modules_root."phone/tpl/table/row_worker.tpl", $row);
//        }
//        $phone = $templateHome->parse($modules_root."phone/tpl/table/row_phone.tpl", $row);
//        $gateway = $templateHome->parse($modules_root."phone/tpl/table/row_gateway.tpl", $row);
//
//        array_push( $data['data'], array("Телефон" =>  $phone,"Фото"=> $photoUser,"Сотрудник"=>$worker,
//            "Подразделение"=>$row['dep_name'], "Аудитория/розетка"=>$row['room_name']. " / " .$row['socket_name'], "IP шлюза/порт"=>$gateway,
//            "Плинт"=>$row['plint_name']. " / " .$row['plint_port_name'], "ID"=>$row['id_socket_execution'], "is_hidden" => $row['is_hidden']));
//
//    }
//    echo json_encode($data);
//}

if($request->hasValue('txt')) {
?>
<<VOIP CONFIG FILE>>Version:2.0008

<AUTOUPDATE CONFIG MODULE>

<PHONE_CONFIG_MODULE>
--Phone Book--     :
Item1 Name         :Direktor
Item1 Number       :123
Item1 Office Number:123
Item1 Mobile Number:888
Item1 Other Number :999
Item1 Ring         :0
<Xml_PhoneBook>
<Xml_PhoneBook_Entry>
<ID>XML-PBook1</ID>
<Name>PGU</Name>
<Addr>https://lk.pnzgu.ru/ajax/phone/xml</Addr>
<Auth>:</Auth>
<Policy>0</Policy>
<Sipline>0</Sipline>
</Xml_PhoneBook_Entry>
</Xml_PhoneBook>
<Phonebook_Groups>friend,home,work,business,classmate,colleague</Phonebook_Groups>
</PHONE_CONFIG_MODULE>
<<END OF FILE>>
<?php 


//<AUTOUPDATE CONFIG MODULE>
//Auto Pbook  Url    :https://lk.pnzgu.ru/ajax/phone/xml


}

if($request->hasValue('edituser')) {
	if($request->getValue('edituser')) $id = $request->getValue('edituser');
	if($id>0) {
		$params = $phoneHome->getValue('phone_socket_execution', 'id', $id, array('id', 'id_socket', 'id_execution','text'));
	}
	//$params['id_user'] = $params['id_execution'];
	if($params['id_execution'] > 0){
		$users = $phoneHome->getUsersAutocomplite(false, $params['id_execution']);
		if(is_array($users) && count($users) > 0){
			$params['user'] = $users[0];
		}
	}
	$listSocket = $phoneHome->getSocket();
	$params['socket_name'] = $functions->makeOption($listSocket, $params['id_socket']);
	$params['link'] = 'socket_execution';
	$params['id'] = $id;
	echo $templateHome->parse($modules_root."phone/tpl/form_socket_execution.tpl", $params);
} elseif($request->getValue('selected_user')) {
	$idExec = $phoneHome->getUserIdByAutocompliteStr($request->getValue('selected_user'));
} elseif ($request->hasValue("getusers")) {
	$return_arr = $phoneHome->getUsersAutocomplite($request->getValue("term"));
	echo json_encode($return_arr);
} elseif($request->hasValue('link') && ($request->hasValue('editform') || $request->hasValue('editrow'))) {
	$param['id'] = $request->getValue('id');
	$param['link'] = $request->getValue('link');
	$param['num'] = $request->getValue('num');
	$param['edit'] = true;
	$param['ajax'] = true;
	switch ($request->getValue('link')) {
		case 'plint_port_socket':
			$listSocket = $phoneHome->getSocket();
			$listPlintPort = $phoneHome->getPlintPort();
			$listRoom = $phoneHome->getListBy('room', 'is_show', 1, array('id', 'name'), 'name');
			if($request->hasValue('add-socket')) { //добавление розетки из общего списка
				if($listRoom) $param['room_name'] = $functions->makeOption($listRoom);
				if($listPlintPort) $param['plint_port_name'] = $functions->makeOption($listPlintPort);
				$param['link'] = 'socket';
				$param['save_from_ajax'] = 1;
				$form = $templateHome->parse($modules_root."phone/tpl/form_socket.tpl", $param);
			} else {
				if($request->hasValue('editrow') && $request->getValue('id')) { //редактирование одной строки
					$itemPhone = $phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->getValue('id'), $phoneHome->item_plint_port_socket);
					$param['plint_port_name'] = $functions->makeOption($listPlintPort, $itemPhone['id_port_plint']);
					$socket = $phoneHome->getValue('phone_socket', 'id', $itemPhone['id_socket'], array('id', 'name', 'id_room'));
					$param['socket_name'] = $functions->makeOption($listSocket, $itemPhone['id_socket']);
					$param['room_name'] = $phoneHome->getValue('room', 'id', $socket['id_room'], array('id', 'name'))['name'];
				} else {
					if ($listPlintPort) $param['plint_port_name'] = $functions->makeOption($listPlintPort);
					if ($listSocket) $param['socket_name'] = $functions->makeOption($listSocket);
					$form = $templateHome->parse($modules_root . "phone/tpl/row_plint_port_socket.tpl", $param);
				}
			}
		break;
		case 'tel_gateway':
			$listTel = $phoneHome->getTel();
			$listGatewayPort = $phoneHome->getGatewayPort();
			if($request->hasValue('editrow') && $request->getValue('id')) {
				$itemPhone = $phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->getValue('id'), $phoneHome->item_tel_gateway);
			}
			if ($listTel) $param['tel_name'] = $functions->makeOption($listTel, $itemPhone['id_tel']);
			if ($listGatewayPort) $param['gateway_port_name'] = $functions->makeOption($listGatewayPort, $itemPhone['id_port_gateway']);
		break;
		case 'gateway_plint':
			$listGatewayPort = $phoneHome->getGatewayPort();
			$listPlintPort = $phoneHome->getPlintPort();
			if($request->hasValue('editrow') && $request->getValue('id')) {
				$itemPhone = $phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->getValue('id'), $phoneHome->item_gateway_plint);
			}
			if($listGatewayPort) $param['gateway_port_name'] = $functions->makeOption($listGatewayPort, $itemPhone['id_port_gateway']);
			if($listPlintPort) $param['plint_port_name'] = $functions->makeOption($listPlintPort, $itemPhone['id_port_plint']);
		break;
		case 'plint_port':
			$listPlint = $phoneHome->getListBy('phone_plint', false, false, array('id', 'name'), 'name DESC');
			if($request->hasValue('editrow') && $request->getValue('id')) {
				$itemPhone = $phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->getValue('id'), $phoneHome->item_plint_port);
				$param['name'] = $itemPhone['name'];
			}
			$param['plint_name'] = $functions->makeOption($listPlint, $itemPhone['id_plint']);
		break;
		case 'gateway_port':
			$listGateway = $phoneHome->getListBy('phone_gateway', false, false, array('id', 'name'), 'name');
			if($request->hasValue('editrow') && $request->getValue('id')) {
				$itemPhone = $phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->getValue('id'), $phoneHome->item_gateway_port);
				$param['name'] = $itemPhone['name'];
			}
			$param['gateway_name'] = $functions->makeOption($listGateway, $itemPhone['id_gateway']);
		break;
	}
	
	if(!$form) $form = $templateHome->parse($modules_root . "phone/tpl/row_" . $request->getValue('link') . ".tpl", $param);
	$res = array(
		'form' => $form
	);
	echo json_encode($res);
} elseif($request->hasValue('link') && $request->hasValue('editfield')) {
	$field = $request->getValue('editfield');
	//$phoneHome->getValue('phone_'.$request->getValue('link'), 'id', $request->hasValue('id'), array('id', 'name', 'id_room'));
	switch ($request->getValue('link')) {
		case 'plint_port_socket':
			if($field == 'id_port_plint') {
				$listPlintPort = $phoneHome->getPlintPort();
				if ($listPlintPort) $content = '<select name="' . $field . '" id="id_port_plint' . $request->getValue('id') . '">' . $functions->makeOption($listPlintPort, $request->getValue('selected')) . '</select>';
			} elseif($field == 'name') {
				$content = '<input type="text" value="' . $request->getValue('selected') . '" name="' . $field . '">';
				}
			$res = array(
				'content' => $content,
				'elem' => $request->getValue('editfield').$request->getValue('id')
			);
			break;
	}
	
	echo json_encode($res);
} elseif($request->hasValue('selectRoom')) { //уточненине выборки по аудитории
	$param['edit'] = false;
	$param['ajax'] = false;
	$param['link'] = $request->getValue('link');
	$selectedRoom = $request->getValue('selectRoom');
	$itemRoom = $phoneHome->getValue('room', 'id', $selectedRoom, array('name'));
	//$listSocket = $phoneHome->getSocket('phone_socket.id_room', $selectedRoom);
	$listSocket = $phoneHome->getListBy('phone_socket', 'id_room', $selectedRoom, array('id', 'name'));
	if($listSocket) {
		$i = 0;
		foreach ($listSocket as $item) {
			$param['num'] = ++$i;
			$param['room_name'] = $itemRoom['name'];
			$param['socket_name'] = $item['name'];
			
			//$itemPlintPort = $phoneHome->getPlintPort('phone_plint_port_socket.id_socket', $item['id']);
			$itemPPS = $phoneHome->getValue('phone_plint_port_socket', 'id_socket', $item['id'], array('id', 'id_port_plint'));
			$itemPP = $phoneHome->getValue('phone_plint_port', 'id', $itemPPS['id_port_plint'], array('id', 'id_plint', 'name'));
			$itemP = $phoneHome->getValue('phone_plint', 'id', $itemPP['id_plint'], array('id', 'name'));
			$param['plint_port_name'] = $itemP['name'].' / '.$itemPP['name'];
			$param['id'] = $itemPPS['id'];
			/*if($itemPlintPort) {
				foreach ($itemPlintPort as $itemPP) {
					$param['plint_port_name'] = $itemPP['name'];
					$param['id'] = $itemPP['id_plint_port_socket'];
				}
			}*/
			$tmp['rows'] .= $templateHome->parse($modules_root . "phone/tpl/row_plint_port_socket.tpl", $param);
		}
		$tmp['plint_port_socket'] = true;
		$param = $templateHome->parse($modules_root . "phone/tpl/table_head.tpl", $tmp);
	}
	$res = array(
		'table' => $param
	);
	echo json_encode($res);
}

?>