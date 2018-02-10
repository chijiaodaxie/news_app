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
		$file_path = "/disk1/data/webpage/news/html_extract/";
		$content = file_get_contents($file_path.$f);
		$post_list = M("fr_article");
		$where = array("uuid"=>$f);
		$post = $post_list->field(array('title', 'description', "keywords", "cats", "landing_page", "addtime", "brand", "related_articles","ht_articles", "cat_articles"))->where( $where )->find();
		// cat list
		$cat_list = M("fr_category");
		$cats = $cat_list->field(array('catname', 'id', 'slug'))->select();
		// right content
		$where = " thumb is not null and thumb <>''";
		$post_fields = array('catid', 'title', 'snippet', "keywords", "thumb", "url", 'addtime');
		$newest_posts = $post_list->field( $post_fields )->where( $where )
			->order("id desc")->limit( 10 )->select();
		
		// related articles
		$related_ids = trim($post["related_articles"], ",");
		$ht_like_ids = trim($post["ht_articles"], ",");
		$cat_like_ids = trim($post["cat_articles"], ",");
		$all_ids = array($related_ids, $ht_like_ids, $cat_like_ids);
		$all_ids_real = array();
		for($i=0;$i<3;$i++){
			if("" != $all_ids[$i]){
				$all_ids_real[] = $all_ids[$i];
			}
		}
		$all_relat_ids = trim(join($all_ids_real, ","), ",");
		// dump($all_relat_ids);
		$order_related = "FIND_IN_SET(id,\"".$all_relat_ids."\")";
		if("" != $all_relat_ids){
			$where_related = "id in (".$all_relat_ids.")";
			$related_articles = $post_list->field( $post_fields )->where( $where_related )
				->order($order_related)->limit( 9 )->select();
		}else{
			$related_articles = array();
		}
		// dump($related_articles);
		// $this->assign('meta_title', $post["title"]." | Super News");
		// $this->assign('title', $post["title"]);
		$this->assign('post', $post);
		$this->assign('content', $content);
		$this->assign('related_posts', $related_articles);
		$this->assign('newest_posts', $newest_posts);
		$this->assign('cat_list', $cats);
		$this->display('show_post');
	}
}