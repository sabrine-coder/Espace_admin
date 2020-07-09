<?php

session_start();
if (!isset($_SESSION['mail']))
{
    header('location:connexion.php?acces');
}


//Instanciation

$nom = "";
$titre = "";
$description = "";
$h1 = "";

if(!empty($_POST)){

    foreach ($_POST as $key => $value)
	{
		$$key = htmlentities($value);
    }

    if (($nom == "")){
        header ('location:generationfichier.php?required');
    }
    elseif (strpos($nom," ") !== false)
	{
		$erreur = "Forbidden spaces!";
    }
    else
    { 
        $succes = 'The file has been created';
        $page = '<!DOCTYPE html>
                 <html lang="fr">
                 <head>
                 <meta charset="UTF-8">
                 <meta name="viewport" content="width=device-width, initial-scale=1.0">
                 <title>';
        $page .= $titre;
        $page .= '</title>
                  <meta name="description" content="'.$description.'">
                  </head>';       
        $page .= '<body>
                  <p>';
        $page .= $description;
        $page .= '</p>
                  <h1>';
        $page .= $h1;
        $page .= '</h1>
                  <main>';
        $page .= $_POST['text'];
        $page .='</main>
                 </body>
                 </html>';
        
$fichier = fopen($_POST['nom'].'.html',"w") or die ("Erreur fopen");
        
$page = utf8_decode($page);

if (!fwrite($fichier,$page))
    {
        echo("Erreur fwrite");
    }

    if (!fclose($fichier))
    {
        echo("Erreur fclose");
    }

    }
}

if (isset($_GET["required"])){
    $erreur = "Le nom du fichier est obligatoire!";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/generate.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,700&display=swap" rel="stylesheet">
    <title>Generate an HTML page</title>

    <script src="https://cdn.tiny.cloud/1/c9pkuwi8uzihg8r6lom3hiw42s6dwntj4chvdcyo1pzym7wb/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>

</head>

<body>
    <header>
        <a href="index_espaceadmin.php">Home</a>
        <a href="connexion.php">Sign out</a>
    </header>
    <main>
        <h1>Generate an HTML page</h1>
        <p style="text-align:center;">
            <?php 
            if (isset($succes)){echo $succes;}
            else{ ?>
        </p>
        <form action="generationfichier.php" method="post">

            <!-- pour le nom du fichier -->
            <div>
                <input type="text" name="nom" id="nom" placeholder="File Name">
                <?php if (isset($erreur)){echo '<p style="color:red;">'.$erreur.'</p>';} ?>

            </div>


            <div>
                <input type="text" name="titre" id="titre" value="<?php echo $titre; ?>" placeholder="Title">
            </div>
            <!-- pour la description-->
            <div>
                <input type="text" name="description" id="description" value="<?php echo $description; ?>" placeholder="Description">
            </div>

            <!-- pour le h1-->
            <div>
                <input type="text" name="h1" id="h1" value="<?php echo $h1; ?>" placeholder="H1">
            </div>

            <!-- pour le main-->
            <div>
                <textarea id="default" name="text"></textarea>
            </div>


            <div>
                <input type="submit" value="Send">
                <input type="reset" value="Reset">
            </div>
        </form>
        <?php
        }
        ?>
    </main>

</body>
</html>