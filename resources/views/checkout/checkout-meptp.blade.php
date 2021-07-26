<button type="button" onclick="makePayment()" class="btn  btn-primary m-1" id="save" name="save"></button>

<script>
    function makePayment() {
        var paymentEngine = RmPaymentEngine.init({
            key: '<?php echo env('REMITA_KEY') ?>'
            customerId: 'iampapaisarkar@gmail.com',
            firstName: 'papai',
            lastName: 'sarkar',
            email: 'iampapaisarkar@gmail.com',
            amount: 500,
            narration: 'Test',
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