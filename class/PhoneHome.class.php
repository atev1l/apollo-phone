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
    public $item_tel = array('id','number','inner_number','is_cell','is_intercity','is_hidden','is_deleted');
    public $item_gateway = array('id','name','ip','ip_out','id_room','count_port','is_deleted');
    public $item_plint = array('id','name','id_room','count_port','is_deleted');
    public $item_socket = array('id','name','id_room','is_deleted');
    public $item_gateway_port = array('id','id_gateway','name','is_deleted');
    public $item_plint_port = array('id','id_plint','name','is_deleted');
    public $item_gateway_plint = array('id','id_port_gateway','id_port_plint','is_deleted');
    public $item_plint_port_socket = array('id','id_socket','id_port_plint','is_deleted');
    public $item_tel_gateway = array('id','id_port_gateway','id_tel','is_deleted');
    public $item_socket_execution = array('id','id_socket','id_execution','text','is_deleted');
    public $item_common = array('id_tel', 'id_gateway', 'id_plint', 'id_port_gateway', 'id_port_plint', 'gateway_name', 'plint_name', 'plint_port_name', 'ip', 'ip_out', 'id_gateway_room', 'id_plint_room', 'socket_name', 'id_socket', 'id_socket_room', 'id_execution', 'gateway_port_name', 'is_deleted');
    //public $UserToSocket = array('id','id_socket','id_execution','id_department','id_room','is_deleted');

    public $keywords = array('id','name','count','is_deleted');
    private $i = 0;
    private $tmp = array();

    public function __construct($request = null, $session = null, $functions = false) {
        $this->db_instance = $GLOBALS ["db5"];
        $this->db_instance2 = $GLOBALS ["db2"];
        $this->db_instance3 = $GLOBALS ["db3"];
        $this->db_instance4 = $GLOBALS ["db"];
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

    public function getSocket($par = false, $val = false, $id_dep = false) {
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

        if($id_dep) {
            if(is_array($id_dep)) {
                $sql_add = "";
                foreach ($id_dep as $value1) {
                    if($sql_add) $sql_add .= " OR ";
                    $sql_add .= " `room`.`id_dep`='".$value1."' ";
                }
                $sql .= ' AND ('.$sql_add.')';
            } else {
                $sql .=" AND `room`.`id_dep`='".$id_dep."'";
            }
        }

        $sql .= " ORDER BY `room`.`name`, `phone_socket`.`name`";
        return $this->db_instance->getListData($sql, array('id', 'name'));
    }

    public function getTelBySocket($par = false, $val = false, $id_dep = false) {
        $sql = "SELECT `phone_socket`.`id`, `phone_tel`.`number`  FROM `phone_socket`
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
        return $this->db_instance->getOneData($sql, array('id', 'number'));
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

    public function getUsersAutocomplite($searchStr, $execId = false, $id_dep = false) {
        $return_arr = array();

        $sql = "SELECT `user`.`id` AS `id`, `user`.`code`, CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`,CONCAT_WS(' # ', `up`.`name`, `dep`.`name`) as `name_department`,ue.id as id_execution FROM `user` ";
        $sql .= "LEFT JOIN `user_execution` ue ON `user`.`id`=`ue`.`id_user` ";
        $sql .= "LEFT JOIN `department` `dep` ON `ue`.`id_department`=`dep`.`id` ";
        $sql .= "LEFT JOIN `user_execution_category` `uec` ON `ue`.`id_category`=`uec`.`id` ";
        $sql .= "LEFT JOIN `user_position` `up` ON `ue`.`id_position`=`up`.`id` ";
        $sql .= "WHERE user.is_deleted=0 ";
        $sql .= " AND ue.is_deleted=0 AND (ue.date_end=0 OR ue.date_end IS NULL OR ue.date_end>'".date('U')."') AND user.is_empl = 1 ";
        if($searchStr) {
            $sql .= " AND CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) like '%" . $searchStr . "%'";
        }
        if($execId){
            $sql .= " AND `ue`.`id`=".$execId;
        }

        if($id_dep) {
            if(is_array($id_dep)) {
                $sql_add = "";
                foreach ($id_dep as $value1) {
                    if($sql_add) $sql_add .= " OR ";
                    $sql_add .= " `ue`.`id_department`='".$value1."' ";
                }
                $sql .= ' AND ('.$sql_add.')';
            } else {
                $sql .=" AND `ue`.`id_department`='".$id_dep."'";
            }
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



    public function getByExec($id=0) {
        $sql = "SELECT `user`.`id`, `user`.`image`,
            CONCAT_WS(' ',`user`.`lastname`,`user`.`firstname`,`user`.`secondname`) AS `name`,
            `user_execution`.`id_department`,
            `department`.`name` as `name_department`, 
            `user_position`.`name` as `position_name`
			FROM `user_execution`
			LEFT OUTER JOIN `user` ON `user_execution`.`id_user`=`user`.`id`
			LEFT OUTER JOIN `user_position` ON `user_execution`.`id_position`=`user_position`.`id`
            LEFT OUTER JOIN `department` ON `user_execution`.`id_department`=`department`.`id` 
			WHERE `user_execution`.`id`='".$id."';";
        $item = $this->db_instance2->getOneData($sql, array('id','id_department','name','position_name','name_department','image'));
        return $item;
    }

    public function getSite($id_site) {
        $sql = "SELECT `site`.`id_dep` FROM `site` WHERE  `site`.`id`='".$id_site."' AND `site`.`is_deleted`='0'";
        $item = $this->db_instance4->getOneData($sql, array('id_dep'));
        return $item;
    }

    public function getPhonebook($rights = false, $id_dep = false) {

        $sql = "
        SELECT 
                                `phone_tel`.`number`,
                                `phone_tel`.`inner_number`,
                                `phone_tel`.`is_hidden`,
								`phone_gateway`.`name` as `gateway_name`,
								`phone_gateway`.`ip`, 
                                `phone_gateway`.`ip_out`,
								`phone_gateway`.`id_room` as `id_gateway_room`,
								`phone_gateway_port`.`name` as `gateway_port_name`,
								`phone_plint_port`.`name` as `plint_port_name`,
								`phone_plint`.`name` as `plint_name`,
								`phone_gateway`.`id_room` as `id_plint_room`,
								`phone_socket`.`name` as `socket_name`,
								`phone_socket`.`id_room` as `id_socket_room`,
								`phone_socket_execution`.`id_execution`,
                                `phone_socket_execution`.`text`,
                                `phone_socket_execution`.`id` as `id_socket_execution`,
                                `room`.`name` as `room_name`,
                                `room`.`id` as `id_room`

        FROM `phone_gateway_plint`  
        LEFT JOIN `phone_gateway_port` on `phone_gateway_plint`.`id_port_gateway`=`phone_gateway_port`.`id` AND `phone_gateway_port`.`is_deleted`='0'
        LEFT JOIN `phone_plint_port` on `phone_plint_port`.`id`=`phone_gateway_plint`.`id_port_plint` AND `phone_plint_port`.`is_deleted`='0'
        LEFT JOIN `phone_plint` on `phone_plint_port`.`id_plint`=`phone_plint`.`id` AND `phone_plint`.`is_deleted`='0'
        LEFT JOIN `phone_gateway` on `phone_gateway_port`.`id_gateway`=`phone_gateway`.`id` AND `phone_gateway`.`is_deleted`='0'
        LEFT JOIN `phone_tel_gateway` on `phone_tel_gateway`.`id_port_gateway`=`phone_gateway_plint`.`id_port_gateway` AND `phone_tel_gateway`.`is_deleted`='0'
        LEFT JOIN `phone_tel` on `phone_tel_gateway`.`id_tel`=`phone_tel`.`id` AND `phone_tel`.`is_deleted`='0'
        LEFT JOIN `phone_plint_port_socket` on `phone_plint_port_socket`.`id_port_plint`=`phone_gateway_plint`.`id_port_plint` AND `phone_plint_port_socket`.`is_deleted`='0'
        LEFT JOIN `phone_socket` on `phone_plint_port_socket`.`id_socket`=`phone_socket`.`id` AND `phone_socket`.`is_deleted`='0'
        LEFT JOIN `room` on `phone_socket`.`id_room`=`room`.`id` AND `room`.`is_deleted`='0'
        LEFT JOIN `phone_socket_execution` on `phone_plint_port_socket`.`id_socket`=`phone_socket_execution`.`id_socket` AND `phone_socket_execution`.`is_deleted`='0'

        WHERE `phone_gateway_plint`.`is_deleted` = 0";

        if($id_dep) {
            if(is_array($id_dep)) {
                $sql_add = "";
                foreach ($id_dep as $value1) {
                    if($sql_add) $sql_add .= " OR ";
                    $sql_add .= " `room`.`id_dep`='".$value1."' ";
                }
                $sql .= ' AND ('.$sql_add.')';
            } else {
                $sql .=" AND `room`.`id_dep`='".$id_dep."'";
            }
        }
        //echo $sql;
        $listTel = $this->db_instance->getListData($sql, array('number','inner_number','gateway_name','ip','ip_out','gateway_port_name','plint_port_name','plint_name','id_socket_execution','id_plint_room','id_gateway_room','socket_name','id_socket_room','id_execution','text','room_name','id_room','is_hidden'));
        if($listTel) {
            $i = 0;
            $room_count=0;
            foreach ($listTel as $value) {
                /*if($value['number']) {
                    $value['number1'] = $value['number'][0].$value['number'][1].'-'.$value['number'][2].$value['number'][3].'-'.$value['number'][4].$value['number'][5];
                }*/

                if($value['number'] && strlen($value['number']) == 6) {
                    $value['number1'] = $value['number'][0].$value['number'][1].'-'.$value['number'][2].$value['number'][3].'-'.$value['number'][4].$value['number'][5];
                } elseif($value['number']) {
                    //$value['number1'] = $value['number'];
                    $value['number1'] = '+7 ('.substr($value['number'], 1, 3).') '.substr($value['number'], 4, 3).'-'.substr($value['number'], 7, 2).'-'.substr($value['number'], 9, 2);
                }


                //Получение комнат
                /*
                $sql = "SELECT * FROM `room` WHERE `id` = '".$value['id_socket_room']."' AND `is_deleted` = 0";
                $itemSocketRoom = $this->db_instance->getOneData($sql, array('name'));
                if($itemSocketRoom) $value['room_name'] = $itemSocketRoom['name'];
                else $value['room_name'] = 'не указано';
                */

                $sql = "SELECT * FROM `room` WHERE `id` = '".$value['id_gateway_room']."' AND `is_deleted` = 0";
                $itemGatewayRoom = $this->db_instance->getOneData($sql, array('name'));
                if($itemGatewayRoom) $value['gateway_room_name'] = $itemGatewayRoom['name'];
                else $value['gateway_room_name'] = 'не указано';

//                $userExec = $GLOBALS['usersHome']->getByExec($value['id_execution']);
//                $userPos = $GLOBALS['usersHome']->getValue('user_position', 'id', $userExec['id_position'], array('name'));
                $userExec = $this->getByExec($value['id_execution']);
                $value['user_name'] = $userExec['name'];
                //if($userExec['position_name']) $value['user_name'] .= ", ".$userPos['name'];
                if($userExec['position_name']) $value['position_name'] = $userExec['position_name'];
                $value['is_photo'] = $userExec['image'];
                $value['id_user'] = $userExec['id'];
                $value['id_dep'] = $userExec['id_department'];

                $this->getDepList($userExec['id_department']);
                for($j = count($this->tmp); $j >0; $j--) {
                    $value['dep_name'] .= $this->tmp[$j]['name'].'. ';
                }

                //Обработка комнат
                /*
                if($rights == 'write' && $value['id_room'] && $this->tmp[1]['id']) {
                    $room_count++;
                    $sql = "SELECT `id_dep` FROM `room` WHERE `id`='".$value['id_room']."'";
                    $room = $this->db_instance->getOneData($sql, array('id_dep'));
                    echo $room['id_dep'].'-'.$value['id_room'].'-'.$value['room_name']."<br>\n";
                    echo $this->tmp[1]['name'].'-'.$this->tmp[1]['id']."<br>\n";
                    echo $room_count."<br>\n";
                    if(!$room['id_dep']) {
                        $sql = "UPDATE `room` SET `id_dep`='".$this->tmp[1]['id']."' WHERE `id`='".$value['id_room']."'";
                        $this->db_instance->query($sql);
                        echo 'update'."<br>\n";
                    }
                }
                //*/

                unset($this->i);
                unset($this->tmp);

                if(!$value['id_execution'] && $value['text']) $value['user_name'] = $value['text'];


                //$value['num'] = ++$i;
                if($rights == 'write') $value['admin'] = true;


                if($rights == 'write' || ($value['number']) && $value['id_socket_room']  && !$value['is_hidden']) {
                    $rows['rows'] .= $GLOBALS['templateHome']->parse($GLOBALS['modules_root'] . "phone/tpl/row_phonebook.tpl", $value);
                }

            }
            if($rows) return $rows;
            else return false;
        }

        /*
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

                */
    }

    public function Uwowo(){
        $data = array(
            'countRecords' => 0,
            'dataPhone' => array()
        );
        $start = $this->request->getValue('start');
        $length = $this->request->getValue('length');
        $searchStr = false;
        $countSql = "SELECT count(*) cn FROM phone_gateway_plint";
        $sql = "
        SELECT 
                                `phone_tel`.`number`,
                                `phone_tel`.`inner_number`,
                                `phone_tel`.`is_hidden`,
								`phone_gateway`.`name` as `gateway_name`,
								`phone_gateway`.`ip`, 
                                `phone_gateway`.`ip_out`,
								`phone_gateway`.`id_room` as `id_gateway_room`,
								`phone_gateway_port`.`name` as `gateway_port_name`,
								`phone_plint_port`.`name` as `plint_port_name`,
								`phone_plint`.`name` as `plint_name`,
								`phone_gateway`.`id_room` as `id_plint_room`,
								`phone_socket`.`name` as `socket_name`,
								`phone_socket`.`id_room` as `id_socket_room`,
								`phone_socket_execution`.`id_execution`,
                                `phone_socket_execution`.`text`,
                                `phone_socket_execution`.`id` as `id_socket_execution`,
                                `room`.`name` as `room_name`,
                                `room`.`id` as `id_room`

        FROM `phone_gateway_plint`  
        LEFT JOIN `phone_gateway_port` on `phone_gateway_plint`.`id_port_gateway`=`phone_gateway_port`.`id` AND `phone_gateway_port`.`is_deleted`='0'
        LEFT JOIN `phone_plint_port` on `phone_plint_port`.`id`=`phone_gateway_plint`.`id_port_plint` AND `phone_plint_port`.`is_deleted`='0'
        LEFT JOIN `phone_plint` on `phone_plint_port`.`id_plint`=`phone_plint`.`id` AND `phone_plint`.`is_deleted`='0'
        LEFT JOIN `phone_gateway` on `phone_gateway_port`.`id_gateway`=`phone_gateway`.`id` AND `phone_gateway`.`is_deleted`='0'
        LEFT JOIN `phone_tel_gateway` on `phone_tel_gateway`.`id_port_gateway`=`phone_gateway_plint`.`id_port_gateway` AND `phone_tel_gateway`.`is_deleted`='0'
        LEFT JOIN `phone_tel` on `phone_tel_gateway`.`id_tel`=`phone_tel`.`id` AND `phone_tel`.`is_deleted`='0'
        LEFT JOIN `phone_plint_port_socket` on `phone_plint_port_socket`.`id_port_plint`=`phone_gateway_plint`.`id_port_plint` AND `phone_plint_port_socket`.`is_deleted`='0'
        LEFT JOIN `phone_socket` on `phone_plint_port_socket`.`id_socket`=`phone_socket`.`id` AND `phone_socket`.`is_deleted`='0'
        LEFT JOIN `room` on `phone_socket`.`id_room`=`room`.`id` AND `room`.`is_deleted`='0'
        LEFT JOIN `phone_socket_execution` on `phone_plint_port_socket`.`id_socket`=`phone_socket_execution`.`id_socket` AND `phone_socket_execution`.`is_deleted`='0'

        WHERE `phone_gateway_plint`.`is_deleted` = 0";

        if($id_dep) {
            if(is_array($id_dep)) {
                $sql_add = "";
                foreach ($id_dep as $value1) {
                    if($sql_add) $sql_add .= " OR ";
                    $sql_add .= " `room`.`id_dep`='".$value1."' ";
                }
                $sql .= ' AND ('.$sql_add.')';
            } else {
                $sql .=" AND `room`.`id_dep`='".$id_dep."'";
            }
        }
        //echo $sql;
        $listTel = $this->db_instance->getListData($sql, array('number','inner_number','gateway_name','ip','ip_out','gateway_port_name','plint_port_name','plint_name','id_socket_execution','id_plint_room','id_gateway_room','socket_name','id_socket_room','id_execution','text','room_name','id_room','is_hidden'));
        if($listTel) {
            $i = 0;
            $room_count=0;
            foreach ($listTel as $value) {
                /*if($value['number']) {
                    $value['number1'] = $value['number'][0].$value['number'][1].'-'.$value['number'][2].$value['number'][3].'-'.$value['number'][4].$value['number'][5];
                }*/

                if($value['number'] && strlen($value['number']) == 6) {
                    $value['number1'] = $value['number'][0].$value['number'][1].'-'.$value['number'][2].$value['number'][3].'-'.$value['number'][4].$value['number'][5];
                } elseif($value['number']) {
                    //$value['number1'] = $value['number'];
                    $value['number1'] = '+7 ('.substr($value['number'], 1, 3).') '.substr($value['number'], 4, 3).'-'.substr($value['number'], 7, 2).'-'.substr($value['number'], 9, 2);
                }


                //Получение комнат
                /*
                $sql = "SELECT * FROM `room` WHERE `id` = '".$value['id_socket_room']."' AND `is_deleted` = 0";
                $itemSocketRoom = $this->db_instance->getOneData($sql, array('name'));
                if($itemSocketRoom) $value['room_name'] = $itemSocketRoom['name'];
                else $value['room_name'] = 'не указано';
                */

                $sql = "SELECT * FROM `room` WHERE `id` = '".$value['id_gateway_room']."' AND `is_deleted` = 0";
                $itemGatewayRoom = $this->db_instance->getOneData($sql, array('name'));
                if($itemGatewayRoom) $value['gateway_room_name'] = $itemGatewayRoom['name'];
                else $value['gateway_room_name'] = 'не указано';

//                $userExec = $GLOBALS['usersHome']->getByExec($value['id_execution']);
//                $userPos = $GLOBALS['usersHome']->getValue('user_position', 'id', $userExec['id_position'], array('name'));
                $userExec = $this->getByExec($value['id_execution']);
                $value['user_name'] = $userExec['name'];
                //if($userExec['position_name']) $value['user_name'] .= ", ".$userPos['name'];
                if($userExec['position_name']) $value['position_name'] = $userExec['position_name'];
                $value['is_photo'] = $userExec['image'];
                $value['id_user'] = $userExec['id'];
                $value['id_dep'] = $userExec['id_department'];

                $this->getDepList($userExec['id_department']);
                for($j = count($this->tmp); $j >0; $j--) {
                    $value['dep_name'] .= $this->tmp[$j]['name'].'. ';
                }

                //Обработка комнат
                /*
                if($rights == 'write' && $value['id_room'] && $this->tmp[1]['id']) {
                    $room_count++;
                    $sql = "SELECT `id_dep` FROM `room` WHERE `id`='".$value['id_room']."'";
                    $room = $this->db_instance->getOneData($sql, array('id_dep'));
                    echo $room['id_dep'].'-'.$value['id_room'].'-'.$value['room_name']."<br>\n";
                    echo $this->tmp[1]['name'].'-'.$this->tmp[1]['id']."<br>\n";
                    echo $room_count."<br>\n";
                    if(!$room['id_dep']) {
                        $sql = "UPDATE `room` SET `id_dep`='".$this->tmp[1]['id']."' WHERE `id`='".$value['id_room']."'";
                        $this->db_instance->query($sql);
                        echo 'update'."<br>\n";
                    }
                }
                //*/

                unset($this->i);
                unset($this->tmp);

                if (!$value['id_execution'] && $value['text']) $value['user_name'] = $value['text'];


                if ($rights == 'write') $value['admin'] = true;

                if ($rights == 'write' || ($value['number']) && $value['id_socket_room']) {
                    //$value['num'] = ++$i;

                    if ($xml) {
                        if (mb_stristr($value['position_name'], "ректор") || mb_stristr($value['position_name'], "начальник") || mb_stristr($value['position_name'], "декан") || mb_stristr($value['position_name'], "президент")) {
                            if (mb_stristr($value['dep_name'], "ректорат")) $value['user_name'] = ' ' . $value['user_name'];
                            if ($arr[$value['user_name']]) $value['user_name'] = $value['user_name'] . ' ';
//							array_push($dataSearchFild, $value);
                            $arr[$value['user_name']] = $GLOBALS['templateHome']->parse($GLOBALS['modules_root'] . "phone/tpl/row_phonebook_xml.tpl", $value);
                            //$rows['rows'] .= $GLOBALS['templateHome']->parse($GLOBALS['modules_root'] . "phone/tpl/row_phonebook_xml.tpl", $value);
                        }
                    } else {
                        array_push($data['dataPhone'], $value);
                        $data['countRecords'] += 1;
//							if (strstr($value['room_name'], '14') != false){
//								array_push($dataSearchFild, $value);
//							}
                        $rows['rows'] .= $GLOBALS['templateHome']->parse($GLOBALS['modules_root'] . "phone/tpl/row_phonebook.tpl", $value);
                    }
                }

            }
            //сортировка по столбцам
            $orderColumn = false;
            $orderDir = "ASC";
            if($this->request->hasValue('order') && $this->request->getValue('order')[0] && $this->request->getValue('order')[0]['column'] >= 0){
                $orderIndex =  $this->request->getValue('order')[0]['column'];
                $orderColumn = $this->request->getValue('columns')[$orderIndex]['data'];
                $orderDir =  $this->request->getValue('order')[0]['dir'];
            }



            // делаем возможность поиска в таблице
            $dataSearchFild = Array(
                'countRecords' => 0,
                'total' => 0,
                'dataPhone'=>
                    array()
            );
            if($searchStr){
                foreach($data['dataPhone'] as $row) {
                    if ((strstr(mb_strtolower($row['dep_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['room_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['user_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['number']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['number1']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['socket_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['gateway_port_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['gateway_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['gateway_room_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['plint_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['ip_out']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['plint_port_name']), mb_strtolower($searchStr)) != false)
                        or (strstr(mb_strtolower($row['id_socket_execution']), mb_strtolower($searchStr)) != false)){
                        array_push($dataSearchFild['dataPhone'], $row);
                    }
                }
                if($orderColumn){
                    switch ($orderColumn) {
                        case 'Фото':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["is_photo"]),mb_strtolower( $b["is_photo"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["is_photo"]), mb_strtolower($a["is_photo"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'Подразделение':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["dep_name"]),mb_strtolower( $b["dep_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["dep_name"]), mb_strtolower($a["dep_name"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'Аудитория/розетка':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["room_name"]),mb_strtolower( $b["room_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["room_name"]), mb_strtolower($a["room_name"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'Телефон':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["number"]), mb_strtolower($b["number"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["number"]), mb_strtolower($a["number"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;

                        case 'Сотрудник':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["user_name"]), mb_strtolower($b["user_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["user_name"]), mb_strtolower($a["user_name"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'IP шлюза/порт':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["ip_out"]), mb_strtolower($b["ip_out"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["ip_out"]), mb_strtolower($a["ip_out"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'Плинт':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["plint_name"]), mb_strtolower($b["plint_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["plint_name"]), mb_strtolower($a["plint_name"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                        case 'ID':
                            $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["id_socket_execution"]), mb_strtolower($b["id_socket_execution"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["id_socket_execution"]), mb_strtolower($a["id_socket_execution"]));
                            }
                            usort($dataSearchFild["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $dataSearchFild['dataPhone'] = array_slice($dataSearchFild['dataPhone'], $start, $length);
                            return $dataSearchFild;
                            break;
                    }
                }
                $dataSearchFild['countRecords'] = count($dataSearchFild['dataPhone']);
                $dataSearchFild['total'] = count($dataSearchFild['dataPhone']);
                $dataSearchFild['dataPhone'] = array_splice($dataSearchFild['dataPhone'], $start, $length);
                return $dataSearchFild;
//            $sql = "SELECT * FROM `rooms` WHERE (name LIKE '%".$searchStr."%')";
//            $countSql = sprintf("SELECT count(*) cn FROM (%s) tcount", $sql);
//            $filteredCount = $this->db_instance->getCountData($countSql, 'cn');
            }else{
                if($orderColumn){
                    switch ($orderColumn) {
                        case 'Фото':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["is_photo"]),mb_strtolower( $b["is_photo"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["is_photo"]), mb_strtolower($a["is_photo"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'Подразделение':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["dep_name"]),mb_strtolower( $b["dep_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["dep_name"]), mb_strtolower($a["dep_name"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'Аудитория/розетка':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["room_name"]),mb_strtolower( $b["room_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["room_name"]), mb_strtolower($a["room_name"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'Телефон':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["number"]), mb_strtolower($b["number"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["number"]), mb_strtolower($a["number"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;

                        case 'Сотрудник':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["user_name"]), mb_strtolower($b["user_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["user_name"]), mb_strtolower($a["user_name"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'IP шлюза/порт':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["ip_out"]), mb_strtolower($b["ip_out"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["ip_out"]), mb_strtolower($a["ip_out"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'Плинт':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strcmp(mb_strtolower($a["plint_name"]), mb_strtolower($b["plint_name"]));
                            }
                            function desc($a, $b)
                            {
                                return strcmp(mb_strtolower($b["plint_name"]), mb_strtolower($a["plint_name"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                        case 'ID':
                            $data['countRecords'] = count($data['dataPhone']);
                            function asc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($a["id_socket_execution"]), mb_strtolower($b["id_socket_execution"]));
                            }
                            function desc($a, $b)
                            {
                                return strnatcmp(mb_strtolower($b["id_socket_execution"]), mb_strtolower($a["id_socket_execution"]));
                            }
                            usort($data["dataPhone"], ($orderDir == 'asc') ? "asc" : "desc");
                            $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                            return $data;
                            break;
                    }
                }
                $data['countRecords'] = count($data['dataPhone']);
                $data['total'] = $data['countRecords'];
                function cmp($a, $b)
                {
                    return strcmp($a["user_name"], $b["user_name"]);
                }
                usort($data["dataPhone"], "cmp");
                $data['dataPhone'] = array_slice($data['dataPhone'], $start, $length);
                return $data;
            }
        }
            return 44;
            //сортировка по столбцам
    }
    public function getDepList($id=0) {
        if($id) {
            $sql = "SELECT * FROM `department` WHERE `id` = '".$id."' AND `level` > 1 AND `type`!='' AND `is_deleted` = 0";
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

    public function getDepList1($id_parent=0, $dep_list = NULL) {
        if($id_parent) {
            $sql = "SELECT `id` FROM `department` WHERE `id_parent` = '".$id_parent."' AND `is_deleted` = 0";
            $item = $this->db_instance2->getListData($sql, array('id'));
            if ($item) {
                if (! $dep_list)
                    $dep_list = array();
                foreach ($item as $value) {
                    array_push($dep_list, $value['id']);
                    $tmp = $this->getDepList1($value['id'], $dep_list);
                    if ($tmp)
                        $dep_list = $tmp;
                }
                return $dep_list;
            }
        }
        return false;
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