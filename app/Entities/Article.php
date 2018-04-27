<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';
    public $primaryKey = 'id';
    public $guarded = [];
    public $timestamps = false;
    public  function  cates()
    {
//        return $this->hasMany(CateArticle::class);
        return $this->belongsTo(CateArticle::class,'cate_id');
    }
}
