<?php

/*
 * SQweb PHP SDK v1.5.9
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
    private $SQW_ADBLOCK_MODAL = 'false';
    private $SQW_TARGETING = 'false';
    private $SQW_BEACON = 'false';
    private $SQW_DWIDE = 'false';
    private $SQW_LANG = 'en';
    private $SQW_SITENAME = '';
    private $SQW_MESSAGE = '';

    /**
     * @param array $config (optional) with keys matching the SQW_* class attributes.
     */
    public function __construct($config = array())
    {
        $this->loadConfig($config);
    }

    private function loadConfig($config = array())
    {
        // Pass in an array
        $config_keys = array(
            'SQW_ID_SITE',
            'SQW_SITENAME',
            'SQW_DEBUG',
            'SQW_ADBLOCK_MODAL',
            'SQW_TARGETING',
            'SQW_BEACON',
            'SQW_DWIDE',
            'SQW_LANG',
            'SQW_MESSAGE'
        );
        if (!empty($config)) {
            if (empty($config['SQW_ID_SITE'])) {
                throw new InvalidArgumentException('SQW_ID_SITE must be defined.');
            }
            foreach ($config_keys as $key) {
                if (array_key_exists($key, $config)) {
                    $this->$key = $config[$key];
                }
            }
            return true;
        }
        // Or use dotenv
        if (file_exists(__DIR__ . '/../../../../.env')) {
            $env = new \Dotenv\Dotenv(__DIR__ . '/../../../..');
            $env->load();
            $env->required('SQW_ID_SITE')->notEmpty();
            foreach ($config_keys as $key) {
                $this->$key = getenv($key);
            }
            return true;
        }
        // Or fallback to looking for sqweb.config
        if (file_exists(__DIR__ . '/../../sqweb.config')) {
            $lines = file(__DIR__ . '/../../sqweb.config');
            foreach ($lines as $line) {
                $tmp = explode('=', $line);
                $key = $tmp[0];
                if (in_array($key, $config_keys)) {
                    $this->$key = rtrim($tmp[1]);
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
                    CURLOPT_URL => 'https://api.multipass.net/token/check',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT_MS => 1000,
                    CURLOPT_TIMEOUT_MS => 1000,
                    CURLOPT_USERAGENT => 'SQweb/SDK 1.6.0',
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
            return $this->response->credit;
        }
        return 0;
    }

    /**
     * Output the JavaScript tag with its configuration object.
     */
    public function script()
    {
        echo '<script>
            var _sqw = {
                id_site: '. $this->SQW_ID_SITE .',
                sitename: "'. $this->SQW_SITENAME .'",
                debug: '. $this->SQW_DEBUG .',
                adblock_modal: '. $this->SQW_ADBLOCK_MODAL .',
                targeting: '. $this->SQW_TARGETING .',
                beacon: '. $this->SQW_BEACON .',
                dwide: '. $this->SQW_DWIDE .',
                i18n: "'. $this->SQW_LANG .'",
                msg: "'. $this->SQW_MESSAGE .'"};
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://cdn.multipass.net/multipass.js";
        document.getElementsByTagName("head")[0].appendChild(script);</script>';
    }

   /*
     * Display a button for locked content
     */
    public function lockingBlock()
    {
        $html = $this->returnBlock('locking');

        echo $html;
    }

    /*
     * Display a supporting button
     */
    public function supportBlock()
    {
        switch ($this->SQW_LANG) {
            case 'fr':
            case 'fr_fr':
                $wording = array(
                    'title'         => 'L\'article est terminé ...',
                    'sentence_1'    => '... mais nous avons besoin que vous lisiez ceci: nous avons de plus en plus
                         de lecteurs chaque jour, mais de moins en moins de revenus publicitaires.',
                    'sentence_2'    => 'Nous souhaitons laisser notre contenu accessible à tous. Nous sommes
                         indépendants et notre travail de qualité prend beaucoup de temps, d\'argent et de dévotion',
                    'sentence_3'    => 'Vous pouvez nous soutenir avec Multipass qui permet de payer pour un bouquet de
                         sites, et ainsi financer le travail des créateurs et journalistes que vous aimez.',
                    'support'       => 'Soutenez nous avec'
                );
                break;

            default:
                $wording = array(
                    'title'         => 'Continue reading...',
                    'sentence_1'    => '... we need you to hear this: More people are reading our website than ever but
                         advertising revenues across the media are falling fast. We need you to hear this: More people
                         are reading our website than ever but advertising revenues across the media are falling fast.',
                    'sentence_2'    => ' We want to keep our content as open as we can. We are independent,
                         and our quality work takes a lot of time, money and hard work to produce. ',
                    'sentence_3'    => 'You can support us with Multipass which enables you to pay for a bundle of
                         websites: you can finance the work of journalists and content creators you love.',
                    'support'       => 'Support us with'
                );
                break;
        }

        $html = '
            <div class="sqw-article-footer-container">
                <div class="sqw-article-footer-body">
                    <div class="sqw-article-footer-body-title">' . $wording['title'] . '</div>
                    <div class="sqw-article-footer-body-content1">' . $wording['sentence_1'] .'</div>
                    <div class="sqw-article-footer-body-content2">' . $wording['sentence_2'] . '</div>
                    <div class="sqw-article-footer-body-content3">' . $wording['sentence_3'] . '</div>
                </div>
                <div onclick="sqw.modal_first()" class="sqw-article-footer-footer">
                    <div class="sqw-article-footer-footer-text">' . $wording['support'] . '</div>
                    <div class="sqw-article-footer-footer-logo-container"></div>
                </div>
            </div>';

        echo $html;
    }

    /*
     * Return the good button according to parent function.
     */
    private function returnBlock($type)
    {
        $wording = $this->selectText($type);

        return '
            <div class="footer__mp__normalize footer__mp__button_container">
                <div class="footer__mp__button_header">
                    <div class="footer__mp__button_header_title">' . $wording['warning'] . '</div>
                    <div onclick="sqw.modal_first()" class="footer__mp__button_signin">'
                    . $wording['already_sub']
                    . '<span onclick="sqw.modal_first()" class="footer__mp__button_login footer__mp__button_strong">'
                    . $wording['login']
                    . '</span></div>
                </div>
                <div onclick="sqw.modal_first()" class="footer__mp__normalize footer__mp__button_cta">
                    <a href="#" class="footer__mp__cta_fresh">' . $wording['unlock'] . '</a>
                </div>
                <div class="footer__mp__normalize footer__mp__button_footer">
                    <p class="footer__mp__normalize footer__mp__button_p">'. $wording['desc'] . '</p>
                    <a target="_blank" class="footer__mp__button_discover footer__mp__button_strong" href="'
                    . $wording['href']
                    . '"><span>></span> <span class="footer__mp__button_footer_txt">'
                    . $wording['discover']
                    . '</span></a>
                </div>
            </div>';
    }

    private function selectText($type)
    {
        if ($type == 'support') {
            switch ($this->SQW_LANG) {
                case 'fr':
                case 'fr_fr':
                    $wording = array(
                        'warning'       => 'Surfez sans publicité.',
                        'already_sub'   => 'Déjà abonné ? ',
                        'login'         => 'Connexion',
                        'unlock'        => 'Soutenez notre site grâce à ',
                        'desc'          => 'L\'abonnement multi-sites, sans engagement.',
                        'href'          => 'https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites',
                        'discover'      => 'Découvrir les partenaires'
                    );
                    break;

                default:
                    $href = 'https://www.multipass.net/en premium-partners-website-without-ads-nor-restriction';
                    $wording = array(
                        'warning'       => 'Surf our website ad free',
                        'already_sub'   => 'Already a member? ',
                        'login'         => 'Sign in',
                        'unlock'        => 'Support our website, get your',
                        'desc'          => 'The multisite subscription, with no commitment.',
                        'href'          => $href,
                        'discover'      => 'Discover all the partners'
                    );
                    break;
            }
        } elseif ($type == 'locking') {
            switch ($this->SQW_LANG) {
                case 'fr':
                case 'fr_fr':
                    $wording = array(
                        'warning'       => 'Cet article est reservé.',
                        'already_sub'   => 'Déjà abonné ? ',
                        'login'         => 'Connexion',
                        'unlock'        => 'Débloquez ce contenu avec',
                        'desc'          => 'L\'abonnement multi-sites, sans engagement.',
                        'href'          => 'https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites',
                        'discover'      => 'Découvrir les partenaires'
                    );
                    break;

                default:
                    $href = 'https://www.multipass.net/en premium-partners-website-without-ads-nor-restriction';
                    $wording = array(
                        'warning'       => 'The rest of this article is restricted.',
                        'already_sub'   => 'Already a member? ',
                        'login'         => 'Sign in',
                        'unlock'        => 'Unlock this content, get your ',
                        'desc'          => 'The multisite subscription, with no commitment.',
                        'href'          => $href,
                        'discover'      => 'Discover all the partners'
                    );
                    break;
            }
        }
        return $wording;
    }

    /**
     * Create the target button div.
     * @param null $size
     */
    public function button($size = null)
    {
        if ($size === 'tiny') {
            echo '<div class="sqweb-button multipass-tiny"></div>';
        } elseif ($size === 'slim') {
            echo '<div class="sqweb-button multipass-slim"></div>';
        } elseif ($size === 'large') {
            echo '<div class="sqweb-button multipass-large"></div>';
        } else { // multipass-regular
            echo '<div class="sqweb-button"></div>';
        }
    }

    public function sqwBalise($balise, $match)
    {
        if (preg_match('/<(\w+)(?(?!.+\/>).*>|$)/', $match, $tmp)) {
            if (!isset($balise)) {
                $balise = array();
            }
            $balise[] = $tmp[1];
        }
        foreach ($balise as $key => $value) {
            if (preg_match('/<\/(.+)>/', $value, $tmp)) {
                unset($balise[ $key ]);
            }
        }
        return $balise;
    }

    /**
     * Put opacity to your text
     * Returns the text with opcaity style.
     * @param text, which is your text.
     * @param int percent which is the percent of your text you want to show.
     * @return string
     */
    public function transparent($text, $percent = 100)
    {
        if (self::checkCredits() === 1 || $percent == 100 || empty($text)) {
            return $text;
        }
        if ($percent === 0) {
            return '';
        }
        $arr_txt = preg_split('/(<.+?><\/.+?>)|(<.+?>)|( )/', $text, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        foreach (array_keys($arr_txt, ' ', true) as $key) {
            unset($arr_txt[ $key ]);
        }
        $arr_txt = array_values($arr_txt);
        $words = count($arr_txt);
        $nbr = ceil($words / 100 * $percent);
        $lambda = 1 / $nbr;
        $alpha = 1;
        $begin = 0;
        $balise = array();
        while ($begin < $nbr) {
            if (isset($arr_txt[$begin + 1])) {
                if (preg_match('/<.+?>/', $arr_txt[ $begin ], $match)) {
                    $balise = self::sqwBalise($balise, $match[0]);
                    $final[] = $arr_txt[ $begin ];
                    $nbr++;
                } else {
                    $tmp = number_format($alpha, 5, '.', '');
                    $final[] = '<span style="opacity: ' . $tmp . '">' . $arr_txt[ $begin ] . '</span>';
                    $alpha -= $lambda;
                }
            }
            $begin++;
        }
        foreach ($balise as $value) {
            $final[] = '</' . $value . '>';
        }
        $final = implode(' ', $final);
        return $final;
    }


    /**
     * Limit the number of articles free users can read per day.
     * @param $limitation int The number of articles a free user can see.
     * @return bool
     */
    public function limitArticle($limitation = 0)
    {
        if (self::checkCredits() == 0 && $limitation != 0) {
            if (!isset($_COOKIE['sqwBlob']) || (isset($_COOKIE['sqwBlob']) && $_COOKIE['sqwBlob'] != -7610679)) {
                $ip2 = ip2long($_SERVER['REMOTE_ADDR']);
                if (!isset($_COOKIE['sqwBlob'])) {
                    $sqwBlob = 1;
                } else {
                    $sqwBlob = ($_COOKIE['sqwBlob'] / 2) - $ip2 - 2 + 1;
                }
                if ($limitation > 0 && $sqwBlob <= $limitation) {
                    $tmp = ($sqwBlob + $ip2 + 2) * 2;
                    setcookie('sqwBlob', $tmp, time()+60*60*24);
                    return true;
                } else {
                    setcookie('sqwBlob', -7610679, time()+60*60*24);
                }
            }
            return false;
        }
        return true;
    }

    /**
     * Display your premium content at a later date to non-paying users.
     * @param  string  $date  Date of publishing the content on your site. It must be an ISO format(YYYY-MM-DD).
     * @param  integer $wait  Days to wait before showing this content to free users.
     * @return bool
     */
    public function waitToDisplay($date, $wait = 0)
    {
        if ($wait === 0 || self::checkCredits() === 1) {
            return true;
        }
        $format = 'Y-m-d';
        $datetime1 = new \Datetime;
        $datetime2 = $datetime1->createFromFormat($format, $date);
        $gap = (int)$datetime1->diff($datetime2)->format('%R%a');
        return ($gap + $wait) > 0 ? false : true;
    }
}
