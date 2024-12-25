function showAddPhotoModal(kdKegiatan) {
    document.getElementById('photoKdKegiatan').value = kdKegiatan;
    var addPhotoModal = new bootstrap.Modal(document.getElementById('addPhotoModal'));
    addPhotoModal.show();
}

function confirmDeletePhoto(kdFoto) {
    Swal.fire({
        title: 'Hapus Foto?',
        text: "Foto akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/kelolaKegiatan/deletePhoto/${kdFoto}`;
        }
    });
}

function confirmDeleteKegiatan(kdKegiatan) {
    Swal.fire({
        title: 'Hapus Kegiatan?',
        text: "Semua data kegiatan termasuk foto akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/kelolaKegiatan/delete/${kdKegiatan}`;
        }
    });
}

// Validasi file upload
document.addEventListener('DOMContentLoaded', function() {
    const photosInput = document.getElementById('photos');
    if (photosInput) {
        photosInput.addEventListener('change', function(e) {
            const files = e.target.files;
            let totalSize = 0;
            let errors = [];

            if (files.length > 10) {
                errors.push('Maksimal 10 foto yang dapat diunggah sekaligus');
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                totalSize += file.size;

                if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                    errors.push(`File ${file.name} harus berformat JPG, JPEG, atau PNG`);
                }

                if (file.size > 5 * 1024 * 1024) {
                    errors.push(`File ${file.name} melebihi batas ukuran 5MB`);
                }
            }

            if (totalSize > 20 * 1024 * 1024) {
                errors.push('Total ukuran file melebihi 20MB');
            }

            if (errors.length > 0) {
                e.target.value = '';
                Swal.fire({
                    title: 'Error!',
                    html: errors.join('<br>'),
                    icon: 'error'
                });
            }
        });
    }
});