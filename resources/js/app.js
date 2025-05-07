// import './bootstrap';
// import './map-add';
// import './form-location';
import TomSelect from 'tom-select';
import $ from 'jquery';
import Swal from 'sweetalert2';


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('popupDelete', (data) => {
        Swal.fire({
            title: "Apakah anda yakin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('confirmDelete', data[0]);
            }
        });
    });

    Livewire.on('miniNotif', (data) => {
        Toast.fire({
            icon: "success",
            title: data[0].message
        });
    });
});

$('.loader').addClass('d-none');

function initTomSelect() {
    var settings = {};
    new TomSelect(".select-beast", {
        create: false,
        maxItems: 1,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
}
initTomSelect();
