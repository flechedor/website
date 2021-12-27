<?php
return function($kirby, $pages, $page) {

    $alert = null;
    $success = false;
    $data = false;

    if($kirby->request()->is('POST') && get('submit')) {

        $token = get('csrf');
				$csrf = csrf($token);
				_debug([
					'confirm' => get('confirm'),
					'token' => $token,
					'session_token' => $kirby->session()->get('kirby.csrf'),
					'csrf_test' => $csrf
				]);
        if(!empty(get('confirm')) || !$csrf) {
            go($page->url());
            exit;
        }

        $data = [
            'name'  => get('name'),
            'email' => get('email'),
            'phone'  => get('phone'),
            'postal'  => get('postal'),
        ];

        $rules = [
            'name'  => ['required', 'match' => '/^[\p{L}\p{Nd}\s]+$/ui'],
            'email' => ['required', 'email'],
            'phone'  => ['required', 'match' => '/^[0-9(). +-]{10,25}$/'],
            'postal' => ['required', 'match' => '/^[0-9]{5}$/'],
        ];

        $messages = [
            'name'  => 'Vos noms et prénoms contiennent des caractères incorrects.',
            'email' => 'L\'adresse email est incorrecte.',
            'phone'  => 'Le numéro de téléphone est incorrect.',
            'postal'  => 'Le code postal est incorrect.',
        ];

        // some of the data is invalid
        if($invalid = invalid($data, $rules, $messages)) {
            $alert = $invalid;

            // the data is fine, let's send the email
        } else {

            require dirname(__FILE__).'/../libs/cryptor.class.php';
            $cryptor = new Cryptor(option('secret'));
            $file = $kirby->root('benevoles').'/base.db';

            if(file_exists($file)) {
                $crypted = file_get_contents($file);
                $csv = unserialize($cryptor->decrypt($crypted));
            } else {
                $csv = [
                    ['Nom/Prénom', 'Email', 'Téléphone', 'Code postal', 'Date/Heure']
                ];
            }
            $csv[] = [
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['postal'],
                date('Y-m-d H:i')
            ];

            $crypted = $cryptor->encrypt(serialize($csv));

            $fp = fopen($file, 'w');
            fwrite($fp, $crypted);
            fclose($fp);

            try {
                $from = $to = $page->mailto()->toString();

                $kirby->email([
                    'template' => 'benevoles',
                    'from'     => $from,
                    'replyTo'  => $data['email'],
                    'to'       => $to,
                    'subject'  => 'Formulaire bénévoles',
                    'data'     => $data
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