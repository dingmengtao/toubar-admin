<?php namespace WebEd\Plugins\Blog\Http\Controllers\Front;

use  WebEd\Plugins\Blog\Models\Post;
use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseFrontController;


class PostController  extends BaseFrontController
{
    //产看产品信息，存在ID,获取信息，传入模板
    public function read(Post $post ,Request $request){
        if($request->id){
            $r=$post->getProductById($request->id);
            if($r){
                return $this-> view('front.product.product_detail',['product'=>$r]);
            }else{
                abort(404);
            }
        }else{
     //不存在跳转列表页
            $r=$post->getProductList();
            return $this-> view('front.product.product_list',['product'=>$r]);
        }


    }
}

