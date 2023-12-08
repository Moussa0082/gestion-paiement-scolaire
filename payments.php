<?php include 'db_connect.php'; ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Liste des paiements </b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_payment">
					<i class="fa fa-plus"></i> Ajouter
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date paiement</th>
									<th class="">ID .</th>
									<th class="">Matricule Elève</th>
									<th class="">Preom</th>
									<th class="">Nom</th>
									<th class="">Classe</th>
									<th class="">Montant payer</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Requête pour trouver les étudiants n'ayant pas encore payé ce mois-ci
$unpaidStudentsQuery = "SELECT ef.id, ef.student_id
                        FROM student_ef_list ef
                        LEFT JOIN payments p ON ef.id = p.ef_id AND MONTH(p.date_created) = MONTH(CURRENT_DATE())
                        WHERE p.id IS NULL";

$unpaidStudentsResult = $conn->query($unpaidStudentsQuery);

// Insérer les enregistrements pour les étudiants non payants
while ($row = $unpaidStudentsResult->fetch_assoc()) {
    $insertPaymentQuery = "INSERT INTO payments (ef_id, amount, remarks, date_created)
                           VALUES ({$row['id']}, 0, 'Non payer', CURRENT_TIMESTAMP())";

    $conn->query($insertPaymentQuery);
}

// Requête pour récupérer la liste des paiements
$paymentsQuery = "SELECT p.*, s.prenom, ' ', s.name as sname, ef.ef_no, s.id_no, c.course
                  FROM payments p
                  INNER JOIN student_ef_list ef ON ef.id = p.ef_id
                  INNER JOIN student s ON s.id = ef.student_id
                  INNER JOIN courses c ON c.id = ef.course_id
                  ORDER BY unix_timestamp(p.date_created) ASC";

// Exécuter la requête
$paymentsResult = $conn->query($paymentsQuery);

?>

<!-- Affichage des paiements dans le tableau -->
<tbody>
    <?php 
    $i = 1;

    if($paymentsResult->num_rows > 0):
        while($row = $paymentsResult->fetch_assoc()):
            $date_created = strtotime($row['date_created']);
            $date_formatted = strftime("%d %B %Y %H:%M", $date_created);
            $amount = $row['amount'];

    ?>
    <tr>
        <td class="text-center"><?php echo $i++ ?></td>
        <td><p><b><?php echo $date_formatted ?></b></p></td>
        <td><p><b><?php echo $row['id_no'] ?></b></p></td>
        <td><p><b><?php echo $row['ef_no'] ?></b></p></td>
        <td><p><b><?php echo ucwords($row['prenom']) ?></b></p></td>
        <td><p><b><?php echo ucwords($row['sname']) ?></b></p></td>
        <td><p><b><?php echo ucwords($row['course']) ?></b></p></td>
        <td class="text-right"><p><b><?php echo $amount>0 ? $amount : "Non payer" ?></b></p></td>
        <td class="text-center">
            <button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">Aperçu</button>
            <button class="btn btn-sm btn-outline-primary edit_payment" type="button" data-id="<?php echo $row['id'] ?>" >Modifier</button>
            <button class="btn btn-sm btn-outline-danger delete_payment" type="button" data-id="<?php echo $row['id'] ?>">Supprimer</button>
        </td>
    </tr>
    <?php 
        endwhile; 
    else:
    ?>
    <tr>
        <th class="text-center" colspan="7">Aucun données.</th>
    </tr>
    <?php
    endif;
    ?>
</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: 150px;
	}
</style>


<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_payment').click(function(){
		uni_modal("Nouveau Paiement ","manage_payment.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal("Details Paiement","view_payment.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.edit_payment').click(function(){
		uni_modal("Modifier Paiement","manage_payment.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_payment').click(function(){
		_conf("Etes vous sûre de supprimer ce paiement ?","delete_payment",[$(this).attr('data-id')])
	})
	function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimer avec succès",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>