#!/usr/local/bin/php
<?php
/**
 * client2pot.php - rips gettext strings from smarty template and client .ini
 *
 * This command line script rips gettext strings from smarty file and .ini, and
 * save one file per project. If file already exists, calls msgmerge.
 *
 * Usage:
 * ./client2pot.php
 *
 * Original code was tsmarty2c.php written by Sagi Bashari <sagi@boom.org.il>
 *
 * @package Scripts
 * @author Yves Bolognini <yves.bolognini@camptocamp.com>
 */

/**
 * Home dirs
 */ 
define('CARTOCLIENT_HOME', realpath(dirname(__FILE__) . '/..') . '/');
define('CARTOCOMMON_HOME', realpath(dirname(__FILE__) . '/..') . '/');
define('CARTOCLIENT_PODIR', CARTOCLIENT_HOME . 'po/');

/**
 * Encoding class for charset
 */
require_once(CARTOCOMMON_HOME . 'common/Encoding.php');

// smarty open tag
$ldq = preg_quote('{');

// smarty close tag
$rdq = preg_quote('}');

// smarty command
$cmd = preg_quote('t');

// extensions of smarty files, used when going through a directory
$extensions = array('tpl');

/**
 * "Fix" string - strip slashes, escape and convert new lines to \n
 * @param string
 * @return string
 */
function fs($str) {
    $str = stripslashes($str);
    $str = str_replace('"', '\"', $str);
    $str = str_replace("\n", '\n', $str);
    return $str;
}

/**
 * Rips gettext strings from $file and prints them in POT format
 * @param string
 * @param array map text_to_translate => references
 * @param array map of texts plurals
 */
function do_file($file, &$texts, &$plurals) {
    $content = @file_get_contents($file);
   
    if (empty($content)) {
        return;
    }

    global $ldq, $rdq, $cmd;

    $regexp = sprintf("/{%s}\s*({%s})\s*([^{%s}]*){%s}([^{%s}]*){%s}\/\\1{%s}/",
                      $ldq, $cmd, $rdq, $rdq, $ldq, $ldq, $rdq);

    preg_match_all($regexp, $content, $matches);
    
    for ($i = 0; $i < count($matches[0]); $i++) {
        $text = fs($matches[3][$i]);
        $ref = substr($file, (strlen(CARTOCLIENT_HOME) - strlen($file)));
        if (array_key_exists($text, $texts)) {
            $texts[$text] .= ',' . $ref;
        } else {
            $texts[$text] = $ref;
        }
        if (preg_match('/plural\s*=\s*["\']?\s*(.[^\"\']*)\s*["\']?/', 
                       $matches[2][$i], $match)) {
            $plurals[$text] = fs($match[1]);
        }
    }
}

/**
 * Goes through a directory
 * @param string
 * @param string project name or ''
 * @param array map text_to_translate => references
 * @param array map of texts plurals
 */
function do_dir($dir, $project, &$texts, &$plurals) {
    
    // Include directory if:
    // - no projects set and not in projects directory, or
    // - project set and not in projects directory OR in this specific project
    // directory
    if (($project == '' && !strstr($dir, 'projects/'))
        || ($project != ''
            && (strstr($dir, 'projects/' . $project)))) {

        $d = dir($dir);
    
        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
    
            $entry = $dir.$entry.'/';

            if (is_dir($entry)) { // if a directory, go through it
                do_dir($entry, $project, $texts, $plurals);
            } else { // if file, parse only if extension is matched
                $pi = pathinfo($entry);
                
                if (isset($pi['extension']) && 
                    in_array($pi['extension'], $GLOBALS['extensions'])) {
                    do_file($entry, $texts, $plurals);
                }
            }
        }
    
        $d->close();
    }
}

/**
 * Finds charset in client.ini
 * @param string
 * @return string
 */
function getCharset($project) {
    
    $class = null;
    $iniFile = CARTOCLIENT_HOME;
    $projectIniFile = CARTOCLIENT_HOME;
    if ($project != '') {
        $projectIniFile .= 'projects/' . $project. '/';
    }
    $iniFile .= 'client_conf/client.ini';
    $projectIniFile .= 'client_conf/client.ini';
    if (file_exists($projectIniFile)) {
        $iniArray = parse_ini_file($projectIniFile);
        if (array_key_exists('EncoderClass.config', $iniArray)) {
            $class = $iniArray['EncoderClass.config'];
        }
    }
    if (is_null($class) && $iniFile != $projectIniFile
                          && file_exists($iniFile)) {
        $iniArray = parse_ini_file($iniFile);
        if (array_key_exists('EncoderClass.config', $iniArray)) {
            $class = $iniArray['EncoderClass.config'];
        }
    }
    if (is_null($class)) {
        $class = 'EncoderUTF';
    }
    $obj = new $class;
    return $obj->getCharset();
}

/**
 * Gets list of projects by reading projects directory
 * @return array
 */
function getProjects() {

    $projects = array();
    $dir = CARTOCLIENT_HOME . 'projects/';
    $d = dir($dir);
    while (false !== ($entry = $d->read())) {
        if (is_dir($dir . $entry) && $entry != '.'
            && $entry != '..' && $entry != 'CVS') {
            $projects[] = $entry;
        }
    }    
    return $projects;
}

/**
 * Finds list of already translated PO files for a project
 * @param string
 * @return array
 */
function getTranslatedPo($project) {
    
    $files = array();
    $dir = CARTOCLIENT_HOME . 'po/';
    $d = dir($dir);

    $pattern = "client\\-";
    if ($project == '') {
        $pattern .= "default\\.(.*)\\.po";
    } else {
        $pattern .= "$project\\.(.*)\\.po";
    }
 
    while (false !== ($entry = $d->read())) {
        if (!is_dir($dir . $entry)) {
            if (ereg($pattern, $entry)) {
            
                $files[] = $entry;
            };
        }
    }    
 
    return $files;   
}

/**
 * Parses an INI file looking for variable ending with '.label'
 * @param string
 * @param array map text_to_translate => references
 * @return boolean
 */
function parseIni($project, &$texts) {

    $iniPath = CARTOCLIENT_HOME;
    if ($project != '') {
        $iniPath .= 'projects/' . $project. '/';
    }
    $iniPath .= 'client_conf/';
    
    if (!is_dir($iniPath)) {
        return true;
    }
    $d = dir($iniPath);
    while (false !== ($entry = $d->read())) {
        if (!is_dir($entry) && substr($entry, -4) == '.ini') {
            $iniFile = $iniPath . $entry;
            $iniArray = parse_ini_file($iniFile);
            foreach($iniArray as $key => $value) {
                if (substr($key, -6) == '.label') {
                    $info = $entry . ':' . $key;
                    if (array_key_exists($value, $texts)) {
                        $texts[$value] .= ',' . $info;
                    } else {
                        $texts[$value] = $info;
                    }
                }
            }
        }
    }
    return true;
}

$projects = getProjects();
// Adds default project
$projects[] = '';

foreach ($projects as $project) {

    $dir = CARTOCLIENT_HOME;
    if ($project != '') {
        $dir .= 'projects/' . $project . '/';
    }
    if (is_dir($dir)) {
    
        // arrays with all translations found
        $texts = array();
        $plurals = array();

        $fileName = 'client-default.po';
        if ($project != '') {
            $fileName = 'client-' . $project . '.po';
        }

        print "Creating new template $fileName ";

        $fh = fopen(CARTOCLIENT_PODIR . $fileName, 'w');
    
        // POT header
        fwrite($fh, '# CartoWeb 3 translation template ' . "\n");
        fwrite($fh, '#' . "\n");
        fwrite($fh, '#, fuzzy' . "\n");
        fwrite($fh, 'msgid ""' . "\n");
        fwrite($fh, 'msgstr ""' . "\n");
        fwrite($fh, '"POT-Creation-Date: ' . date('Y-m-d H:iO') . '\n"' . "\n");
        fwrite($fh, '"MIME-Version: 1.0\n"' . "\n");
        fwrite($fh, '"Content-Type: text/plain; charset=' . 
                                        getCharset($project) . '\n"' . "\n");
        fwrite($fh, '"Content-Transfer-Encoding: 8bit\n"' . "\n");

        parseIni($project, $texts);
        do_dir($dir, $project, $texts, $plurals);

        foreach ($texts as $text => $files) {
            fwrite($fh, "\n");
            foreach (explode(',', $files) as $file) {
                fwrite($fh, "#: $file\n");
            }
            fwrite($fh, 'msgid "' . $text . '"' . "\n");
            if (array_key_exists($text, $plurals)) {
                fwrite($fh, 'msgid_plural "' . $plurals[$text] . '"' . "\n");
                fwrite($fh, 'msgstr[0] ""' . "\n");
                fwrite($fh, 'msgstr[1] ""' . "\n");
            } else {
                fwrite($fh, 'msgstr ""' . "\n");
            }
        }
    
        fclose($fh);
        
        print ".. done.\n";
             
        $poFiles = getTranslatedPo($project);

        foreach ($poFiles as $poFile) {
        
            print "Merging new template into $poFile ";
            exec("msgmerge -o " . CARTOCLIENT_PODIR . "$poFile  "
                 . CARTOCLIENT_PODIR . "$poFile " . CARTOCLIENT_PODIR . "$fileName");
        }                
    }
}
    
?>
