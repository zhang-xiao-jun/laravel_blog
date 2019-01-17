<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Post extends Model
{
    //
    protected $dates = ['published_at'];

    protected $fillable = [
        'title','subtitle','content_raw','page_image','meta_description','layout','is_draft','published_at',
    ];

    // 然后在 Post 模型类中添加如下几个方法

    /**
     * 返回 published_at 字段的日期部分
     */
  /*  public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('Y-m-d');
    }*/

    /**
     * 返回 published_at 字段的时间部分
     */
  /*  public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }*/

    /**
     * content_raw 字段别名
     */
    public function getContentAttribute($value)
    {
        return $this->content_raw;
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class,'post_tag_pivot');
    }

    public function setTitleAttribute ($value)
    {
        $this->attributes['title'] = $value;

        if( !$this->exists ) {
            $value = unique(str_random(8));
            $this->setUniqueSlug($value,0);
            /*$this->attributes['slug'] = str_slug($value);*/
        }
    }

    protected function setUniqueSlug($title,$extra)
    {
        $slug = str_slug($title.'-'.$extra);

        if(static::where('slug',$slug)->exists) {
            if(static::where('slug',$slug)->exists()) {
                $this->setUniqueSlug($title,$extra + 1);
                return;
            }

            $this->attributes['slug'] = $slug;
        }
    }

    /**
     * Set the HTML content automatically when the raw content is set
     *
     * @param string $value
     */
    public function setContentRawAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    /**
     * Sync tag relation adding new tags as needed
     *
     * @param array $tags
     */
    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if (count($tags)) {
            $this->tags()->sync(
                Tag::whereIn('tag', $tags)->get()->pluck('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }
}
