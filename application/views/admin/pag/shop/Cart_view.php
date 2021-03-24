<?php if (isset($success) and $success == 'empty') { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url('admin/add/item'); ?>">Sair</a></span>

        </div>
    </div>
<?php 
} ?>

<div class="alert alert-primary text-center m-2" role="alert">
    Donate
</div>

<div>
    <h4 class="text-dark">Rules</h4>
    <article style="overflow-y: auto; height: 200px; width: 100%; margin: auto; background-color: white; border: 5px solid rgba(228,228,228,0.88);">

        <?php $xml = simplexml_load_file("config/terms.xml");
        foreach ($xml->terms_donate_en->info as $key => $item) { ?>

            <small class="text-secondary p-2 rules-register"><?= $item ?></small>
            <hr/>

        <?php 
    } ?>

    </article>
    <br>
    <div class="text-justify">
        <span class="text-dark">I accept all the rules.</span>&ensp;&ensp;&ensp;<input class="form-check-input" type="checkbox" value="" id="target_check_donate" style="margin-top: 8px !important;" required>
    </div>
</div>

<div class="range-donate">

    <article>

        <?php echo form_open('admin/order'); ?>

        <table class="table text-center">

            <thead>

            <tr>
                <th scope="col" class="donateTitle">Icon</th>
                <th scope="col" class="donateTitle">Item</th>
                <th scope="col" class="donateTitle">Price</th>
                <th scope="col" class="donateTitle">Bonus</th>
                <th scope="col" class="donateTitle">Amount</th>
                <th scope="col" class="donateTitle">Total</th>
            </tr>

            </thead>

            <tbody>
            <?php for ($i = 0; $i < $donateCountItem; $i++) { ?>

                <tr>

                    <td><img style="border-radius: 30px !important;" width="32" height="32" src="<?= base_url("uploaded/icon/" . $donateIconName[$i]); ?>"></td>
                    <td class="text-secondary"><?= $donateItemName[$i]; ?></td>
                    <td class="text-secondary"><?= $donateItemPrice[$i]; ?></td>
                    <td class="text-secondary"><?= $donateBonus[$i]; ?></td>
                    <td class="text-secondary" id="qt">0</td>
                    <td class="text-secondary" style="width: 5%">$<span id="total" class="text-danger">0</span></td>
                    <td class="text-secondary w-25" id="rage-tab">
                        <label for="target_range"></label>
                        <input type="range" class="custom-range w-100" name="form_range" id="target_range" min="1" max="1000">
                        <div id="plus-bonus">+<?= $donateBonus[$i]; ?> Bonus</div>
                    </td>

                    <td class="text-secondary">
                            <input type="hidden" name="form_item_id" value="<?= $itemId = $donateItemId[$i]; ?>">
                            <input type="hidden" name="form_item_icon" value="<?= $iconName = $donateIconName[$i]; ?>">
                            <input type="hidden" name="form_item_name" value="<?= $itemName = $donateItemName[$i]; ?>">
                            <input type="hidden" id="target_item_price" value="<?= $price = $donateItemPrice[$i]; ?>">
                            <input type="hidden" id="target_item_bonus" value="<?= $bonus = $donateBonus[$i]; ?>">
                            <input type="hidden" name="form_item_amount" id="target_item_amount">
                            <input type="hidden" name="form_item_total" id="target_item_total">
                            <input type="submit" class="btn w-100 btn-dark btn-add-donate" value="send" id="target_sub_order">
                    </td>

                 
                </tr>
             <?php 
        } ?>
            </tbody>
        </table>

            <?php echo form_close(); ?>
    </article>
    <img src="<?= base_url('assets/images/keyboard.gif') ?>" class="float-right" width="100">
</div>

<script type="application/javascript">

    $(function () {

        $('input[name=form_range]').change('mousestop',function () {
            
            if (document.getElementById('target_check_donate').checked) {

                $('#plus-bonus').fadeIn('slow');

                setInterval(function () {
                    $('#plus-bonus').fadeOut('slow');
                }, 1);

                $.ajax({
                    type: 'POST',
                    url: "<?= base_url("admin/Store_controllers/cal"); ?>",
                    data: {
                        qt: $(this).val(),price: <?php if (isset($price)) {echo $price;} ?>,
                        bonus: <?php if (isset($bonus)) {echo $bonus;} ?>,
                        csrf_protection: $('input[name="csrf_protection"]').val(),
                        itemId: <?php if (isset($itemId)) {echo $itemId;} ?>,
                        iconName: '<?php if (isset($iconName)) {echo $iconName;} ?>',
                        itemName: '<?php if (isset($itemName)) {echo $itemName;} ?>'
                    },

                    dataType: 'json',
                    success: function (json) {
                        if (json.success === true){

                            console.log(json.total + "\n"+json.qt + "\n"+json.item); //Debug
                            document.getElementById('total').innerHTML = json.total;
                            document.getElementById('qt').innerHTML = json.qt;         
                            $('input[name="form_item_total"]').val(json.total);
                            $('input[name="form_item_amount"]').val(json.qt);
                            
                        }
                    },
                    error:function () {console.log("Error");}
                });

            } else {
                alert("Accepted the rules?");
            }

        });

        $('#target_sub_order').mouseenter(function () {

            var amount = $('#target_item_total').val();
            if (amount === undefined || amount <= 0) alert("Value Zero");

        });

    });


</script>