<?
h2o::addFilter('markdown');

class CaretFilters extends FilterCollection{
    
    function markdown($text){
        // Parses template text into markdown
        return parse_markdown($text); 
    }
    
}
