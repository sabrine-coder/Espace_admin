<?php

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

        if(($mail == $data[3]) && ($password == $data[4]))
           {session_start();
            $_SESSION['mail']= $mail;
            $_SESSION['sid']= session_id();
            header ('location:index_espaceadmin.php');
            
           }
           else
           {
            $erreur = 'Your email address and/or password are wrong!';
            
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
    <link rel="stylesheet" href="css/connexion.css">
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">
    <title>Log in</title>
</head>

<body>
    <header>
        <p>Mail: visit@eemi.com</p>
        <p>Password: testMe@20</p>
    </header>
    <main>
        <div id="image">
            <div>
                
            </div>
        </div>
       
        <form method="post" action="connexion.php">
        <h1>Log In</h1>
            <div>
                <input type="email" name="mail" id="mail" required placeholder="admin@gmail.com" />
            </div>

            <div>
                <input type="password" name="password" id="password" required placeholder="Your password" />
            </div>

            <div class="erreur" style="color:red;">
                <?php if($erreur == true){echo $erreur;} ?>
            </div>

            <div>
                <input type="submit" value="Log In" />
                <a href="mdp_oublie.php" style="color:black;">Forgot your password ?</a>
            </div>

        </form>
    </main>



</body>

</html>