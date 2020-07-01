<?php

require_once dirname(dirname(__FILE__)) . '/gifnoc/config.php';

class Core
{
    public $config;

    public function getConfig()
    {
        global $config;
        $this->config = $config;
    }
}
