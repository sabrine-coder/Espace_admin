<?php

session_start();

if(!isset($_SESSION["mail"]))
{
    header ('location:connexion.php?required');
}  

$fichier = "fichier.csv";
$fic = fopen($fichier, 'rb');
 

while (($ligne = fgetcsv($fic, 1024,";")) !== FALSE) {
  
  $table[]= $ligne;
  
}

fclose($fic);

?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Administrateurs </title>
  <link rel="stylesheet" type="text/css" href="css/comptes.css" />
  <link href="https://icons8.com/icon/60657/design">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">

</head>

<body>
        <div id="scroll_to_top"> 
                <a href="#top"><img src="top.png" alt="Retourner en haut" /></a>
        </div>


  <header>
      <a href="index_espaceadmin.php">Home</a>
      <a href="connexion.php">Sign out</a>
  </header>

  <main>

  <?php
                  
  foreach($table as $infos ){
  ?>
  
    <article>
      
          <div id="photo"
            style="background-image: url('photos/<?php echo($infos[5]);?>'); ">
          </div>

          <div id="description">
            <p><?php if(($infos[0]) == "1") 
                          {
                            echo("Mme".'<br>'.$infos[2].' '.$infos[1]);
                          }
                          else
                          {
                            echo("M.".'<br>'.$infos[2].' '.$infos[1]);
                          } ?>
            </p>

            <p><i class="material-icons">question_answer</i><a href="mailto:<?php echo($infos[3]); ?>"><?php echo($infos[3]); ?>
            </a></p>
          </div>
     
    </article>
  

  <?php
  }         
  ?>
  </main>

  

</body>

</html>