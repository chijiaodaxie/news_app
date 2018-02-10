<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class CategoryController extends CommonController {
	public function index($cat=10,$limit=10){
		$post_id_list = M("fr_article_cat_relat");
		$where = " cat_id='".$cat."' ";
		$posts_ids = $post_id_list->field(array('article_id'))->where( $where )#->limit($limit*20)
			->select();

		for($i=0;$i<count($posts_ids);$i++){
			$posts_ids[$i] = $posts_ids[$i]["article_id"];
		}

		$post_where = " id in ('".implode("','", $posts_ids)."') and thumb is not null and thumb <>''";
		$post_fields = array('catid', 'title', 'snippet', "keywords", "thumb", "url", 'addtime');
		$post_list = M("fr_article");
		$posts = $post_list->field( $post_fields )->where( $post_where )->order("retweet_count desc")->limit($limit)
			->select();
		// dump($posts);
		$newest_posts = $post_list->field( $post_fields )->where( $post_where )->limit($limit)
			->order("id desc")->limit($limit)->select();
		// select cats
		$cat_list = M("fr_category");
		$cats = $cat_list->field(array('catname', 'id', 'slug'))->select();

		$this->assign('post_list', $posts);
		$this->assign('newest_posts', $newest_posts);
		$this->assign('cat_list', $cats);
		$this->assign('cat_id', $cat);
		$this->assign('limit', $limit);
		$this->display('Index/index');
	}

	public function index_more($cat=10,$limit='10,10'){
		// $this->redirect('Admin/Index/index');
		$post_id_list = M("fr_article_cat_relat");
		$where = " cat_id='".$cat."' ";
		$posts_ids = $post_id_list->field(array('article_id'))->where( $where )
			->limit($limit)->select();

		for($i=0;$i<count($posts_ids);$i++){
			$posts_ids[$i] = $posts_ids[$i]["article_id"];
		}

		$post_list = M("fr_article");
		$post_where = " id in ('".implode("','", $posts_ids)."')";
		$where = " `id`>300 and thumb is not null and thumb <>''";
		// $where = " `id`<100";
		$posts = $post_list->field(array('catid', 'title', 'description', "keywords", "thumb", "url", 'addtime'))->where( $post_where )
			->limit($limit)->select();

		$data = $posts;
		// dump( $posts );
		// $this->assign('content', $content);
		// $this->display('index');
		$this->ajaxReturn( $data );
	}
}