<?php
require_once('vendor/autoload.php');

// Calculate Fridays
$given_year = strtotime("1 January 2018");
$for_start = strtotime('Friday', strtotime("1 January 2018"));
$for_end = strtotime('+1 year', strtotime("1 January 2027"));
$fridays = [];
for ($i = $for_start; $i <= $for_end; $i = strtotime('+1 week', $i)) {
    // if the date is friday add it to the array
    if (date('l', $i) == 'Friday') {
        $fridays[] = date('Y-m-d', $i);
    }
}

// MP3 array
$mp3s = (parseS3cmdLs('downloads/mp3/mp3.txt'));
$pdfs = (parseS3cmdLs('downloads/pdf/pdf.txt'));
$docs = (parseS3cmdLs('downloads/doc/doc.txt'));
$sermons = [];
prep($mp3s, 'mp3', $fridays, $sermons);
prep($docs, 'doc', $fridays, $sermons);
prep($pdfs, 'pdf', $fridays, $sermons);

$sources = [
    ['name' => 'General Authority of Islamic Affairs and Endowments, UAE', 'handle' => 'uae-awqaf', 'years' => [2015, 2016, 2018, 2019, 2020, 2021, 2022, 2023, 2024]]
];
$languages  = [
    ['code' => 'ur', 'name' => 'Urdu'],
    ['code' => 'ar', 'name' => 'Arabic'],
    ['code' => 'en', 'name' => 'English'],
    ['code' => 'es', 'name' => 'Spanish'],
];

foreach($sermons as $year => $type) {
    foreach ($type as $t => $month) {
        foreach ($month as $m => $s) {
            $sermons[$year][$t][$m] = array_values( $sermons[$year][$t][$m]);
        }
    }
}

// Normalise
$years = [2015, 2016, 2018, 2019, 2020, 2021, 2022, 2023, 2024];
$months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

// Now let's write the files
// By year.
!is_dir("api/uae-awqaf/") ? mkdir("api/uae-awqaf/"): "";
!is_dir ("yaml/uae-awqaf/") ? mkdir("yaml/uae-awqaf/") : "";
foreach ($years as $year) {
    !is_dir("api/uae-awqaf/$year") ? mkdir("api/uae-awqaf/$year") : "";
    !is_dir("yaml/uae-awqaf/$year") ? mkdir("yaml/uae-awqaf/$year") : "";
    foreach ($months as $month) {
        !is_dir("api/uae-awqaf/$year/$month") ? mkdir("api/uae-awqaf/$year/$month") : "";
        !is_dir("yaml/uae-awqaf/$year/$month") ? mkdir("yaml/uae-awqaf/$year/$month") : "";
    }
    if (isset($sermons[$year]['friday'])) {
        foreach($sermons[$year]['friday'] as $m => $x) {
            // Append month details
            $sermons[$year]['friday'][$m]['sermons'] = $sermons[$year]['friday'][$m];
            $sermons[$year]['friday'][$m]['month'] = $sermons[$year]['friday'][$m][0]['date']['month'];
            foreach ($sermons[$year]['friday'][$m] as $k => $v) {
                if ($k !== 'month' && $k !== 'sermons') {
                    unset($sermons[$year]['friday'][$m][$k]);
                }
            }
            file_put_contents("api/uae-awqaf/$year/$m/friday.json", json_encode($sermons[$year]['friday'][$m]));
            file_put_contents("yaml/uae-awqaf/$year/$m/friday.yml", \Symfony\Component\Yaml\Yaml::dump($sermons[$year]['friday'][$m]));
        }
        file_put_contents("api/uae-awqaf/$year/friday.json", json_encode(array_values($sermons[$year]['friday'])));
        file_put_contents("yaml/uae-awqaf/$year/friday.yml", \Symfony\Component\Yaml\Yaml::dump(array_values($sermons[$year]['friday'])));
    }
    if (isset($sermons[$year]['other'])) {
        foreach($sermons[$year]['other'] as $m => $x) {
            $sermons[$year]['other'][$m]['sermons'] = $sermons[$year]['other'][$m];
            $sermons[$year]['other'][$m]['month'] = $sermons[$year]['other'][$m][0]['date']['month'];
            foreach ($sermons[$year]['other'][$m] as $k => $v) {
                if ($k !== 'month' && $k !== 'sermons') {
                    unset($sermons[$year]['other'][$m][$k]);
                }
            }
            file_put_contents("api/uae-awqaf/$year/$m/other.json", json_encode($sermons[$year]['other'][$m]));
            file_put_contents("yaml/uae-awqaf/$year/$m/other.yml", \Symfony\Component\Yaml\Yaml::dump($sermons[$year]['other'][$m]));
        }
        file_put_contents("api/uae-awqaf/$year/other.json", json_encode(array_values($sermons[$year]['other'])));
        file_put_contents("yaml/uae-awqaf/$year/other.yml", \Symfony\Component\Yaml\Yaml::dump(array_values($sermons[$year]['other'])));
    }
    if (isset($sermons[$year])) {
        foreach ($sermons[$year] as $st => $sb) {
            //$sermons[$year][$st]['type'] = $st;
            foreach ($sermons[$year][$st] as $mx => $mk) {
                file_put_contents("api/uae-awqaf/$year/$mx.json", json_encode([$mk]));
                file_put_contents("yaml/uae-awqaf/$year/$mx.yml", \Symfony\Component\Yaml\Yaml::dump([$mk]));
                $sermons[$year][] = $mk;
                unset($sermons[$year][$st]);
            }
        }
        file_put_contents("api/uae-awqaf/$year.json", json_encode(array_values($sermons[$year])));
        file_put_contents("yaml/uae-awqaf/$year.yml", \Symfony\Component\Yaml\Yaml::dump(array_values($sermons[$year])));
    }
}

file_put_contents("api/sources.json", json_encode($sources));
file_put_contents("yaml/sources.yml", \Symfony\Component\Yaml\Yaml::dump($sources));
file_put_contents("api/languages.json", json_encode($languages));
file_put_contents("yaml/languages.yml", \Symfony\Component\Yaml\Yaml::dump($languages));

function parseS3cmdLs(string $file): array
{
    $result = [];
    $data = file_get_contents($file);
    $line = explode("\n", $data);
    foreach ($line as $l) {
        $segments = explode(" ", $l);
        foreach ($segments as $key => $segment) {
            if ($segment === "") {
                unset($segments[$key]);
            }
        }
        $segments = array_values($segments);
        if (isset($segments[3]) && str_contains($segments[3], 's3://')) {
            $result[] = $segments[3];
        }
        // Each result array contains, in the order:
        // Upload date, upload time, size, s3url
    }

    return $result;
}

function prep($fx, $format, $fridays, &$sermons) {
    $source = 'uae-awqaf';
    foreach($fx as $file) {
        if (strpos($file, '.mp3') !== false || strpos($file, '.docx') !== false ||  strpos($file, '.doc') !== false || strpos($file, '.pdf') !== false) {
            $parts = explode("/", $file);
            $partsTotal = count($parts);
            //$df = $parts[2];
            $dx = explode("-", $parts[$partsTotal - 1]);
            $datex = $dx[0] . '-' . $dx[1] . '-' . $dx[2];
            $lang = $dx[3];
            //var_dump($file);
            $title = trim(str_replace("_", " ", explode('.', $dx[4])[0]));
            $url = "https://cdn.islamic.network/sermons/uae-awqaf/$format/" . $parts[$partsTotal - 1];
            $date = DateTime::createFromFormat('Y-m-j', $datex, new DateTimeZone('Asia/Dubai'));
            if (!$date) {
                var_dump($datex);
                continue;
            }
            $dateObj = [
                'iso8601' => $date->format('c'),
                'month' => ['name' => $date->format('F'), 'shortname' => $date->format('M'), 'number' => $date->format('m')],
                'day' => ['name' => $date->format('l'), 'shortname' => $date->format('D'), 'number' => $date->format('d')],
                'year' => $date->format('Y')
            ];
            if (in_array($datex, $fridays)) {
                // Friday sermon
                if (isset($sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)])) {
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['editions'][] = [
                        'language' => $lang,
                        'format' => $format,
                        'url' => $url
                    ];

                } else {
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['title'] = $title;
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['date'] = $dateObj;
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['type'] = 'friday';
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['source'] = $source;
                    $sermons[$date->format('Y')]['friday'][$date->format('m')][md5($title)]['editions'][] = [
                        'language' => $lang,
                        'format' => $format,
                        'url' => $url
                    ];
                }
            } else {
                // Other / Eid sermon
                if (isset($sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)])) {
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['editions'][] = [
                        'language' => $lang,
                        'format' => $format,
                        'url' => $url
                    ];
                } else {
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['title'] = $title;
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['date'] = $dateObj;
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['type'] = 'other';
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['source'] = $source;
                    $sermons[$date->format('Y')]['other'][$date->format('m')][md5($title)]['editions'][] = [
                        'language' => $lang,
                        'format' => $format,
                        'url' => $url
                    ];
                }
            }
        }
    }
}
