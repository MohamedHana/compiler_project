<?php
    require("../includes/functions.php");
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $source_code = $_POST["source_code"];
        
        //character list can be considered as a word
        $additional_words = ["=" , "==" , ">=" , "<=" , "<" , ">" , "+" , "-" ,"*" , "/" , "(" , ")" , ";" , "," ,
                             "0" , "1" , "2" , "3" , "4" , "5" , "6" , "7" , "8" , "9"] ;
        
        $additional_words = implode("," , $additional_words);
        
        //extract each word inside the given source code
        $lexemes = str_word_count($source_code , 2 , $additional_words);
        
        extract($lexemes);
        require("../templates/tables.php");   
        
    }    
?>
