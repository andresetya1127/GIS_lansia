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

$(document).on('submit', '#form-lansia', function (e) {
    e.preventDefault();
    let form = new FormData(this);
    $.ajax({
        'url': $(this).attr('action'),
        'method': 'POST',
        'data': form,
        'dataType': 'json',
        'contentType': false,
        'processData': false,
        beforeSend: function () {
            $('.loader').removeClass('d-none');
        },
        success: function (response) {

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


$('#check-location').on('click', function (e) {
    e.preventDefault();
    const form = $('#form-lansia');
    $.ajax({
        'url': '/lansia/location/check',
        'method': 'POST',
        'data': form.serialize(),
        'dataType': 'json',
        beforeSend: function () {
            $('.loader').removeClass('d-none');
        },
        success: function (response) {
            if (response.status == 'success' && response.data) {
                let state = response.data.state ?? '';
                let county = response.data.county ?? '';
                let city = response.data.city ?? '';
                let town = response.data.town ?? '';
                let village = response.data.village ?? '';
                let display_name = response.data.display_name ?? '';

                $('input[name="provinsi"]').addClass(state ? 'is-valid' : 'is-invalid').val(state);
                $('input[name="kabupaten"]').addClass(county ? 'is-valid' : 'is-invalid').val(county);
                $('input[name="kecamatan"]').addClass(city ? 'is-valid' : town ? 'is-valid' : 'is-invalid').val(city ?? town);
                $('input[name="desa"]').addClass(village ? 'is-valid' : 'is-invalid').val(village);
                $('textarea[name="alamat"]').addClass(display_name ? 'is-valid' : 'is-invalid').val(display_name ?? '');

                Toast.fire({
                    icon: response.status,
                    title: response.message
                });
            }
        },
        error: function (error) {
            Toast.fire({
                icon: error.responseJSON.status,
                title: error.responseJSON.message
            });
        },
        complete: function () {
            $('.loader').addClass('d-none');
        }
    })
})

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
