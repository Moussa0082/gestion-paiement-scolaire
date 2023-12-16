<?php
include 'db_connect.php';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



  <div id="header">
    <!-- Contenu de l'en-tête -->
</div>
<div class="container-fluid" id="printable-content">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
            <div class="row justify-content-center pt-4">
                <label for="" class="mt-2">Moi</label>
                <div class="col-sm-3">
                    <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                </div>
                <label for="class" class="mt-2 ml-4">Classe</label>
    <div class="col-sm-3">
           <!-- Remplacez-le par le champ de texte -->
           <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">

    </div>
            </div>
            <hr>
            <div class="col-md-12">
                <table class="table table-bordered" id='report-list'>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <!-- <th class="">Date</th> -->
                            <th class="">Matricule elève.</th>
                            <th class="">Prenom</th>
                            <th class="">Nom</th>
                            <th class="">Classe</th>
                            <th class="">Montant payer</th>
                            <th class="">Total Scolaire</th>
                        </tr>
                    </thead>
                    <?php
    $i = 1;
    $total = 0;
    $payments = $conn->query("SELECT p.*, s.prenom, s.name as sname, ef.ef_no, s.id_no, c.course , c.total_amount
    FROM payments p 
    INNER JOIN student_ef_list ef ON ef.id = p.ef_id 
    INNER JOIN student s ON s.id = ef.student_id 
    INNER JOIN courses c ON c.id = ef.course_id
    WHERE date_format(p.date_created,'%Y-%m') = '$month' 
    ORDER BY unix_timestamp(p.date_created) ASC ");

// $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);

if($payments->num_rows > 0):
    while($row = $payments->fetch_array()):
        $total += $row['amount'];
        $mt= $row['amount'];
        // $balance = $row['total_fee'] - $paid;
		
    ?>
    <tr class="table-row">
        <td class="text-center"><?php echo $i++ ?></td>
        <!-- <td>
            <p> <b> -->
                <?php
                //  echo date("M d,Y H:i A",strtotime($row['id_no'])) 
                 ?>
                 <!-- </b>
                 </p>
        </td> -->
        <td>
            <p> <b><?php echo $row['ef_no'] ?></b></p>
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
            <p> <b><?php echo $mt>0 ? $mt : "Non payer" ?></b></p>
        </td>
        <td>
            <p> <b><?php echo ucwords($row['total_amount']) ?></b></p>
        </td>
    </tr>
    <?php 
        endwhile;
        else:
    ?>
    <tr>
        <th class="text-center" colspan="7">Aucun donnés.</th>
    </tr>
    <?php 
        endif;
    ?>
</tbody>
<tfoot>
    <tr>
        <th colspan="5" class="text-right">Total</th>
        <th class="text-right" id="dynamic-total"><?php echo $total ?></th>
        <!-- <th></th> -->
    </tr>
    
</tfoot>
                </table>
                <hr>
                <div class="col-md-12 mb-4">
                    <center>
                        <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Imprimer</button>
                    </center>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <!-- Contenu du pied de page -->
</div>
<noscript>
	<style>
        
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
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
		
    }
	

    @media print {
        #printable-content {
            display: block; /* Rendre la partie visible lors de l'impression */
        }
    }
	</style>
</noscript>
<script>
    



document.getElementById('searchInput').addEventListener('input', function () {
    var searchTerm = this.value.toLowerCase();
    var tableRows = document.querySelectorAll('.table-row');

    tableRows.forEach(function (row) {
        var rowData = row.innerText.toLowerCase();
        row.style.display = rowData.includes(searchTerm) ? 'table-row' : 'none';
    });

    // Recalculate the total after filtering
    function updateDynamicTotal() {
        var dynamicTotal = 0;
        $('.table-row:visible').each(function () {
            var amount = parseInt($(this).find('.amount').text());
            dynamicTotal += isNaN(amount) ? 0 : amount;
        });

        // Mettre à jour le total dynamique dans le footer
        console.log("Dynamic Total:", dynamicTotal);
        $('#dynamic-total').text(dynamicTotal.toFixed(2));
    }
});

// document.getElementById('searchInput').addEventListener('input', function () {
//         var searchTerm = this.value.toLowerCase();
//         var tableRows = document.querySelectorAll('.table-row');

//         tableRows.forEach(function (row) {
//             var rowData = row.innerText.toLowerCase();
//             row.style.display = rowData.includes(searchTerm) ? 'table-row' : 'none';
//         });
//     });

$('#month').change(function(){
    location.replace('index.php?page=payments_report&month='+$(this).val())
})
$('#print').click(function(){
		var _c = $('#report-list').clone();
		var ns = $('noscript').clone();
            ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
		nw.document.write('<p class="text-center"><b>Rapport de paiement du mois de <?php echo date("F, Y",strtotime($month)) ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
		}, 500);
	})
</script>