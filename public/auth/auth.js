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

// Reload saat tombol refresh di tekan
window.addEventListener('beforeunload', function (event) {
  // sebelum halaman di muat ulang
  Swal.fire({
    title: 'Loading...',
    showConfirmButton: false,
    willOpen: () => {
      Swal.showLoading();
    },
    allowOutsideClick: false,
  });
});

// login
// document.addEventListener('DOMContentLoaded', () => {
//   const loginForm = document.querySelector('form')
//   const buttonSubmitLogin = document.querySelector('button[type="submit"]');

//   buttonSubmitLogin.addEventListener('click', (event) => {
//     event.preventDefault();
//     fetch(loginForm.action, {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': loginForm.querySelector('input[name="_token"]').value
//       },
//       body: JSON.stringify({
//         _method: 'POST',
//         username: loginForm.querySelector('input[name="username"]').value,
//         password: loginForm.querySelector('input[name="password"]').value,
//         _token: loginForm.querySelector('input[name="_token"]').value,
//       })
//     }).then(response => {
//       console.log(response)
//       if (response.ok) {
//         swal.fire({
//           title: "Login Berhasil!",
//           icon: "success",
//           showCancelButton: false,
//           showConfirmButton: true,
//           confirmButtonText: "Home"
//         }).then((result) => {
//           if (result.isConfirmed) {
//             window.location.href = "/"
//           }
//         })
//       } else{
//         Swal.fire({
//           toast: true,
//           position: 'top-end',
//           icon: 'error',
//           title: 'Galat Login, Username dan Password tidak cocok!',
//           showConfirmButton: false,
//           timer: 3000,
//           timerProgressBar: true,
//           didOpen: (toast) => {
//             toast.addEventListener('mouseenter', Swal.stopTimer);
//             toast.addEventListener('mouseleave', Swal.resumeTimer);
//           }
//         });
//       }
//     }).catch(error => {
//       Swal.fire({
//         toast: true,
//         position: 'top-end',
//         icon: 'error',
//         title: 'Galat Login, Username dan Password tidak cocok!',
//         showConfirmButton: false,
//         timer: 3000,
//         timerProgressBar: true,
//         didOpen: (toast) => {
//           toast.addEventListener('mouseenter', Swal.stopTimer);
//           toast.addEventListener('mouseleave', Swal.resumeTimer);
//         }
//       });
//     })
//   })

// })