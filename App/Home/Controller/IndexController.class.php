<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class IndexController extends CommonController {
	public function index($limit=10){
		// $this->redirect('Admin/Index/index');
		// select posts
		$post_list = M("fr_article");
		$where = " thumb is not null and thumb <>''";
		$post_fields = array('catid', 'title', 'snippet', "keywords", "thumb", "url", 'brand', 'tweet_user', 'addtime');
		$posts = $post_list->field( $post_fields )->where( $where )->order("retweet_count desc")
			->limit($limit)->select();
		// select cats

		$newest_posts = $post_list->field( $post_fields )->where( $where )
			->order("id desc")->limit($limit)->select();

		$cat_list = M("fr_category");
		$cats = $cat_list->field(array('catname', 'id', 'slug'))->select();
			
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
		$this->assign('newest_posts', $newest_posts);
		$this->assign('cat_list', $cats);
		$this->assign('limit', $limit);
		// dump( $posts );
		// $this->assign('content', $content);
		$this->display('index');
	}

	public function index_more($limit='10,10',$cat="-1"){
		// $this->redirect('Admin/Index/index');

		$post_list = M("fr_article");
		$where = array();
		//cat
		if("-1" != $cat){
			$cat_info = M("fr_category")->field(array("cat_calc_relat"))->where("id=".$cat)->select();
			$cat_name = $cat_info[0]["cat_calc_relat"];
			$where["cats"] = array('like', "%".$cat_name."%");
		}
		// dump($where);

		// $where = " `id`<100";
		$posts = $post_list->field(array('catid', 'title', 'snippet', "keywords", "thumb", "url", 'brand', 'tweet_user', 'addtime'))->where( $where )
			->order("retweet_count desc")->limit($limit)->select();

		$data = $posts;
		// dump( $posts );
		// $this->assign('content', $content);
		// $this->display('index');
		$this->ajaxReturn( $data );
	}
}