<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Minify
 *
 * A minification driver system for CodeIgniter
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     ci-minify
 * @author      Eric Barnes
 * @copyright   Copyright (c) Eric Barnes. (http://ericlbarnes.com/)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link        http://ericlbarnes.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Minify Driver
 *
 * @subpackage  Drivers
 */
class Minify extends CI_Driver_Library {

    /**
     * CI Object
     *
     * @var object
     */
    protected $_ci = '';

    /**
     * valid drivers
     *
     * @var array
     */
    public $valid_drivers = array('css', 'js');

    // Folder
    public $css_dir = '';
    public $js_dir = '';
    public $assets_dir = '';

    // Minify file
    public $js_array = array();
    public $css_array = array();

    // Ouput file
    public $css_file = '';
    public $js_file = '';

    // Output filetime
    private $_file_modify_time = array('css' => 0 , 'js' => 0);

    // ------------------------------------------------------------------------

    /**
     * Construct
     *
     * Initialize params
     *
     * @return \Minify
     */
    public function __construct()
    {
        $this->_ci =& get_instance();
        $this->_ci->load->config('minify', TRUE);
        $this->_ci->load->helper('url');
        $this->_setup();
        log_message('debug', 'CI-Minify: Library initialized.');
    }

    /**
     *  Setting Minify Configuration
     */
    private function _setup()
    {
        // assign variables from confif file
        if (empty($this->css_dir))
        {
            $this->css_dir = $this->_ci->config->item('css_dir', 'minify');
        }

        // check JS dir
        if (empty($this->js_dir))
        {
            $this->js_dir = $this->_ci->config->item('js_dir', 'minify');
        }

        // check general assets dir
        if (empty($this->assets_dir))
        {
            $this->assets_dir = $this->_ci->config->item('assets_dir', 'minify');
            if (!is_writable($this->assets_dir))
            {
                die('Assets directory is not writeable');
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Combine Files
     *
     * Pass an array of files and combine them.
     * @param array $files
     * @param string $type
     * @param bool $compact
     * @param string $css_charset
     * @return mixed
     */
    public function combine_files($files = array(), $type = '', $compact = TRUE, $css_charset = 'utf-8')
    {
        if ( ! is_array($files) OR count($files) < 1)
        {
            log_message('error', 'Minify->combine_files missing files array');
            return FALSE;
        }

        return $this->_do_combine($files, $type, $compact, $css_charset);
    }

    // ------------------------------------------------------------------------

    /**
     * Combine Directory
     *
     * Pass a directory and combine all the files into one string.
     *
     * @param string $directory
     * @param array $ignore
     * @param string $type
     * @param bool $compact
     * @param string $css_charset
     * @return string
     */
    public function combine_directory($directory = '', $ignore = array(), $type = '', $compact = TRUE, $css_charset = 'utf-8')
    {
        $available = array();

        if ($directory == '' OR ! is_dir($directory))
        {
            log_message('error', 'Minify->combine_directory missing files array');
            return FALSE;
        }

        $this->_ci->load->helper('directory');
        foreach (directory_map($directory, TRUE) as $dir => $file)
        {
            if ($this->_get_type($file) == 'js' OR $this->_get_type($file) == 'css')
            {
                $available[$file] = $directory.'/'.$file;
            }
        }

        // Finally get ignored files
        if (count($ignore) > 0)
        {
            foreach ($available AS $key => $file)
            {
                if (in_array($key, $ignore))
                {
                    unset($available[$key]);
                }
            }
        }

        return $this->_do_combine($available, $type, $compact, $css_charset);
    }

    // ------------------------------------------------------------------------

    /**
     * Do combine
     *
     * Combine all the files and return a string.
     *
     * @param array $files
     * @param string $type
     * @param bool $compact
     * @param string $css_charset
     * @return string
     */
    private function _do_combine($files, $type, $compact = TRUE, $css_charset = 'utf-8')
    {
        $contents = '';
        $file_count = 0;

        foreach ($files AS $file)
        {
            if ( ! file_exists($file))
            {
                log_message('error', 'Minify->_do_combine missing file '.$file);
                continue;
            }

            $file_count++;

            if ($type == '')
            {
                $type = $this->_get_type($file);
            }

            $path_info = pathinfo($file, PATHINFO_BASENAME); // Referal File and path

            if ($type == 'css')
            {
                // only one charset placed at the beginning of the document is allowed
                // in order to keep standars compliance and fixing Webkit problems
                // Note: Minify_css driver yet remove all charsets previously
                if ($file_count == 1)
                {
                    $contents .= '@charset "'.$css_charset.'";'."\n";
                }
                $contents .= "\n".'/* @fileRef '.$path_info.' */'."\n";
                $contents .= $this->css->min($file, $compact, $is_aggregated = TRUE);
            }
            elseif ($type == 'js')
            {
                unset($css_charset);
                $contents .= "\n".'// @fileRef '.$path_info.' '."\n";
                $contents .= $this->js->min($file, $compact);
            }
            else
            {
                $contents .= $file."\n\n";
            }
        }

        return $contents;
    }

    // ------------------------------------------------------------------------

    /**
     * Save File
     *
     * Save a file
     *
     * @param string $contents
     * @param string $full_path
     * @return bool
     */
    public function save_file($contents = '', $full_path = '')
    {
        $this->_ci->load->helper('file');

        if ( ! write_file($full_path, $contents))
        {
            log_message('error', 'Minify->save_file could not write file');
            return FALSE;
        }
        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Type
     *
     * Get the file extension to determine file type
     *
     * @param string $file
     * @return string
     */
    private function _get_type($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }


    /**
     *  Add JS or CSS file
     */
    public function addfile($files)
    {
        foreach ($files as $file)
        {
            $type = $this->_get_type($file);
            switch ($type)
            {
                case 'js':
                    $filepath = $this->js_dir . '/' . $file;
                    $this->js_array[] = $filepath;
                    break;
                case 'css':
                    $filepath = $this->css_dir . '/' . $file;
                    $this->css_array[] = $filepath;
                    break;
                default:
                    break;
            }
        }
        return $this;
    }


    /**
     * Prepare deploy file
     */
    public function prepare_file($file)
    {
        $prepare_file = $this->assets_dir . '/' . $file;

        $type = $this->_get_type($file);

        switch ($type)
        {
            case 'js':
                $this->js_file = $prepare_file;
                break;
            case 'css':
                $this->css_file = $prepare_file;
                break;
            default:
                die('Only support JS or CSS File');
                break;
        }


        if (file_exists($prepare_file) && !is_writable($prepare_file))
        {
            die("Can\'t write to file {$prepare_file}");
        }


        // Create deploy file
        if (!file_exists($prepare_file))
        {
            if (!touch($prepare_file))
            {
                die("Can't create file {$prepare_file}");
            }
        }
        else
        {
            $this->_file_modify_time[$type] = filemtime($prepare_file);
        }

        return $this;
    }


    /**
     * scan CSS direcctory and look for changes
     *
     * @param $type
     */
    public function scan_files($type, $force)
    {
        switch ($type)
        {
            case 'css':
                $files_array = $this->css_array;
                $directory   = $this->css_dir;
                $out_file    = $this->css_file;
                break;
            case 'js':
                $files_array = $this->js_array;
                $directory   = $this->js_dir;
                $out_file    = $this->js_file;
        }

        if (is_array($files_array))
        {
            $compile = FALSE;
            foreach ($files_array as $filename)
            {
                if (file_exists($filename))
                {
                    if (filemtime($filename) > $this->_file_modify_time[$type])
                    {
                        $compile = TRUE;
                    }
                }
                else
                {
                    die("File {$filename} is missing");
                }
            }

            // check if this is init build
            if (filesize($out_file) == 0)
            {
                $force = true;
            }

            if ($compile || $force)
            {
                // combine file
                $contents = $this->combine_files($files_array);

                // write minify file
                if ($fh = fopen($out_file, 'w'))
                {
                    fwrite($fh, $contents);
                    fclose($fh);
                }
                else
                {
                    die("Can't write to {$out_file}");
                }
            }
        }
        return $this;
    }


    /**
     * Generate JS or CSS html script
     */
    public function deploy($file , $force = FALSE)
    {
        $this->_ci->load->helper('html');

        $type = $this->_get_type($file);

        $this->prepare_file($file);

        $this->scan_files($type , $force);

        switch ($type)
        {
            case 'js':
                $script = "<script type=\"text/javascript\" src=\"" . base_url($this->js_file) . "?t=" .$this->_file_modify_time['js']. "\"></script>";
                break;
            case 'css':
                $script = link_tag($this->css_file . "?t=" .$this->_file_modify_time['css']);
                break;
            default:
                die('Only support JS or CSS File');
                break;
        }
        return $script;
    }
}

/* End of file Minify.php */
/* Location: ./application/libraries/Minify/Minify.php */
