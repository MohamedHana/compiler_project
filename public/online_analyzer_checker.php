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
                    $message[] = $array_of_tokens[$i];      
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
                $message[] = $array_of_tokens[$i];      
            }
        } 
       
       if(isset($message)) 
       {
           foreach($message as $error)
           {
              if(!empty($error))
              {
                echo '<div class="alert alert-success" role="alert">Check your code at (<strong>'.$error.'</strong>) not accepted token!!</div>';
              }                                     
           }   
       }
       else
       {
           echo "success"; 
       }

  }      
  ?>
