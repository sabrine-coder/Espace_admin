<?php

session_start();

if(!isset($_SESSION["mail"]))
{
    header ('location:connexion.php?required');
}    

// instanciation

$civilite = "";
$firstname = "";
$name = "";
$email = "";
$password = "";
$photo = "";


$civiliteError = "";
$firstnameError = "";
$nameError = "";
$emailError = "";
$passwordError = "";
$photoError = "";

$isSuccess = false;

// pour sécuriser le formulaire 

function verifuInput($var)
{
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlentities($var);

    return $var;

}


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $civilite= verifuInput($_POST["civilite"]);
    $name= verifuInput($_POST["name"]);
    $firstname= verifuInput($_POST["firstname"]);
    $email= verifuInput($_POST["email"]);
    $password= verifuInput($_POST["password"]);
    $photo= verifuInput($_POST["photoUpload"]);
    $isSuccess = true;

    
    
    if(empty($civilite))
    {
        $civiliteError = "This field is required !";
        $isSuccess = false;
        
    }
    
    if(empty($name))
    {
        $nameError = "Please enter your Last name!
        ";
        $isSuccess = false;
       
        
    }
    if(empty($firstname))
    {
        $firstnameError = "Please enter your First name!
        !";
        $isSuccess = false;
        
    }
   

    if(!isEmail($email))
    {
        $emailError = "Please enter a valid email address !";
        $isSuccess = false;
        
    }

    if(!verif_mdp($password))
    {
        $passwordError = "Please enter a strong password: <br> at least 8 characters <br> at least one number <br> at least lowercase and uppercase <br> at least one special character";
        $isSuccess = false;
    }
    else
    {
        $isSuccess = true;
    }

}


// verifier si le mail est valide

function isEmail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

// verification MDP fort (voir caractères spé)




function verif_mdp($password)
{
    $tableau = ['0','1','2','3','4','5','6','7','8','9'];
    $special = ['*','#','@','+','%','&'];

    $test = 0;
    $testspe =0;

    foreach($tableau as $chiffre)
    {
        if (strpos($password, $chiffre) !== false)
        {
            $test = 1;
        }
    }
    foreach($special as $var)
    {
        if (strpos($password, $var) !== false)
        {
            $testspe = 1;
        }
    }

    if (strlen($password) < 8)
    {
        return(false);
    }

    elseif ($test == 0)
    {
        return(false);
    }

    elseif ($testspe == 0)
    {
        return(false);
    }
    

    elseif (is_numeric($password))
    {
        return(false);
    }

    elseif (strtoupper($password) == $password)
    {
        return(false);
    }

    elseif (strtolower($password) == $password)
    {
        return(false);
    }

    else
    {
        return(true);
    }
} 


// uploader la photo

if(isset($_FILES["photoUpload"]))
{
    $namephoto = $_FILES["photoUpload"]["name"];
    $temp = $_FILES["photoUpload"]["tmp_name"];
    $type = $_FILES["photoUpload"]["type"];
    // text/plain
    // application/ms-word  ==> pour la sécurité (tester le mim type du fichier)
    $size = $_FILES["photoUpload"]["size"];
    $error = $_FILES["photoUpload"]["error"];

    // récupérer l'extension d'un fichier
    $tab = explode(".",$namephoto);
    $index = count($tab) - 1;
    $extension = $tab[$index];

    $accept = array ("jpg","JPG");

    // renommer la photo
    $namephoto = "photo-".$_POST["firstname"].".".$extension;


    if ($error != 0)
    {
        $probleme = "The file was not downloaded";
    }

    elseif($size > (1000 * 1000)) // pour donner 1M

    {
        $probleme = "The file is too large";
    }

    elseif (!in_array($extension, $accept)) // comparer si l'extension existe dans le tab
    {
        $probleme = "The extension is not allowed
        ";
    }
    else
    {
        $destination = "photos/".$namephoto;
        move_uploaded_file($temp,$destination);

    

    }
}

// pour écrire dans csv
if (!empty($_POST))
{

    if($isSuccess == true)
    {
        $civilite = $_POST["civilite"];
        $name= $_POST["name"];
        $firstname= $_POST["firstname"];
        $email= $_POST["email"];
        $password= $_POST["password"];
        $photo= $_FILES["photoUpload"];


    $fichier = fopen('fichier.csv', 'a+') or die("Erreur fopen");

    fwrite($fichier,$civilite.";".$name.";".$firstname.";".$email.";".$password.";".$namephoto."\n");

    fclose($fichier);
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="creation.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">
    <title>Création d'un nouveau compte administrateur</title>

</head>

<body>
        
        <header>
            <a href="index_espaceadmin.php">Home</a>
            <a href="deconnexion.php">Sign out</a>
        </header>

    <?php 
if(isset($probleme))
{
    echo($probleme);
}
elseif(isset($succes))
{
    echo($succes);
}
?> 

<main>

    <div id="image">
        <div></div>

    </div>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" role="form"
        enctype="multipart/form-data">
        <h1>Create A New Account</h1>
        <br>
        <div>
            <input type="radio" value="1" name="civilite" required value="<?php echo $civilite; ?>" /> Mrs
            <input type="radio" value="2" name="civilite" required value="<?php echo $civilite; ?>" /> Mr
            <p><?php echo $civiliteError; ?></p>
        </div>
        <div>
            <input type="text" name="name" id="name" required placeholder="Last Name" value="<?php echo $name; ?>" />
            <p><?php echo $nameError; ?></p>
        </div>
        <div>
            <input type="text" name="firstname" id="firstname" required placeholder="First Name" value="<?php echo $firstname; ?>" />
            <p><?php echo $firstnameError; ?></p>
        </div>
        <div>
            <input type="email" name="email" id="email" required placeholder="user@gmail.com"
                value="<?php echo $email; ?>">
            <p><?php echo $emailError; ?></p>
        </div>
        <div>
            <input type="password" name="password" id="password" required placeholder="Minimum 8 characters"
                value="<?php echo $password; ?>" />
            <p><?php echo $passwordError; ?></p>
        </div>

        <div>
            <input type="file" name="photoUpload" id="photoUpload" required>
        </div>
        <div>
            <input type="submit" value="Send" onsubm/>
        </div>
    </form>
</main>
    
  
</body>

</html>