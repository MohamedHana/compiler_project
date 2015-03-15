<br/>
<div align="center" class="container">
    <div class="panel panel-primary">
       <div class="panel-heading">
           <div align="left"> 
               <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">File <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" id="open">open</a></li>
                    <li><a href="#">save</a></li>
                    <li><a href="#">save as</a></li>
                    <li class="divider"></li>
                    <li><a href="#">close</a></li>
                  </ul>
               </div>
               <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Edit <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">copy</a></li>
                    <li><a href="#">cut</a></li>
                    <li><a href="#">paste</a></li>
                  </ul>
               </div>
               <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Output <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">    
                  </ul>
               </div>
               <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Tables <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">    
                  </ul>
               </div>
           </div>    
       </div>
       <div class="panel-body">
          <div class="btn-toolbar" role="toolbar">    
              <div class="btn-group">  
                  <div class="btn-group"><button id="add_new_tab" class="btn btn-warning"><span class="glyphicon glyphicon-file"></span></button></div>
                  <div class="btn-group"><button id="open_file" class="btn btn-warning"><span class="glyphicon glyphicon-folder-open"></span></button></div>                                                       
                    <form hidden id="upload_form" action="upload_txt_file.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="file_select" id="file_select" />                         
                    </form>
                  <div class="btn-group"><button class="btn btn-warning"><span class="glyphicon glyphicon-floppy-save"></span></button></div>
              </div>    
              <div class="btn-group">  
                  <div class="btn-group"><button id="copy"class="btn btn-warning"><span class="glyphicon glyphicon-floppy-disk"></span></button></div>
                  <div class="btn-group"><button id="cut"class="btn btn-warning"><span class="glyphicon glyphicon-cutlery"></span></button></div>
                  <div class="btn-group"><button id="paste"class="btn btn-warning"><span class="glyphicon glyphicon-hand-down"></span></button></div>
              </div> 
              <div class="btn-group">  
                  <div class="btn-group"><button class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span></button></div>
                  <div class="btn-group"><button class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></button></div>                  
              </div> 
              <div class="btn-group">  
                  <div class="btn-group"><button id="run" class="btn btn-success"><span class="glyphicon glyphicon-play"></span></button></div>
                  <div class="btn-group"><button class="btn btn-warning"><span class="glyphicon glyphicon-check"></span></button></div>                  
              </div> 
              <div class="btn-group">  
                  <div class="btn-group"><button class="btn btn-warning"><span class="glyphicon glyphicon-question-sign"></span></button></div>                  
              </div>
          </div>          
          <div hidden align="center" id="alert" class="alert alert-danger"></div>
          <br/>               
          
            <ul class="nav nav-tabs" role="tablist" id="tabs">
              
            </ul>

            <div id="contents" class="tab-content">
              
            </div>     
                                                  
       <div id="online_check"></div>                                                                   
       </div>
       <div class="panel-footer">
           <h3 align="left"><span class="label label-default">Console :</span></h3> 
           <div id="output"></div>            
           <textarea class="form-control" id="console" rows="6" readonly placeholder="Output..."></textarea>                     
       </div>
    </div>
</div>

<script>
$(function(){          
    
   //variable holds the id for each tab and it's content
   var id = 1;
   var number_of_available_tabs = 0;
   
       
   setInterval(function(){
        if(number_of_available_tabs != 0)
        {
            var current = $("ul#tabs li.active").attr("id");            
            current = current.slice(3,4);
            var code = $('#code'+current).val();
            
            if(code)
            {
                $.post('online_analyzer_checker.php' , {'source_code': code} , function(output){
                    if(output == "success")
                    {
                        $('#online_check').hide();
                    }   
                    else
                    {                                          
                        $('#online_check').html(output);                        
                        $('#online_check').show();
                    }      
                });   
            }
                             
            
            
        }
   } , 2000); 
   
   
   //when copy button clicked
   $('#copy').on('click' , function(e){
        e.preventDefault();
        
        if(number_of_available_tabs != 0)
        {
            var current = $("ul#tabs li.active").attr("id");            
            current = current.slice(3,4);
            
            var holdtext = $("#code"+current).innerText;
            //var Copied = holdtext.createTextRange();
            holdtext.execCommand("Copy");
        }    
        
   });
     
   //when user press open from the file menu
   $('#open').on('click', function(e){
        e.preventDefault();
        $('#file_select').trigger('click');
   });
   
   //when the user pressed new tab button
   $('#add_new_tab').on('click' , function(e){
        e.preventDefault();
        
        //stop user from creating more than 10 tabs
        if(number_of_available_tabs == 10)
        {
            //alert user to choose a tab to be compiled
            $('#alert').html('<strong>You can not open more tabs...</strong>');
            $('#alert').slideDown(500).slideUp(2500);
            return false;
        }
        
        //add new tab
        $('#tabs').append('<li id="tab'+id+'"><a href="#new_tab'+id+'" role="tab" data-toggle="tab"><button class="close" id="'+id+'"><span class="glyphicon glyphicon-remove"></span></button>New File</a></li>');
        
        //add new tab content
        $('#contents').append('<div class="tab-pane" id="new_tab'+id+'"><h3 align="left" id="label'+id+'"><span class="label label-default">Source Code :</span></h3><textarea id="code'+id+'" class="form-control" rows="10" placeholder="Type your code here..."></textarea></div>');                      
        
        //increase the id number
        id++;        
                
        //increase the number of opened tabs
        number_of_available_tabs++;
                
   });  
   
   //when user pressed any close button
   $('#tabs').on('click', ' li a .close', function(e){
        e.preventDefault();
               
        //get the id of the clicked button
        var current_id = $(this).attr("id");
        
        $('#save_modal').show();
                
        //remove the current tab
        $('#tab'+current_id).remove();
        
        //remove the current tab content
        $('#new_tab'+current_id).remove();
        
        //decrease the number of opened tabs
        number_of_available_tabs--;
        
        //remove the generated table if there is no tab open 
        if(number_of_available_tabs == 0)
        {
            $('#lexemes_table').remove();
        }
        
   });   

    //when user wants to upload his code file
    $('#open_file').on('click' , function(e){
        e.preventDefault();
        //open the upload window to choose his file 
        $('#file_select').trigger('click');             
    });
   
   
    $("#file_select").change(function() {      
        
        //get the uploaded file type 
        var file = this.files[0];
        var type = file.type;  
        var name = file.name;        
        
        //accept only text files 
        if( type != 'text/plain')
        {
            //alert user to upload only a text files
            $('#alert').html('<strong>Please, you can only upload text files...</strong>');
            $('#alert').slideDown(500).slideUp(2500);
            return false;    
        }
        
        var formData = new FormData($('form')[0]);               
              
        $.ajax({
                url: 'upload_txt_file.php',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                //Ajax events
                success: function(output){
                                //add a new tab with title of file name                               
                                $('#tabs').append('<li id="tab'+id+'"><a href="#new_tab'+id+'" role="tab" data-toggle="tab"><button class="close" id="'+id+'"><span class="glyphicon glyphicon-remove"></span></button>'+name+'</a></li>');
                                //add 
                                $('#contents').append('<div class="tab-pane" id="new_tab'+id+'"><h3 align="left" id="label'+id+'"><span class="label label-default">Source Code :</span></h3><textarea id="code'+id+'" class="form-control" rows="10" placeholder="Type your code here...">'+output+'</textarea></div>');                
                                //increase the id number
                                id++;                
                                //increase the number of opened tabs
                                number_of_available_tabs++;    
                         },
                error: function(){
                           alert("Error sending the file to server!!"); 
                       },
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
           });        
                
        
        
    });
                         
                                        
   
   //when user click the run button
   $('#run').on('click' , function(e){
        e.preventDefault();
        
        //get current tab id
        var current_tab_id = $("ul#tabs li.active").attr("id");
        
        //check if no any active tab
        if(!current_tab_id)
        {
            //alert user to choose a tab to be compiled
            $('#alert').html('<strong>Please, choose the tab you want to run first...</strong>');
            $('#alert').slideDown(500).slideUp(2500);
            return false;
        }
        else
        {   
            //get the id of all tab contents
            var current_id = current_tab_id.slice(3,4);
            
            //get the whole source code of current tab
            var source_code = $('#code'+current_id).val();
            
            //check if the tab source code is empty
            if(source_code == '')
            {
                //alert user to choose a tab to be compiled
                $('#alert').html('<strong>Please, enter your source code first...</strong>');                
                $('#alert').slideDown(500).slideUp(2500);
                return false;
            }
            else
            {
                $.post('lexeical_analyzer.php' , {'source_code': source_code} , function(output){
                                         
                    $('#output').html(output);                        
                    
                });       
            }
        }
                
                
   });
      
   
});

</script>
