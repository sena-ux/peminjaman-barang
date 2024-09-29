function showform(button) {
    let nisn = document.querySelector('#nisn')
    let nis = document.querySelector('#nis')
    let nip = document.querySelector('#nip')
    let role = document.querySelector('#role')
    let submit = document.querySelector('#submit')
    
    if(button.id == 'gurpeg') {
        nisn.classList.add('d-none')
        nis.classList.add('d-none')
        nip.classList.add('d-none')

        nisn.classList.replace('d-none', 'd-none')
        nis.classList.replace('d-none', 'd-none')
        nip.classList.replace('d-none', 'd-show')

        role.value = "gurpeg"
        submit.removeAttribute('disabled')
        submit.type = 'submit'
    } else if(button.id == 'siswa'){
        nisn.classList.replace('d-none', 'd-show')
        nis.classList.replace('d-none', 'd-show')
        nip.classList.replace('d-show', 'd-none')
        
        role.value = "siswa"
        submit.removeAttribute('disabled')
        submit.type = 'submit'
    }
}