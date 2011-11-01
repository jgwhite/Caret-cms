<?
h2o::addTag('get_from');

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
