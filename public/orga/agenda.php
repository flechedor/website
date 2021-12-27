<?php

function dd($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	exit();
}

$your_google_calendar="https://calendar.google.com/calendar/embed?wkst=2&bgcolor=%23ffffff&ctz=Europe%2FParis&src=ZmxlY2hlLmNvbnRhY3RAZ21haWwuY29t&src=ZnIuZnJlbmNoI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%230B8043&showTitle=0&showNav=1&showPrint=0&showTabs=1&showCalendars=1&showTz=0";

/*$your_google_calendar = "https://calendar.google.com/calendar/embed?wkst=2&amp;bgcolor=%23ffffff&amp;ctz=Europe%2FParis&amp;src=ZmxlY2hlLmNvbnRhY3RAZ21haWwuY29t&amp;src=Y2xiMXIyYTR2N2hlMWZoMHRlazllMWQ5dWdAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=bWw5dGxtOWVrMWNscHZqZGYycG5qMTZqdW9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=ZHFzdGFyazd2aGxpNGFxMjNwa2Q2OHYyNTBAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=ZnIuZnJlbmNoI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;color=%23039BE5&amp;color=%237986CB&amp;color=%23A79B8E&amp;color=%23F09300&amp;color=%230B8043&showTitle=0&showNav=1&showPrint=0&showTabs=1&showCalendars=1&showTz=0";*/

$your_google_calendar = "https://calendar.google.com/calendar/embed?wkst=2&bgcolor=%23ffffff&ctz=Europe%2FParis&src=ZmxlY2hlLmNvbnRhY3RAZ21haWwuY29t&src=Y2xiMXIyYTR2N2hlMWZoMHRlazllMWQ5dWdAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=bWw5dGxtOWVrMWNscHZqZGYycG5qMTZqdW9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=ZHFzdGFyazd2aGxpNGFxMjNwa2Q2OHYyNTBAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=ZnIuZnJlbmNoI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%237986CB&color=%23A79B8E&color=%23F09300&color=%230B8043&showTitle=0&showNav=1&showPrint=0&showTabs=1&showCalendars=1&showTz=0";

$url= parse_url($your_google_calendar);
$google_domain = $url['scheme'].'://'.$url['host'];

// Load and parse Google's raw calendar
$dom = new DOMDocument;
$dom->loadHTMLFile($your_google_calendar);

// Change Google's JS file to use absolute URLs
$scripts = $dom->getElementsByTagName('script');

foreach ($scripts as $script) {
	$js_src = $script->getAttribute('src');

	if ($js_src) {
		$parsed_js = parse_url($js_src, PHP_URL_HOST);
		if (!$parsed_js) {
			$script->setAttribute('src', $google_domain . $js_src);      
		}
	}
}

$styles_links = $dom->getElementsByTagName('link');
foreach($styles_links as $style_link) {
	$href = $style_link->getAttribute('href');
	if($href) {
		$parsed_css = parse_url($href, PHP_URL_HOST);
		if(!$parsed_css) {
			$style_link->setAttribute('href', $google_domain . $href);
		}
	}
}

// Create a link to a new CSS file
$roboto_css = $dom->createElement('link');
$roboto_css->setAttribute('type', 'text/css');
$roboto_css->setAttribute('rel', 'stylesheet');
$roboto_css->setAttribute('href', 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');

$agenda_css = $dom->createElement('link');
$agenda_css->setAttribute('type', 'text/css');
$agenda_css->setAttribute('rel', 'stylesheet');
$agenda_css->setAttribute('href', 'css/agenda.css');
// Append this link at the end of the head
$head = $dom->getElementsByTagName('head')->item(0);
$head->appendChild($roboto_css);
$head->appendChild($agenda_css);

// Remove old stylesheet
/*$oldcss = $dom->documentElement;
$link = $oldcss->getElementsByTagName('link')->item(0);
$head->removeChild($link);*/

// Export the HTML
echo $dom->saveHTML();
