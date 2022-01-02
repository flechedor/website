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

    // group by month
    $groupedEvents = [];
    foreach ($events as $event) {
        $month = $event->formatedMonth();
        if (!array_key_exists($month, $groupedEvents)) $groupedEvents[$month] = [];
        $groupedEvents[$month][] = $event;
    }

    return [
        'groupedEvents' => $groupedEvents,
    ];
};
