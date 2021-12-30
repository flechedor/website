<?php

use Kirby\Cms\Page;

class EventPage extends Page
{

    public function formatedDate()
    {
        $start = $this->debut();
        $end = $this->fin();
        if ($end->toDate() == $start->toDate()) {
            return "{$this->formatDate($start, 'ccc dd/MM')}";
        } else {
            return "{$this->formatDate($start, 'DD/MM')} - {$this->formatDate($end, 'DD/MM')}";
        }
    }

    public function formatedTime()
    {
        return $this->formatHour($this->opentime());
    }

    public function formatedMonth()
    {
        return $this->formatDate($this->debut(), 'MMMM yyyy');
    }

    private function formatHour($datetime)
    {
        $minutes = $datetime->toDate('%M');
        // Display 17H instead of 17h00
        return $datetime->toDate('%HH') . ($minutes == '00' ? '' : $minutes);
    }

    private function formatDate($date, $format)
    {
        $fmt = new \IntlDateFormatter('fr_FR', 0, 0);
        $fmt->setPattern($format);
        return $fmt->format($date->toDate());
    }
}
