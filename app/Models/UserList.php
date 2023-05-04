<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserList extends  Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'tags',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 150, 150)
            ->nonQueued();
    }

    public function getTags(){
        return ($this->tags) ? explode(', ',$this->tags) : [];
    }

    public function updateTags($tags){
        $this->update([
            'tags'=> implode(', ',$tags),
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'title'=>$this->title,
            'description'=>$this->description,
            'tags'=>$this->tags,
            'created_at'=>$this->created_at,
        ];
    }
}
