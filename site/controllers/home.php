<?php

return function ($page, $pages, $kirby) {
    $events = page('agenda')->children()->listed()
        ->filterBy('fin', 'date >=', date('Y-m-d'))
        ->sortBy('debut', 'asc')
        ->limit(4);

    return [
        'events' => $events
    ];
};
