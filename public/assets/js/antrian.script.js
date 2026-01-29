document.addEventListener('DOMContentLoaded', function () {
    // Preload audio
    var tingtungAudio = new Audio('/audio/tingtung.mp3')

    // Fungsi untuk menambahkan spasi pada nomor antrian dengan mengganti 0 menjadi "kosong"
    function addSpacesToText(text) {
        if (!text) return '' // cegah error split undefined
        return text
            .split('')
            .map((char) => (char === '0' ? 'kosong' : char))
            .join(', ')
    }

    // Fungsi untuk memainkan suara antrian
    function playAudio(nomorAntrian, message) {
        tingtungAudio.onended = function () {
            var nomorAntrianWithSpaces = addSpacesToText(nomorAntrian)
            if (
                typeof responsiveVoice !== 'undefined' &&
                responsiveVoice.speak
            ) {
                responsiveVoice.speak(
                    'Nomor Antrian, ' + nomorAntrianWithSpaces + ', ' + message,
                    'Indonesian Female',
                    {
                        rate: 0.9,
                        pitch: 1,
                        volume: 10
                    }
                )
            } else {
                console.error(
                    'responsiveVoice tidak tersedia. Periksa apakah file responsivevoice.js dimuat dengan benar.'
                )
            }
        }
        tingtungAudio.play()
    }

    // Event listener untuk button panggil dokter
    document.querySelectorAll('.btn-panggil').forEach(function (button) {
        button.addEventListener('click', function () {
            var nomorAntrian = button.getAttribute('data-nomor-antrian')
            var poli = button.getAttribute('data-poli') // ambil poli dari tombol
            panggilAntrian(nomorAntrian, poli)
        })
    })

    function panggilAntrian(nomorAntrian, poli) {
        $.ajax({
            url: '/panggil-antrian',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nomor_antrian: nomorAntrian,
                poli: poli
            },
            success: function (response) {
                if (response.success) {
                    // Update tampilan nomor antrian sesuai poli
                    if (poli === 'umum') {
                        $('#nomorAntrianUmum').text(response.nomor)
                    } else if (poli === 'gigi') {
                        $('#nomorAntrianGigi').text(response.nomor)
                    }

                    playAudio(
                        response.nomor,
                        'Silahkan Masuk ke Ruang Poli ' + poli
                    )
                } else {
                    alert(response.message)
                }
            },
            error: function (error) {
                console.error('Gagal memanggil antrian:', error)
            }
        })
    }

    // Event listener untuk button panggil perawat
    // Tangkap klik pada seluruh document, lalu filter tombol target
    document.addEventListener('click', function (e) {
        const button = e.target.closest('.btn-panggil-perawat');
        if (!button) return; // kalau bukan tombol, abaikan

        const nomorAntrianPerawat = button.getAttribute('data-nomor-antrian-perawat');
        const poli = button.getAttribute('data-poli');
        panggilAntrianPerawat(nomorAntrianPerawat, poli);
    });

    function panggilAntrianPerawat(nomorAntrianPerawat, poli) {
        $.ajax({
            url: '/panggil-antrian-perawat',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nomor_antrian_perawat: nomorAntrianPerawat
            },
            success: function (responsePerawat) {
                $('#nomorAntrianPerawat').text(
                    responsePerawat.nomorAntrianPerawat
                )
                $('#perawat').html(responsePerawat.view)
                // playAudio(responsePerawat.nomorAntrianPerawat, "Silahkan Menuju Poli " + poli);
                playAudio(
                    responsePerawat.nomorAntrianPerawat,
                    'Silahkan Menuju Pendaftaran'
                )
            },
            error: function (error) {
                console.error('Gagal memuat tampilan antrian:', error)
            }
        })
    }

    // Event listener untuk button panggil obat
    document.querySelectorAll('.btn-panggil-obat').forEach(function (button) {
        button.addEventListener('click', function () {
            var nomorAntrianObat = button.getAttribute(
                'data-nomor-antrian-obat'
            )
            panggilAntrianObat(nomorAntrianObat)
        })
    })

    function panggilAntrianObat(nomorAntrianObat) {
        $.ajax({
            url: '/panggil-antrian-obat',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nomor_antrian_obat: nomorAntrianObat
            },
            success: function (responseObat) {
                $('#nomorAntrianObat').text(responseObat.nomorAntrianObat)
                $('#obat').html(responseObat.view)
                playAudio(
                    responseObat.nomorAntrianObat,
                    'Silahkan Menuju Ruang Farmasi'
                )
            },
            error: function (error) {
                console.error('Gagal memuat tampilan antrian:', error)
            }
        })
    }

    // Event listener untuk membuka detail row pada tabel
    document.querySelectorAll('.row-detail').forEach(function (row) {
        row.addEventListener('click', function () {
            var detailRow = this.nextElementSibling
            if (detailRow && detailRow.classList.contains('detail-row')) {
                detailRow.style.display =
                    detailRow.style.display === 'none' ||
                    detailRow.style.display === ''
                        ? 'table-row'
                        : 'none'
            }
        })
    })
})
