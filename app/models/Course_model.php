<?php 
/**
 * courses model
 */
class Course_model extends Model
{
	
	public $errors = [];
	protected $table = "courses";
	
	protected $allowedColumns = [

		'title',
		'description',
		'user_id',
		'category_id',
		'sub_category_id',
		'level_id',
		'language_id',
		'price_id',
		'promo_link',
		'course_image',
		'course_promo_video',
		'primary_subject',
		'date',
		'tags',
		'congratulation_message',
		'welcome_message',
		'approved',
		'published',
		'subtitle',
		'currency_id',
		'csrf_code',
		'views',
		'trending'

	];

	public function course_landing_validate($data){
		$this->errors=[];

		if(empty($data['title']))
		{
			$this->errors['title'] = "A course name is required";
		}else
		if(!preg_match("/^[a-zA-Z \-\_\&]+$/", trim($data['title'])))
		{
			$this->errors['title'] = "course name can only have letters and spaces and";
		}
		
		if(empty($data['primary_subject']))
		{
			$this->errors['primary_subject'] = "A primary subject is required";
		}else
		if(!preg_match("/^[a-zA-Z \-\_\&]+$/", trim($data['primary_subject'])))
		{
			$this->errors['primary_subject'] = "primary subject can only have letters and spaces and";
		}


		if(empty($data['language_id']))
		{
			$this->errors['language_id'] = "A language is required";
		}

		if(empty($data['level_id']))
		{
			$this->errors['level_id'] = "A level is required";
		}

		if(empty($data['currency_id']))
		{
			$this->errors['currency_id'] = "A currency is required";
		}

		if(empty($data['price_id']))
		{
			$this->errors['price_id'] = "A price is required";
		}

		if(empty($data['category_id']))
		{
			$this->errors['category_id'] = "A category is required";
		}

		if(empty($data['description']))
		{
			$this->errors['description'] = "A description is required";
		}

		if(empty($data['subtitle']))
		{
			$this->errors['subtitle'] = "A sub title is required";
		}
		
		if(empty($this->errors))
		{
			return true;
		}

		return false;

	}

	public function message_course_validate($data){
		$this->errors = [];
		

		if(empty($data['welcome_message']))
		{
			$this->errors['welcome_message'] = "A welcome message is required";
		}

		if(empty($data['congratulation_message']))
		{
			$this->errors['congratulation_message'] = "A congratulation message is required";
		}

		
		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}


	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['title']))
		{
			$this->errors['title'] = "A course name is required";
		}else
		if(!preg_match("/^[a-zA-Z \-\_\&]+$/", trim($data['title'])))
		{
			$this->errors['title'] = "course name can only have letters and spaces and";
		}
		
		if(empty($data['primary_subject']))
		{
			$this->errors['primary_subject'] = "A primary subject is required";
		}else
		if(!preg_match("/^[a-zA-Z \-\_\&]+$/", trim($data['primary_subject'])))
		{
			$this->errors['primary_subject'] = "primary subject can only have letters and spaces and";
		}


		if(empty($data['category_id']))
		{
			$this->errors['category_id'] = "A category is required";
		}
		
		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}


	public function edit_validate($data,$id)
	{
		$this->errors = [];

		if(empty($data['firstname']))
		{
			$this->errors['firstname'] = "A first name is required";
		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['firstname'])))
		{
			$this->errors['firstname'] = "first name can only have letters without spaces";
		}
		

		if(empty($data['lastname']))
		{
			$this->errors['lastname'] = "A last name is required";
		}else
		if(!preg_match("/^[a-zA-Z]+$/", trim($data['lastname'])))
		{
			$this->errors['lastname'] = "last name can only have letters without spaces";
		}

		//check email
		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "Email is not valid";
		}else
		if($results=$this->where(['email'=>$data['email']]))
		{
			foreach($results as $result){
				if($id != $result->id)
					$this->errors['email'] = "That email already exists";
			}
		}

		if(!empty($data['phone']))
		{
			if(!preg_match("/^(01|\+2)[0-9]{9}$/", trim($data['phone']))){
				if(!filter_var($data['phone'],FILTER_VALIDATE_URL))
					$this->errors['phone'] = "Phone number not valid";
			}
		}

		if(!empty($data['facebook_link']))
		{
			if(!filter_var($data['facebook_link'],FILTER_VALIDATE_URL))
			{
				$this->errors['facebook_link'] = "Facebook link is not valid";
			}
		}

		if(!empty($data['twitter_link']))
		{
			if(!filter_var($data['twitter_link'],FILTER_VALIDATE_URL))
			{
				$this->errors['twitter_link'] = "Twitter link is not valid";
			}
		}

		if(!empty($data['instagram_link']))
		{
			if(!filter_var($data['instagram_link'],FILTER_VALIDATE_URL))
			{
				$this->errors['instagram_link'] = "Instagram link is not valid";
			}
		}

		if(!empty($data['linkedin_link']))
		{
			if(!filter_var($data['linkedin_link'],FILTER_VALIDATE_URL))
			{
				$this->errors['linkedin_link'] = "Linkedin link is not valid";
			}
		}

  
		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}

	public function join($where=''){
		$query='select courses.*,categories.category,users.firstname,prices.name as pricename from courses  
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
