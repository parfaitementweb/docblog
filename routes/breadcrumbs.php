<?php

// Docs
Breadcrumbs::for('docs', function ($trail) {
    $trail->push(__('docblog::docs.home'), url('/docs'));
});

// Home > Docs > [Tag]
Breadcrumbs::for('tag', function ($trail, $element) {
    $trail->parent('docs');
    if ($element) {
        $trail->push($element->name, locale_url('docs/tags/' . $element->name));
    }
});

// Home > Docs > [Tag] > [Doc]
Breadcrumbs::for('doc', function ($trail, $element) {
    $trail->parent('tag', $element->tags->first());
    $trail->push(( ! empty($element->breadcrumb_title)) ? $element->breadcrumb_title : $element->title, url('docs', $element->id));
});

// Home > Docs > Search
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('docs');
    $trail->push(__('docblog::docs.search'), url('/docs'));
});