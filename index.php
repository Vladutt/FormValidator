<?php
include 'FormValidation.php';

if(isset($_POST['trimite'])){

  $formValidation = new FormValidation($_POST);
  $formValidation->setRules([
    'username' => 'required|min:3',
    'email' => 'required|email',
    'password' => 'required|min:8'
  ]);
  $formValidation->setCustomErrors([
    'username.required' => 'Acest câmp este gol...',
    'username.min' => 'doar 3' 
  ]);
  
  if(!$formValidation->isValidated()){
    
    print_r($formValidation->getErrors());
  
  }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CHESTII</title>
</head>
<body>
  <form action="" method="post">
    <input type="text" name="username"> <br> <hr>
    <input type="text" name="email"> <br> <hr>
    <input type="password" name="password"> <br> <hr>
    <button type="submit" name='trimite'>Trimite</button>
  </form>
</body>
</html>
