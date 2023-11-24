<?php
// Vérification que le formulaire a bien été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Connexion à la base de données
    $connexion = mysqli_connect("localhost", "root", "", "indexation");

    // Vérification de la connexion
    if (!$connexion) {
        die("La connexion a échoué: " . mysqli_connect_error());
    }

    // Récupération des données du formulaire
    $title = $_POST['title'];
    $mot = $_POST['mot'];
   $target_file="";

    // Vérification que tous les champs ont été remplis
    if (!empty($_FILES['monfichier']['name']) && !empty($title) && !empty($mot)) {

        // Vérification du type de fichier
        $extensions_autorisees = array('pdf', 'txt', 'ppt', 'docx');
        $file_extension = strtolower(pathinfo($_FILES['monfichier']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $extensions_autorisees)) {
            echo"Le type de fichier n'est pas autorisé";
        }

        // Vérification de la taille du fichier
        if ($_FILES['monfichier']['size'] > 1000000) {
            echo "Le fichier est trop volumineux";
        }

        // Déplacement du fichier vers le dossier de stockage
        $target_dir = "C:/DocumentsIR/";
        $target_file = $target_dir . basename($_FILES['monfichier']['name']);

        if (!move_uploaded_file($_FILES['monfichier']['tmp_name'], $target_file)) {
            echo"Une erreur est survenue lors du téléchargement du fichier";
        }

        // Insertion des données dans la base de données
        $sql = "INSERT INTO document (doc_title,doc_path,doc_keywords) VALUES ('$title', '$target_file', '$mot')";

        if (mysqli_query($connexion, $sql)) {
            echo "Le document a bien été ajouté à la base de données";
        } else {
            echo "Une erreur est survenue lors de l'ajout du document à la base de données: " . mysqli_error($connexion);
        }

    } else {
        echo "Veuillez remplir tous les champs du formulaire";
    }



    // Fermeture de la connexion à la base de données
    mysqli_close($connexion);
}

?>
