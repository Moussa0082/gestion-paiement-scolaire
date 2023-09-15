<?php 
include 'db_connect.php';
$fees = $conn->query("SELECT ef.*,s.prenom, s.name as sname,s.id_no,concat(c.course,' - ',c.level) as `class` FROM student_ef_list ef inner join student s on s.id = ef.student_id inner join courses c on c.id = ef.course_id  where ef.id = {$_GET['ef_id']}");
foreach($fees->fetch_array() as $k => $v){
	$$k= $v;
}
$payments = $conn->query("SELECT * FROM payments where ef_id = $id ");
$pay_arr = array();
while($row=$payments->fetch_array()){
	$pay_arr[$row['id']] = $row;
}
?>

<style>
	.flex{
		display: inline-flex;
		width: 100%;
	}
	.w-50{
		width: 50%;
	}
	.text-center{
		text-align:center;
	}
	.text-right{
		text-align:right;
	}
	table.wborder{
		width: 100%;
		border-collapse: collapse;
	}
	table.wborder>tbody>tr, table.wborder>tbody>tr>td{
		border:1px solid;
	}
	p{
		margin:unset;
	}
	.image{
		margin-left: 2%;
		margin-top: -10px;
		width: 70px;
		height: 60px;
	}
    .text-droite{
		margin-top: -65px;
	}
	hr{
		top: 10px;
	}
	 /* Cacher l'en-tête et le pied de page dans l'impression */
	 @media print {
        @page {
            margin: 0; /* Supprimer les marges par défaut de l'impression */
        }
        body {
            margin: 1cm; 
        }
        #header, #footer {
            display: none; /* Cacher l'en-tête et le pied de page */
        }
		#header{
			background-color: white ;
		}
    }
	

    @media print {
        #printable-content {
            display: block; /* Rendre la partie visible lors de l'impression */
        }
    }
</style>
<div id="header">
    <!-- Contenu de l'en-tête -->
</div>

<div class="container-fluid" id="printable-content">
	<div class="image">
		<img src="./assets/image/logo.jpeg" alt="" width="100px;" height="60px;" >
			
		</div>
		<div class="text-droite">
			<strong style="color: green; margin-left:45%; margin-top: -60px;">EFDM (Ecole Fondamentale Privée Dian Male)</strong>
			<span style="color: red; text-transform:uppercase; margin-left:48%; margin-top: -10px; " >Travail-Discipline-Perseverence</span>
			</div>

	<!-- <p class="text-center"> <b>
	<?php 
	// echo $_GET['pid'] == 0 ? "Facture de paiement" : 'Facture de paiement'
	 ?>
		
	</b></p> -->
	<br>
	<br>
	<hr>
	<div class="flex">
		<div class="w-50">
			<p>Matricule: <b><?php echo $ef_no ?></b></p>
			<p>Etudiant: <b><?php echo ucwords($prenom . " ". $sname )  ?></b></p>
			<p>Classe: <b><?php echo $class ?></b></p>
		</div>
		<?php if($_GET['pid'] > 0): ?>
		<div class="w-50">
			<p>Date paiement: <b><?php echo isset($pay_arr[$_GET['pid']]) ? date(" M d, Y",strtotime($pay_arr[$_GET['pid']]['date_created'])): '' ?></b></p>
			<p>Montant payer: <b><?php echo isset($pay_arr[$_GET['pid']]) ? $pay_arr[$_GET['pid']]['amount']: '' ?></b></p>
		</div>
		<?php endif; ?>
	</div>
	<hr>
	<p><b>Réçu de paiement</b></p>
	<table class="wborder">
		<tr>
			<td width="50%">
				<p><b>Détails paiement</b></p>
				<hr>
				<table width="100%">
					<tr>
						<td width="50%">Type de paiement</td>
						<td width="50%" class='text-right'>Montant</td>
					</tr>
					<?php 
				$cfees = $conn->query("SELECT * FROM fees where course_id = $course_id");
				$ftotal = 0;
				while ($row = $cfees->fetch_assoc()) {
					$ftotal += $row['amount'];
				?>
				<tr>
					<td><b><?php echo $row['description'] ?></b></td>
					<td class='text-right'><b><?php echo $row['amount'] ?></b></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<th>Total</th>
					<th class='text-right'><b><?php echo $ftotal ?></b></th>
				</tr>
				</table>
			</td>			
			<td width="50%">
			<p><b>Détails paiement</b></p>
				<table width="100%" class="wborder">
					<tr>
						<td width="50%">Date</td>
						<td width="50%" class='text-right'>Montant</td>
					</tr>
					<?php 
						$ptotal = 0;
						foreach ($pay_arr as $row) {
							if($row["id"] <= $_GET['pid'] || $_GET['pid'] == 0){
							$ptotal += $row['amount'];
					?>
					<tr>
						<td><b><?php echo date("Y-m-d",strtotime($row['date_created'])) ?></b></td>
						<td class='text-right'><b><?php echo $row['amount'] ?></b></td>
					</tr>
					<?php
						}
						}
					?>
					<tr>
						<th>Total</th>
						<th class='text-right'><b><?php echo $ptotal ?></b></th>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>Total Payable Scolaire</td>
						<td class='text-right'><b><?php echo $ftotal ?></b></td>
					</tr>
					<tr>
						<td>Total Payer</td>
						<td class='text-right'><b><?php echo $ptotal ?></b></td>
					</tr>
					<tr>
						<td>Somme restant</td>
						<td class='text-right'><b><?php echo $ftotal-$ptotal ?></b></td>
					</tr>
				</table>
			</td>			
		</tr>
	</table>
</div>

<div id="footer">
    <!-- Contenu du pied de page -->
</div>