<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Caret {

    public function render_page($page_uri){
        // Get the controller instance of CodeIgniter
        $CI =& get_instance();
        
        // Load required files
        $CI->load->spark('markdown/1.2.0');
        $CI->load->helper('url');
        
        require('application/libraries/h2o-php/h2o.php');
        require('CaretFilters.php');
        require('CaretTags.php');
        include('application/libraries/yaml/lib/sfYamlParser.php');
        
        // Instantiate a new Yaml Parser
        $yaml = new sfYamlParser();
        
        // Parse the contents of the yaml file into the $page array
        $page = $yaml->parse(file_get_contents('pages/' . $page_uri));

        // Create the site array globals
        $site = array(
          'root' => base_url()  
        );
        
        // Load the template
        $h2o = new h2o('templates/' . $page['template'] . '.html'); // load the template

        
        // Return the final html
        return html_entity_decode($h2o->render(compact('page', 'site')));
    }

    public function render_admin_page($template_name, $page){
        $CI =& get_instance();

        $CI->load->spark('markdown/1.2.0');
        require('application/libraries/h2o-php/h2o.php');

        $h2o = new h2o('templates-admin/' . $template_name . '.html'); // load the template

        h2o::addFilter('markdown');
        
        return html_entity_decode($h2o->render(compact('page')));
    }

    public function find_page($uri){
        // Resolves a URI to a file within pages/
        if ($uri == "") { // If uri is blank, assume we mean the homepage
            return "index.yaml"; // Look for the index.yaml datafile
        }else{ // Otherwise, parse the uri to find the matching datafile
            if (is_dir('pages/' . $uri)) {// Check the directory exists
                return $uri . '/index.yaml'; // Return the index.yaml file in this directory
            }else{
                // Check the file exists
                if (file_exists('pages/' . $uri . '.yaml')) {
                    return $uri . '.yaml';
                }else{
                    // Throw 404
                    show_404(); 
                }
            }
            
        }
    }

}

