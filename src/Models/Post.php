<?php

namespace Parfaitementweb\DocBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Tags\HasTags;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements Feedable, HasMedia
{
    use HasTags;
    use HasSlug;
    use HasTranslations;
    use HasMediaTrait;

    public $with = ['tags'];
    public $dates = ['publish_date'];
    public $casts = [
        'published' => 'boolean',
    ];
    public $translatable = ['title', 'slug', 'excerpt', 'text', 'published', 'seo_title', 'seo_description'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->usingLanguage(config('app.fallback_locale'))
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
            ->doNotGenerateSlugsOnCreate();
    }

    public function url($locale = null)
    {
        if ( ! $locale) {
            $locale = app()->getLocale();
        }

        return locale_url('blog/' . $this->getTranslationWithFallback('slug', $locale), $locale);
    }

    public function exists($locale)
    {
        return $this->getTranslationWithoutFallback('slug', $locale) && $this->getTranslationWithoutFallback('published', $locale);
    }

    public function getTagsTextAttribute(): string
    {
        return $this->tags->pluck('name')->implode(', ');
    }

    public function updateAttributes(array $attributes)
    {
        $this->setTranslation('slug', $attributes['lang'], $attributes['slug']);
        $this->setTranslation('title', $attributes['lang'], $attributes['title']);
        $this->setTranslation('text', $attributes['lang'], $attributes['text']);
        $this->setTranslation('excerpt', $attributes['lang'], $attributes['excerpt']);
        $this->setTranslation('seo_title', $attributes['lang'], ( ! empty($attributes['seo_title'])) ? $attributes['seo_title'] : null);
        $this->setTranslation('seo_description', $attributes['lang'], ( ! empty($attributes['seo_description'])) ? $attributes['seo_description'] : null);
        $this->setTranslation('published', $attributes['lang'], isset($attributes['published']) ? true : false);
        $this->redirect = $attributes['redirect'] ?: null;
        $this->author = $attributes['author'];
        $this->publish_date = $attributes['publish_date'];

        $this->save();

        if ( ! empty($attributes['tags_text'])) {
            $tags = array_map(function (string $tag) {
                return trim(strtolower($tag));
            }, explode(',', $attributes['tags_text']));

            $this->syncTags($tags);
        } else {
            $this->syncTags([]);
        }

        if ( ! empty($attributes['upload'])) {
            $this->addMediaFromRequest('upload')->toMediaCollection();
        }

        ResponseCache::flush();

        return $this;
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->excerpt)
            ->updated($this->publish_date)
            ->link(url($this->url()))
            ->author($this->author);
    }

    public static function getFeedItems()
    {
        return static::where('published->' . LaravelLocalization::getCurrentLocale(), true)
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion($media->name);

        $this->addMediaConversion('thumb')->width(250);
    }
}
