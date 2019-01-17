<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{
    //
    protected $table = 'tags';

    protected $fillable = [
        'tag','title','subtitle','page_image','meta_description','reverse_direction',
    ];

    /**
     * 定义文章与标签之间多对多关系
     *
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_tag_pivot');
    }

    public static function addNeededTags(array $tags)
    {
        if(count($tags) === 0) {
            return;
        }

        //pluck 从数据表中返回单一字段
        $found = static::whereIn('tag',$tags)->get()->pluck('tag')->all();

        foreach (array_diff($tags,$found) as $tag) {
            static::create([
                'tag'=>$tag,
                'title'=>$tag,
                'subtitle'=>'Subtitle for'.$tag,
                'page_image'=>'',
                'meta_description'=>'',
                'reverse_derection'=>false,
            ]);
        }
    }
}
