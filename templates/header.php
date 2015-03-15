<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts -->
    <!--<link href='http://fonts.googleapis.com/css?family=Crafty+Girls|Istok+Web:400,700,400italic,700italic|Shadows+Into+Light|Merriweather:400,700italic,400italic,300,700,300italic' rel='stylesheet' type='text/css'>--> 

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap2.js"></script>        
    <script src="js/jquery.js"></script>
    <script src="js/jquery.form.min.js"></script>      
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--> 
    <script src="js/myscript.js"></script>
    
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystyles.css" rel="stylesheet">    
    
    
    
    <?php if (isset($title)): ?>
        <title>Compiler: <?= htmlspecialchars($title) ?></title>
    <?php else: ?>
        <title>Compiler</title>
    <?php endif ?>
        
  </head>
  <body>
     <div class="content row">
         <div align="center">                                           
              <a href="home.php"><img src="/img/logo.bmp" width="500px" height="50px" alt="compiler Logo"></img></a>                                                          
         </div>    
     </div>  
