function resetTable() {
    var table = $('#barang-table').DataTable();
    table.search('').columns().search('').draw();
}

function reloadTable() {
    var table = $('#barang-table').DataTable();
    table.ajax.reload();
}

//Import Data Barang
const importDataBarang = async () => {
    const { value: file } = await Swal.fire({
        title: "Upload Data Barang",
        html: `Silahkan download template dengan <a href='/admin/download/template/import/barang'> Klik Disini</a>`,
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
                url: '/admin/import/barang',
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
                    let failedItemsMessage = '';
                    let icon = '';
                    let title = '';
                    if (response.failed_count > 0) {
                        failedItemsMessage = `<br>Nama Barang yang gagal di upload: <span class="text-danger">${response.failedItemsString}</span>`;
                    }
                    if (response.failed_count > 0 && response.success_count > 0) {
                        icon = 'info';
                        title = 'Data tidak Semua ter-Upload.'
                    } else if (response.failed_count == 0 && response.success_count == 0) {
                        title = 'Tidak ada data yang perlu di update.'
                        icon = 'info';
                    } else {
                        title = 'Import data successfully.'
                        icon = 'success';
                    }

                    Swal.fire({
                        title: title,
                        icon: icon,
                        html: `<p>Data barang sukses diupload: <span class="text-success">${response.success_count}</span>
                        <br>Data barang gagal diupload: <span class="text-danger">${response.failed_count}</span>
                        ${failedItemsMessage}</p>`
                    });
                },
                error: (xhr, status, error) => {
                    console.log(xhr.responseJSON.data)
                    Swal.fire("Error", `There was an error importing the data, Periksan file yang mau di upload.`, "error");
                }
            });
        } catch (error) {
            swal.fire("Error", error.message, "error");
        }
    } else {
        Swal.fire({
            title: 'File Un-Uploaded!',
            icon: 'info',
            text: 'Select file yang mau di upload.',
            showConfirmButton: true,
            showCloseButton: false,
            confirmButtonText: 'OK'
        }).then((result) => { if (result.isConfirmed) { importDataBarang() } })
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

const showInventoryBarang = async (id, page = 1, selectedCategory = "") => {
    await $.ajax({
        url: `/admin/barang/inventory/${id}?page=${page}&orderby=${selectedCategory}`,
        success: function (response) {
            let tableRows = response.data.map(row => `
                <tr>
                    <td>${row.barang.nama_barang}</td>
                    <td>${row.kode_barang}</td>
                    <td>${row.barang.category.name}</td>
                    <td>${row.barang.pengadaan}</td>
                    <td>${row.barang.sumber_dana}</td>
                    <td>${row.kondisi}</td>
                </tr>
            `).join('');

            let paginationLinks = response.links.map(link => {
                if (link.url) {
                    return `
                        <li class="page-item ${link.active ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="showInventoryBarang(${id}, ${new URL(link.url).searchParams.get('page')}, '${selectedCategory}')">
                                ${link.label}
                            </a>
                        </li>
                    `;
                } else {
                    return `
                        <li class="page-item disabled">
                            <span class="page-link">${link.label}</span>
                        </li>
                    `;
                }
            }).join('');

            let uniqueCategories = [...new Set(response.data.map(data => data.barang.category.name))];

            let category = uniqueCategories.map(categoryName => {
                return `<option value="${categoryName}">${categoryName}</option>`;
            });


            let uniqueKondisi = [...new Set(response.data.map(data => data.kondisi))];

            let kondisi = uniqueKondisi.map(kondisiName => {
                return `<option value="${kondisiName}">${kondisiName}</option>`;
            });

            let uniqueSumberDana = [...new Set(response.data.map(data => data.barang.sumber_dana))];

            let sumberDana = uniqueSumberDana.map(kondisiName => {
                return `<option value="${kondisiName}">${kondisiName}</option>`;
            });

            let uniquePengadaan = [...new Set(response.data.map(data => data.barang.pengadaan))];

            let pengadaan = uniquePengadaan.map(kondisiName => {
                return `<option value="${kondisiName}">${kondisiName}</option>`;
            });

            let combinedOptions = `
                <optgroup label="Kategori">
                    ${category.join('')}
                </optgroup>
                <optgroup label="Kondisi">
                    ${kondisi.join('')}
                </optgroup>
                <optgroup label="Sumber Dana">
                    ${sumberDana.join('')}
                </optgroup>
                <optgroup label="Pengadaan">
                    ${pengadaan.join('')}
                </optgroup>
            `;

            if ($('.swal2-container').length) {
                $('#inventoryTableBody').html(tableRows);
                $('#paginationButtons').html(`<ul class="pagination">${paginationLinks}</ul>`);
            } else {
                Swal.fire({
                    title: `Detail Barang dari ${response.data[0].barang.nama_barang}`,
                    icon: false,
                    width: 900,
                    html: `
                    <table class="table table-bordered border-primary">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputSelectCategory">Options</label>
                            <select class="form-select" id="inputSelectCategory" onchange="showInventoryBarang(${id}, 1, this.value)">
                                <option selected value="">Choose...</option>
                                ${combinedOptions}
                            </select>
                        </div>
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kode Barang</th>
                                <th>Jenis Barang</th>
                                <th>TGL Pengadaan</th>
                                <th>Sumber Dana</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            ${tableRows}
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="paginationButtons">
                            ${paginationLinks}
                        </ul>
                    </nav>
                `,
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: "OK",
                });
            }
        }
    });
}
