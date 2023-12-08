<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM student_inscription where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<?php
if(isset($_POST['ef_id'])){
    $ef_id = $_POST['ef_id'];
    
    // Récupérer les frais d'inscription de la table "courses" pour l'ef_id sélectionné
    $course_query = $conn->query("SELECT frais FROM courses WHERE ef_id = $ef_id");
    
    if($course_query->num_rows > 0){
        $row = $course_query->fetch_assoc();
        $frais_inscription = $row['frais'];
    } else {
        $frais_inscription = 0; // Si aucun frais d'inscription n'est trouvé, initialisez-le à 0
    }
    
    // echo $frais_inscription;
}
?>

<div class="container-fluid">
	<form id="manage-payment">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Matricule/Etudiants</label>
			<select name="ef_id" id="ef_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$fees = $conn->query("SELECT ef.*,s.prenom,s.name as sname,s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id order by s.name asc ");
					while($row= $fees->fetch_assoc()):
						// $paid = $conn->query("SELECT frais FROM student_inscription where ef_id=".$row['id'].(isset($id) ? " and id!=$id " : ''));    
						// $paids = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';          
						// $balance = $row['total_fee'] - $paid;         
                        $paid = $conn->query("SELECT * FROM courses WHERE ef_id = ".$row['id'].(isset($id) ? " AND id != $id " : ''));
                        $paids = $paid->num_rows > 0 ? $paid->fetch_array()['frais'] : 0; // Assurez-vous que $paids est initialisé à 0 si aucun frais payé n'est trouvé
				?>
				<option value="<?php echo $row['id'] ?>" data-balance="<?php echo $paids ?>" <?php echo isset($ef_id) && $ef_id == $row['id'] ? 'selected' : '' ?>> <?php echo  $row['ef_no'].' | ' .ucwords($row['prenom']) . " " .ucwords($row['sname'])   ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		 <div class="form-group">
            <label for="" class="control-label">Frais d'inscription</label>
            <input type="text" class="form-control text-right" id="balance"  required readonly>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Montant Total Payer</label>
            <input type="number" class="form-control text-right" name="amount" id="amount"  value="<?php  echo isset($amount) ? $amount : '';  ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Remarque</label>
            <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control" ><?php echo isset($remarks) ? $remarks :'' ?></textarea>
        </div>
	</form>
</div>
  
<script>
	$('#amount').keyup(function() {
    var amountPaid = parseInt($(this).val().replace(/,/g, ''), 10); // Convertit en nombre entier

    // Récupère le montant total à payer depuis l'attribut data-balance du champ select
    var totalBalance = parseInt($('#ef_id option:selected').data('balance'));

    if (amountPaid > totalBalance) {
        alert("Le montant payé ne doit pas dépasser le montant total à payer.");
        $(this).val(''); // Vide le champ Montant Total Payer en cas de dépassement
        // Réinitialisez tous les autres champs du formulaire
        // $('#ef_id').val('');
        // $('#balance').val('');
        // $('#remarks').val('');
    }
});
 
  // Vérification au survol du bouton "Enregistrer"
  $('#save-button').click(function() {
            var efId = $('#ef_id').val();
            var amount = $('#amount').val();
            var remarks = $('#remarks').val();

            if (!efId || !amount || !remarks) {
                alert("Veuillez remplir tous les champs avant d'enregistrer.");
            }
        });

</script>


<script>


// $('#amount').keyup(function() {
//     var amountPaid = parseInt($(this).val().replace(/,/g, '')); // Récupère le montant saisi et convertit en nombre

//     // Récupère le montant total à payer depuis l'attribut data-balance du champ select
//     var totalBalance = parseInt($('#ef_id option:selected').data('balance'));

//     if (amountPaid > totalBalance) {
//         alert("Le montant payé ne doit pas dépasser le montant total à payer.");
//         $(this).val(''); // Vide le champ en cas de dépassement
//     }
// });


	$('.select2').select2({
		placeholder:'Selectinner ici',
		width:'100%'
	})
	
	// $('#ef_id').change(function(){
	// 	var amount= $('#ef_id option[value="'+$(this).val()+'"]').attr('data-balance')
	// 	$('#balance').val(parseInt(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	// })
	$('#ef_id').change(function () {
    var amount = $('#ef_id option[value="' + $(this).val() + '"]').attr('data-balance');
    amount = parseInt(amount);
    // Formater le montant sans virgule ni point
    $('#balance').val(amount.toLocaleString('en-US', { maximumFractionDigits: 0, minimumFractionDigits: 0 }));
    });
	$('#manage-payment').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_payments',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					alert_toast("Données enregistrer avec succès.",'success')
						setTimeout(function(){
							var nw = window.open('receipts.php?ef_id='+resp.ef_id+'&pid='+resp.pid,"_blank","width=900,height=600")
							setTimeout(function(){
								nw.print()
								setTimeout(function(){
									nw.close()
									location.reload()
								},500)
							},500)
						},500)
				}
			}
		})
	})
</script>
