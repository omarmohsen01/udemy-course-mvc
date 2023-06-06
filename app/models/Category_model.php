<?php 

/**
 * Category model
 */
class Category_model extends Model
{
	
	public $errors = [];
	protected $table = "categories";

	protected $allowedColumns = [

		'category',
		'disabled',
		'slug',
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['category']))
		{
			$this->errors['category'] = "A category is required";
		}else
		if(!preg_match("/^[a-zA-Z \&\']+$/", trim($data['category'])))
		{
			$this->errors['category'] = "category can only have letters and spaces or &";
		}	
		
		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}

	public function join($where=''){
		$query='select courses.*,categories.category,users.firstname,prices.name as pricename,categories.slug from courses  
				inner join categories on 
				categories.id=courses.category_id
				inner join 
				users on users.id=courses.user_id
				Left outer join
				prices on prices.id=courses.price_id 
						
		'.$where;
		$db=new Database();
		$res=$db->query($query);
		return $res;
	}

}