<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "indexation");

// Vérification de la connexion
if (!$connexion) {
    die("La connexion a échoué: " . mysqli_connect_error());
}

// Récupération du mot clé saisi dans le formulaire
$mot = $_POST["mot"];

// Requête SQL pour récupérer les documents contenant le mot clé saisi


       
            $sql = "SELECT * FROM document WHERE doc_keywords LIKE '%$mot%'";
            $result = mysqli_query($connexion, $sql);
// Affichage des résultats dans un tableau
if(mysqli_num_rows($result)>0){
    echo "<table border='1 ' bgcolor='#eeeeee'>
    <tr>
        <th>Titre</th>
        <th>Chemin</th>
    </tr>";
$index=0;
while ($ligne = mysqli_fetch_row($result)) {

    $titre=$ligne[1];
   $path=$ligne[2];
   $index=$index+1;
   echo " <tr><td>$index</td><td>$titre</td><td>$path</td></tr>";
}
 

echo "</table>";
echo "<p >Recherche terminée !</p>";
}
else echo "<p>Aucun résultat trouvé.</p>";



// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
