const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar() {
    sidebar.classList.toggle('close');
    toggleButton.classList.toggle('rotate');

    closeAllSubMenus()
}

function toggleSubMenu(button) {
    if (!button.nextElementSibling.classList.contains('show')) {
        closeAllSubMenus()
    }
    button.nextElementSibling.classList.toggle('show');
    button.classList.toggle('rotate')

    if (sidebar.classList.contains('close')) {
        sidebar.classList.toggle('close')
        toggleButton.classList.toggle('rotate')
    }
}

function closeAllSubMenus() {
    Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
        ul.classList.remove('show')
        ul.previousElementSibling.classList.remove('rotate')
    })
}

function goFullscreen() {
    document.documentElement.requestFullscreen();
}

function subMenuNavbar(button) {
    // button.style.backgroundColor = "#222533"
    button.classList.toggle('visited')
    button.style.borderTopLeftRadius = ".5em"
    button.nextElementSibling.classList.toggle('show-sub-menu-navbar')
}

// goFullscreen()

// logout
document.addEventListener('DOMContentLoaded', function () {
    const btnLogout = document.querySelector('#logout-admin');
    const logoutForm = document.querySelector('#logout-form');

    btnLogout.addEventListener('click', function (event) {
        event.preventDefault();
        logoutUser();
    });

    function logoutUser() {
        Swal.fire({
            title: "Apakah yakin mau Logout!",
            text: "Tekan LOGOUT jika yakin mau Logout.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Logout"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Logging out...',
                    text: 'Please wait while we log you out.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                try {
                    fetch(logoutForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': logoutForm.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            _method: 'POST'
                        })
                    })
                        .then(response => {
                            window.location.href = '/login';
                        })
                        .catch(error => {
                            console.log("Terjadi Error: ", error);
                        });

                } catch (error) {
                    Swal.fire({
                        title: "Error!",
                        text: "There was an error logging out.",
                        icon: "error"
                    });
                }


                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    }
});

// Reload saat tombol refresh di tekan
window.addEventListener('beforeunload', function (event) {
    // sebelum halaman di muat ulang
    Swal.fire({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" style="background: none; width:200px;">  <linearGradient id="a11">
            <stop offset="0" stop-color="#2239e3" stop-opacity="0"></stop>
            <stop offset="1" stop-color="#2239e3"></stop>
          </linearGradient>
          <circle fill="none" stroke="url(#a11)" stroke-width="25" stroke-linecap="round" stroke-dasharray="0 44 0 44 0 44 0 44 0 360" cx="75" cy="75" r="55" transform-origin="center">
            <animateTransform type="rotate" attributeName="transform" calcMode="discrete" dur="2" values="360;324;288;252;216;180;144;108;72;36" repeatCount="indefinite"></animateTransform>
          </circle>
        </svg>`,
        showConfirmButton: false,
        allowOutsideClick: false,
        willOpen: () => {
            // Mengatur style popup agar background transparan
            const swalContainer = Swal.getPopup();
            swalContainer.style.background = 'transparent'; // Menghilangkan background
            swalContainer.style.boxShadow = 'none'; // Menghilangkan bayangan
        }
    });
});

// Form Validation
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        const submitButton = form.querySelector('button[type="submit"]')
        submitButton.disabled = true

        form.addEventListener('input', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                submitButton.disabled = true
            } else {
                submitButton.disabled = false
            }
            form.classList.add('was-validated')
        }, false)
    })
})()


function validateNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, "");
}

// // Reload saat tombol refresh di tekan
// window.addEventListener('beforeunload', function (event) {
//     // sebelum halaman di muat ulang
//     Swal.fire({
//         title: 'Loading...',
//         showConfirmButton: false,
//         willOpen: () => {
//             Swal.showLoading();
//         },
//         allowOutsideClick: false,
//     });
// });

function loadingPage() {
    Swal.fire({
        title: 'Loading...',
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false,
    });
}

// Check All
function checkAll(checkbox) {
    const isChecked = $(checkbox).is(':checked');
    $('.siswa-checkbox').prop('checked', isChecked);
}

function updateSelectAll() {

    const totalCheckboxes = $('.siswa-checkbox').length;
    const checkedCheckboxes = $('.siswa-checkbox:checked').length;

    $('#select-all-checkbox').prop('checked', totalCheckboxes === checkedCheckboxes);
}

// Other Options
function toggleOtherInput(selectElement) {
    const otherInput = document.querySelector('[name="other_barang"]');
    if (selectElement.value === 'other') {
        otherInput.classList.remove('d-none');
        otherInput.focus();
        // selectElement.classList.add('d-none')
    } else {
        // selectElement.classList.remove('d-none')
        otherInput.classList.add('d-none');
        otherInput.value = '';
    }
}