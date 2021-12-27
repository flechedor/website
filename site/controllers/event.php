<?php

return function($kirby, $pages, $page)
{
    $all_filters = page('agenda')->filters()->toStructure();
    $filters = [];
    foreach($page->filters()->toData() as $filter) {
        foreach($all_filters as $f) {
            if($filter == $f->name()) {
                $filters[] = $f;
                continue;
            }
        }
    }

    $reservations = [
        'avec réservation' => [
            'text' => "Réservation requise",
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

    $resa = $page->reservations()->value();

    return [
        'filters' => $filters,
        'resa' => $resa,
        'reservations' => $reservations
    ];
};