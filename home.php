<?php 
include 'db_connect.php' ;


     //fonction pour obtenir le total des élèves
  function getTotalEleve() {
    global $conn;
  
       
  $query = $conn->query('SELECT COUNT(*) AS total FROM student');
               
  $result = $query->fetch_assoc();
                
  return $result['total'];
    
  }
  
  $eleve = getTotalEleve();



  
//fonction pour obtenir le total des paiements effectués
function getNombrePaiement() {
    global $conn;
    
    
    $query = $conn->query('SELECT COUNT(*) AS total FROM payments');
    
    $result = $query->fetch_array();
                
return $result['total'];
    
}

$paiements = getNombrePaiement(); 

//fonction pour obtenir le total des sommes payer
function getSommesTotalPayer() {
    global $conn;

       
$query = $conn->query('SELECT SUM(amount) AS total FROM payments');
               
$result = $query->fetch_assoc();
                
return $result['total'];
    
}

$sommeTotalPayer = getSommesTotalPayer();





// function getTotalSommesNonPayer() {
//     global $conn;

       
// $query = $conn->query('SELECT SUM(GRAND_TOTAL) AS total FROM invoice');
               
// $result = $query->fetch_assoc();
                
// return $result['total'];
    
// }

// $total_somme = getTotalSommesNonPayer();





?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}

    .row{
        display: flex;
        

    }
</style>
   
<!-- <link rel="stylesheet" href="assets/plugins/morris/morris.css"> -->

   
<!-- <link rel="stylesheet" href="assetss/css/fullcalendar.min.css"> -->

<!-- <link rel="stylesheet" href="assetss/css/dataTables.bootstrap4.min.css"> -->

<!-- <link rel="stylesheet" href="assetss/css/bootstrap.min.css"> -->



<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Bienvenue dans L'ECOLE DE SOURCE DE LA SANTE DE BAMAKO  " . $_SESSION['login_name']."!"  ?>
                    <hr>
                </div>
            </div>      			 
        </div>
    </div>
</div>

  <!-- new  -->
  <!-- style="width: 80px; margin-left:1%; margin-top: 5%; height:100px; border:1px solid black -->
  
<div class="row">
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3" >
<div class="dash-widget dash-widget5">
<span class="float-left"><img src="assets/img/dash/dash-1.png" alt="" width="80" ></span>
<div class="dash-widget-info text-right">
<span>Total Elèves</span>
<h3>  <?php echo $eleve; ?> </h3>
</div>
</div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3"  >
<div class="dash-widget dash-widget5">
<div class="dash-widget-info text-left d-inline-block">
<span>Total Sommes Payer</span>
<h3><?php echo $sommeTotalPayer  . " FCFA"; ?> </h3>
</div>
<span class="float-right"><img src="assets/img/dash/dash-2.png" width="80" alt=""></span>
</div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
<div class="dash-widget dash-widget5">
<span class="float-left"><img src="assets/img/dash/dash-3.png" alt="" width="80"></span>
<div class="dash-widget-info text-right">
<span>Total Sommes Non Payer</span>
<h3>  <?php echo $sommeTotalPayer  . " FCFA"; ?> </h3>
</div>
</div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
<div class="dash-widget dash-widget5">
<div class="dash-widget-info d-inline-block text-left">
<span>Nombre De Paiement Effectuer</span>
<h3><?php echo $paiements ?></h3>
</div>
<span class="float-right"><img src="assets/img/dash/dash-4.png" alt="" width="80"></span>
</div>
</div>
</div>

  <!-- end  -->

<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        // start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Données enregistrer avec succès",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            // start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>