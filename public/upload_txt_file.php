<?php
    
    require("../includes/functions.php");   
    
    //set the path that will contain the uploaded file 
    $target_path = "uploads/";
    $target_path = $target_path . basename( $_FILES['file_select']['name']); 
    $file_name = basename( $_FILES['file_select']['name']);
    
    //check if the file name exists in the uploads folder                
    
    //upload the file to the given directory
    if (move_uploaded_file($_FILES["file_select"]["tmp_name"], $target_path))
    {          
                
        //save file into database
        $query = query("INSERT INTO transation_tables_files(file_name , file_path) VALUES(?,?)",$file_name , $target_path);        
         
        //check for database errors
        if( $query === false)
        {
            echo "Error inserting file info into database";
            return false;
        }
        
        require("uploads/$file_name");
        //variable holds the whole text inside the uploaded file
       // $file_open = fopen("uploads/$file_name", "r");
      /*  
        while(!feof($file_open))
        {   
            //get line by line
            $line = fgets($file_open);
            //get the line length
            $length = strlen($line);                 
            
            //if line starts with #           
            if($line[0]== "#")
            {    
                //cut the lines to separated strings                                         
                $lines = preg_split("/[\s,]+/", $line);
                
                //get name of the table
                $table_name = $lines[1];
                
                //save name into database
                query("INSERT INTO transation_tables(table_name) VALUES(?)", $table_name);                                                                                        
            }
            else if($line[0] == "@")
            {   
                $line_strings = preg_split("/[\s,]+/", $line);
                
                if($line_strings[0] == "@def")
                {                    
                    query("update transation_tables
                           set word_letters = '".$line_strings[1]."'
                           where table_name = '".$table_name."'");
                                               
                    echo  $line_strings[1]." transation table\n";                                         
                }
                else if($line_strings[0] == "@start_state")
                {                                        
                    query("update transation_tables 
                           set start_state = '".$line_strings[1]."'
                           where table_name = '".$table_name."'");
                           
                    echo "start_state : ".$line_strings[1]."\n";   
                }
                else if($line_strings[0] == "@final_state")
                {                    
                    query("update transation_tables 
                           set final_state = '".$line_strings[1]."'
                           where table_name = '".$table_name."'");
                       
                    echo "final state : ".$line_strings[1]."\n";   
                }
                else if($line_strings[0] == "@states")
                {
                    $states = array();
                    
                    for($i=9 ; $i<$length ; $i++)                    
                    {
                        $states[$i-9] = $line[$i];
                    }
                    $states = implode($states);
                    
                    query("update transation_tables
                           set states = '".$states."'
                           where table_name = '".$table_name."'");
                           
                    echo "states : ".$states;       
                }
                else if($line_strings[0] == "@tt")
                {
                    $tt = array();
                    
                    for($i=5 ; $i<$length ; $i++)
                    {
                        $tt[$i-5] = $line[$i];
                    }
                    $tt = implode($tt);
                    
                    query("update transation_tables
                           set transation_table = '".$tt."'
                           where table_name = '".$table_name."'");
                           
                    echo "transation table : ".$tt."\n";       
                }
            }            
        }
        
        fclose($file_open); */                                                       
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }    
    
?>

