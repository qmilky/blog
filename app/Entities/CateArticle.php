<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\IdTrait;
class CateArticle extends Model
{
    //使用Trait无需配置，直接在App文件夹下建立Traits/Trait文件，写好逻辑代码即可
    use IdTrait;  //类外也需要use App\Traits\IdTrait;否则找不到这个类，此即为Trait的用法，使用trait的话，数据库中主键都为id。
    public $table = 'cate_article';
    /*主键一定要和数据库中的一致，否则影响删除*/
    public $primaryKey = 'id';
//    public $primaryKey = 'cate_id';
    public $guarded = [];
    public $timestamps = false;


    public  static function tree()
    {
       $cates =  self::orderBy('cate_order','asc')->get();
       /*对分类数据进行格式化，排序缩进*/
       return self::getTrees($cates,0);

    }

    public static function getTrees($category,$pid)
    {
        $arr = [];
        foreach($category as $k=>$v){
            if ($v->cate_pid==$pid){
                $v->cate_names=$v->cate_name;
                $arr[]=$v;


                foreach ($category as $m=>$n) {
                    //如果一个分类的pid == $v这个类的id,那这个类就是$v的子类
                    if($n->cate_pid == $v->id){
//                        $n->cate_names = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$n->cate_name;
                        $n->cate_names = '|----------'.$n->cate_name;
                        $arr[] = $n;
                    }
//                    self::getTree($category,$v->cate_id);
                }
            }

        };
        return $arr;

    }


}
