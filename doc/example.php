<?php

use Zemanta\Zemanta;
use Zemanta\Response;

// Config
$key    = 'your api here';
$text   = 'The Phoenix Mars Lander has successfully deployed its robotic arm and
           tested other instruments including a laser designed to detect dust,
           clouds, and fog. The arm will be used to dig up samples of the Martian
           surface which will be analyzed as a possible habitat for life';

// API
$zemanta = new Zemanta($key);
$response = $zemanta->api(Zemanta::METHOD_SUGGEST, $text);

echo $response->getFormat()  . ' => ' . $response->getBody();