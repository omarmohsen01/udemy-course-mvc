<?php

/**
 * Admin class
 */
class Admin extends Controller
{
	
	//index view===> dashboard in admin view
	public function index()
	{

		if(!Auth::logged_in()){
			message('Please login first');
			redirect('login');
		}
		$data['title'] = "Dashboard";

		$this->view('admin/dashboard',$data);
	}

	//courses view
	public function courses($action=null,$id=null)
	{
		//first check if user login or not
		if(!Auth::logged_in()){
			message('Please login first');
			redirect('login');
		}

		//get session id
		$user_id= Auth::getId(); 
		//course object from Course class[errors,tablename,allowedcolumn,validate,edit validate]
		$language=new Language_model();
		$course=new Course_model();
		$category=new Category_model();
		$currency=new Currency_model();
		$level=new Level_model();
		$price=new Price_model();
		//make data array that send with view function

		$data=[];
		$data['action']=$action;
		$data['id']=$id;

		if($action=='add')
		{
			//category object from Category class[errors,tablename,allowedcolumn,validate] 
			//fetch all record in categories table and put in data to send to view page
			$data['categories']=$category->findAll('asc');

			if($_SERVER['REQUEST_METHOD'] == "POST"){
				//if course data was posted in form is validate
				if($course->validate($_POST))
				{

					$_POST['date'] = date("Y-m-d H:i:s");
					$_POST['user_id'] = $user_id;
					$_POST['price_id'] = 1;

					//insert this data in cousrse table
					$course->insert($_POST);
					//after insertion ,get the record and put in row
					$row=$course->first(['user_id'=>$user_id,'published'=>0]);	
					message("Your course was successfuly created");

					if($row){
						redirect('admin/courses/edit/'.$row->id);
					}else{
						redirect('admin/courses');
					}
				}
				$data['erorrs']=$course->errors;
			}
		}elseif($action=='delete'){
			$data['categories'] = $category->findAll('asc');
			$data['languages'] = $language->findAll('asc');
			$data['currencies'] = $currency->findAll('asc');
			$data['levels'] = $level->findAll('asc');
			$data['prices'] = $price->findAll('asc');
			
			//get course information
			$data['row'] = $row = $course->first(['user_id'=>$user_id,'id'=>$id]);
			
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$course->delete($id);
				message('course deleting successfully');
				redirect('admin/courses');
			}
		}
		elseif($action=='edit'){
			$data['categories'] = $category->findAll('asc');
			$data['languages'] = $language->findAll('asc');
			$data['currencies'] = $currency->findAll('asc');
			$data['levels'] = $level->findAll('asc');
			$data['prices'] = $price->findAll('asc');
			
			//get course information
			$data['row'] = $row = $course->first(['user_id'=>$user_id,'id'=>$id]);
			
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$folder='uploads/images/';
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php",'<?php //sillence');
					file_put_contents("uploads/index.php",'<?php //sillence');
				}

				if($_POST['page']=='course-landing-page'){

					if($course->course_landing_validate($_POST)){

						$allowed=['image/jpeg','image/png'];

						if(!empty($_FILES['image']['name'])){

							if($_FILES['image']['error']==0){

								if(in_array($_FILES['image']['type'],$allowed)){
									
									$destenation=$folder.time().$_FILES['image']['name'];

									move_uploaded_file($_FILES['image']['tmp_name'],$destenation);

									$_POST['course_image']=$destenation;

									if(file_exists($row->course_image)){

										unlink($row->course_image);
									}
								}else{
									$course->errors['course_image']='this type is not allowed';
								}
							}else{
								$course->errors['course_image']='Could not upload image';
							}
						}

						$file_name = $_FILES['video']['name'];
						$file_type = $_FILES['video']['type'];
						$file_size = $_FILES['video']['size'];
						$destenation=$folder.time().$_FILES['video']['name'];
						$allowed_extensions = array("webm", "mp4", "ogv");
						$file_name_temp = explode(".", $file_name);
						$extension = end($file_name_temp);
						
						$file_size_max = 2147483648;
						if (!empty($file_name))
						{
							if (($file_type == "video/webm") || ($file_type == "video/mp4") || ($file_type == "video/ogv") &&
								($file_size < $file_size_max) && in_array($extension, $allowed_extensions))
							{
								if ($_FILES['video']['error'] > 0)
								{
									$course->errors['course_promo_video']= "Unexpected error occured, please try again later.";
								} else {
									if (file_exists("secure/".$file_name))
									{
										echo $file_name." already exists.";
									} else {
										move_uploaded_file($_FILES["video"]["tmp_name"], $destenation);
										$_POST['course_promo_video']=$destenation;
									}
								}
							} else {
								$course->errors['course_promo_video']= "Invalid video format.";
							}
						} else {
							$course->errors['course_promo_video']= "Please select a video to upload.";
						}
						
						$course->update($id,$_POST);
					}
				}elseif($_POST['page']=='message-course'){
					if($course->message_course_validate($_POST)){
						$course->update($id,$_POST);
					}
				}
				
				if(empty($course->errors)){
					message("course updated successfully");
				}else{
					message("Please correct these errors");
				}
			}
			$data['errors']=$course->errors;


		}
		else{
			
			$data['rows']=$course->join();
		}
		$this->view('admin/courses',$data);

	}
	

	public function categories($action=null,$id=null)
	{
		//first check if user login or not
		if(!Auth::logged_in()){
			message('Please login first');
			redirect('login');
		}
		//get session id
		$user_id= Auth::getId(); 
		//course object from Course class[errors,tablename,allowedcolumn,validate,edit validate]
		$language=new Language_model();
		$course=new Course_model();
		$category=new Category_model();
		$currency=new Currency_model();
		$level=new Level_model();
		$price=new Price_model();
		//make data array that send with view function
		$data=[];
		$data['action']=$action;
		$data['id']=$id;

		if($action=='add')
		{
			//category object from Category class[errors,tablename,allowedcolumn,validate] 
			//fetch all record in categories table and put in data to send to view page
			$data['categories']=$category->findAll('asc');

			if($_SERVER['REQUEST_METHOD'] == "POST"){
				//if course data was posted in form is validate
				if($category->validate($_POST))
				{
					//insert this data in cousrse table
					$_POST['slug']=str_to_url($_POST['category']);
					$category->insert($_POST);
					message("Your category was successfuly created");
					redirect('admin/categories');
					
				}
				$data['erorrs']=$category->errors;
			}
		}elseif($action=='delete'){
			$data['categories'] = $category->findAll('asc');
			$data['languages'] = $language->findAll('asc');
			$data['currencies'] = $currency->findAll('asc');
			$data['levels'] = $level->findAll('asc');
			$data['prices'] = $price->findAll('asc');
			
			//get course information
			$data['row'] = $row = $course->first(['user_id'=>$user_id,'id'=>$id]);
			
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$course->delete($id);
				message('course deleting successfully');
				redirect('admin/courses');
			}
		}
		elseif($action=='edit'){
			$data['categories'] = $category->findAll('asc');
			$data['languages'] = $language->findAll('asc');
			$data['currencies'] = $currency->findAll('asc');
			$data['levels'] = $level->findAll('asc');
			$data['prices'] = $price->findAll('asc');
			
			//get course information
			$data['row'] = $row = $course->first(['user_id'=>$user_id,'id'=>$id]);
			
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$folder='uploads/images/';
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php",'<?php //sillence');
					file_put_contents("uploads/index.php",'<?php //sillence');
				}

				if($_POST['page']=='course-landing-page'){

					if($course->course_landing_validate($_POST)){

						$allowed=['image/jpeg','image/png'];

						if(!empty($_FILES['image']['name'])){

							if($_FILES['image']['error']==0){

								if(in_array($_FILES['image']['type'],$allowed)){
									
									$destenation=$folder.time().$_FILES['image']['name'];

									move_uploaded_file($_FILES['image']['tmp_name'],$destenation);

									$_POST['course_image']=$destenation;

									if(file_exists($row->course_image)){

										unlink($row->course_image);
									}
								}else{
									$course->errors['course_image']='this type is not allowed';
								}
							}else{
								$course->errors['course_image']='Could not upload image';
							}
						}

						$file_name = $_FILES['video']['name'];
						$file_type = $_FILES['video']['type'];
						$file_size = $_FILES['video']['size'];
						$destenation=$folder.time().$_FILES['video']['name'];
						$allowed_extensions = array("webm", "mp4", "ogv");
						$file_name_temp = explode(".", $file_name);
						$extension = end($file_name_temp);
						
						$file_size_max = 2147483648;
						if (!empty($file_name))
						{
							if (($file_type == "video/webm") || ($file_type == "video/mp4") || ($file_type == "video/ogv") &&
								($file_size < $file_size_max) && in_array($extension, $allowed_extensions))
							{
								if ($_FILES['video']['error'] > 0)
								{
									$course->errors['course_promo_video']= "Unexpected error occured, please try again later.";
								} else {
									if (file_exists("secure/".$file_name))
									{
										echo $file_name." already exists.";
									} else {
										move_uploaded_file($_FILES["video"]["tmp_name"], $destenation);
										$_POST['course_promo_video']=$destenation;
									}
								}
							} else {
								$course->errors['course_promo_video']= "Invalid video format.";
							}
						} else {
							$course->errors['course_promo_video']= "Please select a video to upload.";
						}
						
						$course->update($id,$_POST);
					}
				}elseif($_POST['page']=='message-course'){
					if($course->message_course_validate($_POST)){
						$course->update($id,$_POST);
					}
				}
				
				if(empty($course->errors)){
					message("course updated successfully");
				}else{
					message("Please correct these errors");
				}
			}
			$data['errors']=$course->errors;


		}
		else{
			
			$data['rows']=$category->where(['disabled'=>0],'Asc');
		}

		$this->view('admin/categories',$data);

	}
	
	public function profile($id=null)
	{
		if(!Auth::logged_in()){
			message('Please login first');
			redirect('login');
		}
		$id=$id??Auth::getid();
		$user=new User_model();
		$data['row']=$row=$user->first(['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row){

			$folder='uploads/images/';
			if(!file_exists($folder))
			{
				mkdir($folder,0777,true);
				file_put_contents($folder."index.php",'<?php //sillence');
				file_put_contents("uploads/index.php",'<?php //sillence');
			}

			if($user->edit_validate($_POST,$id))
			{

				$allowed=['image/jpeg','image/png'];
				if(!empty($_FILES['image']['name'])){
					if($_FILES['image']['error']==0){
						if(in_array($_FILES['image']['type'],$allowed)){
							$destenation=$folder.time().$_FILES['image']['name'];
							move_uploaded_file($_FILES['image']['tmp_name'],$destenation);
							$_POST['image']=$destenation;
							if(file_exists($row->image)){
								unlink($row->image);
							}
						}else{
							$user->errors['image']='this type is not allowed';
						}
					}else{
						$user->errors['image']='Could not upload image';
					}
				}
				$user->update($id,$_POST);
			}
				if(empty($user->errors)){
					$arr['message']="Profile saved successfully";
				}else{
					$arr['message']="Please correct these errors";
					$arr['errors']=$user->errors;
				}
				echo json_encode($arr);
				die;
		}
		$data['title'] = "Profile";
		$data['errors']=$user->errors;
		$this->view('admin/profile',$data);
	}
	
}