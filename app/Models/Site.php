<?php

namespace App\Models;

use Database\Factories\SiteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Fillable(['name'])]
class Site extends Model implements HasMedia
{
    /** @use HasFactory<SiteFactory> */
    use HasFactory, InteractsWithMedia;

    protected $table = 'sites';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero')->singleFile();

        $this->addMediaCollection('about')->singleFile();

        $this->addMediaCollection('og')
            ->singleFile()
            ->registerMediaConversions(function (Media $media): void {
                $this->addMediaConversion('og')
                    ->fit(Fit::Crop, 1200, 630);
            });
    }
}
