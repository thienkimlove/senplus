<?php

namespace App\Models;

use App\Helpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => false,
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'posts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'slug',
        'desc',
        'content',
        'square_image',
        'circle_image',
        'status',
        'author_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function transform()
    {
        $content = Helpers::transformImageContent($this);

        DB::table('posts')->update([
            'content' =>  $content
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function mainTopics()
    {
        return $this->belongsToMany(Topic::class, 'main_topic_posts', 'post_id', 'topic_id');
    }

    public function otherTopics()
    {
        return $this->belongsToMany(Topic::class, 'other_topic_posts', 'post_id', 'topic_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function getTagListAttribute()
    {
        return $this->mainTopics()->pluck('name')->all();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
