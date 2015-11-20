<?php

class SQweb {

    /**
     * Send an http request to the api
     * returns true if logged, 0 if not
     * @return int
     */

    public function sqweb_check_credits() {
        $site_id = null;
        if (defined('ID_SITE'))
            $site_id = ID_SITE;
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
        $err = curl_error($curl);
        curl_close($curl);

        $response = json_decode($response);
        if ($response != null && $response->status === true && $response->credit > 0) {
            return ($response->credit);
        }
        return (0);
    }

    public function sqweb_script()
    {
        echo '<script>
        var _sqw = {id_webmaster: '. ID_WEBMASTER .', id_site: '. ID_SITE .', debug: '. DEBUG .', targeting: '. TARGETING .', beacon: '. BEACON .', dwide: '. DWIDE .'};
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "//cdn.sqweb.com/sqweb-beta.js";
        document.getElementsByTagName("head")[0].appendChild(script);</script>';
    }

    public function sqweb_button($color = null)
    {
        if ('grey' === $color) {
            echo '<div class="sqweb-button sqweb-grey"></div>';
        } else {
            echo '<div class="sqweb-button"></div>';
        }
    }
}
