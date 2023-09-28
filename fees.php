<?php include('db_connect.php');?>
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  transform: scale(1.3);
  padding: 10px;
  cursor:pointer;
}

</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Liste des élèves liées à une scolarité spécifique</b>
						<button class="btn btn-primary btn-block btn-sm col-sm-2" id="printButton">Imprimer</button>

						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_fees">
					<i class="fa fa-plus"></i> Ajouter
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
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
									<th class="text-center">Action</th>
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
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>">Aperçu</button>
										<button class="btn btn-sm btn-outline-primary edit_fees" type="button" data-id="<?php echo $row['id'] ?>" >Modifier</button>
										<button class="btn btn-sm btn-outline-danger delete_fees" type="button" data-id="<?php echo $row['id'] ?>">Supprimer</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
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
// document.getElementById('printButton').addEventListener('click', function () {
//     var printWindow = window.open('imprimer_liste_eleves.php', '_blank', 'width=800,height=600');
//     printWindow.document.addEventListener('DOMContentLoaded', function () {
//         // Ajoutez le bouton d'impression personnalisé à la page d'impression
//         var printButton = printWindow.document.createElement('button');
//         printButton.textContent = 'Imprimer';
//         printButton.className = 'btn btn-primary';
//         printButton.addEventListener('click', function () {
//             printWindow.print();
//         });
//         printWindow.document.body.appendChild(printButton);

//     });
// });
// document.getElementById('printButton').addEventListener('click', function () {
//     var printWindow = window.open('imprimer_liste_eleves.php', '_blank', 'width=800,height=600');
//     printWindow.document.addEventListener('DOMContentLoaded', function () {
//         // Ajoutez le bouton d'impression personnalisé à la page d'impression
//         var printButton = printWindow.document.createElement('button');
//         printButton.textContent = 'Imprimer';
//         printButton.className = 'btn btn-primary';
//         printButton.addEventListener('click', function () {
//             printWindow.print();
//         });
//         printWindow.document.body.appendChild(printButton);

//         // Masquer les éléments que vous ne souhaitez pas imprimer
//         var elementsToHide = printWindow.document.querySelectorAll('#headr,#footer');
//         elementsToHide.forEach(function (element) {
//             element.style.display = 'none';
//         });
//     });
// });

</script>
<script>
	$('#printButton').click(function(){
    // Ouvrir une nouvelle fenêtre pop-up
    var printWindow = window.open('imprimer_liste_eleves.php', '_blank', 'width=800,height=600');

    // Attacher un gestionnaire d'événements une fois que la nouvelle fenêtre est chargée
    printWindow.addEventListener('load', function () {
        // Ajoutez le bouton d'impression personnalisé à la nouvelle fenêtre
        var printButton = printWindow.document.createElement('button');
        printButton.textContent = 'Imprimer';
        printButton.className = 'btn btn-primary';
        printButton.addEventListener('click', function () {
            printWindow.print();
        });
        // printWindow.document.body.appendChild(printButton);

        // Masquer les éléments que vous ne souhaitez pas imprimer dans la nouvelle fenêtre
        var elementsToHide = printWindow.document.getElementById('footer');
        elementsToHide.forEach(function (element) {
            element.style.display = 'none';
        });
    });
});

</script>


<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#printButton').click(function () {
    $('#printModal').modal('show').find('.modal-body').load('imprimer_liste_eleves.php');
});

	
	$('.view_payment').click(function(){
		uni_modal("Details Paiement","view_payment.php?ef_id="+$(this).attr('data-id')+"&pid=0","mid-large")
		
	})
	$('#new_fees').click(function(){
		uni_modal("Paiement Frais de Scolarité de l'élève ","manage_fee.php","mid-large")
		
	})
	$('.edit_fees').click(function(){
		uni_modal("Associer un élève à une scolarité spécifique","manage_fee.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_fees').click(function(){
		_conf("Voulez vous supprimer ?","delete_fees",[$(this).attr('data-id')])
	})
	function delete_fees($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_fees',
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