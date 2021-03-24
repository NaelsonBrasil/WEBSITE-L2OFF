<br>
<div class="row">

<div class="col-md-2">
    <p style="font-size: 14px;">Your NickName and Id</p>
    <ul class="list-group">
    <?php for ($i = 0; $i < $countChar; $i++) { ?>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <small><?php echo $charName[$i]; ?></small>
        <span class="badge badge-light badge-pill"> <?php echo $charId[$i]; ?></span>
    </li>

    <?php } ?>
    </ul>
    </div>
    <div class="col-md-10">
    </div>
</div>
<br>
<div class="range-donate">

    <article>

        <?php echo form_open('','onsubmit="return false;" id="form_transfer"'); ?>

        <table class="table text-center">

            <thead>

            <tr>
                <th scope="col" class="donateTitle">Icon</th>
                <th scope="col" class="donateTitle">Item</th>
                <th scope="col" class="donateTitle">Quantity Total</th>
                <th scope="col" class="donateTitle">Quantity Transfer</th>
                <th scope="col" class="donateTitle">Character Id</th>
                <th scope="col" class="donateTitle">Transfer</th>
            </tr>

            </thead>

            <tbody>
            <?php for ($i = 0; $i < $countRegisterDonated; $i++) { ?>

                <tr>
                    
                    <td><img style="border-radius: 30px !important;" width="32" height="32" src="<?= base_url("uploaded/icon/" . $iconName[$i]); ?>"></td>
                    
                     <td class="text-secondary"><?= $itemName[$i]; ?></td>
                     <td class="text-secondary" id="qt_item"><?= $quantity[$i]; ?></td>
                     
                    <td class="text-secondary"><input type="text" name="form_quantity" class="form-control " id="target_qt" placeholder="Qt"required></td>
                   
                    <td class="text-secondary">
                    <div>
                    <input type="hidden" name="form_itemId" value="<?= $itemId[$i];?>">
                    <input type="text" name="form_charId" class="form-control" id="target_id" placeholder="Id" required>
                    <div  class="alert alert-primary m-1"><small style="font-size: 16px;">Nick:</small> <small id="char_name"></small><div>
                    </div>
                    </td>

                    <td class="text-secondary"><input type="submit" class="btn w-100 btn-dark btn-add-donate" value="send" id="target_sub_order"></td>
                
                </tr>
                
             <?php } ?>
            </tbody>
        </table>

            <?php echo form_close(); ?>

    </article>
    <div class="alert alert-success" role="alert" id="alert-transfer" style="display: none;">Transfer with success!</div>
</div>


<script type="application/javascript">

    $(function () {

        $('input[name=form_charId]').on('input',function () {
                
                //console.log($('input[name="form_id_char"]').val());

                $.ajax({
                    type: 'POST',
                    url: "<?= base_url("admin/Store_controllers/verifyChar"); ?>",
                    data: {

                        charId: $('input[name="form_charId"]').val(),
                        csrf_protection: $('input[name="csrf_protection"]').val()},

                    dataType: 'json',
                    success: function (json) {
                        if (json.success === true){

                            document.getElementById('char_name').innerHTML = json.charName;

                        }
                    },
                    error:function () {console.log("Error");}
                });          
            });


         $('#form_transfer').submit(function ($e) {
                
                $e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url("admin/Store_controllers/transferItem"); ?>",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (json) {
                        if (json.success === true) {

                            $('#alert-transfer').fadeIn();

                            setTimeout(function () {
                            $('#alert-transfer').fadeOut();

                            }, 3000);
                            
                            document.getElementById('qt_item').innerHTML = json.qt;
                            console.log(json.success);
                            console.log(json.qt);
                        }

                        if (json.charNotExist === true){ alert("Character not exist"); }
                        if(json.notHaveItem === true){ alert("No have item"); }
                        if(json.bigger === true){ alert("Quantity bigger that stored"); }
                    },
                    error:function () {console.log("Error");}
                });
         });
   });

</script>
