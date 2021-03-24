<?php if (isset($orderCountItem) > 0) { ?>
    <div class="alert alert-info m-3 text-center" role="alert">
        <span>Orders: </span> <span class="badge badge-danger"> <?= $orderCountItem ?></span>
    </div>
<?php 
} else { ?>
    <div class="alert alert-info m-3 text-center" role="alert">
        No have order
    </div>
<?php } ?>

<?php if (isset($limitOders) === true) { ?>
    <div class="alert alert-info m-3 text-center" role="alert">
        Quantity Orders bigger that limit <?php echo $limit_orders ?>
    </div>
<?php } ?>

<?php if (isset($success) and $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span> Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/order"); ?>">Sair</a></span>

        </div>
    </div>
<?php 
} ?>

<script type="application/javascript">

    $(function () {
        $('.upload-delete').click(function (e) {

            e.preventDefault();
        
            $.ajax({
                url: '<?= base_url('admin/Store_controllers/deleteOrder') ?>',
                type: 'POST',
                data: {orderId: parseInt($(this).val()), token: $(this).attr('id'), csrf_protection: $('input[name="csrf_protection"]').val()},
                dataType: 'json',
                success: function (json) {
                    
                    if (json.deleted === true) {
                        let url = ' <?= site_url('admin/order'); ?>';
                        window.location.href = url;
                    }
                    
                },
                error: function (result) {
                    alert("Error");
                }
            });

        });
    });
</script>

<div class="range-donate">

    <div class="alert alert-danger" role="alert">Warning, bonus defined after payment, not is included on interface of paypal, it's added separated!</div>
    <article>


 

        <table class="table text-center">

            <thead>

            <tr>
                <th scope="col" class="donateTitle">Icon</th>
                <th scope="col" class="donateTitle">Name</th>
                <th scope="col" class="donateTitle">Amount</th>
                <th scope="col" class="donateTitle">Total</th>
                <th scope="col" class="donateTitle">Payment</th>
                <th scope="col" class="donateTitle">Click for Donate</th>
                <th scope="col" class="donateTitle">Delete</th>
            </tr>

            </thead>
        
            <tbody>
           
        
            <?php for ($i = 0; $i < $orderCountItem; $i++) { ?>
   
                <tr>
                
                <?php echo form_open('admin/process','method="post"'); ?>
                    <td><img style="border-radius: 30px !important;" width="32" height="32" src="<?= base_url("uploaded/icon/" . $orderIcon[$i]); ?>"></td>
                    <td class="text-secondary" ><?= $orderItemName[$i] ?></td>
                    <td class="text-secondary" ><?= $orderAmount[$i] ?></td>
                    <td class="text-secondary" style="width: 5%">$<span id="total" class="text-danger"><?= $total[$i] ?></span></td>
                    <td class="text-secondary w-25">
                    <select class="form-control form-control-sm" name="form_select">
                            <option value="1">Paypal</option>
                            <option value="2">PagSeguro</option>
                    </select>
                    </td>

                    <td class="text-secondary">

                    <input type="hidden" name="form_order" id="target_order" value="<?= $orderId[$i] ?>">
                    <input type="submit" class="btn w-100 btn-dark" value="Donate" id="target_sub_order">
    
                    </td>
                    <!-- Iverter ID Token-->
                    <td><button type="button" class="upload-delete" id="<?= $token[$i] ?>" value="<?= $orderId[$i] ?>"><i class="fas fa-trash-alt"></i></button></td>
                 
                    <?php echo form_close(); ?>
                </tr>
           
            <?php  } ?>

      
        </tbody>

        </table>

    

    </article>


</div>

