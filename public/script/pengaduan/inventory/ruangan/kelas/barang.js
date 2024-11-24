function resetTable() {
    var table = $('#inventoryruangkelasbarang-table').DataTable();
    table.search('').columns().search('').draw();
}

function reloadTable() {
    var table = $('#inventoryruangkelasbarang-table').DataTable();
    table.ajax.reload();
}

const newinventoryKelas = async () => {
    let setKondisi = window.setKondisi;
    let optionsKondisi = `<option selected>Choose....</option>`;
    let optionsBarang = `<option selected>Choose....</option>`;
    for (const [key, value] of Object.entries(setKondisi)) {
        optionsKondisi += `<option value="${value}" rounded p-1">${value}</option>`;
    }

    // let inputKondisi = ``;
    // let optionsBarang = `<option selected>Choose....</option>`;
    // for (const [key, value] of Object.entries(setKondisi)) {
    //     inputKondisi += `
    //         <div id="kondisiUpdate" class="mb-3 col-md-3">
    //             <label for="amount" class="form-label">Jumlah ${value}</label>
    //             <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah untuk ${value}" required>
    //             <div class="valid-feedback">
    //                 Looks good!
    //             </div>
    //             <div class="invalid-feedback">
    //                 Please choose a username.
    //             </div>
    //         </div>
    //     `;
        
    // }

    const response = await $.ajax({
        url: `/inventory/barangrk/create`,
    });

    for (const [key, value] of Object.entries(response.data)) {
        optionsBarang += `<option value="${value.id}" rounded p-1">${value.nama_barang}</option>`;
    }

    const { value: formValues } = await Swal.fire({
        title: "<strong>Insert Kondisi Barang Kelas</strong>",
        icon: false,
        html: `
            <form id="createNewBarangRK" class="row g-3 needs-validation" novalidate>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <select class="form-select" name="nama_barang" required>
                        <optgroup label="Nama Barang">
                            ${optionsBarang}
                        </optgroup>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-select" aria-label="Default select example" name="kondisi" onchange="selectKondisi(this)" required>
                        <optgroup label="Kondisi Barang">
                            ${optionsKondisi}
                        </optgroup>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan kode barang yang tertera." required>
                    <small>Jika kode barang belum tertera maka isi dengan (-)</small>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
                <div id="kondisiUpdate" class="mb-3 col-md-6"></div>
                <div class="mb-3 col-md-12">
                    <label for="foto" class="form-label">Foto Dokumentasi</label>
                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*" capture="camera" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>
        </form>
      `,
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: "Insert",
        showLoaderOnConfirm: true,
        width: 800,
        position: 'center',
        preConfirm: () => {
            const form = document.getElementById('createNewBarangRK');

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                Swal.showValidationMessage('Please fill out the form correctly');
                return false;
            }

            const formValues = $(form).serializeArray();
            const formData = new FormData();

            formValues.forEach(({ name, value }) => {
                formData.append(name, value);
            });

            const fileInput = document.getElementById('foto');
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
                url: "/inventory/barangrk",
                method: 'POST',
                data: formValues,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    console.log(response)
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                        }).then(reloadTable());
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: response.title,
                            text: response.message,
                        }).then((result) => { if (result.isConfirmed) { newinventoryKelas() } });
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
                        text: 'Something went wrong! ',
                    }).then((result) => { if (result.isConfirmed) { newinventoryKelas() } });
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

function selectKondisi(select) {
    const kondisiUpdateElement = document.getElementById('kondisiUpdate');
    const selectedText = select.options[select.selectedIndex].text;
    kondisiUpdateElement.innerHTML = `
                <label for="amount" class="form-label">Jumlah ${selectedText}</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah untuk ${selectedText}" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
        `;
}

const tanggapi = async (inventory_id) => {
    let options = `<option selected>Choose...</option>`;
    let statusInventory = "";
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
        url: `/inventory/barangrk/${inventory_id}`,
    });

    statusInventory = response.data.status;

    if (statusInventory === "Validasi") {
        delete status['pending'];
    } else if (statusInventory === "Dalam Pengerjaan" || statusInventory === "Sedang Diproses" || statusInventory === "Selesai") {
        defaultBg = "bg-info";
        delete status['pending'];
        delete status['validasi'];
        delete status['error'];
    }

    for (const [key, value] of Object.entries(status)) {
        if (value !== statusInventory) {
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
                <input type="text" class="form-control" placeholder="Input nama dengan benar." aria-label="name" aria-describedby="name" id="name" value="${response.data.barang.nama_barang}" name="name" required>
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
                <input type="file" class="form-control" id="inputGroupFile02" accept="image/*" capture="camera" required name="file">
            </div>
            <input type="hidden" name="inventory_id" value="${inventory_id}">
            <input type="hidden" name="key" value="${response.data.tanggapan.key}">
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
                url: "/inventory/barangrk/tanggapi",
                method: 'POST',
                data: formValues,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (response) => {
                    if (response.status == "Success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Siswa created successfully',
                        }).then(reloadTable());
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: response.message,
                            text: response.message,
                        }).then((result) => { if (result.isConfirmed) { tanggapi(inventory_id) } });
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
                    }).then((result) => { if (result.isConfirmed) { tanggapi(inventory_id) } });
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