<?php
namespace Yaseek;

class Instagram {

    const API_URI = 'https://api.instagram.com/v1';
    const CURL_TIMEOUT = 10;
    const MAX_DEFAULT_ITEMS = 50;
    const CACHE_DURATION = 3600;

    private $clientId;

    public $cache;

    public function __construct($clientId, $cache) {
        $this->clientId = $clientId;
        $this->cache = $cache;
    }

    private function request($url, $queryObj = FALSE) {
        if (!is_array($queryObj)) {
            $queryObj = array();
        }
        $queryObj['client_id'] = $this->clientId;
        //$this->cache->saveData('queryObj', $queryObj);
        $fullurl = self::API_URI . $url . "?" . http_build_query($queryObj);
        //$this->cache->saveData('fullurl', $fullurl);
        $key = md5($fullurl);

        $answer = $this->cache->getData($key);
        if ($answer) {
            return $answer;
        } else {
            if (extension_loaded('curl')){
                $ch = curl_init($fullurl);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);
                $answer = curl_exec($ch);
                curl_close($ch);
            } elseif(ini_get('allow_url_fopen') AND extension_loaded('openssl')){
                $answer = file_get_contents($fullurl);
            };
            $this->cache->saveData($key, $answer);
            return $answer;
        }
    }

    public function tagsSearchByName($tag) {
        return $this->request('/tags/search', array('q'=>$tag));
    }

    // OPTIONAL QUERY PARAMETERS: COUNT, MIN_TAG_ID, MAX_TAG_ID
    public function tagsGetMarkedMedia($tag, $query = FALSE) {
        //$this->cache->saveData('testQuery', $query);
        if (!is_array($query)) {
            $query = array('count' => self::MAX_DEFAULT_ITEMS);
        }
        
        $url = sprintf("/tags/%s/media/recent", urlencode($tag));
        return $this->request($url, $query);
    }
}