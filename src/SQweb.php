<?php
/*
 * SQweb PHP SDK
 * @link https://github.com/SQweb-team/SQweb-SDK-PHP
 * @license http://opensource.org/licenses/GPL-3.0
 */

/**
 * Usage:
 * <code>
 * $sqweb = new \SQweb\SQweb();
 * $sqweb = new \SQWeb\SQweb(['SQW_ID_SITE'=>1234]);
 *
 * $sqweb->script(); // outputs <script...>
 * $sqweb->button(); // outputs <img src....>
 * </code>
 */
namespace SQweb;

class SQweb
{

    private $response;

    private $SQW_ID_SITE = null;
    private $SQW_DEBUG = 'false';
    private $SQW_TARGETING = 'false';
    private $SQW_BEACON = 'false';
    private $SQW_DWIDE = 'false';
    private $SQW_LANG = 'en';
    private $SQW_MESSAGE = '';

    /**
     * @param array $config (optional) with keys matcing the SQW_* class attributes.
     */
    public function __construct($config = array())
    {
        $this->loadConfig($config);
    }

    private function loadConfig($config = array())
    {
        // Pass in an array
        $config_keys = [
            'SQW_ID_SITE',
            'SQW_DEBUG',
            'SQW_TARGETING',
            'SQW_BEACON',
            'SQW_DWIDE',
            'SQW_LANG',
            'SQW_MESSAGE'
        ];

        if (!empty($config)) {
            if (empty($config['SQW_ID_SITE'])) {
                throw new InvalidArgumentException('SQW_ID_SITE MUST be defined.');
            }
            foreach($config_keys as $key) {
                if (array_key_exists($key, $config)) {
                    $this->$key = $config[$key];
                }
            }
            return true;
        }
        // Or use dotenv
        if (file_exists(__DIR__ . '/../../../../.env')) {
            $env = new \Dotenv\Dotenv(__DIR__ . '/../../../..');
            $env->required('SQW_ID_SITE')->notEmpty();
            $env->load();
            foreach ($config_keys as $key) {
                $this->$key = getenv($key);
            }
            return true;
        }
        // Or fallback to looking for sqweb_config.php
        if (file_exists(__DIR__ . '/../../sqweb_config.php')) {
            $lines = file(__DIR__ . '/../../sqweb_config.php');
            foreach ($lines as $line) {
                $tmp = explode('=', $value);
                $key = $tmp[0];
                if(in_array($key, $config_keys)) {
                    $this->$key = $tmp[1];
                }
            }
            return true;
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
            $site_id = $this->SQW_ID_SITE;
            if (isset($_COOKIE['sqw_z']) && null !== $site_id) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.sqweb.com/token/check',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT_MS => 1000,
                    CURLOPT_TIMEOUT_MS => 1000,
                    CURLOPT_USERAGENT => 'SQweb/SDK 1.1',
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
