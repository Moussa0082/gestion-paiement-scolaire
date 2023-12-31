<?php include 'db_connect.php' ?>

<div class="container-fluid">
    <form id="manage-fees">
        <div id="msg"></div>
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="" class="control-label">Enrollement NO ./ E.F. </label>
            <input type="text" class="form-control" name="ef_no" id="ef_no"  readonly required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Etudiant</label>
            <select name="student_id" id="student_id" class="custom-select input-sm select2">
                <option value=""></option>
                <?php
                $student = $conn->query("SELECT * FROM student order by name asc ");
                while ($row = $student->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['id'] ?>" data-firstname="<?php echo $row['prenom'] ?>" data-lastname="<?php echo $row['name'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['prenom']) . '  ' . $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Classe</label>
            <select name="course_id" id="course_id" class="custom-select input-sm select2">
                <option value=""></option>
                <?php
                $student = $conn->query("SELECT *,concat(course,'-',level) as class FROM courses order by course asc ");
                while ($row = $student->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['total_amount'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Frais</label>
            <input type="text" class="form-control text-right" name="total_fee" value="<?php echo isset($total_fee) ? $total_fee : '' ?>" required readonly>
        </div>
    </form>
</div>

<script>
    $('.select2').select2({
        placeholder: 'Selection ici',
        width: '100%'
    })

    // Fonction pour générer un matricule
    function generateMatricule(firstName, lastName) {
        // Obtenir la première lettre du prénom et du nom en majuscules
        var firstLetter = firstName.charAt(0).toUpperCase();
        var lastLetter = lastName.charAt(0).toUpperCase();

        // Obtenir l'année en cours
        var currentYear = new Date().getFullYear();

        // Générer deux chiffres aléatoires entre 10 et 99
        var randomNumbers = Math.floor(Math.random() * (99 - 10 + 1)) + 10;

        // Concaténer les éléments pour former le matricule
        var matricule = firstLetter + lastLetter + currentYear + randomNumbers;

        // Mettre à jour la valeur du champ ef_no
        $('#ef_no').val(matricule);
    }

    // Écouter les changements dans le menu déroulant des étudiants
    $('#student_id').change(function () {
        var selectedOption = $(this).find(':selected');
        var firstName = selectedOption.data('firstname');
        var lastName = selectedOption.data('lastname');

        // Appeler la fonction pour générer le matricule
        generateMatricule(firstName, lastName);
    })
    $('#student_id').change(function () {
    var selectedOption = $(this).find(':selected');
    var studentId = selectedOption.val();

    // Mettre à jour le champ de formulaire avec l'ID de l'élève sélectionné
    $('[name="student_id"]').val(studentId);
});


    $('#course_id').change(function () {
        var amount = $('#course_id option[value="' + $(this).val() + '"]').attr('data-amount');
        amount = parseInt(amount); // Convertir en entier

        // Formater le montant sans virgule ni point
        $('[name="total_fee"]').val(amount.toLocaleString('en-US', { maximumFractionDigits: 0, minimumFractionDigits: 0 }));
    })
    

    $('#manage-fees').submit(function (e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_fees',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)
                end_load()
            },
            success: function (resp) {
                if (resp == 1) {
                    location.reload();
                    alert_toast("Données enregistrer avec succès.", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger">Le numéro EF existe déjà.</div>')
                    end_load()
                }
            }
        })
    })
</script>
