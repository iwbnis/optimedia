<?php

namespace WHMCMS;

use \WHMCMS\Database\Capsule;

final class Base {

    public static $moduleConfig = null;

    public static $latestVersion = null;

    public static $htaccessStart = "# WHMCMS Code Started";

    public static $htaccessEnd = "# WHMCMS Code Ended";

    public static $breadcrumbs = [];

    public static $language = null;

    public static $_LANG = null;

    /**
     * Load Module Settings
     */
    protected static function loadConfig(){

        $getSetting = Capsule::table("mod_whmcms_settings")
        ->get();

        foreach ($getSetting as $setting){
            $setting = (array) $setting;

            self::$moduleConfig[ $setting['varname'] ] = $setting['value'];
        }

    }

    /**
     * Get Module Setting
     */
    public static function getConfig($setting){

        if (is_null(self::$moduleConfig)){
            self::loadConfig();
        }

        if (isset(self::$moduleConfig[ $setting ]) === false){
            return null;
        }

        return self::$moduleConfig[ $setting ];

    }

    /**
     * Set Setting
     */
    public static function setConfig($setting, $value = ""){

        if (is_null(self::$moduleConfig)){
            self::loadConfig();
        }

        if (isset(self::$moduleConfig[ $setting ]) === false){

            Capsule::table("mod_whmcms_settings")
            ->insert([
                "varname" => $setting,
                "value" => $value
            ]);

        }

        Capsule::table("mod_whmcms_settings")
        ->where("varname", "=", $setting)
        ->update([
            "value" => $value
        ]);

        self::loadConfig();

    }

    /**
     * Get System Config
     */
    public static function getSystemConfig($setting){

        global $CONFIG;

        if (!isset($CONFIG[ $setting ])){
            return null;
        }

        return $CONFIG[ $setting ];

    }

    /**
     * Get System URL
     */
    public static function getSystemURL(){

        if (strlen(self::getSystemConfig("SystemSSLURL")) > 10){
            $systemURL = self::getSystemConfig("SystemSSLURL");
        }
        else {
            $systemURL   = self::getSystemConfig("SystemURL");
        }

        $systemURL = rtrim($systemURL, "/") . "/";

        return $systemURL;

    }

    /**
     * Get Modules' Admin URL
     */
    public static function getModURL(){

        return "addonmodules.php?module=whmcms";

    }

    public static function generateRewriteRules(){

        global $CONFIG, $customadminpath;

        $customadminpath = trim($customadminpath, "/");

        $rules = [];

        $rules[] = '';

        $rules[] = '<IfModule mod_rewrite.c>';
        $rules[] = 'RewriteEngine on';
        $rules[] = '';
        $rules[] = '# RewriteBase is set to "/" so rules do not need updating if the';
        $rules[] = '# installation directory is relocated.  It is imperative that';
        $rules[] = '# there is also a RewriteCond rule later that can effectively get';
        $rules[] = '# the actual value by comparison against the request URI.';
        $rules[] = '#';
        $rules[] = '# If there are _any_ other RewriteBase directives in this file,';
        $rules[] = '# the last entry will take precedence!';
        $rules[] = 'RewriteBase /';
        $rules[] = '';

        $rules[] = '# Determine the actual base and use it';
        $rules[] = 'RewriteCond $0#%{REQUEST_URI} ([^#]*)#(.*)\1$';

        # Apply WHMCS Rules v6.0.0 >< v7.2.0
        $WHMCSVersion = explode("-", self::getSystemConfig('Version'));
        if (version_compare("6.0.0", $WHMCSVersion[0], "<=") === true && version_compare("7.2.0", $WHMCSVersion[0], ">") === true){
            $rules[] = '# Apply WHMCS Rules For versions between v6.0.0 and v7.2.0';
            $rules[] = 'RewriteRule ^announcements/([0-9]+)/[a-z0-9_-]+\.html$ %2announcements.php?id=$1 [L,NC]';
            $rules[] = 'RewriteRule ^announcements$ %{ENV:CWD}announcements.php [L,NC]';
            $rules[] = 'RewriteRule ^downloads/([0-9]+)/([^/]*)$ %2downloads.php?action=displaycat&catid=$1 [L,NC]';
            $rules[] = 'RewriteRule ^downloads$ %2downloads.php [L,NC]';
            $rules[] = 'RewriteRule ^knowledgebase/([0-9]+)/[a-z0-9_-]+\.html$ %2knowledgebase.php?action=displayarticle&id=$1 [L,NC]';
            $rules[] = 'RewriteRule ^knowledgebase/([0-9]+)/([^/]*)$ %2knowledgebase.php?action=displaycat&catid=$1 [L,NC]';
            $rules[] = 'RewriteRule ^knowledgebase$ %2knowledgebase.php [L,NC]';
            $rules[] = 'RewriteRule ^.well-known/openid-configuration %2oauth/openid-configuration.php [L,NC]';
            $rules[] = '';
        }

        # Set WHMCMS as Homepage
        if (self::fromInput(self::getConfig("homepage"), 'int') > 0){
            $rules[] = '# Set WHMCMS as the homepage';
            $rules[] = 'DirectoryIndex ' . self::getConfig("frontendfile") . ' index.php';
            $rules[] = '';
        }

        # Custom Pages
        $rules[] = '# Send all requests to WHMCMS';
        $rules[] = '# Excluding all built-in WHMCS paths';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/knowledgebase';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/announcements';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/download';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/subscription';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/domain';
        $rules[] = 'RewriteCond %{REQUEST_URI} !/store'; // WHMCS MarketConnect (Cart.php)
        $rules[] = 'RewriteCond %{REQUEST_URI} !/cart'; // WHMCS Cart
        $rules[] = 'RewriteCond %{REQUEST_URI} !/invoices'; // Invoices
        $rules[] = 'RewriteCond %{REQUEST_URI} !/invoice'; // Invoices
        $rules[] = 'RewriteCond %{REQUEST_URI} !/auth'; // Social Login-in Integrations
        $rules[] = 'RewriteCond %{REQUEST_URI} !/password'; // Password Reset
        $rules[] = 'RewriteCond %{REQUEST_URI} !/account'; // My Account
        $rules[] = 'RewriteCond %{REQUEST_URI} !/login'; // Login
        $rules[] = 'RewriteCond %{REQUEST_URI} !/paymentmethod'; // Payment Methods
        $rules[] = 'RewriteCond %{REQUEST_URI} !/' . $customadminpath; // Admin Area
        $rules[] = 'RewriteCond %{REQUEST_FILENAME} !-f';
        $rules[] = 'RewriteCond %{REQUEST_FILENAME} !-d';
        $rules[] = '';
        //$rules[] = '# Determine the actual base and use it';
        //$rules[] = 'RewriteCond $0#%{REQUEST_URI} ([^#]*)#(.*)\1$';
        $rules[] = 'RewriteRule ^.*$ %2' . self::getConfig("frontendfile") . ' [QSA,L]';
        $rules[] = '';
        $rules[] = '';

        # Custom Error Pages
        if (self::getConfig("error400") === "enable"){
            $rules[] = 'ErrorDocument 400 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/400';
        }
        if (self::getConfig("error403") === "enable"){
            $rules[] = 'ErrorDocument 403 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/403';
        }
        if (self::getConfig("error404") === "enable"){
            $rules[] = 'ErrorDocument 404 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/404';
        }
        if (self::getConfig("error405") === "enable"){
            $rules[] = 'ErrorDocument 405 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/405';
        }
        if (self::getConfig("error408") === "enable"){
            $rules[] = 'ErrorDocument 408 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/408';
        }
        if (self::getConfig("error500") === "enable"){
            $rules[] = 'ErrorDocument 500 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/500';
        }
        if (self::getConfig("error502") === "enable"){
            $rules[] = 'ErrorDocument 502 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/502';
        }
        if (self::getConfig("error504") === "enable"){
            $rules[] = 'ErrorDocument 504 ' . self::getBaseDirectory() . self::getConfig("frontendfile") . '?rp=/error/504';
        }

        $rules[] = '</IfModule>';

        $rules[] = '';

        return join("\n", $rules);

    }

    public static function getBaseDirectory(){

        global $CONFIG;

        $parseURL = parse_url(self::getSystemConfig('SystemURL'));

        $explode = explode("/", $parseURL['path']);

        if ($parseURL['path'] === "/"){
            $baseDirectory = "/";
        }
        else {

            foreach ($explode as $index => $directory){
                if (empty($directory)){
                    unset($explode[ $index ]);
                }
            }

            $baseDirectory = join("/", $explode);
            $baseDirectory = trim($baseDirectory, "/");
            if (strlen($baseDirectory) > 0){
                $baseDirectory = "/" . $baseDirectory . "/";
            }
            else {
                $baseDirectory = "/" . $baseDirectory;
            }

        }

        return $baseDirectory;

    }

    public static function replaceBetween($string, $needle_start, $needle_end, $replacement) {
        $pos = strpos($string, $needle_start);
        $start = $pos === false ? 0 : $pos + strlen($needle_start);

        $pos = strpos($string, $needle_end, $start);
        $end = $start === false ? strlen($string) : $pos;

        return substr_replace($string, $replacement, $start, $end - $start);
    }

    public static function getBetweenTwoStrings($string, $needle_start, $needle_end) {
        $pos = strpos($string, $needle_start);
        $start = $pos === false ? 0 : $pos + strlen($needle_start);

        $pos = strpos($string, $needle_end, $start);
        $end = $start === false ? strlen($string) : $pos;

        return substr($string, $start, $end - $start);
    }

    public static function getSystemLanguages($excludeDefaultLanguage = false){

        global $CONFIG;

        $defaultLanguage = self::getSystemConfig('Language') . '.php';

        $languages = array();

        # Exclude ".", ".." from list
        $exclude = [".", "..", "index.php", "readme.txt"];

        if ($excludeDefaultLanguage === true){
            $exclude[] = self::toLower($defaultLanguage);
        }

        # Read Directory
        $getFiles = new \DirectoryIterator(ROOTDIR . '/lang/');

        # Loop All Items Found Inside
        foreach ($getFiles as $file){

            $fileName = self::toLower($file->getFileName());

            # Only List Valid Files also Exclude unwanted ones
            if (!in_array($fileName, $exclude) && $file->isFile() === true && $file->getExtension() === "php"){
                $language = str_replace(".php", "", $fileName);
                $languages[ $language ] = $language;
            }
        }

        return $languages;

    }

    public static function getSystemDefaultLanguage(){

        return self::toLower(self::getSystemConfig('Language'));

    }

    public static function getClientAreaTemplates($excludeDefaultTemplate = false){

        $defaultTemplate = self::getSystemConfig('Template');

        $templates = array();

        # Exclude ".", ".." from list
        $exclude = [".", "..", "index.php", "README.txt", "orderforms"];

        if ($excludeDefaultTemplate === true){
            $exclude[] = $defaultTemplate;
        }

        # Read Directory
        $getFiles = new \DirectoryIterator(ROOTDIR . '/templates/');

        # Loop All Items Found Inside
        foreach ($getFiles as $file){
            # Only List Valid Files also Exclude unwanted ones
            if (!in_array($file->getFileName(), $exclude) && $file->isDir() === true){
                $templates[ $file->getFileName() ] = $file->getFileName();
            }
        }

        return $templates;

    }

    public static function getClientTemplate(){

        $templates = self::getClientAreaTemplates();

        # Request
        if (self::fromRequest('systpl') !== "" && in_array(self::fromRequest('systpl'), $templates) === true){
            return self::fromRequest('systpl');
        }

        # Session
        if (self::fromInput($_SESSION['Template']) !== "" && in_array(self::fromInput($_SESSION['Template']), $templates) === true){
            return self::fromInput($_SESSION['Template']);
        }

        # Config
        if (self::getSystemConfig('Template') !== "" && in_array(self::getSystemConfig('Template'), $templates) === true){
            return self::getSystemConfig('Template');
        }

        return null;
    }

    public static function generateAlias($string = ""){

        $transliterateChars = [
            // latin
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'Ae',
            'Å' => 'A',
            'Æ' => 'AE',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ð' => 'D',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'Oe',
            'Ő' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'Ue',
            'Ű' => 'U',
            'Ý' => 'Y',
            'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'ae',
            'å' => 'a',
            'æ' => 'ae',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'd',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'oe',
            'ő' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'ue',
            'ű' => 'u',
            'ý' => 'y',
            'þ' => 'th',
            'ÿ' => 'y',
            'ẞ' => 'SS',

            // Language Specific

            // Arabic
            'ا' => 'a',
            'أ' => 'a',
            'إ' => 'i',
            'آ' => 'aa',
            'ؤ' => 'u',
            'ئ' => 'e',
            'ء' => 'a',
            'ب' => 'b',
            'ت' => 't',
            'ث' => 'th',
            'ج' => 'j',
            'ح' => 'h',
            'خ' => 'kh',
            'د' => 'd',
            'ذ' => 'th',
            'ر' => 'r',
            'ز' => 'z',
            'س' => 's',
            'ش' => 'sh',
            'ص' => 's',
            'ض' => 'dh',
            'ط' => 't',
            'ظ' => 'z',
            'ع' => 'a',
            'غ' => 'gh',
            'ف' => 'f',
            'ق' => 'q',
            'ك' => 'k',
            'ل' => 'l',
            'م' => 'm',
            'ن' => 'n',
            'ه' => 'h',
            'و' => 'w',
            'ي' => 'y',
            'ى' => 'a',
            'ة' => 'h',
            'ﻻ' => 'la',
            'ﻷ' => 'laa',
            'ﻹ' => 'lai',
            'ﻵ' => 'laa',

            // Persian additional characters than Arabic
            'گ' => 'g',
            'چ' => 'ch',
            'پ' => 'p',
            'ژ' => 'zh',
            'ک' => 'k',
            'ی' => 'y',

            // Arabic diactrics
            'َ' => 'a',
            'ً' => 'an',
            'ِ' => 'e',
            'ٍ' => 'en',
            'ُ' => 'u',
            'ٌ' => 'on',
            'ْ' => '',

            // Arabic numbers
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',

            // Persian numbers
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',

            // Burmese consonants
            'က' => 'k',
            'ခ' => 'kh',
            'ဂ' => 'g',
            'ဃ' => 'ga',
            'င' => 'ng',
            'စ' => 's',
            'ဆ' => 'sa',
            'ဇ' => 'z',
            'စျ' => 'za',
            'ည' => 'ny',
            'ဋ' => 't',
            'ဌ' => 'ta',
            'ဍ' => 'd',
            'ဎ' => 'da',
            'ဏ' => 'na',
            'တ' => 't',
            'ထ' => 'ta',
            'ဒ' => 'd',
            'ဓ' => 'da',
            'န' => 'n',
            'ပ' => 'p',
            'ဖ' => 'pa',
            'ဗ' => 'b',
            'ဘ' => 'ba',
            'မ' => 'm',
            'ယ' => 'y',
            'ရ' => 'ya',
            'လ' => 'l',
            'ဝ' => 'w',
            'သ' => 'th',
            'ဟ' => 'h',
            'ဠ' => 'la',
            'အ' => 'a',
            // consonant character combos
            'ြ' => 'y',
            'ျ' => 'ya',
            'ွ' => 'w',
            'ြွ' => 'yw',
            'ျွ' => 'ywa',
            'ှ' => 'h',
            // independent vowels
            'ဧ' => 'e',
            '၏' => '-e',
            'ဣ' => 'i',
            'ဤ' => '-i',
            'ဉ' => 'u',
            'ဦ' => '-u',
            'ဩ' => 'aw',
            'သြော' => 'aw',
            'ဪ' => 'aw',
            // numbers
            '၀' => '0',
            '၁' => '1',
            '၂' => '2',
            '၃' => '3',
            '၄' => '4',
            '၅' => '5',
            '၆' => '6',
            '၇' => '7',
            '၈' => '8',
            '၉' => '9',
            // virama and tone marks which are silent in transliteration
            '္' => '',
            '့' => '',
            'း' => '',

            // Czech
            'č' => 'c',
            'ď' => 'd',
            'ě' => 'e',
            'ň' => 'n',
            'ř' => 'r',
            'š' => 's',
            'ť' => 't',
            'ů' => 'u',
            'ž' => 'z',
            'Č' => 'C',
            'Ď' => 'D',
            'Ě' => 'E',
            'Ň' => 'N',
            'Ř' => 'R',
            'Š' => 'S',
            'Ť' => 'T',
            'Ů' => 'U',
            'Ž' => 'Z',

            // Dhivehi
            'ހ' => 'h',
            'ށ' => 'sh',
            'ނ' => 'n',
            'ރ' => 'r',
            'ބ' => 'b',
            'ޅ' => 'lh',
            'ކ' => 'k',
            'އ' => 'a',
            'ވ' => 'v',
            'މ' => 'm',
            'ފ' => 'f',
            'ދ' => 'dh',
            'ތ' => 'th',
            'ލ' => 'l',
            'ގ' => 'g',
            'ޏ' => 'gn',
            'ސ' => 's',
            'ޑ' => 'd',
            'ޒ' => 'z',
            'ޓ' => 't',
            'ޔ' => 'y',
            'ޕ' => 'p',
            'ޖ' => 'j',
            'ޗ' => 'ch',
            'ޘ' => 'tt',
            'ޙ' => 'hh',
            'ޚ' => 'kh',
            'ޛ' => 'th',
            'ޜ' => 'z',
            'ޝ' => 'sh',
            'ޞ' => 's',
            'ޟ' => 'd',
            'ޠ' => 't',
            'ޡ' => 'z',
            'ޢ' => 'a',
            'ޣ' => 'gh',
            'ޤ' => 'q',
            'ޥ' => 'w',
            'ަ' => 'a',
            'ާ' => 'aa',
            'ި' => 'i',
            'ީ' => 'ee',
            'ު' => 'u',
            'ޫ' => 'oo',
            'ެ' => 'e',
            'ޭ' => 'ey',
            'ޮ' => 'o',
            'ޯ' => 'oa',
            'ް' => '',

            // Greek
            'α' => 'a',
            'β' => 'v',
            'γ' => 'g',
            'δ' => 'd',
            'ε' => 'e',
            'ζ' => 'z',
            'η' => 'i',
            'θ' => 'th',
            'ι' => 'i',
            'κ' => 'k',
            'λ' => 'l',
            'μ' => 'm',
            'ν' => 'n',
            'ξ' => 'ks',
            'ο' => 'o',
            'π' => 'p',
            'ρ' => 'r',
            'σ' => 's',
            'τ' => 't',
            'υ' => 'y',
            'φ' => 'f',
            'χ' => 'x',
            'ψ' => 'ps',
            'ω' => 'o',
            'ά' => 'a',
            'έ' => 'e',
            'ί' => 'i',
            'ό' => 'o',
            'ύ' => 'y',
            'ή' => 'i',
            'ώ' => 'o',
            'ς' => 's',
            'ϊ' => 'i',
            'ΰ' => 'y',
            'ϋ' => 'y',
            'ΐ' => 'i',
            'Α' => 'A',
            'Β' => 'B',
            'Γ' => 'G',
            'Δ' => 'D',
            'Ε' => 'E',
            'Ζ' => 'Z',
            'Η' => 'I',
            'Θ' => 'TH',
            'Ι' => 'I',
            'Κ' => 'K',
            'Λ' => 'L',
            'Μ' => 'M',
            'Ν' => 'N',
            'Ξ' => 'KS',
            'Ο' => 'O',
            'Π' => 'P',
            'Ρ' => 'R',
            'Σ' => 'S',
            'Τ' => 'T',
            'Υ' => 'Y',
            'Φ' => 'F',
            'Χ' => 'X',
            'Ψ' => 'PS',
            'Ω' => 'O',
            'Ά' => 'A',
            'Έ' => 'E',
            'Ί' => 'I',
            'Ό' => 'O',
            'Ύ' => 'Y',
            'Ή' => 'I',
            'Ώ' => 'O',
            'Ϊ' => 'I',
            'Ϋ' => 'Y',

            // Latvian
            'ā' => 'a',
            // 'č' => 'c', // duplicate
            'ē' => 'e',
            'ģ' => 'g',
            'ī' => 'i',
            'ķ' => 'k',
            'ļ' => 'l',
            'ņ' => 'n',
            // 'š' => 's', // duplicate
            'ū' => 'u',
            // 'ž' => 'z', // duplicate
            'Ā' => 'A',
            // 'Č' => 'C', // duplicate
            'Ē' => 'E',
            'Ģ' => 'G',
            'Ī' => 'I',
            'Ķ' => 'k',
            'Ļ' => 'L',
            'Ņ' => 'N',
            // 'Š' => 'S', // duplicate
            'Ū' => 'U',
            // 'Ž' => 'Z', // duplicate

            // Macedonian
            'Ќ' => 'Kj',
            'ќ' => 'kj',
            'Љ' => 'Lj',
            'љ' => 'lj',
            'Њ' => 'Nj',
            'њ' => 'nj',
            'Тс' => 'Ts',
            'тс' => 'ts',

            // Polish
            'ą' => 'a',
            'ć' => 'c',
            'ę' => 'e',
            'ł' => 'l',
            'ń' => 'n',
            // 'ó' => 'o', // duplicate
            'ś' => 's',
            'ź' => 'z',
            'ż' => 'z',
            'Ą' => 'A',
            'Ć' => 'C',
            'Ę' => 'E',
            'Ł' => 'L',
            'Ń' => 'N',
            'Ś' => 'S',
            'Ź' => 'Z',
            'Ż' => 'Z',

            // Ukranian
            'Є' => 'Ye',
            'І' => 'I',
            'Ї' => 'Yi',
            'Ґ' => 'G',
            'є' => 'ye',
            'і' => 'i',
            'ї' => 'yi',
            'ґ' => 'g',

            // Romanian
            'ă' => 'a',
            'Ă' => 'A',
            'ș' => 's',
            'Ș' => 'S',
            // 'ş' => 's', // duplicate
            // 'Ş' => 'S', // duplicate
            'ț' => 't',
            'Ț' => 'T',
            'ţ' => 't',
            'Ţ' => 'T',

            // Russian https://en.wikipedia.org/wiki/Romanization_of_Russian
            // ICAO

            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'i',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sh',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'Yo',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'I',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'Kh',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sh',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',

            // Serbian
            'ђ' => 'dj',
            'ј' => 'j',
            // 'љ' => 'lj',  // duplicate
            // 'њ' => 'nj', // duplicate
            'ћ' => 'c',
            'џ' => 'dz',
            'Ђ' => 'Dj',
            'Ј' => 'j',
            // 'Љ' => 'Lj', // duplicate
            // 'Њ' => 'Nj', // duplicate
            'Ћ' => 'C',
            'Џ' => 'Dz',

            // Slovak
            'ľ' => 'l',
            'ĺ' => 'l',
            'ŕ' => 'r',
            'Ľ' => 'L',
            'Ĺ' => 'L',
            'Ŕ' => 'R',

            // Turkish
            'ş' => 's',
            'Ş' => 'S',
            'ı' => 'i',
            'İ' => 'I',
            // 'ç' => 'c', // duplicate
            // 'Ç' => 'C', // duplicate
            // 'ü' => 'u', // duplicate, see langCharMap
            // 'Ü' => 'U', // duplicate, see langCharMap
            // 'ö' => 'o', // duplicate, see langCharMap
            // 'Ö' => 'O', // duplicate, see langCharMap
            'ğ' => 'g',
            'Ğ' => 'G',

            // Vietnamese
            'ả' => 'a',
            'Ả' => 'A',
            'ẳ' => 'a',
            'Ẳ' => 'A',
            'ẩ' => 'a',
            'Ẩ' => 'A',
            'đ' => 'd',
            'Đ' => 'D',
            'ẹ' => 'e',
            'Ẹ' => 'E',
            'ẽ' => 'e',
            'Ẽ' => 'E',
            'ẻ' => 'e',
            'Ẻ' => 'E',
            'ế' => 'e',
            'Ế' => 'E',
            'ề' => 'e',
            'Ề' => 'E',
            'ệ' => 'e',
            'Ệ' => 'E',
            'ễ' => 'e',
            'Ễ' => 'E',
            'ể' => 'e',
            'Ể' => 'E',
            'ọ' => 'o',
            'Ọ' => 'o',
            'ố' => 'o',
            'Ố' => 'O',
            'ồ' => 'o',
            'Ồ' => 'O',
            'ổ' => 'o',
            'Ổ' => 'O',
            'ộ' => 'o',
            'Ộ' => 'O',
            'ỗ' => 'o',
            'Ỗ' => 'O',
            'ơ' => 'o',
            'Ơ' => 'O',
            'ớ' => 'o',
            'Ớ' => 'O',
            'ờ' => 'o',
            'Ờ' => 'O',
            'ợ' => 'o',
            'Ợ' => 'O',
            'ỡ' => 'o',
            'Ỡ' => 'O',
            'Ở' => 'o',
            'ở' => 'o',
            'ị' => 'i',
            'Ị' => 'I',
            'ĩ' => 'i',
            'Ĩ' => 'I',
            'ỉ' => 'i',
            'Ỉ' => 'i',
            'ủ' => 'u',
            'Ủ' => 'U',
            'ụ' => 'u',
            'Ụ' => 'U',
            'ũ' => 'u',
            'Ũ' => 'U',
            'ư' => 'u',
            'Ư' => 'U',
            'ứ' => 'u',
            'Ứ' => 'U',
            'ừ' => 'u',
            'Ừ' => 'U',
            'ự' => 'u',
            'Ự' => 'U',
            'ữ' => 'u',
            'Ữ' => 'U',
            'ử' => 'u',
            'Ử' => 'ư',
            'ỷ' => 'y',
            'Ỷ' => 'y',
            'ỳ' => 'y',
            'Ỳ' => 'Y',
            'ỵ' => 'y',
            'Ỵ' => 'Y',
            'ỹ' => 'y',
            'Ỹ' => 'Y',
            'ạ' => 'a',
            'Ạ' => 'A',
            'ấ' => 'a',
            'Ấ' => 'A',
            'ầ' => 'a',
            'Ầ' => 'A',
            'ậ' => 'a',
            'Ậ' => 'A',
            'ẫ' => 'a',
            'Ẫ' => 'A',
            // 'ă' => 'a', // duplicate
            // 'Ă' => 'A', // duplicate
            'ắ' => 'a',
            'Ắ' => 'A',
            'ằ' => 'a',
            'Ằ' => 'A',
            'ặ' => 'a',
            'Ặ' => 'A',
            'ẵ' => 'a',
            'Ẵ' => 'A'
        ];

        $currencies = [
            '$' => 'USD',
            '€' => 'EUR',
            '₢' => 'BRN',
            '₣' => 'FRF',
            '£' => 'GBP',
            '₤' => 'ITL',
            '₦' => 'NGN',
            '₧' => 'ESP',
            '₩' => 'KRW',
            '₪' => 'ILS',
            '₫' => 'VND',
            '₭' => 'LAK',
            '₮' => 'MNT',
            '₯' => 'GRD',
            '₱' => 'ARS',
            '₲' => 'PYG',
            '₳' => 'ARA',
            '₴' => 'UAH',
            '₵' => 'GHS',
            '¢' => 'cent',
            '¥' => 'CNY',
            '元' => 'CNY',
            '円' => 'YEN',
            '﷼' => 'IRR',
            '₠' => 'EWE',
            '฿' => 'THB',
            '₨' => 'INR',
            '₹' => 'INR',
            '₰' => 'PF',
            '₺' => 'TRY',
            '؋' => 'AFN',
            '₼' => 'AZN',
            'лв' => 'BGN',
            '៛' => 'KHR',
            '₡' => 'CRC',
            '₸' => 'KZT',
            'ден' => 'MKD',
            'zł' => 'PLN',
            '₽' => 'RUB',
            '₾' => 'GEL'
        ];

        $string = trim($string);

        // String are empty
        if (strlen($string) === 0){
            return null;
        }

        // Do Transliterate
        foreach ($transliterateChars as $key => $value){
            $string = str_replace($key, $value, $string);
        }

        // Convert Currencies
        foreach ($currencies as $key => $value) {
            $string = str_replace($key, $value, $string);
        }

        // Replace Spaces
        $string = preg_replace("/\s+/", "-", $string);

        // Replace Unwanted Chars
        $string = preg_replace("/[^A-Za-z0-9-_]+/", "", $string);

        // Remove Trailing Delimiter
        $string = trim($string, "-");

        // Replace Duplicated Delimeiter With one
        // https://randomdrake.com/2008/04/10/php-and-regex-replacing-repeating-characters-with-single-characters-in-a-string/
        $string = preg_replace('{(-)\1+}', '$1', $string);

        // Lowercase the final string
        $string = self::toLower($string);

        if (empty($string)){
            return null;
        }

        return $string;
    }

    /**
     * Validate Alias
     *
     *
     */
    public static function validateAlias($type, $relId = 0, $alias = "", $source = ""){

        $alias = trim($alias);

        if (strlen($alias) > 0){
            $generatedAlias = self::generateAlias($alias);
        }
        else {
            $generatedAlias = self::generateAlias($source);
        }

        if (strlen(trim(trim($generatedAlias, "-"))) === 0){
            $generatedAlias = self::generateAlias($source);
        }

        if ($type === "pages"){
            $getDuplicates = Capsule::table("mod_whmcms_pages")
            ->where("alias", "=", $generatedAlias)
            ->where("pageid", "!=", $relId)
            ->where("topid", "=", 0)
            ->count();
        }

        elseif ($type === "faq"){
            $getDuplicates = Capsule::table("mod_whmcms_faqgroups")
            ->where("alias", "=", $generatedAlias)
            ->where("groupid", "!=", $relId)
            ->where("topid", "=", 0)
            ->count();
        }

        elseif ($type === "portfolio-category"){
            $getDuplicates = Capsule::table("mod_whmcms_portfoliocategories")
            ->where("alias", "=", $generatedAlias)
            ->where("categoryid", "!=", $relId)
            ->where("topid", "=", 0)
            ->count();
        }

        elseif ($type === "portfolio-project"){
            $getDuplicates = Capsule::table("mod_whmcms_portfolio")
            ->where("alias", "=", $generatedAlias)
            ->where("projectid", "!=", $relId)
            ->where("topid", "=", 0)
            ->count();
        }



        if ($getDuplicates > 0){
            $generatedAlias .= "-" . ($getDuplicates + 1);
        }

        return $generatedAlias;

    }

    public static function fromRequest($name, $return = "string"){
        return self::validateInput($_REQUEST[ $name ], $return);
    }

    public static function fromGet($name, $return = "string"){
        return self::validateInput($_GET[ $name ], $return);
    }

    public static function fromPost($name, $return = "string"){
        return self::validateInput($_POST[ $name ], $return);
    }

    public static function fromInput($input, $return = "string"){
        return self::validateInput($input, $return);
    }

    public static function fromConfig($input, $return = "string"){
        return self::validateInput(self::getConfig($input), $return);
    }

    /**
     * Validate Input and make sure to return the requested type
     *
     * @param mixed $input
     * @param string $return    Make sure to return the requested type
     */
    public static function validateInput($input, $return = "string"){

        # Array
        if (is_array($input) || $return === "array"){
            if (!is_array($input) || count($input) === 0) {
                return [];
            }
            return $input;
        }

        # NULL
        if ($return === "null"){
            if (isset($input) === false || strlen(trim($input)) === 0 || is_null($input)){
                return null;
            }
//            if (is_array($input) === true && count($input) === 0){
//                return null;
//            }
            return $input;
        }

        # Bool
        if ($return === "true" || $return === true){
            if (in_array($input, ["on", 1, '1', "1", true, "true"])){
                return true;
            }
        }
        if ($return === "false" || $return === false){
            if (in_array($input, ["", 0, '0', "0", false, "false", null])){
                return false;
            }
        }

        # Integer
        if (in_array($return, ["int", "integer", "number"])){
            return intval($input);
        }

        # String
        if (strlen(trim($input)) === 0 || is_string($input) === false){
            return "";
        }

        return $input;

    }

    /**
     * Get Latest Version Number from WHMCMS.com
     *
     * @return bool/string
     */
    public static function getLatestVersionNumber(){

        $url = 'http://www.whmcms.com/modules/addons/whmcmsupdates/updates.php';

        $postfields = ['licensekey' => self::getConfig("licensekey")];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data);

        if (is_null($json) || !isset($json[0]->latestversion)){
            return false;
        }

        # Validate Version Number
        $split = explode("-", $json[0]->latestversion);
        $split = explode(".", $split[0]);

        $parts = array_filter($split, function($v, $k){
            if (self::fromInput($v) === ""){
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        if (count($parts) === 0){
            return false;
        }

        return $json[0]->latestversion;

    }

    /**
     * Check if WHMCMS is Up-To-Date
     *
     * @return string
     */
    public static function isUpToDate(){

        $latestVersion = self::getLatestVersion();

        $currentVersion = MODVERSION;

        if (isset($latestVersion) === false || isset($currentVersion) === false){
            return "unknown";
        }

        if (version_compare($latestVersion, $currentVersion, ">")){
            return "update available";
        }

        if (version_compare($latestVersion, $currentVersion, "=")){
            return "up to date";
        }

        return "unknown";
    }

    /**
     * Load Supported Icons From Resources Files
     *
     * @return array
     */
    public static function getResourcesIcons(){

        $resources = array();

        # Exclude ".", ".." from list
        $exclude = [".", "..", "index.php", "README.txt"];

        # Read Directory
        $getFiles = new \DirectoryIterator(ROOTDIR . '/modules/addons/whmcms/resources/icons/');

        # Loop All Items Found Inside
        foreach ($getFiles as $file){
            # Only List Valid Files also Exclude unwanted ones
            if (!in_array($file->getFileName(), $exclude) && $file->isFile() === true && $file->getExtension() === "json"){
                $filePath = ROOTDIR . '/modules/addons/whmcms/resources/icons/' . $file->getFileName();
                $fileContent = file_get_contents($filePath, FILE_USE_INCLUDE_PATH);
                $fileName = str_replace(".json", "", self::toLower($file->getFileName()));
                $resources[ $fileName ] = json_decode($fileContent, true);
            }
        }

        return $resources;

    }

    /**
     * Detect Admin Language
     *
     * @return string
     */
    public static function getAdminLanguage(){

        $systemLanguages = self::getSystemLanguages(false);

        # Request
        $language = self::toLower(self::fromRequest("language"));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # Session
        $language = self::toLower(self::fromInput($_SESSION['Language']));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # Database
        # Get Logged-in Admin Language
        $getAdmin = Capsule::table("tbladmins")
        ->where("id", "=", $_SESSION['adminid'])
        ->select("language")
        ->first();
        $getAdmin = (array) $getAdmin;

        $language = self::toLower(self::fromInput($getAdmin['language']));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # CONFIG
        $language = self::getSystemDefaultLanguage();
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

    }

    /**
     * Detect Client Language
     *
     * @return string
     */
    public static function getClientLanguage(){

        $systemLanguages = self::getSystemLanguages(false);

        # Request
        $language = self::toLower(self::fromRequest("language"));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # Session
        $language = self::toLower(self::fromInput($_SESSION['Language']));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # Database
        # Get Logged-in Client Language
        $getClient = Capsule::table("tblclients")
        ->where("id", "=", $_SESSION['uid'])
        ->select("language")
        ->first();
        $getClient = (array) $getClient;

        $language = self::toLower(self::fromInput($getClient['language']));
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

        # CONFIG
        $language = self::getSystemDefaultLanguage();
        if ($language !== "" && in_array($language, $systemLanguages) === true){
            return $language;
        }

    }

    /**
     * Get Translation
     *
     * @return array    $_LANG
     */
    public static function getTranslationFile($language){

        # Include Default Language Files
        if (file_exists(ROOTDIR . '/modules/addons/whmcms/lang/' . $language . '.php')){

            $_LANG = include(ROOTDIR . '/modules/addons/whmcms/lang/' . $language . '.php');

            if (file_exists(ROOTDIR . '/modules/addons/whmcms/lang/overrides/' . $language . '.php')){

                $overridesFile = include(ROOTDIR . '/modules/addons/whmcms/lang/overrides/' . $language . '.php');

                $_LANG = array_replace_recursive($_LANG, $overridesFile);

            }

        }

        # Include Default Language Files
        elseif (file_exists(ROOTDIR . '/modules/addons/whmcms/lang/english.php')){

            $_LANG = include(ROOTDIR . '/modules/addons/whmcms/lang/english.php');

            if (file_exists(ROOTDIR . '/modules/addons/whmcms/lang/overrides/english.php')){

                $overridesFile = include(ROOTDIR . '/modules/addons/whmcms/lang/overrides/english.php');

                $_LANG = array_replace_recursive($_LANG, $overridesFile);

            }

        }

        self::$_LANG = $_LANG;

    }

    /**
     * Get WHMCMS Latest Version Number (the Exact Number)
     *
     * @return string   eg. 3.0.0
     */
    public static function getLatestVersion(){

        if (is_null(self::$latestVersion)){
            self::$latestVersion = self::getLatestVersionNumber();
        }

        return self::$latestVersion;

    }

    /**
     * Apply WHMCMS Rewrite Rules to .htaccess file
     *
     * @return array
     */
    public static function applyRewriteRules(){

        # htaccess file exists and writable
        if (!is_file(ROOTDIR . "/.htaccess") || !is_writable(ROOTDIR . "/.htaccess")){
            return [
                "result" => "error",
                "message" => "Couldn't apply the rewrite rules to .htaccess file, make sure this file exists and writable in WHMCS main directory, <a href='http://www.whmcms.com/link.php?id=9' target='_blank'>for more info</a>."
            ];
        }

        ### Apply Our Rules
        # Save HTACCESS File
        # Get File Content
        $fileContent = file_get_contents(ROOTDIR . '/.htaccess');

        # Rewrite Rules Wasn't Found, Lets Write it for the first time
        if (strpos($fileContent, self::$htaccessStart) === false && strpos($fileContent, self::$htaccessEnd) === false){

            $newFileContent = [];

            $newFileContent[] = self::$htaccessStart;
            $newFileContent[] = self::generateRewriteRules();
            $newFileContent[] = self::$htaccessEnd;

            $fileContent = join("", $newFileContent) . "\n\n" . $fileContent;

        }
        # Rewrite Rules Exists, Lets Update It
        else {

            # Delete old Rules
            $fileContent = self::replaceBetween($fileContent, self::$htaccessStart, self::$htaccessEnd, "");
            $fileContent = str_replace(self::$htaccessStart, "", $fileContent);
            $fileContent = str_replace(self::$htaccessEnd, "", $fileContent);

            # Add New Rules
            $newFileContent = [];

            $newFileContent[] = self::$htaccessStart;
            $newFileContent[] = self::generateRewriteRules();
            $newFileContent[] = self::$htaccessEnd;

            $fileContent = join("", $newFileContent) . "\n\n" . $fileContent;

        }

        # Save The New File
        $openFileForEdit = fopen(ROOTDIR . '/.htaccess', 'w+');
        fwrite($openFileForEdit, $fileContent);
        fclose($openFileForEdit);

        return ["result" => "success"];

    }

    /**
     * Check if WHMCMS Rewrite Rules are up-to-date
     *
     * @return array
     */
    public static function isRewriteRulesUpToDate(){

        # htaccess file exists and writable
        if (!is_file(ROOTDIR . "/.htaccess") || !is_writable(ROOTDIR . "/.htaccess")){
            return [
                "result" => "error",
                "message" => ".htaccess file does not exists or not writable."
            ];
        }

        # Get File Content
        $fileContent = file_get_contents(ROOTDIR . '/.htaccess');
        $fileContent = trim(self::getBetweenTwoStrings($fileContent, self::$htaccessStart, self::$htaccessEnd), "\n");

        # Get Generated Content
        $generatedContent = trim(self::generateRewriteRules(), "\n");

        if (strcmp($fileContent, $generatedContent) === 0){

            return [
                "result" => "success",
                "message" => ".htaccess file has the required rules to make SEO URLs work as expected."
            ];

        }

        return [
            "result" => "nomatch",
            "message" => ".htaccess file has outdated rules, please update it in order for WHMCMS to work as expected."
        ];

    }

    /**
     * Detect WHMCMS Frontend File Version for compatibility purpose
     *
     * return bool/string
     */
    public static function getFrontendFileVersion(){

        global $cc_encryption_hash;

        $url = self::getSystemURL() . self::getConfig("frontendfile");

        $postfields = ['getfrontendfileversion' => md5($cc_encryption_hash)];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data);

        if (is_null($json) || !isset($json->frontendfileversion)){
            return false;
        }

        return $json->frontendfileversion;

    }

    /**
     * Convert String to lowercase
     *
     * @param string The text that will be converted to lowercase
     * @return string lowercase text
     */
    public static function toLower($string){

        if (function_exists("mb_strtolower")){
            return mb_strtolower($string);
        }

        return strtolower($string);

    }

    /**
     * Convert String to uppercase
     *
     * @param string The text that will be converted to uppercase
     * @return string uppercase text
     */
    public static function toUpper($string){

        if (function_exists("mb_strtoupper")){
            return mb_strtoupper($string);
        }

        return strtoupper($string);

    }

    /**
     * Define and Match Route Path URLs
     *
     * @return array    ["action" => "portfolio.project", "params" => ["key" => "value"]]
     *
     */
    public static function getClientAreaRoutePath(){

        # Get WHMCS Base directory
        $baseDirectory = rtrim(self::getBaseDirectory(), "/");

        # Init Router
        $router = new \AltoRouter();

        # Define Custom Regex Patterns
        $router->addMatchTypes([
            "portfoliotag" => '[a-zA-Z0-9-_\s]+',
            "pages" => '[a-zA-Z0-9-]+'
        ]);

        # Define Base Path
        if (strlen($baseDirectory) > 0){
            $router->setBasePath($baseDirectory);
        }

        # Get Request URI
        $requestURI = urldecode($_SERVER['REQUEST_URI']);

        # Parse Request URI based on link format
        # http://awesome.host/whmcms.php?rp=/pagealias
        if (self::fromRequest('rp') !== ""){
            $requestURI = $baseDirectory . "/" . self::getConfig("frontendfile") . "?rp=" . self::fromRequest('rp');
            $router->setBasePath($baseDirectory . "/" . self::getConfig("frontendfile") . "?rp=");
        }
        # http://awesome.host/whmcms.php/pagealias
        elseif (strpos($requestURI, self::getConfig("frontendfile")) !== false) {
            $router->setBasePath($baseDirectory . "/" . self::getConfig("frontendfile"));
        }

        # Homepage
        if (self::fromInput(self::getConfig("homepage"), 'int') > 0){
            $router->map('GET|POST','/', 'pages#homepage', 'pages.homepage');
        }

        # Portfolio
        $router->map('GET','/portfolio/tags/[portfoliotag:tag]', 'portfolio#tag', 'portfolio.tag');
        $router->map('GET','/portfolio/item/[pages:alias]', 'portfolio#project', 'portfolio.project');
        $router->map('GET','/portfolio/[pages:alias]', 'portfolio#category', 'portfolio.category');
        $router->map('GET','/portfolio', 'portfolio#index', 'portfolio.index');

        # FAQ
        $router->map('GET','/faq/[pages:alias]', 'faq#group', 'faq.group');

        # Error Pages
        $router->map('GET','/error/[i:code]', 'errorpages#errorpages', 'errorpages.errorpages');

        # Pages
        $router->map('GET','/[pages:alias]', 'pages#page', 'pages.page');



        # Match Current Request
        $match = $router->match($requestURI);

        return [
            "action" => $match['name'],
            "params" => $match['params'],
        ];

    }

    /**
     * Return String Time Ago From Timestamp
     *
     * @param string    $timestamp Unix time (eg. 15246987632)
     * @return string   2 days ago
     */
    public static function timeAgo($timestamp){

        $periods = [
            WHMCMS::__("commonSecond"),
            WHMCMS::__("commonMinute"),
            WHMCMS::__("commonHour"),
            WHMCMS::__("commonDay"),
            WHMCMS::__("commonWeek"),
            WHMCMS::__("commonMonth"),
            WHMCMS::__("commonYear"),
            WHMCMS::__("commonDecade")
        ];

        $lengths = ["60", "60", "24", "7", "4.35", "12", "10"];
        $now = time();
        $difference = $now - $timestamp;
        $tense= WHMCMS::__("commonAgo");

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[ $j ];
        }
        $difference = round($difference);

        if($difference != 1) {
            $periods[ $j ] .= WHMCMS::__("commonDateS");
        }

        return $difference . ' ' . $periods[ $j ] . ' ' . $tense;

    }

    /**
     *  Get File Extension
     *
     *  Will return null if no extension found (README, .htaccess)
     *
     *  @param string $fileName
     *  @return null/string
     */
    public static function getFileExt($fileName){

        if (self::fromInput($fileName) === ""){
            return null;
        }

        $split = explode(".", $fileName);

        $split = array_filter($split);

        if (count($split) <= 1){
            return null;
        }

        return $split[ count($split) - 1 ];

    }

    public static function redirect($message = "", $messageType = "success", $reloadTo = ""){

        if (strlen($message) > 0){

            $_SESSION['whmcms_message'] = $message;

            if ($messageType === "success"){
                $_SESSION['whmcms_messagetype'] = "info";
            }
            elseif (in_array($messageType, ["error", "danger"])){
                $_SESSION['whmcms_messagetype'] = "danger";
            }
            else {
                $_SESSION['whmcms_messagetype'] = "warning";
            }

        }

        if (strlen($reloadTo) > 0){

            header("Location: " . $reloadTo);

            exit;

        }

        header("Location: " . MODURL);

        exit;

    }

    public static function isAdmin(){

        return self::fromInput($_SESSION['adminid'], 'int') > 0 ? true : false;

    }

    public static function isClient(){

        if (self::fromInput($_SESSION['adminid'], 'int') === 0 && self::fromInput($_SESSION['cid'], 'int') === 0 && self::fromInput($_SESSION['uid'], 'int') > 0){
            return true;
        }

        return false;

    }

    public static function isContact(){

        if (self::fromInput($_SESSION['adminid'], 'int') === 0 && self::fromInput($_SESSION['cid'], 'int') > 0){
            return true;
        }

        return false;

    }

    public static function isVisitor(){

        if (self::fromInput($_SESSION['adminid'], 'int') === 0 && self::fromInput($_SESSION['cid'], 'int') === 0 && self::fromInput($_SESSION['uid'], 'int') === 0){
            return true;
        }

        return false;

    }

    public static function getUserType(){

        if (self::isAdmin() === true){
            return "admin";
        }

        if (self::isContact() === true){
            return "contact";
        }

        if (self::isClient() === true){
            return "client";
        }

        return "visitor";

    }

    public static function addToBreadCrumbs($link, $title){

        self::$breadcrumbs[ $link ] = $title;

    }

    public static function getBreadCrumbs(){

        return self::$breadcrumbs;

    }

    /* PageId => Title */
    public static function getPageParentsTree($pageId){

        $pages = [];

        # Get Page
        $getPage = Capsule::table("mod_whmcms_pages")
        ->where("pageid", "=", $pageId);
        $getPage = (array) $getPage->first();

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_pages")
        ->where("topid", "=", $pageId)
        ->where("language", "=", self::getClientLanguage())
        ->select("title");

        if ($getTranslation->count() > 0){
            $getTranslation = (array) $getTranslation->first();
            $getPage['title'] = ((self::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $getPage['title']);
        }

        if ($getPage['parentid'] > 0){
            $getParents = self::getPageParentsTree($getPage['parentid']);
            foreach ($getParents as $parent){
                $pages[] = $parent;
            }
        }

        $pages[] = [
            "pageid" => $pageId,
            "title" => $getPage['title'],
            "url" => self::generateFriendlyURL($getPage, "pages.page")
        ];

        return $pages;

    }

    public static function generateFriendlyURL($data = [], $type = ""){

        # Default
        $alias = $data['alias'];

        # Pages
        if ($type === "pages.homepage"){
            return self::getSystemURL();
        }
        if ($type === "pages.page"){
            $alias = $data['alias'];
        }

        # FAQ
        if ($type === "faq.group"){
            $alias = "faq/" . $data['alias'];
        }

        # ErrorPages
        if ($type === "errorpages.errorpages"){
            $alias = "error/" . $data['code'];
        }

        # Portfolio Index
        if ($type === "portfolio.index"){
            $alias = "portfolio";
        }

        # Portfolio Category
        if ($type === "portfolio.category"){
            $alias = "portfolio/" . $data['alias'];
        }

        # Portfolio Tags
        if ($type === "portfolio.tag"){
            $alias = "portfolio/tags/" . $data['alias'];
        }

        # Portfolio Project
        if ($type === "portfolio.project"){
            $alias = "portfolio/item/" . $data['alias'];
        }

        if (self::getConfig("FriendlyURLsMode") === "fully"){
            return self::getSystemURL() . $alias;
        }
        elseif (self::getConfig("FriendlyURLsMode") === "friendly"){
            return self::getSystemURL() . self::getConfig("frontendfile") . "/" . $alias;
        }

        return self::getSystemURL() . self::getConfig("frontendfile") . "?rp=/" . $alias;

    }

    public static function randomInt($length = 6){
        $chars = "1234567890";
        $string = "";
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($chars)-1);
            $string .= $chars[$pos];
        }

        return $string;
    }

    public static function __($key, $staticKeys = []){

        # Detect Language
        if (self::$language === null){
            if (defined("CLIENTAREA") === true && CLIENTAREA === true && self::getUserType() !== "admin"){
                self::$language = self::getClientLanguage();
            }
            else {
                self::$language = self::getAdminLanguage();
            }
        }

        # Load Translation Files
        if (self::$_LANG === null){

            self::getTranslationFile(self::$language);

        }

        if (isset(self::$_LANG[ $key ])){
            return self::translateStaticKeys(self::$_LANG[ $key ], $staticKeys);
        }

        $split = explode(".", $key);

        if (isset(self::$_LANG[ $split[0] ][ $split[1] ])){
            return self::translateStaticKeys(self::$_LANG[ $split[0] ][ $split[1] ], $staticKeys);
        }

        return $key;

    }

    protected static function translateStaticKeys($string, $extra = []){

        $keys = [
            ":systemurl" => self::getSystemURL(),
            ":frontendfile" => self::getConfig("frontendfile")
        ];

        $keys = array_merge($keys, $extra);

        foreach ($keys as $key => $value){
            $string = str_replace($key, $value, $string);
        }

        return $string;

    }

    public static function getPortfolioTags(){

        $tags = [];

        $getProjects = Capsule::table("mod_whmcms_portfolio")
        ->where("topid", "=", 0)
        ->where("enable", "=", 1)
        ->select("tags");

        foreach ($getProjects->get() as $project){

            $project = (array) $project;

            $projectTags = explode(",", $project['tags']);

            foreach ($projectTags as $tag){
                $tag = trim($tag);

                if(isset($tags[ self::toLower($tag) ])){
                    continue;
                }

                $tags[ self::toLower($tag) ] = $tag;
            }

        }

        return $tags;
    }

    /**
     * Cut text to specific length.
     *
     * @author JoseRobinson.com
     * @version 201306301956
     * @link GitHup: https://gist.github.com/5897554
     * @param string $str The text to cut.
     * @param int $limit The maximum number of characters that must be returned.
     * @param stirng $brChar The character to use for breaking the string.
     * @param string $pad The string to use at the end of the cutted string.
     * @return string
     */
    public static function cutText($str, $limit, $brChar = ' ', $pad = '...'){

        if (empty($str) || strlen($str) <= $limit) {
            return $str;
        }

        $output = substr($str, 0, ($limit+1));
        $brCharPos = strrpos($output, $brChar);
        $output = substr($output, 0, $brCharPos);
        $output = preg_replace('#\W+$#', '', $output);
        $output .= $pad;

        return $output;
    }


}

?>
