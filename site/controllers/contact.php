<?php
return function ($kirby, $pages, $page) {

    $alert = null;
    $success = false;
    $data = false;
    if ($kirby->request()->is('POST')) {

        $token = get('csrf');
        if (!empty(get('confirm')) || csrf($token) !== true) {
            go($page->url());
            exit;
        }

        $data = [
            'name'  => get('name'),
            'email' => get('email'),
            'text'  => get('text')
        ];

        $rules = [
            'name'  => ['required', 'min' => 2],
            'email' => ['required', 'email'],
            'text'  => ['required', 'min' => 3, 'max' => 3000],
        ];

        $messages = [
            'name'  => 'Veuillez entrer un nom valide.',
            'email' => 'L\'adresse email est incorrecte.',
            'text'  => 'Veuillez entrer un texte entre 3 et 3000 caractères.'
        ];


        if ($invalid = invalid($data, $rules, $messages)) {
            // some of the data is invalid
            $alert = $invalid;
        } else {
            // the data is fine, let's send the email
            try {
                $dest = $page->mailto()->toStructure();
                foreach ($dest as $d) {
                    if (trim(strtolower($d->pole())) === "contact") {
                        $to = $d->email()->toString();
                    }
                }
                $from = $page->mailfrom()->toBool() === true ? $data['email'] : $to;

                $kirby->email([
                    'template' => 'contact',
                    'from'     => $from,
                    'replyTo'  => $data['email'],
                    'to'       => $to,
                    'subject'  => esc($page->subject()),
                    'data'     => [
                        'text'   => esc($data['text']),
                        'sender' => esc($data['name']),
                        'from'  => esc($data['email'])
                    ]
                ]);
            } catch (Exception $error) {
                $alert['error'] = "Le formulaire n'a pas pu être envoyé. $error";
            }

            // no exception occured, let's send a success message
            if (empty($alert)) {
                $success = true;
                $data = false;
            }
        }
    }

    return [
        'alert'   => $alert,
        'data'    => $data,
        'success' => $success
    ];
};
