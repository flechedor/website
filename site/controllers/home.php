<?php

return function($page, $pages, $kirby)
{
    $events = page('agenda')->children()->listed()->filterBy('fin', 'date >=', date('Y-m-d'))->sortBy('debut', 'asc')->limit(3);

    $reservations = [
        'avec réservation' => [
            'text' => "Réservation",
            'class' => 'resa'
        ],
        'complet' => [
            'text' => "Complet !",
            'class' => 'alert'
        ],
        'annulé' => [
            'text' => "Annulé...",
            'class' => 'rip'
        ]
    ];

    return [
        'events' => $events,
        'reservations' => $reservations
    ];
};