<div id="lexemes_table" class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
      <thead>
          <tr>
              <th><strong>id</strong></th>  
              <th><strong>Lexeme</strong></th>
              <th><strong>Token</strong></th>
              <th><strong>Category</strong></th>                            
          </tr>
      </thead>
      <tbody>
          <?php for($i=0 ; $i<count($array_of_tokens) ; $i++):?>
              <tr class="info">  
                  <th><?php echo $i?></th>                
                  <th><?echo $array_of_tokens[$i]?></th>
                  <?php if($array_of_tokens[$i] == "if" || $array_of_tokens[$i] == "else" || $array_of_tokens[$i] == "end" || $array_of_tokens[$i] == "repeat" || $array_of_tokens[$i] == "then" || $array_of_tokens[$i] == "until" || $array_of_tokens[$i] == "read" || $array_of_tokens[$i] == "write"):?>
                  <th>reserved word</th>
                  <th>keyword</th>
                  <?php elseif($array_of_tokens[$i] == ">" || $array_of_tokens[$i] == "<" || $array_of_tokens[$i] == "="):?>
                  <th>comparison operator</th>
                  <th>operator</th>
                  <?php elseif($array_of_tokens[$i] == ":="):?>
                  <th>assignment operator</th>
                  <th>operator</th>
                  <?php elseif($array_of_tokens[$i] == "+" || $array_of_tokens[$i] == "-" || $array_of_tokens[$i] == "*" || $array_of_tokens[$i] == "/"):?>
                  <th>arthimatic operator</th>
                  <th>operator</th>
                  <?php elseif($array_of_tokens[$i] == "(" || $array_of_tokens[$i] == ")" || $array_of_tokens[$i] == ";"):?>
                  <th>symbol</th>
                  <th>symbol</th>
                  <?php elseif(eregi("[[:digit:]]" , $array_of_tokens[$i]) && !eregi("[[:alpha:]]" , $array_of_tokens[$i])):?>
                  <th>number</th>
                  <th>constant</th>
                  <?php elseif(eregi("[[:alnum:]]" , $array_of_tokens[$i]) && eregi("^[[:alpha:]]" , $array_of_tokens[$i])) :?>
                        <?php if(eregi("[^a-zA-Z0-9]" , $array_of_tokens[$i])):?>
                          <th>unknown token</th>
                          <th>not accepted token</th> 
                        <?php else:?>
                          <th>identifier</th>
                          <th>identifier</th>
                        <?php endif ?>                   
                  <?php else:?>
                  <th>unknown token</th>
                  <th>not accepted token</th>
                  <?php endif ?>                                   
              </tr>          
          <?php endfor;?>
      </tbody>
  </table>
</div>

   
