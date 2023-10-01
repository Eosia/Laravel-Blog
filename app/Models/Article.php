<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;


class Article extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'user_id', 'slug', 'content', 'category_id'];
    protected $guarded = ['category_id', 'user_id', 'slug'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Catégorie anonyme',
        ]);
    }


}
