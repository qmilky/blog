<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';
    public $primaryKey = 'id';
    public $guarded = [];
    public $timestamps = false;
    protected $statusTxt = [
        '0'  => '禁用',
        '1'  => '启用',
    ];
    public  function  cates()
    {
//        return $this->hasMany(CateArticle::class);
        return $this->belongsTo(CateArticle::class,'cate_id');
    }
    public  function transform()
    {
        if(isset($this->status)){
            $this->status_txt = isset($this->statusTxt[$this->status]) ? $this->statusTxt[$this->status] : '不详';
        }
        return $this;
    }
}
