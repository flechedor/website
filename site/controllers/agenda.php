<?php

use Kirby\Toolkit\Str;

return function ($kirby, $pages, $page) {
    $request = $kirby->request();

    // TODO adds "archive" button in the menu?
    if ($request->get('section') == 'archives') {
        $events = $page->children()->listed()->filterBy('fin', 'date <', date('Y-m-d'))->sortBy('fin', 'desc');
    } else {
        $events = $page->children()->listed()->filterBy('fin', 'date >=', date('Y-m-d'))->sortBy('debut', 'asc');
    }

    $filters = [];
    foreach ($events as $event) {
        foreach ($event->filters()->toData() as $filter)
            $filters[] = $filter;
    }
    $filters = array_unique($filters);

    return [
        'events' => $events,
        'filters' => $filters
    ];
};
