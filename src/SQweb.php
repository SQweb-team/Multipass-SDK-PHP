<?php
/*
 * SQweb PHP SDK
 * @author Pierre Lavaux <pierre@sqweb.com>
 * @author Bastien Botella <bastien@sqweb.com>
 * @link https://github.com/SQweb-team/SQweb-SDK-PHP
 * @license http://opensource.org/licenses/GPL-3.0
 */

namespace SQweb;

class SQweb
{

    private $response;

    public function __construct()
    {
        $conf = 'define';
        if (file_exists(__DIR__.'/../../../../.env')) {
            $env = new \Dotenv\Dotenv(__DIR__.'/../../../..');
            $env->load();
            $conf = 'dotenv';
        }
        self::config($conf);
    }

    public function config($opt)
    {
        if ($opt == 'dotenv') {
            $this->SQW_ID_SITE = getenv('SQW_ID_SITE');
            $this->SQW_DEBUG = getenv('SQW_DEBUG');
            $this->SQW_TARGETING = getenv('SQW_TARGETING');
            $this->SQW_BEACON = getenv('SQW_BEACON');
            $this->SQW_DWIDE = getenv('SQW_DWIDE');
            $this->SQW_LANG = getenv('SQW_LANG');
            $this->SQW_MESSAGE = getenv('SQW_MESSAGE');
        } elseif ($opt == 'define') {
            $file = file_get_contents(__DIR__.'/../../sqweb_config');
            $opts = explode(PHP_EOL, $file);
            foreach ($opts as $value) {
                $tmp = explode('=', $value);
                $key = $tmp[0];
                $this->$key = $tmp[1];
            }
        }
    }

    /**
     * Query the API for auth and credits status.
     * Returns the credits, or 0.
     * @return int
     */
    public function checkCredits()
    {
        if (empty($this->response)) {
            $site_id = null;
            if (defined('ID_SITE')) {
                $site_id = ID_SITE;
            }
            if (isset($_COOKIE['sqw_z']) && null !== $site_id) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.sqweb.com/token/check',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT_MS => 1000,
                    CURLOPT_TIMEOUT_MS => 1000,
                    CURLOPT_USERAGENT => 'SQweb/SDK 1.0.4',
                    CURLOPT_POSTFIELDS => array(
                        'token' => $_COOKIE['sqw_z'],
                        'site_id' => $site_id,
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $this->response = json_decode($response);
            }
        }
        if ($this->response !== null && $this->response->status === true && $this->response->credit > 0) {
            return ($this->response->credit);
        }
        return (0);
    }

    public function script()
    {
        echo '<script>
            var _sqw = {
                id_site: '. $this->SQW_ID_SITE .',
                debug: '. $this->SQW_DEBUG .',
                targeting: '. $this->SQW_TARGETING .',
                beacon: '. $this->SQW_BEACON .',
                dwide: '. $this->SQW_DWIDE .',
                i18n: "'. $this->SQW_LANG .'",
                msg: "'. $this->SQW_MESSAGE .'"};
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "//cdn.sqweb.com/sqweb-beta.js";
        document.getElementsByTagName("head")[0].appendChild(script);</script>';
    }

    /**
     * Create the target button div.
     * @param null $color
     */
    public function button($color = null)
    {
        if ('grey' === $color) {
            echo '<div class="sqweb-button sqweb-grey"></div>';
        } else {
            echo '<div class="sqweb-button"></div>';
        }
    }
}
