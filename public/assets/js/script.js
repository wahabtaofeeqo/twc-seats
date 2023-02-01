(function($) {
    $(".available").click(function(e) {

        let type = $(this).attr('data-type');
        let seatId = $(this).attr('data-id');
        let color = $(this).attr('data-color');
        let number = $(this).attr('data-number');

        $('#seat-id').val(seatId);
        $('#seat-type').val(type);
        $('#seat-color').val(color);
        $('#seat-number').val(number);
        $('#seat-price').text('₦25,000');

        //
        $("#formModal").modal('show');
    })

    // Couch
    $(".couch").click(function(e) {

        let type = $(this).attr('data-type');
        let seatId = $(this).attr('data-id');
        let color = $(this).attr('data-color');
        let number = $(this).attr('data-number');

        $('#seat-id').val(seatId);
        $('#seat-type').val(type);
        $('#seat-color').val(color);
        $('#seat-number').val(number);
        $('#seat-price').text('₦100,000');

        //
        $("#formModal").modal('show');
    })

    $(".buy-ticket").click(function(e) {
        $("#ticketModal").modal('show');
    })

    $(".confirm").click(function(e) {
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');
        toastr.info('Please wait...')

        if(confirm('Do you wish to continue')) {
            axios.post(`/api/approve`, {id, type})
            .then(res => {
                toastr.success(res.data.message)
                window.location.reload();
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
        }
    })

    $(".cancel").click(function(e) {
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');
        toastr.info('Please wait...')

        if(confirm('Do you wish to continue?')) {
            axios.post(`/api/cancel`, {id, type})
            .then(res => {
                toastr.success(res.data.message)
                window.location.reload();
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
        }
    })

    //
    $("#buyForm").submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        axios.post(`/api/confirm`, data)
            .then(res => {
                toastr.success(res.data.message)
                window.location.reload();
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
    })

    $("#ticketForm").submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        axios.post(`/api/tickets`, data)
            .then(res => {
                toastr.success(res.data.message)
                $("#ticketModal").modal('hide');
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
    })

    //
    let payWithPaystack = (data) => {
        let amount = 25000;
        let handler = PaystackPop.setup({
            key: 'pk_test_379e4193510b67197fa56d8783f3c64e3386d3e7',
            name: data.name,
            email: data.email,
            amount: amount * 100,
            onClose: function() {
                toastr.info('Process terminated')
            },
            callback: function(response) {
                axios.post(`/api/verify/${response.reference}`, data)
                    .then(res => {
                        console.log(res);
                        toastr.success(res.data.message)
                        window.location.reload();
                    })
                    .catch(e => {
                        toastr.error('Unable to verify payment')
                    })
            }
        });

        //
        handler.openIframe();
    }

    $("#bookForm").submit(function(e) {
        e.preventDefault();
        data = $(this).serialize();
        axios.post(`/api/book`, data)
            .then(res => {
                toastr.success(res.data.message)
                window.location.reload();
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
    })

    $(".btn-logout").click(function(e) {
        axios.get(`/api/logout`)
            .then(res => {
                toastr.success(res.data.message)
                window.location.reload();
            })
            .catch(e => {
                let message = e.response?.data?.message || e.message
                toastr.error(message)
            })
    })
})(jQuery)
