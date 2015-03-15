<?php
    require("../includes/functions.php");    
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get the source code from user
        $source_code = $_POST["source_code"];
        
        //chunck the whole code to individual characters
        $every_character = preg_split("//", $source_code);
        
        //to detect the end of the source code 
        $every_character[] = " ";
        
        //get the length of the characters array
        $source_code_length = count($every_character);   
        
        //variable to check the word status (if true then the word finished else the word didn't finished yet)                                
        $check = false;       
                       
        //loop throw each character 
        for($i = 0 ; $i < $source_code_length ; $i++)
        {
            if($every_character[$i] == "{")
            {                                                               
                for($z = $i ; $z < $source_code_length ; $z++)       
                {
                    if($every_character[$i] == "}")
                    {                        
                        $comments[] = $every_character[$i];
                        break; 
                    }
                    else
                    {                                                
                        $comments[] = $every_character[$i];
                        $i++;                                                
                    }
                }                                
            }
            else
            {
                if($every_character[$i] == " " || $every_character[$i] == "\n" || $every_character[$i] == "\t")
                {                        
                    $spaces[] = $i;                    
                    $check = true;
                }           
                else if($every_character[$i] == "+")
                {                    
                    $add[] = $i;                                       
                    $check = true;
                }
                else if($every_character[$i] == "-")  
                {
                    $sub[] = $i;                   
                    $check = true;
                } 
                else if($every_character[$i] == "*")
                {
                    $mult[] = $i;                    
                    $check = true;
                }
                else if($every_character[$i] == "/")
                {
                    $div[] = $i;                    
                    $check = true;
                }
                else if($every_character[$i] == ">")
                {
                    $greater[] = $i;                    
                    $check = true;
                }
                else if($every_character[$i] == "<")
                {
                    $smaller[] = $i;                    
                    $check = true;
                }
                else if($every_character[$i] == "=")
                {
                    $equal[] = $i;         
                    $check = true;
                }
                else if($every_character[$i] == "(")
                {
                    $open_bracket[] = $i;                    
                    $check = true;
                }
                else if($every_character[$i] == ")")
                {
                    $close_bracket[] = $i;
                    $check = true;
                }
                else if($every_character[$i] == ";")
                {
                    $semi_col[] = $i;
                    $check = true;
                }
                else if($every_character[$i] == ":" && $every_character[$i+1] == "=")
                {
                    $assign[] = $i;
                    $assign[] = $i+1;
                    $i++;
                    $check = true;
                }
                else
                {
                    $words_and_numbers[] = $i;                                                                                 
                    $check = false;                                                         
                }               
                
                if($check)   
                {   
                    if(isset($word))  
                    {                  
                        $all_words[] =  implode($word);                    
                        $array_of_tokens[] = implode($word);                    
                        unset($word);                         
                    }   
                    
                    if($every_character[$i] != " " && $every_character[$i] != "\n" && $every_character[$i] != "\t")                   
                        {
                            if($every_character[$i-1] == ":" && $every_character[$i] == "=")
                            {
                                $array_of_tokens[] = $every_character[$i-1].$every_character[$i];
                            }
                            else
                            {
                                $array_of_tokens[] = $every_character[$i];
                            }
                        }
                }
                else
                {
                    $word[] = $every_character[$i];                
                }
             }                                                           
        }   
        
        $tokens_array_length = count($array_of_tokens);
        //loop to determine each token category and type
        for($i=0 ; $i<$tokens_array_length ; $i++)
        {
            if($array_of_tokens[$i] == " ")
            {
                continue;
            }
            elseif($array_of_tokens[$i] == "if" || $array_of_tokens[$i] == "else" || $array_of_tokens[$i] == "end" ||
               $array_of_tokens[$i] == "repeat" || $array_of_tokens[$i] == "then" || $array_of_tokens[$i] == "until" ||
               $array_of_tokens[$i] == "read" || $array_of_tokens[$i] == "write")
            {
               $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "key_word" , "category"=> "reserved_word" ];
               $each_token[] = $array_of_tokens[$i];
               $token_type[] = "keyword";
            }
            elseif($array_of_tokens[$i] == ">" || $array_of_tokens[$i] == "<" || $array_of_tokens[$i] == "=")   
            {
               $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "comparison_op" , "category"=> "operator" ];  
               $each_token[] = $array_of_tokens[$i];
               $token_type[] = "comparison_op";               
            }
            elseif($array_of_tokens[$i] == ":=")
            {
               $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "assign_op" , "category"=> "operator" ];  
               $each_token[] = $array_of_tokens[$i];
               $token_type[] = "assign_op";
            }
            elseif($array_of_tokens[$i] == "+" || $array_of_tokens[$i] == "-" || $array_of_tokens[$i] == "*" || $array_of_tokens[$i] == "/")
            {
                if($array_of_tokens[$i] == "+" || $array_of_tokens[$i] == "-")
                {
                     $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "add_minus_op" , "category"=> "operator" ];     
                     $each_token[] = $array_of_tokens[$i];
                     $token_type[] = "add_minus_op";
                }
                else
                {
                     $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "mul_div_op" , "category"=> "operator" ];     
                     $each_token[] = $array_of_tokens[$i];
                     $token_type[] = "mul_div_op";
                }                
            }
            elseif($array_of_tokens[$i] == "(" || $array_of_tokens[$i] == ")" || $array_of_tokens[$i] == ";")
            {
                $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "symbol" , "category"=> "symbol" ];     
                $each_token[] = $array_of_tokens[$i];
                $token_type[] = "symbol";
            }
            elseif(eregi("[[:digit:]]" , $array_of_tokens[$i]) && !eregi("[[:alpha:]]" , $array_of_tokens[$i]))
            {
                $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "number" , "category"=> "number" ];     
                $each_token[] = $array_of_tokens[$i];
                $token_type[] = "number";
            }
            elseif(eregi("[[:alnum:]]" , $array_of_tokens[$i]) && eregi("^[[:alpha:]]" , $array_of_tokens[$i]))
            {
                if(eregi("[^a-zA-Z0-9]" , $array_of_tokens[$i]))
                {
                    $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "unknown_token" , "category"=> "unaccepted_token" ];     
                    $each_token[] = $array_of_tokens[$i];
                    $token_type[] = "unknown_token";       
                }   
                else
                {
                    $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "id" , "category"=> "identifier" ];     
                    $each_token[] = $array_of_tokens[$i];
                    $token_type[] = "id";
                } 
            }
            else
            {
                $tokens_and_lexemes[] = ["token"=>$array_of_tokens[$i] , "type"=> "unknown_token" , "category"=> "unaccepted_token" ];     
                $each_token[] = $array_of_tokens[$i];
                $token_type[] = "unknown_token";
            }
        }                       
        
        //dump($tokens_and_lexemes);
        extract($array_of_tokens);                    
        require("../templates/tables.php");   
        
        
        
                //start parsing                                       
      /*  $output = program($each_token , $token_type);
        
        if(empty($output))
        {
            echo "Your program is ready for compiler";
        }
        else
        {
            extract($output);
        }*/
        
                                                            
    }  
        
    
 /*

function program($each_token , $token_type)
{
    $length = count($each_token);
    $start = 0;
    
    $output = stmt_seq($each_token , $token_type , $length , $start);
    
    return $output;
    
}
 
 
function stmt_seq($each_token , $token_type , $length , $start) 
{
    for($x=$start ; $start<$length ; $x++)
    {
        if($each_token[$x] == "if") 
        {
            $x = if_stmt($each_token , $token_type , $length , $start);   
        }
        elseif($each_token[$start] == "repeat")
        {
            $x = repeat_stmt($each_token , $token_type , $length , $start);   
        }
        elseif($each_token[$start] == "read")
        {
            $x = read_stmt($each_token , $token_type , $length , $start);   
        }
        elseif($each_token[$start] == "write")        
        {
            $x = write_stmt($each_token , $token_type , $length , $start);   
        }
        elseif($token_type[$start] == "id")
        {
            $x = assign_stmt($each_token , $token_type , $length , $start);   
        }
        else
        {
            if($token_type[$x] == "number")
            {
                $error_message[] = "You can't start your statment with number !!";                        
            }
            elseif($token_type[$x] == "assign_op")
            {
                $error_message[] = "Not valid assignment operation!!";            
            }
            elseif($token_type[$x] == "comparison_op" || $token_type[$x] == "add_minus_op" || $token_type[$x] == "mul_div_op")
            {
                $error_message[] = "This operator missing identifiers and values!!";           
            }
            elseif($token_type[$x] == "symbol")
            {
                $error_message[] = "This symbol ".$each_token[$x]." is not in it's valid position";            
            }
            else
            {
                $error_message[] = "unknown error !!??";            
            }               
        }
    }
    
     return $error_message;
}


function read_stmt($each_token , $token_type , $length , $start)
{
    if($each_token[$start] == "read")
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing read keyword!!";
        $start++;
    }
    
    if($token_type[$start] == "id")
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing identifier!!";
        $start++;
    }
    
    if($each_token[$start] == ";")
    {        
        $start++;
    }
    else
    {   
        $error_message[] = "missing semi-colon !!";
        $start++;
    }
    
    return $start;
}
    
    
/*    
function program($each_token , $token_type)
{
    $start = 0;
    $each_token_array_length = count($each_token);   
    
    $output_of_parsing = stmt_sequence($each_token , $token_type , $start , $each_token_array_length);    
    
    return $error_message;
}                       

//function
function stmt_sequence($each_token , $token_type , $start , $length)
{
    for($x=$start ; $x < $length ; $x++)    
    {
        if($each_token[$x] == "if")
        {
            $x = if_stmt($each_token , $token_type , $start , $length);
        }
        elseif($each_token[$x] == "repeat")
        {
            $x = repeat_stmt($each_token , $token_type , $start , $length);
        }
        elseif($token_type[$x] == "id")
        {
            $x = assign_stmt($each_token , $token_type , $start , $length);
        }
        elseif($each_token[$x] == "read")
        {
            $x = read_stmt($each_token , $token_type , $start , $length);
        }
        elseif($each_token[$x] == "write")
        {
            $x = write_stmt($each_token , $token_type , $start , $length);
        }
        else
        {
            if($token_type[$x] == "number")
            {
                $error_message[] = "You can't start your statment with number !!";            
                $x = $length;    
            }
            elseif($token_type[$x] == "assign_op")
            {
                $error_message[] = "Not valid assignment operation!!";
                $x = $length;    
            }
            elseif($token_type[$x] == "comparison_op" || $token_type[$x] == "add_minus_op" || $token_type[$x] == "mul_div_op")
            {
                $error_message[] = "This operator missing identifiers and values!!";
                $x = $length;    
            }
            elseif($token_type[$x] == "symbol")
            {
                $error_message[] = "This symbol ".$each_token[$x]." is not in it's valid position";
                $x = $length;    
            }
            else
            {
                $error_message[] = "unknown error !!??";
                $x = $length;    
            }
        }
    }
}

//function
function if_stmt($each_token , $token_type , $start , $length)
{    
        if($each_token[$start] == "if")
        {
            $start++;
        }
        else
        {
            return $length;
        }
        
        if($each_token[$start] == "(" || $token_type[$start] == "id" || $token_type[$start] == "number")     
        {            
            $start = exp($each_token , $token_type , $start , $length);   
        }
        else
        {
            $error_message[] = "You must enter exprsion after if keyword";         
        }
        
        if($each_token[$start] == "then")
        {
            $start++;
            $start = stmt_sequence($each_token , $token_type , $start , $length);
        }
        else
        {
            $error_message[]= "then keyword is missing !!";
        }
        
        if($each_token[$start] == "end")
        {
            return $start+1;
        }
        else
        {
            $error_message[]="missing end keyword at the end of if statment";            
        }
        
        return $length;
}



//function
function repeat_stmt($each_token , $token_type , $start , $length)
{
    if($each_token[$start] == "repeat")
    {
        $start++;
    }
    else
    {
        return $length;
    }
    
    $start = stmt_sequence($each_token , $token_type , $start , $length);
    
    if($each_token[$start] == "until")
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing until keyword in the repeat statement";   
    }
    
    $start = exp($each_token , $token_type , $start , $length);
    
    return $start;
    
}


//function
function assign_stmt($each_token , $token_type , $start , $length)
{
    if($token_type[$start] == "id")
    {
        $start++;
    }
    else
    {
        $error_message[] = "you must assign values to identifiers (varialbles)";
        return $length;
    }
    
    $start = exp($each_token , $token_type , $start , $length);
    
    return $start;
}


//function
function read_stmt($each_token , $token_type , $start , $length)
{
    if($each_token[$start] == "read")
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing read keyword !!";
        return $length;
    }
    
    if($token_type[$start] == "id")
    {
        return $start+1;
    }
    else
    {
        $error_message[] = "missing identifier after read keyword";   
        return $length;
    }
}


//function
function write_stmt($each_token , $token_type , $start , $length)
{
    if($each_token[$start] == "write")
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing write keyword";
        return $length;
    }
    
    $start = exp($each_token , $token_type , $start , $length);
    
    return $start;
}


//function 
function exp($each_token , $token_type , $start , $length)
{
    $start = simple_exp($each_token , $token_type , $start , $length);    
    
    if($start == $length)
    {
        return $start;
    }
    elseif($token_type[$start] == "comparison_op")
    {
        $start = comparison_op($each_token , $token_type , $start , $length);
    
        if($start == $length)
        {
            return $start;   
        }
        
        $start = simple_exp($each_token , $token_type , $start , $length);
    }
    
    return $start;            
}



//function
function comparison_op($each_token , $token_type , $start , $length)
{
    if($token_type[$start] == "comparison_op")
    {
        return $start+1;
    }
    
    $error_message[] = "comparison opertator missing";
    return $length;
}


//function
function simple_exp($each_token , $token_type , $start , $length)
{
    if($token_type[$start] == "add_minus_op")
    {
        $error_message[] = "identifier or number missing!!";  
        return $length;      
    }

    $start = term($each_token , $token_type , $start , $length);

    if($token_type[$start] == "add_minus_op" || $token_type[$start] == "mul_div_op")        
    {
        $start++;
    }
    else
    {
        $error_message[] = "missing operator (+ , - , * , /)";        
        return $length;
    }   
    
    return $start;
            
}


function term($each_token , $token_type , $start , $length)
{
    if($token_type[$start]== "id" || $token_type[$start]== "number")      
    {
        $start++;
        return $start;
    }
    else
    {
        $error_message[] = "missing identifier or number";        
        return $length;
    }
    
}*/
?>
