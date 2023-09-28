<?php



require "db_connect.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Liste élèves</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="liste-apprenant.css">

	<style>
		 @media print {
		.print-table{
           width: 100% !important;
        }

        #no-print {
            display: none !important;
        }
		#sidebar{
			display:none;
		}

	 }
	</style>
</head>




<body>


 <h2 style="margin-left: 80vh;" id="no-print"> Les des élèves   <strong>DM</strong> </h2>
      <button class="btn btn-primary" style="margin-left:90%; margin-top:-2%;" id="printButton">Imprimer</button>
    <table id="studentTable"  class="print-table">

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

    </table>


    <script>
		document.getElementById('printButton').addEventListener('click', function () {
    // Cacher les éléments inutiles avant l'impression
    var table = document.getElementById('studentTable');
    var elementsToHide = document.querySelectorAll('#printButton, .btn-action');
    elementsToHide.forEach(function (element) {
        element.style.display = 'none';
    });

    // Imprimer le tableau
    window.print();

    // Rétablir l'affichage après l'impression
    elementsToHide.forEach(function (element) {
        element.style.display = '';
    });
});

	</script>
	

</body>

</html>