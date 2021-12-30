<?php

use Kirby\Cms\Page;

class EventPage extends Page
{

    public function formatDate()
    {
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR');
        $start = $this->content()->get('debut');
        $end = $this->content()->get('fin');
        if ($end->toDate() > $start->toDate()) {
            if ($start->toDate('%m') == $end->toDate('%m')) {
                $date = "Du " . $start->toDate('%d') . " au " . $end->toDate('%d') . " " . $start->toDate('%B %Y');
            } else {
                if ($start->toDate('%Y') == $end->toDate('%Y')) {
                    $date = "Du " . $start->toDate('%d') . " " . $start->toDate('%B') . " au " . $end->toDate('%d') . " " . $end->toDate('%B %Y');
                } else {
                    $date = "Du " . $start->toDate('%d') . " " . $start->toDate('%B %Y') . " au " . $end->toDate('%d') . " " . $end->toDate('%B %Y');
                }
            }
        } else {
            $date = utf8_encode($start->toDate('%A %d %B %Y'));
            $tmp = explode(' ', $date);
            $tmp[0] = '<span class="day">' . $tmp[0] . '</span>';
            $date = join(' ', $tmp);
        }

        if ($this->content()->get('showtime')->toBool()) {
            if ($this->content()->get('closetime')->isNotEmpty()) {
                $date .= '<small class="time">De ' . $this->content()->get('opentime')->toDate('%H:%M') . ' à ' . $this->content()->get('closetime')->toDate('%H:%M') . '</small>';
            } else {
                $date .= '<small class="time">À partir de ' . $this->content()->get('opentime')->toDate('%H:%M') . '</small>';
            }
        }

        return htmlspecialchars($date);
    }

    public function monthDate()
    {
        $start = $this->content()->get('debut');
        $fmt = new \IntlDateFormatter('fr_FR', 0, 0);
        $fmt->setPattern('MMMM yyyy');
        return $fmt->format($start->toDate());
    }
}
