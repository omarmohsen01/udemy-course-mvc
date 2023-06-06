<?php 
if(!defined("ROOT")) die ("direct script access denied");

/**
 * home class
 */
class Home extends Controller
{
	
	public function index()
	{
		$course=new Course_model();
		$category=new Category_model();
		$data['title'] = "Home";
		$data['categories']=$category->where(['disabled'=>0],'desc',100);
		$data['trending']=$course->join('where approved=0 order by trending desc limit 5');
		$data['rows']=$course->join('where approved=0 limit 7');

		if(!empty($data['rows'])){
			$data['firstrow']=$data['rows'][0];
			unset($data['rows'][0]);

			$total_rows=count($data['rows']);
			$half_rows=round($total_rows/2);

			$data['rows1']=array_splice($data['rows'],0,$half_rows);
			$data['rows2']=$data['rows '];

		}

		$this->view('home',$data);
	}
	
}