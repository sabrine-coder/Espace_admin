<?php
session_start();

if(!empty($_POST))
{
    if (($_POST["mail"] == "") or ($_POST['password'] == ""))
    {
        header ('location:connexion.php?required');
    }
 

    $mail= $_POST["mail"];
    $password= $_POST["password"];

    $fichier = fopen("fichier.csv","r") or die("Erreur fopen");

  
   while (($data= fgetcsv($fichier,1000,";")) !== FALSE) 
   {
    $table[]= $data;

        if($mail == $data[3]) 
           {
            $_SESSION['mail']= $mail;

            unset($data[3]);
           
           }
           else
           {
            $erreur = 'Vérifiez votre adresse mail !';
            
           }
    }   
fclose($fichier);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>connexion</title>
    <link rel="stylesheet" type="text/css" href="password.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <a href="index_espaceadmin.php">Home</a>
        <a href="connexion.php">Sign out</a>
    </header>
    <main>
    <h1>Initialize your password</h1>

    <form method="post" action="mdp_oublie.php">
        <div>
            <input type="email" name="mail" id="mail" required placeholder="Your E-mail" />
        </div>
        <div>
            <input type="password" name="password" id="password" required placeholder="New Password" />
        </div>


        <div>
            <input type="submit" value="Send" />
        </div>
    </form>
    </main>
</body>

</html>