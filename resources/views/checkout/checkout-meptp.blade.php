<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
</head>
<body onLoad="makePayment()">
<script>
    function makePayment() {
        var paymentEngine = RmPaymentEngine.init({
            key: '<?php echo env('REMITA_KEY') ?>',
            customerId: '<?php $user->id ?>',
            firstName: '<?php $user->firstname ?>',
            lastName: '<?php $user->lastname ?>',
            email: '<?php $user->email ?>',
            amount: '<?php $amount ?>',
            narration: '<?php echo env('REMITA_NARRATION') ?>',
            onSuccess: function(response) {
                console.log('callback Successful Response', response);
            },
            onError: function(response) {
                console.log('callback Error Response', response);
            },
            onClose: function() {
                console.log("closed");
            }
        });
        paymentEngine.showPaymentWidget();
    }
</script>
</body>
</html>
