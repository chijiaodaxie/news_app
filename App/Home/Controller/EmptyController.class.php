<?php
namespace Home\Controller;
use Home\Controller\CommonController;

/**
 * 空模块，主要用于显示404页面，请不要删除
 */
class EmptyController extends CommonController{
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->show('<b>404 Not Found in home</b>');
		exit;
	}

}