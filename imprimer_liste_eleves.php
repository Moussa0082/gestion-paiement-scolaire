

<?php
// Récupérez le titre dynamique en fonction de la recherche (à adapter selon votre logique)
$titre = isset($_GET['searchInput']) ? "Liste des paiements de " . $_GET['searchInput'] : "Liste de paiements";

// Incluez le fichier de connexion à la base de données et tout autre code nécessaire
include('db_connect.php');
?>


    
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

            #header {
        display: none;
        }


/* Masquer les éléments dans le pied de page lors de l'impression */   
  #footer {
        display: none;
    }

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
    
    <header id="header">


    </header>
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
        <button class="btn" id="btn" onclick="window.print()">Imprimer</button>
        
        </div>
        
</div>


    <!-- Incluez le tableau de la liste des élèves -->


    
    <!-- <table class="table table-condensed table-bordered table-hover"> -->
    <table id="studentTable" class="print-table">
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
    <?php 
        $i = 1;
        $totalFees = 0;
        $totalPaid = 0;
        $fees = $conn->query("SELECT ef.*, s.prenom, s.name as sname, s.id_no, c.course
        FROM student_ef_list ef
        INNER JOIN student s ON s.id = ef.student_id
        INNER JOIN courses c ON c.id = ef.course_id
        ORDER BY s.name ASC");
        
        while($row = $fees->fetch_assoc()):
            $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
            $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
            $balance = $row['total_fee'] - $paid;
            $totalFees += $row['total_fee'];
            $totalPaid += $paid;
        ?>
        <tr>
        <td class="text-center"><?php echo $i++ ?></td>            <td>
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
            </td>
            <td class="text-right">
                <p> <b><?php echo $balance ?></b></p>
            </td>
        </tr>
    <?php endwhile; ?>
 </tbody>
<tfoot>
<tr>
            <th colspan="5" class="text-right">Total élèves: <strong id="totalStudents"></strong> </th>
            <th class="text-right" id="totalFees"><?php echo $totalFees; ?></th>
            <th class="text-right" id="totalPaid"><?php echo $totalPaid; ?></th>
            <th class="text-right" id="totalBalance"><?php echo $totalFees - $totalPaid; ?></th>
        </tr>
</tfoot>
</table>


     <footer id="footer">

     
    
     </footer>

     <script src="mp.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>

      
      const totalFeesElement = document.getElementById('totalFees');
      const totalPaidElement = document.getElementById('totalPaid');
      const totalBalanceElement = document.getElementById('totalBalance');
        const totalStudentsElement = document.getElementById('totalStudents');
        let filteredCounter = 1; // Initialiser le compteur pour les étudiants filtrés

        function updateTotals() {
    const rows = document.querySelectorAll('#studentTable tbody tr');

    let totalFees = 0;
    let totalPaid = 0;
    let totalStudents = 0;

    rows.forEach(row => {
        const fees = parseInt(row.querySelector('td:nth-child(6) p b').textContent);
        const paid = parseInt(row.querySelector('td:nth-child(7) p b').textContent);

        totalFees += fees;
        totalPaid += paid;
        totalStudents++;
    });

    const totalBalance = totalFees - totalPaid;

    totalFeesElement.textContent = totalFees.toFixed(0);
    totalPaidElement.textContent = totalPaid.toFixed(0);
    totalBalanceElement.textContent = totalBalance.toFixed(0);
    totalStudentsElement.textContent = totalStudents;
}
 updateTotals();

   document.getElementById('searchInput').addEventListener('input', function () {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentTable tbody tr');
       const tbody = document.getElementById('studentTable').querySelector('tbody');

    let totalFees = 0;
    let totalPaid = 0;
    let totalStudents = 0;
    filteredCounter = 1;

     // Réinitialiser le contenu actuel du tbody
    tbody.innerHTML = '';
    
    rows.forEach(row => {
        const studentName = row.querySelector('td:nth-child(3) b').textContent.toLowerCase();
        const studentClasse = row.querySelector('td:nth-child(5) b').textContent.toLowerCase();
        const fees = parseInt(row.querySelector('td:nth-child(6) p b').textContent);
        const paid = parseInt(row.querySelector('td:nth-child(7) p b').textContent);
        
        if (studentName.includes(searchText) || studentClasse.includes(searchText)) {
            totalFees += fees;
            totalPaid += paid;
            
            totalStudents ++;

             // Créer une nouvelle ligne avec le compteur filtré
             const filteredRow = row.cloneNode(true);
            filteredRow.querySelector('td:nth-child(1)').textContent = filteredCounter++;
            tbody.appendChild(filteredRow);

        }else{
            tbody.appendChild(row);
        }
        
        
    });

    const totalBalance = totalFees - totalPaid;

    totalFeesElement.textContent = totalFees.toFixed(0);
    totalPaidElement.textContent = totalPaid.toFixed(0);
    totalBalanceElement.textContent = totalBalance.toFixed(0);
    totalStudentsElement.textContent = totalStudents; // Mettez à jour le nombre total d'élèves
});

     // Trier les lignes par prénom avant de les ajouter au tableau
     sortedRows.sort((a, b) => {
         const nameA = a.querySelector('td:nth-child(3) b').textContent.toLowerCase();
         const nameB = b.querySelector('td:nth-child(3) b').textContent.toLowerCase();
         return nameA.localeCompare(nameB);
        });
        
        // Mettre à jour le tableau avec les lignes triées
        const tbody = document.getElementById('studentTable').querySelector('tbody');
        tbody.innerHTML = ''; // Effacer le contenu actuel du tbody

        sortedRows.forEach(row => {
            tbody.appendChild(row); // Ajouter chaque ligne triée au tbody
        });

        // Mettre à jour les totaux
        const totalBalance = totalFees - totalPaid;
        totalFeesElement.textContent = totalFees.toFixed(0);
        totalPaidElement.textContent = totalPaid.toFixed(0);
        totalBalanceElement.textContent = totalBalance.toFixed(0);
        totalStudentsElement.textContent = totalStudents; // Update the total students count
   
</script>



