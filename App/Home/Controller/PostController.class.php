<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class PostController extends CommonController {
	// public function index(){
	// 	// $this->show('<h1>News home</h1>');
	// 	$this->redirect('post/show_post');

	// 	// $content = file_get_contents("/disk1/data/webpage/news/html_extract/000d3b8d277351e552ff81ccce56ce99");
	// 	// $title = "This is the title|这是什么字体？";
	// 	// $meta_title = "He lives 120s | break news";
	// 	// $this->assign('meta_title', $meta_title);
	// 	// $this->assign('title', $title);
	// 	// $this->assign('content', $content);
	// 	// $this->display('index');
	// }
	public function show_post($f){
		$file_path = "/disk1/data/webpage/news/test_html_extract/";
		$content = file_get_contents($file_path.$f);
		$post_list = M("fr_article");
		$where = array("uuid"=>$f);
		$post = $post_list->field(array('title', 'description', "keywords"))->where( $where )->find();

		$this->assign('meta_title', $post["title"]);
		$this->assign('title', $post["title"]);
		$this->assign('content', $content);
		$this->display('show_post');
	}
}