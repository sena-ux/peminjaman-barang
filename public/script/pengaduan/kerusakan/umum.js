function resetTable() {
    var table = $('#kerusakanumum-table').DataTable();
    table.search('').columns().search('').draw();
}

function reloadTable() {
    var table = $('#kerusakanumum-table').DataTable();
    table.ajax.reload();
}


//select swal dengan data in databases
// let options = `<option selected>Choose...</option>`;
//     barangData.forEach(item => {
//         console.log(item)
//         options += `<option value="${item.id_barang}">${item.nama_barang}</option>`;
//     });
// <div class="input-group py-1">
//             <label class="input-group-text col-sm-4" for="barang_name">Barang</label>
//             <select class="form-select" id="barang_name" name="barang">
//                 ${options}
//             </select>
//         </div>

// Add Siswa
const addPengaduan = async () => {
    const { value: formValue } = await Swal.fire({
        title: "<strong>Create Pengaduan</strong>",
        icon: false,
        html: `
    <form id="siswaForm">
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" for="barang">Nama Barang</span>
            <input type="text" class="form-control" placeholder="Input nama barang dengan benar." aria-label="barang" aria-describedby="barang" id="barang" name="barang" required>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4" for="title">Title</span>
            <input type="text" class="form-control" placeholder="Input judul dari pengaduan." aria-label="title" aria-describedby="title" id="title" name="title" required>
        </div>
        <div class="input-group py-1">
            <span class="input-group-text col-sm-4">Message</span>
            <textarea class="form-control" placeholder="Input detail permasalahan." id="message" name="message" required></textarea>
        </div>
        <div class="input-group py-1">
            <label class="input-group-text col-sm-4" for="inputGroupFile02">Foto Pengaduan </label>
            <input type="file" class="form-control" id="inputGroupFile02" name="file">
        </div>
    </form>
  `,
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: "Create Pengaduan",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const form = $('#siswaForm');
            if (!form[0].checkValidity()) {
                Swal.showValidationMessage('Please fill out all required fields correctly.');
                return false;
            }

            const formValues = form.serializeArray();
            const formData = new FormData();
            formValues.forEach(({ name, value }) => {
                formData.append(name, value);
            });

            const fileInput = document.querySelector('#inputGroupFile02');
            if (fileInput && fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]); // Menambahkan file ke FormData
            }
            return formData;
        }
    });

    if (formValue) {
        try {
            loadingPage()
            $.ajax({
                url: '/pengaduan/umum',
                method: 'POST',
                data: formValue,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    if (response.status === "Success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Siswa created successfully',
                        }).then(reloadTable());
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: response.message,
                            text: response.message,
                        }).then((result) => { if (result.isConfirmed) { addPengaduan() } });
                    }
                },
                error: (xhr, status, error) => {
                    var errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! ' + errorMessage,
                    }).then((result) => { if (result.isConfirmed) { addPengaduan() } });
                }
            })
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Request failed',
                text: 'Please try again later',
            });
        }
    }
}

// Tanggapan
tanggapi = async (pengaduan_id) => {
    let options = `<option selected>Choose...</option>`;
    let statusPengaduan = "";
    let bg = "";
    const status = {
        "pending": "Pending",
        "validasi": "Validasi",
        "error": "Error",
        "dalam_pengerjaan": "Dalam Pengerjaan",
        "sedang_diproses": "Sedang Diproses",
        "selesai": "Selesai"
    };

    const response = await $.ajax({
        url: `/pengaduan/umum/${pengaduan_id}`,
    });

    statusPengaduan = response.data[0].status_pengaduan;

    if (statusPengaduan === "Validasi") {
        delete status['pending'];
    } else if (statusPengaduan === "Dalam Pengerjaan" || statusPengaduan === "Sedang Diproses" || statusPengaduan === "Selesai") {
        defaultBg = "bg-info";
        delete status['pending'];
        delete status['validasi'];
        delete status['error'];
    }

    for (const [key, value] of Object.entries(status)) {
        if (value !== statusPengaduan) {
            let bgValue = "";
            switch (value) {
                case "Pending":
                    bgValue = "bg-warning";
                    break;
                case "Validasi":
                    bgValue = "bg-success";
                    break;
                case "Error":
                    bgValue = "bg-danger";
                    break;
                case "Dalam Pengerjaan":
                    bgValue = "bg-info";
                    break;
                case "Sedang Diproses":
                    bgValue = "bg-warning";
                    break;
                case "Selesai":
                    bgValue = "bg-success";
                    break;

                default:
                    bgValue = "bg-secondary"
                    break;
            }
            options += `<option value="${value}" data-bg="${bgValue}" class="${bgValue} rounded p-1">${value}</option>`;
        }
    }

    const { value: formValues } = await Swal.fire({
        title: "Tanggapi",
        html: `
        <form id="siswaForm">
            <div class="input-group py-1">
                <span class="input-group-text col-sm-4" for="name">Name</span>
                <input type="text" class="form-control" placeholder="Input nama name dengan benar." aria-label="name" aria-describedby="name" id="name" value="${response.data[0].title}" name="name" required>
            </div>
            <div class="input-group py-1">
                <span class="input-group-text col-sm-4" for="message">Message</span>
                <input type="text" focus class="form-control focus" placeholder="Input permasalahan singkat pengaduan." aria-label="message" aria-describedby="message" id="message" name="message" required>
            </div>
            <div class="input-group py-1">
                <label class="input-group-text col-sm-4" for="status_tanggapan">Status Pengaduan</label>
                <select class="form-select" onchange="selectBgStatus(this)" id="status_pengaduan" name="status">
                    ${options}
                </select>
            </div>
            <div class="input-group py-1">
                <label class="input-group-text col-sm-4" for="inputGroupFile02">Foto Tanggapan </label>
                <input type="file" class="form-control" id="inputGroupFile02" name="file">
            </div>
            <input type="hidden" name="pengaduan_id" value="${pengaduan_id}">
        </form>
        `,
        focusConfirm: false,
        preConfirm: () => {
            const form = $('#siswaForm');
            if (!form[0].checkValidity()) {
                Swal.showValidationMessage('Semua Input Wajib Diisi.');
                return false;
            }


            if ($('#status_pengaduan').val() == "Choose...") {
                Swal.showValidationMessage('Silahkan memberikan status pengaduan terbaru!');
                return false;
            }

            const formValues = form.serializeArray();
            const formData = new FormData();
            formValues.forEach(({ name, value }) => {
                formData.append(name, value);
            });

            const fileInput = document.querySelector('#inputGroupFile02');
            if (fileInput && fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);
            }
            return formData;
        }
    });

    if (formValues) {
        try {
            loadingPage()
            $.ajax({
                url: "/tanggapan",
                method: 'POST',
                data: formValues,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    if (response.status === "Success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Siswa created successfully',
                        }).then(reloadTable());
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: response.message,
                            text: response.message,
                        }).then((result) => { if (result.isConfirmed) { tanggapi(pengaduan_id) } });
                    }
                },
                error: (xhr, status, error) => {
                    var errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! ' + errorMessage,
                    }).then((result) => { if (result.isConfirmed) { tanggapi(pengaduan_id) } });
                }
            })
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Request failed',
                text: 'Please try again later',
            });
        }
    }
}

function selectBgStatus(select) {
    select.classList.remove('bg-warning', 'bg-info', 'bg-secondary', 'bg-success', 'bg-danger');

    const selectedOption = select.options[select.selectedIndex];
    const bgClass = selectedOption.getAttribute('data-bg');

    if (bgClass) {
        select.classList.add(bgClass);
    }
}