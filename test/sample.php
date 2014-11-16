<?php

require_once dirname( __DIR__ ) . '/lib/class.instagram.php';

$instagram = new Yaseek\Instagram(
    "c1b6b219a7e942cf891a8274126831f2", __DIR__ . '/cache');

$instagram->cache->
    saveData('TAGS', json_decode($instagram->tagsGetMarkedMedia('coffeelike')));
