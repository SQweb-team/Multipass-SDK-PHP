<?php

class SQweb
{

    /**
     * Send an http request to the api
     * returns true if logged, 0 if not
     * @return int
     */

    private $response;

    public function sqwebCheckCredits() {
        if (empty($this->response)) {
            $site_id = null;
            if (defined('ID_SITE')) {
                $site_id = ID_SITE;
            }
            if (isset($_COOKIE['sqw_z']) && null !== $site_id) {
                $cookiez = $_COOKIE['sqw_z'];
            } else {
                return (0);
            }
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.sqweb.com/token/check',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT_MS => 1000,
                CURLOPT_TIMEOUT_MS => 1000,
                CURLOPT_POSTFIELDS => array(
                    'token' => $cookiez,
                    'site_id' => $site_id,
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);
            $this->response = $response;
        }
        if ($this->response != null && $this->response->status === true && $this->response->credit > 0) {
            return ($this->response->credit);
        }
        return (0);
    }

    public function sqwebScript()
    {
        echo '<script>
        var _sqw = {id_webmaster: '. ID_WEBMASTER .', id_site: '. ID_SITE .', debug: '. DEBUG .', targeting: '. TARGETING .', beacon: '. BEACON .', dwide: '. DWIDE .', i18n: "'. LANG .'"};
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "//cdn.sqweb.com/sqweb-beta.js";
        document.getElementsByTagName("head")[0].appendChild(script);</script>';
    }

    public function sqwebButton($color = null)
    {
        if ('grey' === $color) {
            echo '<div class="sqweb-button sqweb-grey"></div>';
        } else {
            echo '<div class="sqweb-button"></div>';
        }
    }
}
