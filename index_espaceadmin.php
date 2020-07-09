<?php 

session_start();

  if(!isset($_SESSION["mail"]))
{
    header ('location:connexion.php?required');
} 



// récupérer et afficher bienvenue le prénom et le nom qui correspondent à l'adresse mail connéctée

$mail= $_SESSION["mail"];

$fichier = "fichier.csv";
$fic = fopen($fichier, 'rb');
 

while (($ligne = fgetcsv($fic, 1024,";")) !== FALSE) {
  
  $table[]= $ligne;
  
}
                
foreach($table as $infos )
{
            
if(($_SESSION["mail"]) == $infos[3])
{
    $personne = ucwords($infos[2].' '.$infos[1]);
}

}
fclose($fic);

  
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Espace admin</title>
    <link rel="stylesheet" type="text/css" href="css/accueil.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
            <a href="index_espaceadmin.php">Home</a>
            <a href="deconnexion.php">Sign out</a>
    </header>
    <main>
    <h1>Welcome <?php echo($personne); ?></h1>

    <div class="button_container">
        <a href="creation.php" class="btn">Create a New Account</a>
        <a href="generationfichier.php" class="btn">Generate an HTML page</a>
        <a href="comptesadmins.php" class="btn">Show admins</a>
    </div>
    
    </main>
</body>

</html>