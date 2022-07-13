<?php
global $wpdb;
$table_name = $wpdb->prefix . 'paypal_settings';
$result = $wpdb->get_results("SELECT * FROM $table_name");
$currency_symbol = "";
$currency = "";
$paypal_email = "";
$payza_email = "";
$contact_email = "";
if($result)
{
if($result[0]->currency_symbol){
    $currency_symbol = $result[0]->currency_symbol;
}
if($result[0]->currency)
{
    $currency = $result[0]->currency;
}
if($result[0]->paypal_account)
{
    $paypal_email = $result[0]->paypal_account;
}
if($result[0]->payza_email)
{
    $payza_email = $result[0]->payza_email;
}
if($result[0]->contact_email)
{
    $contact_email = $result[0]->contact_email;
}
}
?>

<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php
        echo    __('PayPal Settings')
        ?>
    </h1>
    <hr class="wp-header-end">
    <form action="javascript:;" id="paypal_settings" method="POST">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th>
                        <label for="currency_symbol">Currency Symbol</label>
                    </th>
                    <td>
                        <input type="text" class="regular-text" value="<?php echo $currency_symbol; ?>" id="currency_symbol" required name="currency_symbol" placeholder="Please Enter PayPal Currency Symbol" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="currency">Currency</label>
                    </th>
                    <td>
                        <input type="text" class="regular-text" id="currency" value="<?php echo $currency; ?>" name="currency" required placeholder="USD" style="text-transform: uppercase;" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="paypal_email">PayPal Email</label>
                    </th>
                    <td>
                        <input type="email" class="regular-text" value="<?php echo $paypal_email; ?>" id="paypal_email" name="paypal_email" required placeholder="Please Enter PayPal Email" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="payza_email">Payza Email</label>
                    </th>
                    <td>
                        <input type="email" class="regular-text" value="<?php echo $payza_email; ?>" id="payza_email" name="payza_email" placeholder="Please Enter Payza Email" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="contact_email">Contact Email</label>
                    </th>
                    <td>
                        <input type="email" class="regular-text" value="<?php echo $contact_email; ?>" id="contact_email" name="contact_email" required placeholder="Please Enter Contact Email" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="response-message"></p>
        <p class="submit">

            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
            <span class="spinner" style="float: none;"></span>
        </p>
    </form>

</div>

<script>
    jQuery(document).ready(($) => {
        $('#paypal_settings').submit(() => {
            $('.spinner').addClass('is-active')
            $('#paypal_settings #submit').attr('disabled', true)
            let form_data = $('#paypal_settings').serialize()
            $.ajax({
                method: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'paypal_settings',
                    currency_symbol: $('#currency_symbol').val(),
                    currency: $('#currency').val(),
                    paypal_email: $('#paypal_email').val(),
                    payza_email: $('#payza_email').val(),
                    contact_email: $('#contact_email').val(),
                },
                success: (response) => {
                    let data = $.parseJSON(response)
                    $('.response-message').html(data.message)
                    $('.spinner').removeClass('is-active')
                    $('#paypal_settings #submit').removeAttr('disabled')
                }
            })
        })
    })
</script>