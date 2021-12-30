<?php
Kirby::plugin('seb/flechedor', [
    'fieldMethods' => [
        'boolToStr' => function ($field) {
            return $field->isTrue() ? "oui" : "non";
        }
    ],
    'hooks' => []
]);
