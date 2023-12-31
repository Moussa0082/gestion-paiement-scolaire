<?php 
include 'db_connect.php'; 

 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM courses where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}


?>
<?php 

        // Obtenir l'année actuelle
$annee_actuelle = date("Y");

// Calculer l'année suivante pour créer la plage d'années
$annee_suivante = $annee_actuelle + 1;

// Créer la plage d'années au format "AAAA-AAAA" (par exemple, "2023-2024")
$plage_annees = "$annee_actuelle-$annee_suivante";



 
?>
<div class="container-fluid">
    <form action="" id="manage-course">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
        <div class="col-lg-6 border-right">
            <h5><b>Details classe</b></h5>
            <hr>
            <div id="msg" class="form-group"></div>
            <div class="form-group">
                <label for="" class="control-label">Classe</label>
                <input type="text" class="form-control" name="course"  value="<?php echo isset($course) ? $course :'' ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Classe</label>
                <input type="number" class="form-control" name="frais"  value="<?php echo isset($frais) ? $frais :'' ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Année Scolaire</label>
                <input type="text" class="form-control" name="level"  value="<?php echo $plage_annees ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Description</label>
                <textarea name="description" id="" cols="30" rows="4" class="form-control" required=""><?php echo isset($description) ? $description :'' ?></textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <h5><b>Details scolarité</b></h5>
            <hr>
            <div class="row">
                <div class="form-group">
                    <label for="ft" class="control-label">Type </label>
                    <input type="text" id="ft" class="form-control-sm">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Montant</label>
                    <input type="number" step="any" min="0" id="amount" class="form-control-sm text-right">
                </div>
                 <div class="form-group pt-1">
                    <label for="" class="control-label">&nbsp;</label>
                    <button class="btn btn-primary btn-sm" type="button" id="add_fee">Ajouter à la liste</button>
                </div>
            </div>
            <hr>
            <table class="table table-condensed" id="fee-list">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="50%">Type</th>
                        <th width="45%">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($id)):
                        $fees = $conn->query("SELECT * FROM fees where course_id = $id");
                        $total = 0;
                        while($row=$fees->fetch_assoc()): 
                            $total += $row['amount'];
                    ?>
                        <tr>
                            <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))" ><i class="fa fa-times"></i></button></td>
                            <td>
                                <input type="hidden" name="fid[]" value="<?php echo $row['id'] ?>">
                                <input type="hidden" name="type[]" value="<?php echo $row['description'] ?>">
                                <p><small><b class="ftype"><?php echo $row['description'] ?></b></small></p>
                            </td>
                            <td>
                                <input type="hidden" name="amount[]" value="<?php echo $row['amount'] ?>">
                                <p class="text-right"><small><b class="famount"><?php echo $row['amount'] ?></b></small></p>
                            </td>
                        </tr>
                    <?php
                        endwhile; 
                        endif; 
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <th class="text-right">
                            <input type="hidden" name="total_amount" value="<?php echo isset($total) ? $total : 0 ?>">
                            <span class="tamount"><?php echo isset($total) ? $total: 0 ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </form>
</div>
<div id="fee_clone" style="display: none">
     <table >
            <tr>
                <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))" ><i class="fa fa-times"></i></button></td>
                <td>
                    <input type="hidden" name="fid[]">
                    <input type="hidden" name="type[]">
                    <p><small><b class="ftype"></b></small></p>
                </td>
                <td>
                    <input type="hidden" name="amount[]">
                    <p class="text-right"><small><b class="famount"></b></small></p>
                </td>
            </tr>
    </table>
</div>
<script>
    $('#manage-course').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#add_fee').click(function(){
        var ft = $('#ft').val()
        var amount = $('#amount').val()
        if(amount == '' || ft == ''){
            alert_toast("Please fill the Fee Type and Amount field first.",'warning')
            return false;
        }
        var tr = $('#fee_clone tr').clone()
        tr.find('[name="type[]"]').val(ft)
        tr.find('.ftype').text(ft)
        tr.find('[name="amount[]"]').val(amount)
        tr.find('.famount').text(parseFloat(amount).toLocaleString('en-US'))
        $('#fee-list tbody').append(tr)
        $('#ft').val('').focus()
        $('#amount').val('')
        calculate_total()
    })
    function calculate_total(){
        var total = 0;
        $('#fee-list tbody').find('[name="amount[]"]').each(function(){
            total += parseFloat($(this).val())
        })
        $('#fee-list tfoot').find('.tamount').text(parseFloat(total).toLocaleString('en-US'))
        $('#fee-list tfoot').find('[name="total_amount"]').val(total)

    }
    function rem_list(_this){
        _this.closest('tr').remove()
        calculate_total()
    }
    $('#manage-course').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        if($('#fee-list tbody').find('[name="fid[]"]').length <= 0){
            alert_toast("Vueiller renseigner au moin une colone du type de scolarité",'danger')
            end_load()
            return false;
        }
        $.ajax({
            url:'ajax.php?action=save_course',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Donées inserer avec succès.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2"> Cette classe a déjà été ajoutée.</div>')
                end_load()
                }   
            }
        })
    })

    $('.select2').select2({
        placeholder:"Selectinner ici",
        width:'100%'
    })
</script>