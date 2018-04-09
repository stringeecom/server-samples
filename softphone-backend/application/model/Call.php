<?php
class Model_Call {
        
        
        /**
         * @var         MysqliDb
         * @access      private
         */
        private $db;
        private $table = "call_log";
        public $totalPages;
		public $totalCount;
        
        /**
         * model constructor 
         */
        public function __construct() {
                global $db;
                $this->db = $db;
        }
        
        public function findAll($condition, $page, $limit) {
				$this->db->join('account_project', 'dh_call_log.project_id = dh_account_project.id', 'left');
				$this->db->where('dh_account_project.account_sid',$_SESSION['account']['account_sid']);
				
				if($condition['project_id']){
					$this->db->where('dh_call_log.project_id', $condition['project_id']);
				}
				if($condition['from_date']){
					$this->db->where("DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y/%m/%d')",$condition['from_date'],'>=');
				}
				if($condition['to_date']){
					$this->db->where("DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y/%m/%d')",$condition['to_date'],'<=');
				}
				
				if($condition['from_number']){
					$this->db->where('from_number', '%'.$condition['from_number'].'%', 'like');
				}
				if($condition['to_number']){
					$this->db->where('to_number', '%'.$condition['to_number'].'%', 'like');
				}
				if($condition['from_internal']){
					if($condition['from_internal'] == 'on'){
						$this->db->where('from_internal', 1);
					}else{
						$this->db->where('from_internal', 0);
					}
				}
				if($condition['to_internal']){
					if($condition['to_internal'] == 'on'){
						$this->db->where('to_internal', 1);
					}else{
						$this->db->where('to_internal', 0);
					}
				}
				$this->db->orderBy('start_time','DESC');
				$this->db->pageLimit = $limit;
                $call = $this->db->paginate($this->table, $page, 
						"dh_call_log.*, dh_account_project.name as project_name,".
						"DATE_FORMAT(FROM_UNIXTIME(dh_call_log.start_time/1000),'%Y/%m/%d, %H:%i:%s') as start_time_datetime,".
						"DATE_FORMAT(FROM_UNIXTIME(dh_call_log.answer_time),'%Y/%m/%d, %H:%i:%s') as answer_time_datetime,".
						"DATE_FORMAT(FROM_UNIXTIME(dh_call_log.stop_time/1000),'%Y/%m/%d, %H:%i:%s') as stop_time_datetime,".
						"DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y/%m/%d, %H:%i:%s') as created_datetime"
					);
                $this->totalPages = $this->db->totalPages;
				$this->totalCount = $this->db->totalCount;
                return $call;
        }
		
		
		public function callByDay($condition){

			$query = "SELECT created_datetime, SUM(total) as total ".
					"from (SELECT DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y-%m-%d') as created_datetime, COUNT(dh_call_log.id) AS total, dh_account_project.name as project_name FROM dh_call_log  ";
			$query .= "LEFT JOIN dh_account_project ON dh_call_log.project_id = dh_account_project.id";
			$query .= " WHERE dh_account_project.account_sid = ". "'".$_SESSION['account']['account_sid']."'";
			if($condition['project_id']){
				$query .= " AND dh_call_log.project_id = "."'". $condition['project_id']."'";
			}
			if($condition['from_date']){
				$query .= " AND DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y/%m/%d') >= ". "'".$condition['from_date']."'";
			}
			if($condition['to_date']){
				$query .= " AND DATE_FORMAT(FROM_UNIXTIME(dh_call_log.created),'%Y/%m/%d') <= ". "'".$condition['to_date']."'";
			}
			
			if($condition['from_number']){
				$query .= " AND from_number LIKE "."'%".$condition['from_number']."%'";
			}
			if($condition['to_number']){
				$query .= " AND to_number LIKE "."'%".$condition['to_number']."%'";
			}
			if($condition['from_internal']){
				if($condition['from_internal'] == 'on'){
					$query .= " AND from_internal = 1";
				}else{
					$query .= " AND from_internal = 0";
				}
			}
			if($condition['to_internal']){
				if($condition['to_internal'] == 'on'){
					$query .= " AND to_internal = 1";
				}else{
					$query .= " AND to_internal = 0";
				}
			}
			
			
			$query .= " GROUP by dh_call_log.id) dh_call_log  GROUP BY created_datetime";
			
			return $this->db->rawQuery($query);
			
		}
		
		
		
        public function findOne($conditions) {
                foreach($conditions as $k => $v){
                        $this->db->where($k, $v);
                }
                return $this->db->getOne($this->table);
        }

        public function insert($data) {
                $id = $this->db->insert($this->table, $data);
                return $id;
        }

        public function update($callId, $data) {
                $this->db->where('id', $callId);
                $this->db->update($this->table, $data);
                return $callId;
        }
        
        public function delete($conditions) {
                foreach ($conditions as $k => $v) {
                        $this->db->where($k, $v);
                }
                return $this->db->delete($this->table);
        }
        
        public function rawQuery($query, $bindParams) {
			return $this->db->rawQuery($query, $bindParams);
		}
	

}
