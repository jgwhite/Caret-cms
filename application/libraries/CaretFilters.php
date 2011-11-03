<?
h2o::addFilter('markdown');
h2o::addFilter('textile');

class CaretFilters extends FilterCollection{
    
    function markdown($text){
        // Parses template text into markdown
        return parse_markdown($text); 
    }
    
    function textile($text){
        $textile = new Textile;
        return $textile->TextileThis($text);
    }
}
