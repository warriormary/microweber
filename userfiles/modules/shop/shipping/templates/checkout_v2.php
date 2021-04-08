<script type="text/javascript">
    showShippingModule = function (shippingModule,shippingModulePath) {
        $('.js-shipping-gateway-box').html('');
        $.ajax({
            url: "<?php print route('checkout.shipping_method_change') ?>",
            data: {"shipping_gw":shippingModulePath},
            method: 'POST',
        }).done(function() {
            mw.reload_module('shop/cart');

            var newShippingModuleElement  = $('<div/>').appendTo('#mw-shipping-gateway-module-'+shippingModule);

            newShippingModuleElement.attr('id', 'mw-shipping-gateway-module-render-'+shippingModule);
            newShippingModuleElement.attr('data-type',shippingModulePath);
            newShippingModuleElement.attr('class','js-shipping-gateway-module-box');
            newShippingModuleElement.attr('template','checkout_v2');

            mw.reload_module(newShippingModuleElement);
        });
    }
</script>

<?php
if (isset($params['selected_provider'])) {
    $selected_shipping_gateway = $params['selected_provider'];
}
?>

<div class="mw-shipping-select">
    <div  class="my-3" <?php if(count($shipping_options) == 1): ?>style="display: none" <?php endif; ?>>
        <h4 class="mt-5"><?php _e("How you prefer to receive your order ?"); ?></h4>
        <small class="text-muted d-block mb-2"> <?php _e("Choose the right method for deliver your order."); ?></small>
        <?php $count = 0;
         foreach ($shipping_options as $item) : $count++; ?>
                <div class="form-group">
                    <div class="custom-control custom-radio checkout-v2-radio pl-0 pt-3">
                        <label class="control-label">
                        <input type="radio" onchange="showShippingModule('<?php echo md5($item['module_base']); ?>','<?php echo $item['module_base']; ?>');" name="shipping_gw" value="<?php print  $item['module_base']; ?>" <?php if ($selected_shipping_gateway == $item['module_base']): ?> checked="checked" <?php endif; ?>">

                            <?php
                            if (isset($item['settings']['icon_class'])):
                            ?>
                            <i class="shipping-icons-checkout-v2 <?php echo $item['settings']['icon_class']; ?>"></i>
                            <?php
                            endif;
                            ?>
                            <?php print $item['name']; ?>
                        </label>
                    </div>
                </div>

             <div id="mw-shipping-gateway-module-<?php echo md5($item['module_base']); ?>" class="js-shipping-gateway-box"></div>

            <?php endforeach; ?>
    </div>

    <?php if (is_module($selected_shipping_gateway)): ?>
    <script type="text/javascript">
        showShippingModule('<?php echo md5($selected_shipping_gateway); ?>','<?php echo $selected_shipping_gateway ?>');
    </script>
    <?php endif; ?>
</div>


