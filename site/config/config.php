<?php
/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen. 
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
use Kirby\Exception\DuplicateException;
use Kirby\Toolkit\Str;
use distantnative\Retour\Redirects;
use Kirby\Cms\Dir;
use Kirby\Cms\Response;

$debug = true;

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

return [
    'debug' => $debug,
    'panel' => [
        'slug' => 'backo',
        'css' => 'assets/css/panel/custom-panel.css'
    ],
    'hooks' => [
        'page.event.create:after' => function($page) {
            //debug('page.event.create:after');
            if($page->finadd()->isEmpty() || $page->debutadd()->toDate() > $page->finadd()->toDate()) {
                $debut = $fin = $page->debutadd();
                $recurrent = false;
            } else {
                $debut = $page->debutadd();
                $fin = $page->finadd();
                $recurrent = $page->recurrentadd()->toBool();
            }

            $page = $page->save([
                'eventid' => bin2hex(random_bytes(16)),
                'slug' => null,
                'debut' => $debut->toDate('%Y-%m-%d'),
                'fin' => $debut->toDate('%Y-%m-%d'),
                'recurrent' => $recurrent ? 'true' : 'false',
                'created' => date(DATE_ATOM),
                'updated' => date(DATE_ATOM)
            ]);

            if($recurrent && $page->interval()->toInt() > 0 && $debut->toDate() < $fin->toDate()) {
                $start = new DateTime($debut->toDate('%Y-%m-%d'));
                $end = new DateTime($fin->toDate('%Y-%m-%d'));
                $end = $end->modify('+1 day');
                $interval = new DateInterval('P'.$page->interval()->toInt().'D');
                $period = new DatePeriod($start, $interval, $end,DatePeriod::EXCLUDE_START_DATE);
                foreach($period as $date)
                {
                    $p = $page->duplicate($date->format('Y-m-d').'-'.Str::slug($page->title()));
                    $p->save([
                        'debut' => $date->format('Y-m-d'),
                        'fin' => $date->format('Y-m-d'),
                        'updated' => date(DATE_ATOM),
                        'recurrent' => $recurrent ? 'true' : 'false'
                    ]);
                }
            }

            try {
                $page->changeSlug($debut->toDate('%Y-%m-%d')."-".Str::slug($page->title()));
            } catch(DuplicateException $e) {
                $page->delete(true);
            }
        },
        'page.event.changeTitle:after' => function($newPage, $oldPage) {
            //debug('page.event.changeTitle:after');
            if($newPage->title() != $oldPage->title()) {
                $newPage->save([
                    'updated' => date(DATE_ATOM)
                ]);
            }
        },
        'page.event.changeSlug:after' => function($newPage, $oldPage) {
            //debug('page.event.changeSlug:after');
            if($newPage->slug() != $oldPage->slug() && $newPage->isPublished()) {
                Redirects::write([
                    'status' => '301',
                    'from' => 'agenda/'.$oldPage->slug(),
                    'to' => site()->url().'/agenda/'.$newPage->slug()
                ]);

                $newPage->save([
                    'updated' => date(DATE_ATOM)
                ]);
            }
        },
        'page.event.update:after' => function($newPage, $oldPage)
        {
            //debug('page.event.update:after');
            if($newPage->fin()->toDate() < $newPage->debut()->toDate()) {
                $newPage = $newPage->save([
                   'fin' =>  $newPage->debut()->toDate('%Y-%m-%d')
                ]);
            }
            if($newPage->recurrent()->isTrue() && $newPage->copyContent()->isTrue()) {
                $events = $newPage->parent()->childrenAndDrafts()->search($newPage->eventid(), 'eventid');
                foreach($events as $event) {
                    if($event != $newPage && !$event->isPublished()) {
                        $date = $event->debut();
                        $event->delete(true);
                        $duplicate = $newPage->duplicate($date->toDate('%Y-%m-%d')."-".Str::slug($newPage->title()), ['files' => true]);
                        $duplicate->save([
                            'debut' => $date->toDate('%Y-%m-%d'),
                            'fin' => $date->toDate('%Y-%m-%d'),
                            'copyContent' => 'false',
                            'updated' => date(DATE_ATOM)
                        ]);
                    }
                }
            }
            $newPage->save([
                'copyContent' => 'false',
                'updated' => date(DATE_ATOM)
            ]);
        },
        'page.event.changeStatus:after' => function($newPage, $oldPage)
        {
            //debug( 'page.event.changeStatus:after');
            if($newPage->recurrent()->isTrue()) {
                $pages = page('agenda')->childrenAndDrafts()->filter(function($page) use (&$newPage) {
                    return $page->debut()->toDate() > time() && $page->eventid()->value() == $newPage->eventid()->value();
                });
                $status = false;
                if($newPage->isPublished() && $newPage->publishOthers()->isTrue()) {
                    $status = 'listed';
                } else if($newPage->isDraft() && $newPage->unpublishOthers()->isTrue()) {
                    $status = 'draft';
                }
                if($status) {
                    $drafts = $newPage->contentFileDirectory().DIRECTORY_SEPARATOR.'..';
                    $i = $newPage->num() + 1;
                    debug('pages count:', $pages->count(), $status);
                    foreach ($pages as $page) {
                        $folder = $page->contentFileDirectory();
                        $page = $page->save([
                            'publishOthers' => 'false',
                            'unpublishOthers' => 'false',
                            'published' => $status == 'listed' ? 'true' : 'false',
                            'updated' => date(DATE_ATOM)
                        ]);
                        if($page->status() !== $status) {
                            if($status == 'listed') {
                                $page = $page->changeStatus($status);
                                $page->changeNum($i);
                                $i++;
                            } else if($status == 'draft') {
                                if(Dir::exists($folder)) {
                                    debug('content folder:', $folder);
                                    debug('_drafts folder:', $drafts);
                                    recurse_copy($folder, $drafts.DIRECTORY_SEPARATOR.$page->slug());

                                    Dir::remove($folder);
                                    debug('deleting folder:', $folder);
                                    $tmp = $page->contentFileDirectory();
                                    Dir::remove($tmp);
                                    debug('deleting folder:', $tmp);
                                }
                            }
                        }
                    }
                } else {
                    $newPage->save([
                        'updated' => date(DATE_ATOM)
                    ]);
                }
            } else {
                $newPage->save([
                    'updated' => date(DATE_ATOM)
                ]);
            }
        }
    ],
    'cache' => [
        'pages' => [
            'active' => !$debug, //!$debug,
        ]
    ],
    'date'  => [
        'handler' => 'strftime'
    ],
    'secret' => 'XfvJqYEVoR8vRtVFxpnNX9Hlfh8UUSoV',
];
