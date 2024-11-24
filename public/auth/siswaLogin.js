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
        }else{
            submitButton.disabled = false
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()