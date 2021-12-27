<?php
Kirby::plugin('seb/flechedor', [
    'fieldMethods' => [
        'toColors' => function($field) {
            $names = array_map('trim', explode(',', $field->value));
            $colors = [];
            $filters = $field->model()->parent()->filters()->toStructure();
            foreach($names as $name) {
                foreach($filters as $filter) {
                    if($filter->name() == $name) {
                        $colors[] = $filter->color();
                    }
                }
            }
            $field->value = '<ul class="tags-colors">';
            foreach($colors as $color) {
                $field->value .= '<li style="background-color: '.$color.'"></li>';
            }
            $field->value .= '</ul>';
            return $field;
        },
        'boolToStr' => function($field) {
             return $field->isTrue() ? "oui" : "non";
        }
    ],
    'hooks' => [

    ]
]);