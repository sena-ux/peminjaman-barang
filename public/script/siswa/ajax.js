function resetTable() {
    var table = $('#siswa-table').DataTable();
    table.search('').columns().search('').draw();
}

function reloadTable() {
    var table = $('#siswa-table').DataTable();
    table.ajax.reload();
}

// Add Siswa
function addSiswa() {
    Swal.fire({
        title: "<strong>Create Siswa</strong>",
        icon: false,
        html: `
    <form id="siswaForm">
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Username</span>
            <input type="text" class="form-control" id="username" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Username" name="username" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Email</span>
            <input type="email" class="form-control" id="email" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Email" name="email" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Name</span>
            <input type="text" class="form-control" id="name" aria-describedby="basic-addon3 basic-addon4" name="name" placeholder="Enter your Nama Lengkap" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">NISN</span>
            <input type="text" class="form-control" oninput="validateNumber(this)" id="nisn" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NISN" name="nisn" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">NIS</span>
            <input type="text" class="form-control" oninput="validateNumber(this)" id="nis" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NIS" name="nis" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Kelas</span>
            <input type="text" class="form-control" id="kelas" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Kelas" name="kelas" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Nomor HP</span>
            <input type="text" class="form-control" oninput="validateNumber(this)" id="no_hp" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Nomor HP Aktif" name="no_hp" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Password</span>
            <input type="password" class="form-control" id="password" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Password" name="password" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" id="basic-addon3">Confirm Password</span>
            <input type="password" class="form-control" id="confirm_password" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Confirm Password" name="password_confirmation" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Wajib di sini, minlength 5.
            </div>
        </div>
    </form>
  `,
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: "Create Siswa",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const form = $('#siswaForm');
            if (!form[0].checkValidity()) {
                Swal.showValidationMessage('Please fill out all required fields correctly.');
                return false;
            }
            return form.serialize();
        }
    }).then((result) => {
        if (result.isConfirmed) {
            loadingPage();
            $.ajax({
                url: '/admin/siswa',
                type: 'POST',
                method: 'POST',
                data: result.value,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Siswa created successfully',
                            text: response.message
                        }).then(reloadTable());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        }).then((result) => { if (result.isConfirmed) { addSiswa() } });
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! ' + errorMessage,
                    }).then((result) => { if (result.isConfirmed) { addSiswa() } });
                }
            });
        }
    })
}

// Reset Password All
function resetPasswordAll() {
    swal.fire({
        title: "Reset Password All Siswa",
        text: "Fitur ini digunakan untuk reset semua password siswa.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Reset Semua Siswa",
    }).then((result) => {
        if (result.isConfirmed) {
            swal.fire({
                title: "Reset Password",
                input: "password",
                inputLabel: "Buat Password : ",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: false,
                confirmButtonText: 'Reset',
                confirmButtonColor: 'primary',
                showLoaderOnConfirm: true,
                backdrop: true,
                preConfirm: async () => {
                    const newPassword = Swal.getInput().value;
                    if (!newPassword || newPassword.length < 8) {
                        let message;
                        if (!newPassword) {
                            message = 'Password tidak boleh kosong!';
                        } else {
                            message = 'Password harus terdiri dari minimal 8 karakter!';
                        }
                        return Swal.showValidationMessage(message);
                    }
                    try {
                        const url = "/admin/reset/all/password/siswa";
                        const response = await fetch(url, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ newPassword })
                        });

                        if (response.ok) {
                            const result = await response.json();
                            Swal.fire({
                                title: "Good job!",
                                text: `${result.message}`,
                                icon: "success",
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            reloadTable()
                            swal.fire('Success', result.message, 'success')
                        } else {
                            return Swal.showValidationMessage(`
                              ${JSON.stringify(await response.json())}
                            `);
                        }
                    } catch (error) {
                        Swal.showValidationMessage(`
                            Request failed: ${error}
                            `);
                    }
                },
                allowOutsideClick: () => resetTable()
            })
        }
    }).then((result) => {
        reloadTable();
    })
}


//Edit
function editSiswa(button) {
    $.ajax({
        url: `/admin/siswa/${button.id}/edit`,
        success: (response) => {
            Swal.fire({
                title: "<strong>Create Siswa</strong>",
                icon: false,
                html: `
            <form id="siswaForm">
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Username</span>
                    <input type="text" class="form-control" id="username" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Username" name="username" value="${response.data.user.username}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Email</span>
                    <input type="email" class="form-control" id="email" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Email" name="email" value="${response.data.user.email}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Name</span>
                    <input type="text" class="form-control" id="name" aria-describedby="basic-addon3 basic-addon4" name="name" placeholder="Enter your Nama Lengkap" value="${response.data.name}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">NISN</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="nisn" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NISN" name="nisn" value="${response.data.nisn}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">NIS</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="nis" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NIS" name="nis" value="${response.data.nis}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Kelas</span>
                    <input type="text" class="form-control" id="kelas" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Kelas" name="kelas" value="${response.data.kelas.name}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Nomor HP</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="no_hp" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Nomor HP Aktif" name="no_hp" value="${response.data.no_hp}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
            </form>
          `,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Update Siswa",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const form = $('#siswaForm');
                    if (!form[0].checkValidity()) {
                        Swal.showValidationMessage('Please fill out all required fields correctly.');
                        return false;
                    }
                    return form.serialize();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingPage();
                    $.ajax({
                        url: `/admin/siswa/${button.id}`,
                        type: 'PATCH',
                        method: 'PATCH',
                        data: result.value,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Siswa created successfully',
                                    text: response.message
                                }).then(reloadTable());
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Silahkan lakukan perubahan Data',
                                    text: response.message,
                                }).then((result) => { if (result.isConfirmed) { editSiswa(button) } });
                            }
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong! ' + errorMessage,
                            }).then((result) => { if (result.isConfirmed) { editSiswa(button) } });
                        }
                    });
                }
            })
        }
    })

}

// Delete
function deleteSiswa(id) {
    Swal.fire({
        title: "Delete Siswa",
        text: `Apakah yakin delete siswa dengan id ${id}`,
        icon: 'warning',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#d33',
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            return await $.ajax({
                url: `/admin/siswa/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            }).then(() => {
                Swal.fire('Deleted!', 'Siswa telah dihapus.', 'success');
                reloadTable();
            }).catch((xhr) => {
                Swal.fire('Error!', xhr.responseJSON.message, 'error'); // Menampilkan pesan kesalahan dari backend
            });
        }
    });
}


// Show Tabel
function show(id) {
    $.ajax({
        url: `/admin/siswa/${id}`,
        success: (response) => {
            Swal.fire({
                title: `Detail Data dari ${response.data.name}`,
                icon: false,
                html: `
            <form id="siswaForm">
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Username</span>
                    <input type="text" class="form-control" id="username" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Username" name="username" value="${response.data.user.username}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Email</span>
                    <input type="email" class="form-control" id="email" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Email" name="email" value="${response.data.user.email}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Name</span>
                    <input type="text" class="form-control" id="name" aria-describedby="basic-addon3 basic-addon4" name="name" placeholder="Enter your Nama Lengkap" value="${response.data.name}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">NISN</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="nisn" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NISN" name="nisn" value="${response.data.nisn}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">NIS</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="nis" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your NIS" name="nis" value="${response.data.nis}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Kelas</span>
                    <input type="text" class="form-control" id="kelas" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Kelas" name="kelas" value="${response.data.kelas.name}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
                <div class="input-group py-1">
                    <span class="input-group-text col-sm-4" id="basic-addon3">Nomor HP</span>
                    <input type="text" class="form-control" oninput="validateNumber(this)" id="no_hp" aria-describedby="basic-addon3 basic-addon4" placeholder="Enter your Nomor HP Aktif" name="no_hp" value="${response.data.no_hp}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 5.
                    </div>
                </div>
            </form>
          `,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "OK",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const form = $('#siswaForm');
                    if (!form[0].checkValidity()) {
                        Swal.showValidationMessage('Please fill out all required fields correctly.');
                        return false;
                    }
                    return form.serialize();
                }
            })
        }
    })
}

// Import data siswa
const importDataSiswa = async () => {
    const { value: file } = await Swal.fire({
        title: "Upload Data Siswa",
        html: `Silahkan download template dengan <a href='/admin/download/template/import/siswa'> Klik Disini</a>`,
        input: "file",
        inputAttributes: {
            accept: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "aria-label": "Upload Data Siswa"
        }
    });

    if (file) {
        loadingPage()
        const formData = new FormData();
        formData.append('file', file);
        try {
            $.ajax({
                url: '/admin/import/siswa',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = evt.loaded / evt.total;
                            Swal.fire({
                                title: 'Loading...',
                                html: `Mengunggah Data Siswa... ${Math.round(percentComplete * 100)}%`,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                },
                                allowOutsideClick: false,
                            });
                        }
                    }, false);
                    return xhr;
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    reloadTable()
                    Swal.fire("Success", "Data Siswa imported successfully!", "success");
                },
                error: (xhr, status, error) => {
                    Swal.fire("Error", `There was an error importing the data. ${xhr.responseText}`, "error");
                }
            });
        } catch (error) {
            swal.fire("Error", error.message, "error");
        }
    }
};

function downloadTemplate() {
    loadingPage()

    const form = $('<form>', {
        action: '/admin/download/template/import/siswa',
        method: 'GET',
        style: 'display: none;'
    });

    $('body').append(form);
    form.submit();
    form.remove();

}

function removeSelected() {
    const selectedValues = [];
    $('.siswa-checkbox:checked').each(function() {
        selectedValues.push($(this).val());
    });

    if (selectedValues.length > 0) {
        $.ajax({
            url: '/admin/delete/selected/siswa',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                ids: selectedValues
            },
            success: function(response) {
                reloadTable()
                swal.fire("Success", response.message, "success");
                $('.row-checkbox:checked').closest('tr').remove();
            },
            error: function(xhr) {
                swal.fire('Error', xhr.responseText, 'error')
            }
        });
    } else {
        swal.fire('Error', "Pilih data terlebih dahulu!", 'error')
    }
}