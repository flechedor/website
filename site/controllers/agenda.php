<?php

use Kirby\Toolkit\Str;

return function($kirby, $pages, $page)
{
    $request = $kirby->request();

    if(empty($request->get('section')) || !in_array($request->get('section'), ['prochainement', 'archives'])) {
        $section = 'prochainement';

    } else {
        $section = $request->get('section');
    }

    if($section == 'prochainement') {
        $events = $page->children()->listed()->filterBy('fin', 'date >=', date('Y-m-d'))->sortBy('debut', 'asc');
    } else {
        $events = $page->children()->listed()->filterBy('fin', 'date <', date('Y-m-d'))->sortBy('fin', 'desc');
    }

    $filters = [];
    foreach($page->filters()->toStructure() as $filter) {
        $p = $events->filter(function($event) use (&$filter) {
            if(strpos($event->filters()->toString(), $filter->name()->value()) !== false) {
                return true;
            } else {
                return false;
            }
        });
        if($p->count()) {
            $filters[$filter->name()->value()] = $filter->color()->value();
        }
    }
    if(!empty($request->get('filter')) && array_key_exists($request->get('filter'), $filters)) {
        $filter = $request->get('filter');
        $events = $events->filter(function ($event) use (&$filter, &$filters) {
            if($event->filters()->isEmpty()) return false;
            $event_filters = $event->filters()->toData();
            foreach($event_filters as $event_filter) {
                if($filter === $event_filter) {
                    return true;
                }
            }
            return false;
        });
    } else {
        $filter = '';
    }

    if(!empty($request->get('resa')) && in_array($request->get('resa'), ["avec réservation","sans réservation"])) {
        $resa = $request->get('resa');
        $p = $events->filter(function($event) use ($resa) {
           return $event->reservations()->value() == $resa;
        });
        if($p->count()) {
            $events = $p;
        } else {
            $resa = '';
        }
    } else {
        $resa = '';
    }

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
        'filters' => $filters,
        'filter' => $filter,
        'section' => $section,
        'resa' => $resa,
        'reservations' => $reservations,
    ];
};
