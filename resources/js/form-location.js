import $ from 'jquery';
import 'bootstrap';
import Swal from 'sweetalert2';


const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// Form confirm location
let options = {
    backdrop: 'static',
    keyboard: false
}
const modal = new coreui.Modal('#modal-detail-location', options)

$(document).on('submit', 'form[data-ajax="submit-location"]', function (e) {
    e.preventDefault();
    const form = $(this);
    $.ajax({
        'url': $(this).attr('action'),
        'method': 'POST',
        'data': form.serialize(),
        'dataType': 'json',
        beforeSend: function () {
            $('.loader').removeClass('d-none');
        },
        success: function (response) {
            if (response.status == 'success' && response.data) {
                modal.show();
                $('#modal-detail-location').find('.modal-body').html(response.data);
            }

            if (response.status == 'success' && response.url) {
                Toast.fire({
                    icon: response.status,
                    title: response.message
                });
                window.location.href = response.url;
            }
        },
        error: function (error) {
            Toast.fire({
                icon: error.responseJSON.status,
                title: error.responseJSON.message
            });
            if (error.responseJSON.validations) {
                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                const errors = error.responseJSON.validations;

                for (const [key, value] of Object.entries(errors)) {

                    form.find(`input[name="${key}"]`).addClass('is-invalid');
                    form.find(`input[name="${key}"]`).after(`<div class="invalid-feedback">${value}</div>`);
                }
            }
        },
        complete: function () {
            $('.loader').addClass('d-none');

        }
    })
});



function age(tanggalLahir) {
    const today = new Date();
    const lahir = new Date(tanggalLahir);
    let umur = today.getFullYear() - lahir.getFullYear();
    const bulan = today.getMonth() - lahir.getMonth();

    if (bulan < 0 || (bulan === 0 && today.getDate() < lahir.getDate())) {
        umur--;
    }

    return umur;
}


$(document).on('change', 'input[name="tgl_lahir"]', function () {
    const tanggalLahir = $(this).val();
    const umur = age(tanggalLahir);
    $('input[name="umur"]').val(umur);
})
