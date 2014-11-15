<?php

require_once dirname( __DIR__ ) . '/vendor/autoload.php';
require_once dirname( __DIR__ ) . '/lib/class.instagram.php';

$cache = new Yaseek\Cache( __DIR__ . '/cache', 10);

$instagram = new Yaseek\Instagram(
    "c1b6b219a7e942cf891a8274126831f2", "a09e24112fe9435986048a7d231e625f");
