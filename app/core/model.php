<?php 
/**
 * main model class
 */
class Model extends Database
{
	protected $allowedColumns=[];
	protected $table = "";

	public function insert($data)
	{
		//remove unwanted columns
		if(!empty($this->allowedColumns))
		{
			foreach ($data as $key => $value) {
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "INSERT INTO " . $this->table;
		$query .= " (".implode(",", $keys) .") VALUES (:".implode(",:", $keys) .")";

		$this->query($query,$data);

	}

	public function update($id,$data)
	{
		//remove unwanted columns
		if(!empty($this->allowedColumns))
		{
			foreach ($data as $key => $value) {
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query ="UPDATE ".$this->table." set ";
		foreach($keys as $key){
			$query .=$key.'=:'.$key.',';
		}
		$query=trim($query,',');
		$query.=' WHERE id= :id';

		$data['id']=$id;
		$this->query($query,$data);

	}

	public function where($data,$order='desc',$offset=0)
	{
		$keys = array_keys($data);

		$query = "select * from ".$this->table." where ";

		foreach ($keys as $key) {
			$query .= $key . "=:" . $key . " && ";
		}
 
 		$query = trim($query,"&& ");
		$query .= " order by id $order ";
		$res = $this->query($query,$data);

		if(is_array($res))
		{
			return $res;
		}

		return false;

	}

	public function findAll($order='desc')
	{
		$query = "select * from ".$this->table." order by id $order ";
 		$res = $this->query($query);

		if(is_array($res))
		{
			return $res;
		}

		return false;

	}

	public function first($data,$order='desc')
	{

		$keys = array_keys($data);

		$query = "select * from ".$this->table." where ";

		foreach ($keys as $key) {
			$query .= $key . "=:" . $key . " && ";
		}
 
 		$query = trim($query,"&& ");
 		$query .= " order by id $order limit 1";

		$res = $this->query($query,$data);

		if(is_array($res))
		{
			return $res[0];
		}

		return false;

	}

	public function delete(int $id):bool{
		$query = "delete from ".$this->table." where id = :id limit 1";
 		$this->query($query,['id'=>$id]);

		return true;
	}

}