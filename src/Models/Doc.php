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
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc extends Model implements Feedable, HasMedia
{
    use HasTags;
    use HasSlug;
    use HasTranslations;
    use HasMediaTrait;
    use Searchable;
    use SoftDeletes;

    public $with = ['tags'];
    public $dates = ['publish_date', 'deleted_at'];
    public $casts = [
        'published' => 'boolean',
    ];
    public $translatable = ['title', 'slug', 'text', 'published', 'seo_title', 'seo_description', 'breadcrumb_title'];

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
        if (! $locale) {
            $locale = app()->getLocale();
        }

        return locale_url('docs/' . $this->getTranslationWithFallback('slug', $locale), $locale);
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
        $this->setTranslation('seo_title', $attributes['lang'], (! empty($attributes['seo_title'])) ? $attributes['seo_title'] : null);
        $this->setTranslation('seo_description', $attributes['lang'], (! empty($attributes['seo_description'])) ? $attributes['seo_description'] : null);
        $this->setTranslation('breadcrumb_title', $attributes['lang'], (! empty($attributes['breadcrumb_title'])) ? $attributes['breadcrumb_title'] : null);
        $this->setTranslation('published', $attributes['lang'], isset($attributes['published']) ? true : false);
        $this->author = $attributes['author'];
        $this->publish_date = $attributes['publish_date'];

        $this->save();

        if (! empty($attributes['tags_text'])) {
            $tags = array_map(function (string $tag) {
                return trim(strtolower($tag));
            }, explode(',', $attributes['tags_text']));

            $this->syncTags($tags);
        } else {
            $this->syncTags([]);
        }

        if (! empty($attributes['upload'])) {
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
            ->summary($this->text)
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

    public function toSearchableArray(): array
    {
        if (! $this->published) {
            return [];
        }

        $localized_titles = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $localized_titles[] = $this->getTranslation('title', $localeCode);
        }

        $localized_texts = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $localized_texts[] = substr(strip_tags($this->getTranslation('text', $localeCode)), 0, 5000);
        }

        return array_merge(['id' => $this->id], $localized_titles, $localized_texts);
    }
}
