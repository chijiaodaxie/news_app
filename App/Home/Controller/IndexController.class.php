<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class IndexController extends CommonController {
	public function index($limit=10){
		// $this->redirect('Admin/Index/index');
		// select posts
		$post_list = M("fr_article");
		$where = " `id`>300 and thumb is not null and thumb <>''";
		$posts = $post_list->field(array('catid', 'title', 'description', "keywords", "thumb", "url", 'addtime'))->where( $where )
			->limit($limit)->select();
		// select cats
		$post_list = M("fr_category");
		$cats = $post_list->field(array('catname'))->select();
			
		// $this->show('<h1>News home</h1>');
		// $this->redirect('Post/show_post');

		// $content = file_get_contents("/disk1/data/webpage/news/html_extract/000d3b8d277351e552ff81ccce56ce99");
		$meta_title = "supper break news";
		$meta_des = "supper break news|lalaal";
		$meta_kw = "supper break news";
		$this->assign('meta_title', $meta_title);
		$this->assign('meta_des', $meta_des);
		$this->assign('meta_kw', $meta_kw);

		$this->assign('post_list', $posts);
		$this->assign('cat_list', $cats);
		$this->assign('limit', $limit);
		// dump( $posts );
		// $this->assign('content', $content);
		$this->display('index');
	}

	public function index_more($limit='10,10'){
		// $this->redirect('Admin/Index/index');

		$post_list = M("fr_article");
		$where = " `id`>300 and thumb is not null and thumb <>''";
		// $where = " `id`<100";
		$posts = $post_list->field(array('catid', 'title', 'description', "keywords", "thumb", "url", 'addtime'))->where( $where )
			->limit($limit)->select();

		$data = $posts;
		// dump( $posts );
		// $this->assign('content', $content);
		// $this->display('index');
		$this->ajaxReturn( $data );
	}
}