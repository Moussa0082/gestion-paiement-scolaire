

<?php
// Récupérez le titre dynamique en fonction de la recherche (à adapter selon votre logique)
$titre = isset($_GET['searchInput']) ? "Liste des paiement de " . $_GET['searchInput'] : "Liste des paiement";

// Incluez le fichier de connexion à la base de données et tout autre code nécessaire
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>impression</title>
    <!-- Incluez vos styles CSS et tout autre contenu nécessaire pour l'impression -->
    <link rel="stylesheet" href="votre_style.css">
    
    <style>



     table.print-table {
        border-collapse: collapse;
        width: 100%;
    }

    table.print-table th, table.print-table td {
        border: 1px solid #000; /* Bordures en gras pour l'impression */
        padding: 8px;
        text-align: left;
    }
    

    table.print-table th {
        background-color: #f2f2f2;
    }
 
        @media print {
    table.print-table {
        border-collapse: collapse;
        width: 100%;
    }
    .haut,.btn,#footer{
        display:none;
    }
    .form-control{
        display:none;
    }
    

    table.print-table th, table.print-table td {
        border: 1px solid #000; /* Bordures en gras pour l'impression */
        padding: 8px;
        text-align: left;
    }

    table.print-table th {
        background-color: #f2f2f2;
    }
}

   .haut{
    display: flex;
    justify-content: space-between;
   }
   .btn{
    /* margin-left:70%; */
    margin-top:-15px;
    color:white;
    background-color: #1c84e3;
    width:100px;
    height:25px;
    cursor: pointer;
}
table{
    
    margin-top:15px;
   }
   #footer{
    display: none;
   }
 
   .entete{
    display:flex;
    justify-content:space-between;
   }

   .form-control{
    height:20px;
    margin-top:5px;
   }
    </style>
    
</head>
<body>
    <!-- Ajoutez le titre dynamique à votre page d'impression -->
    <h1 style="justify-content:center; display:flex;">
        <?php
     echo $titre;
      ?>
      </h1>

    
<div class="haut">

    <div class="serach"  style="margin-top:-20px; width:200px;">
        
    <input type="text"   class="form-control" id="searchInput" name="searchInput" placeholder="Rechercher...">
</div>
    
    <div class="entete">
        
        <!-- Ajoutez un bouton de retour ou d'impression supplémentaire si nécessaire -->
        <button class="btn" onclick="window.print()">Imprimer</button>
        
        </div>
        
</div>


    <!-- Incluez le tableau de la liste des élèves -->


    
    <!-- <table class="table table-condensed table-bordered table-hover"> -->
    <table id="studentTable"  class="print-table">

                            <thead>
                                <tr>

                                    <th class="text-center">#</th>
                                    <th class="">Matricule Elève</th>
                                    <th class="">Prenom</th>
                                    <th class="">Nom</th>
                                    <th class="">Classe</th>
                                    <th class="">Scolarité payable</th>
                                    <th class="">Montant payer</th>
                                    <th class="">Somme Restant</th>
                                </tr>
                            </thead>

                        <tbody>
                        <?php 
                        $i = 1;
                        $fees = $conn->query("SELECT ef.*, s.prenom, s.name as sname, s.id_no, c.course
                        FROM student_ef_list ef
                        INNER JOIN student s ON s.id = ef.student_id
                        INNER JOIN courses c ON c.id = ef.course_id
                        ORDER BY s.name ASC");
                        // $fees = $conn->query("SELECT ef.*,s.prenom, s.name as sname,s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id order by s.name asc ");
                        while($row=$fees->fetch_assoc()):
                            $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
                            $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
                            $balance = $row['total_fee'] - $paid;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td>
                                <p> <b><?php echo $row['id_no'] ?></b></p>
                            </td>
                            
                            <td>
                                <p> <b><?php echo ucwords($row['prenom']) ?></b></p>
                            </td>
                            <td>
                                <p> <b><?php echo ucwords($row['sname']) ?></b></p>
                            </td>
                            <td>
                                <p> <b><?php echo ucwords($row['course']) ?></b></p>
                            </td>
                            <td class="text-right">
                                <p> <b><?php echo $row['total_fee'] ?></b></p>
                            </td>
                            <td class="text-right">
                                <p> <b><?php echo $paid ?></b></p>

                            <td class="text-right">
                                <p> <b><?php echo $balance ?></b></p>
                            </td>
                            
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

<!-- </table> -->
    </table>

     <div id="footer">

    
     </div>


  
     <script src="mp.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
