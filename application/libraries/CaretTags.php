<?
h2o::addTag('get_from');
h2o::addTag('children_of');

class Get_from_Tag extends H2o_Node{
    var $page;

    function __construct($argstring, $parser, $pos=0) {
        $this->page = $argstring;
        $this->body = $parser->parse('endget_from');
        $options = $parser->options;
    }

    function render($context, $stream){
        $yaml = new sfYamlParser();
       
        // Parse the contents of the yaml file into the $page array
        $page = $yaml->parse(file_get_contents('pages/' . $this->page . '.yaml'));

        $output = new StreamWriter;
       
        $context->set('get', $page);
        $this->body->render($context, $output);
        
        $output = $output->close();

        $stream->write($output);
    }
}

class Children_of_Tag extends H2o_Node{
   
    function __construct($argstring, $parser, $pos=0) {
        $this->page = $argstring;
        $this->body = $parser->parse('endchildren_of');
        $options = $parser->options;
    }
    
    function render($context, $stream){

        $CI =& get_instance();

        $CI->load->helper('directory');

        // Map the directory beneath the specified folder
        $children = directory_map('pages/' . $this->page . '/');
        $yaml = new sfYamlParser();
        
        for ($i=0; $i < count($children) ; $i++) { 
            // Loop through all the filenames and parse their yaml data into an array
            $page = $yaml->parse(file_get_contents('pages/' . $this->page . '/' . $children[$i]));
            $children[$i] = $page;
        }
        
        $output = new StreamWriter;
       
        $context->set('children', $children);
        $this->body->render($context, $output);
        
        $output = $output->close();

        $stream->write($output); 
    }
    
}
