<?php

class Model_Phonebook {

	/**
	 * @var         MysqliDb
	 * @access      private
	 */
	private $db;
	private $table = "phonebook";

	/**
	 * model constructor 
	 */
	public function __construct() {
		global $db;
		$this->db = $db;
	}

	public function findAll($conditions) {
		foreach ($conditions as $k => $v) {
			$this->db->where($k, $v);
		}
		return $this->db->get($this->table);
	}

	public function findOne($conditions) {
		foreach ($conditions as $k => $v) {
			$this->db->where($k, $v);
		}
		return $this->db->getOne($this->table);
	}

	public function insert($data) {
		$id = $this->db->insert($this->table, $data);
		return $id;
	}

	public function update($conditions, $data) {
		foreach ($conditions as $k => $v) {
			$this->db->where($k, $v);
		}
		$this->db->update($this->table, $data);
		return $conditions['phone'];
	}

	public function delete($conditions = array()) {
		foreach ($conditions as $k => $v) {
			$this->db->where($k, $v);
		}
		$this->db->delete($this->table);
	}

}
