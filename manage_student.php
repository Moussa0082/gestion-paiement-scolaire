<?php 
session_start();

include 'db_connect.php'; 




 



// function generateMatricule() {
//     // Obtenir la date actuelle au format 'YmdHis' (Année, Mois, Jour, Heures, Minutes, Secondes)
//     $currentDate = date('YmdHis');

//     // Générer un nombre aléatoire à 3 chiffres
//     $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

//     // Concaténer la date et le nombre aléatoire pour créer le matricule
//     $matricule = $currentDate . $randomNumber;

//     return $matricule;
// }

// // Utilisation de la fonction pour générer un matricule <?php echo $matricule;
 
 // $matricule = generateMatricule(); 


if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM student where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">Matricule .</label>
            <input type="text" class="form-control" name="id_no" id="matricule" value="" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Prenom</label>
            <input type="text" name="prenom" id="" cols="30" id="first_name" rows="3" class="form-control" required=""><?php echo isset($prenom) ? $prenom :'' ?></input>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Nom</label>
            <input type="text" class="form-control" id="last_name" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="" class="control-label">Contact du parent</label>
            <input type="text" class="form-control" id="contact" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
        </div>
    </form>
</div>
   
<script>
    // Fonction pour générer un matricule
    function generateMatricule() {
        var firstName = document.getElementById('first_name').value;
        var lastName = document.getElementById('last_name').value;
        var year = new Date().getFullYear();
        var randomNumbers = Math.floor(Math.random() * 100);

        // Assurez-vous que les champs prénom et nom ne sont pas vides
        if (firstName.length > 0 && lastName.length > 0) {
            var matricule = firstName.charAt(0).toUpperCase() + lastName.charAt(0).toUpperCase() + year + randomNumbers;
            document.getElementById('matricule').value = matricule;
        } else {
            document.getElementById('matricule').value = ''; // Effacer le champ matricule si les champs prénom ou nom sont vides
        }
    }

    // Écoutez les changements dans le champ Nom (Last Name) pour générer automatiquement le matricule
    document.getElementById('last_name').addEventListener('keyup', generateMatricule);
</script>
<script>
    $('#manage-student').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        //a modifier
        // if($('#fee-list tbody').find('[name="fid[]"]').length <= 0){
        //     alert_toast("Vueiller renseigner tous les champs",'danger')
        //     end_load()
        //     return false;
        // }
        var firstName = $('#first_name').val(); // Remplacez 'first_name' par l'ID de votre champ de prénom
        var lastName = $('#last_name').val(); // Remplacez 'last_name' par l'ID de votre champ de nom
        var contact = $('#contact').val();

        // Ajoutez d'autres champs requis de la même manière

        if (firstName === '' || lastName === '' || contact === '') {
            $('#msg').html('<div class="alert alert-danger mx-2">Veuillez remplir tous les champs.</div>');
        } else if(firstName === '' && lastName === '' || contact === ''){
            $('#msg').html('<div class="alert alert-danger mx-2">Veuillez remplir tous les champs.</div>');

        }
        else if(firstName === '' && lastName === '' && contact === ''){
            $('#msg').html('<div class="alert alert-danger mx-2">Veuillez remplir tous les champs.</div>');

        }

        else
        $.ajax({
            url:'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Données enregistrer avec succès.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Ce matricule est déjà attribué à un élève.</div>')
                end_load()
            }   
            // else if(resp==0){
            //         $('#msg').html('<div class="alert alert-danger mx-2">Veuiller remplir tous les champs.</div>')
            //         end_load()

                // }
            }
        })
    })


    $('.select2').select2({
        placeholder:"Selectionner ici",
        width:'100%'
    })
</script>