<?php
class PhoneHome {
	private $db_instance;
	private $db_instance2;
	private $db_instance3;
	private $item_per_page;
	private $lng_prefix;
	private $request;
	private $session;
	private $nDB;
	private $functions;
	public $sql;
	public $count;
	public $item_tel = array('id','number','inner_number','is_cell','is_intercity','is_deleted');
	public $item_gateway = array('id','name','ip','ip_out','id_room','count_port','is_deleted');
	public $item_plint = array('id','name','id_room','count_port','is_deleted');
	public $item_socket = array('id','name','id_room','is_deleted');
	public $item_gateway_port = array('id','id_gateway','name','is_deleted');
	public $item_plint_port = array('id','id_plint','name','is_deleted');
	public $item_gateway_plint = array('id','id_port_gateway','id_port_plint','is_deleted');
	public $item_plint_port_socket = array('id','id_socket','id_port_plint','is_deleted');
	public $item_tel_gateway = array('id','id_port_gateway','id_tel','is_deleted');
	public $item_socket_execution = array('id','id_socket','id_execution','is_deleted');
	public $item_common = array('id_tel', 'id_gateway', 'id_plint', 'id_port_gateway', 'id_port_plint', 'gateway_name', 'plint_name', 'plint_port_name', 'ip', 'ip_out', 'id_gateway_room', 'id_plint_room', 'socket_name', 'id_socket', 'id_socket_room', 'id_execution', 'gateway_port_name', 'is_deleted');
	//public $UserToSocket = array('id','id_socket','id_execution','id_department','id_room','is_deleted');
	
	public $keywords = array('id','name','count','is_deleted');
	private $i = 0;
	private $tmp = array();
	
	public function __construct($request = null, $session = null, $functions = false) {
		$this->db_instance = $GLOBALS ["db"];
		$this->db_instance2 = $GLOBALS ["db2"];
		$this->db_instance3 = $GLOBALS ["db3"];
		$this->request = $request;
		$this->session = $session;
		$this->functions = $functions;
	}
	
	public function getValue($table=false,$par=false,$value=false,$array=null,$order=false) {
		if(!$par) return false;
		$sql = "SELECT * FROM `".$table."` WHERE `".$par."`='".$value."' ";
		if(strstr($sql,'WHERE')) $sql .= ' AND ';
		else $sql .= ' WHERE ';
		$sql .= " `is_deleted`='0'";
		if($order) $sql .= " ORDER BY ".$order;
		//echo $sql.'<br>';
		return $this->db_instance->getOneData($sql,$array);
	}
	
	public function getListBy($table=false,$par=false,$value=false,$array=null, $order=false) {
		$sql = "SELECT * ";
		//if($order == 'name') $sql .= ", CAST(name AS UNSIGNED) AS name2 ";
		$sql .= " FROM `" . $table . "` ";
		if($par && $value) $sql .= "WHERE `" . $par . "`='" . $value . "' ";
		if (strstr($sql, 'WHERE')) $sql .= ' AND ';
		else $sql .= ' WHERE ';
		$sql .= " `is_deleted`='0' ";
		if($order) {
			$sql .= " ORDER BY ";
			//if ($order == 'name') $sql .= " name2, ";
			$sql .= $order;
		}
		//echo $sql;
		return $this->db_instance->getListData($sql, $array);
		
	}
	
	public function getListExtended($table=false,$par=false,$value=false,$array=null,$order=false) {
		$sql = "SELECT * FROM `" . $table . "` ";
		$sql .= "LEFT OUTER JOIN `` ";
		if($par && $value) $sql .= "WHERE `" . $par . "`='" . $value . "' ";
		if (strstr($sql, 'WHERE')) $sql .= ' AND ';
		else $sql .= ' WHERE ';
		$sql .= " `is_deleted`='0' ORDER BY " . $order . " ";
		//echo $sql;
		return $this->db_instance->getListData($sql, $array);
		
	}
	
	public function getGatewayPort($par = false, $val = false) {
		$sql = "SELECT `phone_gateway_port`.`id`,CONCAT_WS(' / ', CONCAT_WS(' ', `phone_gateway`.`name`, `phone_gateway`.`ip_out`), `phone_gateway_port`.`name`, `phone_tel`.`number`) as `name`, `phone_tel`.`number` FROM `phone_gateway_port`
				LEFT OUTER JOIN `phone_gateway` ON `phone_gateway_port`.`id_gateway` = `phone_gateway`.`id`
				LEFT OUTER JOIN `phone_tel_gateway` ON `phone_gateway_port`.`id` = `phone_tel_gateway`.`id_port_gateway`
				LEFT OUTER JOIN `phone_tel` ON `phone_tel`.`id` = `phone_tel_gateway`.`id_tel`
				WHERE `phone_gateway`.`is_deleted` = 0
				";
		if($par && $val) $sql .= " AND ".$par." = '".$val."' ";
		$sql .= " ORDER BY `phone_gateway`.`name`";
		return $this->db_instance->getListData($sql, array('id', 'name', 'number'));
	}
	
	public function getPlintPort($par = false, $val = false) {
		$sql = "SELECT `phone_plint_port`.`id`, CONCAT_WS(' / ', `phone_plint`.`name`, `phone_plint_port`.`name`, `phone_socket`.`name`, `room`.`name`, `phone_tel`.`number`) as `name`,
				`room`.`name` as `room_name`, `phone_plint_port_socket`.`id` as `id_plint_port_socket` FROM `phone_plint_port`
				LEFT OUTER JOIN `phone_plint` ON `phone_plint_port`.`id_plint` = `phone_plint`.`id`
				LEFT OUTER JOIN `phone_plint_port_socket` ON `phone_plint_port_socket`.`id_port_plint` = `phone_plint_port`.`id`
				LEFT OUTER JOIN `phone_socket` ON `phone_plint_port_socket`.`id_socket` = `phone_socket`.`id`
				LEFT OUTER JOIN `room` ON `phone_socket`.`id_room` = `room`.`id`
				
				LEFT OUTER JOIN `phone_gateway_plint` ON `phone_plint_port`.`id` = `phone_gateway_plint`.`id_port_plint`
				LEFT OUTER JOIN `phone_gateway_port` ON `phone_gateway_plint`.`id_port_gateway` = `phone_gateway_port`.`id`
				LEFT OUTER JOIN `phone_tel_gateway` ON `phone_gateway_port`.`id` = `phone_tel_gateway`.`id_port_gateway`
				LEFT OUTER JOIN `phone_tel` ON `phone_tel`.`id` = `phone_tel_gateway`.`id_tel`
				
				WHERE `phone_plint`.`is_deleted` = 0 AND `phone_plint_port`.`is_deleted` = 0
				";
		if($par && $val) $sql .= " AND ".$par." = '".$val."' ";
		$sql .= " ORDER BY `phone_plint`.`name`";
		return $this->db_instance->getListData($sql, array('id', 'name', 'room_name', 'id_plint_port_socket'));
	}
	
	public function getSocket($par = false, $val = false) {
		$sql = "SELECT `phone_socket`.`id`, CONCAT_WS(' / ', `room`.`name`, `phone_socket`.`name`, `phone_tel`.`number`) as `name` FROM `phone_socket`
				LEFT OUTER JOIN `room` ON `phone_socket`.`id_room` = `room`.`id`
				
				LEFT OUTER JOIN `phone_plint_port_socket` ON `phone_plint_port_socket`.`id_socket` = `phone_socket`.`id`
				LEFT OUTER JOIN `phone_plint_port` ON `phone_plint_port_socket`.`id_port_plint` = `phone_plint_port`.`id`
				LEFT OUTER JOIN `phone_gateway_plint` ON `phone_plint_port`.`id` = `phone_gateway_plint`.`id_port_plint`
				LEFT OUTER JOIN `phone_gateway_port` ON `phone_gateway_plint`.`id_port_gateway` = `phone_gateway_port`.`id`
				LEFT OUTER JOIN `phone_tel_gateway` ON `phone_gateway_port`.`id` = `phone_tel_gateway`.`id_port_gateway`
				LEFT OUTER JOIN `phone_tel` ON `phone_tel`.`id` = `phone_tel_gateway`.`id_tel`
				
				WHERE `room`.`is_deleted` = 0 AND `phone_socket`.`is_deleted` = 0
				";
		if($par && $val) $sql .= " AND ".$par." = '".$val."' ";
		$sql .= " ORDER BY `room`.`name`, `phone_socket`.`name`";
		return $this->db_instance->getListData($sql, array('id', 'name'));
	}
	
	public function getTel($par = false, $val = false) {
		$sql = "SELECT *, `number` as `name` FROM `phone_tel`
				WHERE `phone_tel`.`is_deleted` = 0
				";
		if($par && $val) $sql .= " AND `".$par."` = '".$val."' ";
		$sql .= " ORDER BY `phone_tel`.`number`";
		array_push($this->item_tel, 'name');
		return $this->db_instance->getListData($sql, $this->item_tel);
	}
	public function getTelByPort($portId = 0) {
		$sql = "SELECT *, `number` as `name` FROM `phone_tel`
				LEFT OUTER JOIN `phone_tel_gateway` ON `phone_tel`.`id` = `phone_tel_gateway`.`id_tel`
				WHERE `phone_tel`.`is_deleted` = 0 AND `phone_tel_gateway`.`id_port_gateway` = '".$portId."'
				";
		return $this->db_instance->getOneData($sql, $this->item_tel);
	}
	
	public function getSocketByPort($portId = 0) {
		$sql = "SELECT `phone_socket`.`id`,CONCAT_WS(' / ', `phone_socket`.`name`, `room`.`name`) as `name` FROM `phone_socket`
				LEFT OUTER JOIN `phone_plint_port_socket` ON `phone_plint_port_socket`.`id_socket` = `phone_socket`.`id`
				LEFT OUTER JOIN `room` ON `phone_socket`.`id_room` = `room`.`id`
				WHERE `room`.`is_deleted` = 0 AND `phone_socket`.`is_deleted` = 0 AND `phone_plint_port_socket`.`id_port_plint` = '".$portId."'
				";
		return $this->db_instance->getOneData($sql, $this->item_socket);
	}
	
	public function getUsersAutocomplite($searchStr, $execId = false) {
		$return_arr = array();
		
		$sql = "SELECT `user`.`id` AS `id`, `user`.`code`, CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`,CONCAT_WS(' # ', `uec`.`name`, `dep`.`name`) as `name_department`,ue.id as id_execution FROM `user` ";
		$sql .= "LEFT JOIN `user_execution` ue ON `user`.`id`=`ue`.`id_user` ";
		$sql .= "LEFT JOIN `department` `dep` ON `ue`.`id_department`=`dep`.`id` ";
		$sql .= "LEFT JOIN `user_execution_category` `uec` ON `ue`.`id_category`=`uec`.`id` ";
		$sql .= "WHERE user.is_deleted=0 ";
		$sql .= " AND ue.is_deleted=0 AND (ue.date_end=0 OR ue.date_end IS NULL OR ue.date_end>'".date('U')."') AND user.is_empl = 1 ";
		if($searchStr) {
			$sql .= " AND CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) like '%" . $searchStr . "%'";
		}
		if($execId){
			$sql .= " AND `ue`.`id`=".$execId;
		}
		$sql .= " ORDER BY `lastname`,`firstname`";
		
		$items = $this->db_instance2->getListData($sql, array('id','id_execution','name','name_department'));
		foreach ($items as $user){
			array_push($return_arr,  $user['name'].' ('.$user['name_department'].') # '.$user['id'].' # '.$user['id_execution']);
		}
		return $return_arr;
	}
	
	public function getUserIdByAutocompliteStr($autocompliteStr){
		$subStr = mb_strrchr($autocompliteStr,'#');
		if($subStr && mb_strlen($subStr) > 2){
			$execId = mb_substr($subStr, 2);
			if($execId) {
				return $execId;
			}
		}
		return false;
	}
	
	public function getPhonebook($rights = false) {
		$sql = "SELECT * FROM `phone_tel` WHERE `is_deleted` = 0 ORDER BY `number`";
		$listTel = $this->db_instance->getListData($sql, $this->item_tel);
		if($listTel) {
			$rows = array();
			$i = 0;
			foreach ($listTel as $itemTel) {
				$sql = "SELECT 	`phone_tel_gateway`.`id_tel`,
								`phone_tel_gateway`.`id_port_gateway`,
								`phone_gateway`.`id` as `id_gateway`,
								`phone_gateway`.`name` as `gateway_name`,
								`phone_gateway`.`ip`, `phone_gateway`.`ip_out`,
								`phone_gateway`.`id_room` as `id_gateway_room`,
								`phone_gateway_port`.`name` as `gateway_port_name`,
								`phone_plint_port`.`id` as `id_port_plint`,
								`phone_plint_port`.`name` as `plint_port_name`,
								`phone_plint`.`id` as `id_plint`,
								`phone_plint`.`name` as `plint_name`,
								`phone_gateway`.`id_room` as `id_plint_room`,
								`phone_socket`.`name` as `socket_name`,
								`phone_socket`.`id` as `id_socket`,
								`phone_socket`.`id_room` as `id_socket_room`,
								`phone_socket_execution`.`id_execution`,
                                `phone_socket_execution`.`is_deleted` as `is_deleted`
						FROM `phone_tel_gateway`
						LEFT OUTER JOIN `phone_gateway_port` ON `phone_tel_gateway`.`id_port_gateway` = `phone_gateway_port`.`id`
						LEFT OUTER JOIN `phone_gateway` ON `phone_gateway_port`.`id_gateway` = `phone_gateway`.`id`
						LEFT OUTER JOIN `phone_gateway_plint` ON `phone_gateway_plint`.`id_port_gateway` = `phone_gateway_port`.`id`
						LEFT OUTER JOIN `phone_plint_port` ON `phone_gateway_plint`.`id_port_plint` = `phone_plint_port`.`id`
						LEFT OUTER JOIN `phone_plint` ON `phone_plint_port`.`id_plint` = `phone_plint`.`id`
						LEFT OUTER JOIN `phone_plint_port_socket` ON `phone_plint_port_socket`.`id_port_plint` = `phone_plint_port`.`id`
						LEFT OUTER JOIN `phone_socket` ON `phone_plint_port_socket`.`id_socket` = `phone_socket`.`id`
						LEFT JOIN `phone_socket_execution` ON `phone_socket_execution`.`id_socket` = `phone_socket`.`id`
						WHERE `id_tel` = '".$itemTel['id']."' AND `phone_tel_gateway`.`is_deleted` = 0 AND `phone_gateway_port`.`is_deleted` = 0 AND `phone_gateway`.`is_deleted` = 0
							AND `phone_gateway_plint`.`is_deleted` = 0 AND `phone_plint_port`.`is_deleted` = 0 AND `phone_plint`.`is_deleted` = 0 AND `phone_plint_port_socket`.`is_deleted` = 0
							AND `phone_socket`.`is_deleted` = 0";
				$listTelGateway = $this->db_instance->getListData($sql, $this->item_common);
				if($listTelGateway) {
					foreach ($listTelGateway as $itemTelGateway) {
						$itemTelGateway['number'] = $itemTel['number'][0].$itemTel['number'][1].'-'.$itemTel['number'][2].$itemTel['number'][3].'-'.$itemTel['number'][4].$itemTel['number'][5];
						$itemTelGateway['inner_number'] = $itemTel['inner_number'];
						
						$sql = "SELECT * FROM `room` WHERE `id` = '".$itemTelGateway['id_socket_room']."' AND `is_deleted` = 0";
						$itemSocketRoom = $this->db_instance->getOneData($sql, array('name'));
						if($itemSocketRoom) $itemTelGateway['room_name'] = $itemSocketRoom['name'];
						else $itemTelGateway['room_name'] = 'не указано';
						$sql = "SELECT * FROM `room` WHERE `id` = '".$itemTelGateway['id_gateway_room']."' AND `is_deleted` = 0";
						$itemGatewayRoom = $this->db_instance->getOneData($sql, array('name'));
						if($itemGatewayRoom) $itemTelGateway['gateway_room_name'] = $itemGatewayRoom['name'];
						else $itemTelGateway['gateway_room_name'] = 'не указано';
						
						$userExec = $GLOBALS['usersHome']->getByExec($itemTelGateway['id_execution']);
						$userPos = $GLOBALS['usersHome']->getValue('user_position', 'id', $userExec['id_position'], array('name'));
						$itemTelGateway['user_name'] = $userExec['name'];
						if($userPos) $itemTelGateway['user_name'] .= ", ".$userPos['name'];
						$itemTelGateway['id_user'] = $userExec['id'];
						//$itemTelGateway['dep_name'] = $userExec['name_department'];
						$itemTelGateway['id_dep'] = $userExec['id_department'];
						$itemTelGateway['num'] = ++$i;
	
						$this->getDepList($userExec['id_department']);
						for($j = count($this->tmp); $j >0; $j--) {
							$itemTelGateway['dep_name'] .= $this->tmp[$j]['name'].'. ';
						}
						unset($this->i);
						unset($this->tmp);
						if($rights == 'write') $itemTelGateway['admin'] = true;
						if(!$itemTelGateway['is_deleted']) {
						  $rows['rows'] .= $GLOBALS['templateHome']->parse($GLOBALS['modules_root'] . "phone/tpl/row_phonebook.tpl", $itemTelGateway);
						}
					}
				}
			}
			if($rows) return $rows;
		} else return false;
	}

	public function getDepList($id=0) {
		if($id) {
			$sql = "SELECT * FROM `department` WHERE `id` = '".$id."' AND `level` > 1 AND `type`!='' AND `is_deleted` = 0";
			//echo $sql.'<br>';
			$item = $this->db_instance2->getOneData($sql, array('id','id_parent','name'));
			if($item) {
				$this->i++;
				$this->tmp[$this->i]['id'] = $item['id'];
				$this->tmp[$this->i]['name'] = $item['name'];
				$this->getDepList($item['id_parent']);
			} else return;
			if($this->tmp) return $this->tmp;
		}
	}
	
	public function save($table = false, $item = false, $array = false) {
		if($table && $item && $array) return $this->db_instance->saveData($item, $table, $array);
		else return 0;
	}
	
	public function delete($table = false, $id = 0) {
		if($id) {
			$sql = "UPDATE `" . $table . "` SET `is_deleted`='1' WHERE `id`='" . $id . "'";
			return $this->db_instance->query($sql);
		} else return 0;
	}
}
?>