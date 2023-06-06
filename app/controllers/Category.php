<?php 
if(!defined("ROOT")) die ("direct script access denied");

/**
 * category controller class
 */
class Category extends Controller
{
	
	public function index($slug = null)
	{
		$course=new Course_model();
		$category=new Category_model();

		$data['title'] = "Category";
        $query="select courses.*,categories.category,users.firstname,prices.name as pricename,categories.slug from courses  
                    inner join categories on 
                    categories.id=courses.category_id
                    inner join 
                    users on users.id=courses.user_id
                    Left outer join
                    prices on prices.id=courses.price_id 
                    where categories.slug=:slug";
		$data['rows']=$course->query($query,['slug'=>$slug]);
		$data['categories']=$category->where(['disabled'=>0],'desc',100);
		$data['trending']=$course->join('where approved=0 order by trending desc limit 5');

        if(!empty($data['rows'])){
			$data['firstrow']=$data['rows'][0];
			unset($data['rows'][0]);

			$total_rows=count($data['rows']);
			$half_rows=round($total_rows/2);

			$data['rows1']=array_splice($data['rows'],0,$half_rows);
			$data['rows2']=$data['rows'];

		}

		$this->view('category',$data);
	}
	
}