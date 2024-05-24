<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('#permission-location').on('click', function(){
            var el = $(this);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        const validLat = '-5.399239';
                        const validLong = '105.309080';
                        var distance = calculateDistance(latitude, longitude, validLat, validLong);

                        el.addClass('hidden');
                        $('#reader').removeClass('hidden');
                        presensi_siswa(distance);
                    },
                    function(error) {
                        toastr.error('Wajib Menghidupkan GPS!')
                    }
                );
            } else {
                alert('Gunakan Browser Lain atau Chrome!');
            }
        });
        function presensi_siswa(distance){
            Html5Qrcode.getCameras().then(devices => {
            /**
             * devices would be an array of objects of type:
             * { id: "id", label: "label" }
             */
                if (devices && devices.length) {
                    var cameraId = devices[0].id;
        
                    const token_masuk = "{{ $token['masuk'] }}";
                    const token_pulang = "{{ $token['pulang'] }}";
                    
                    const html5QrCode = new Html5Qrcode("reader");

                    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                        var id_siswa = "{{ auth()->user()->siswa->id_siswa }}";
                        if(token_masuk == decodedText){
                            requestSubmitPresensi(id_siswa, 1, distance);
                        }
                        if(token_pulang == decodedText){
                            requestSubmitPresensi(id_siswa, 2, distance);
                        }
                    };

                    function requestSubmitPresensi(id_siswa, id_token, distance){
                        let isScanner = false;
                        if(isScanner !== true){
                            isScanner = true;
                            $.ajax({
                                type: 'post',
                                url: "{{ route('siswa.submit.presensi') }}",
                                data: {
                                    _token : "{{ csrf_token() }}",
                                    nama : id_token,
                                    id_siswa : id_siswa,
                                    distance : distance
                                },
                                beforeSend: function(){
                                    $('.loader').show();
                                },
                                success: function(response){
                                    $('.loader').hide();
                                    if(response.type === 'success'){
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: response.msg,
                                            icon: 'success',
                                            timer: 5000,
                                            confirmButtonText: 'Tutup'
                                        });
                                    }
                                    if(response.type === 'error'){
                                        Swal.fire({
                                            title: 'Gagal',
                                            text: response.msg,
                                            icon: 'error',
                                            timer: 5000,
                                            confirmButtonText: 'Tutup'
                                        });
                                    }
                                    isScanner = false;
                                }
                            });
                        }
                    }
                    const config = { fps: 1, qrbox: { 
                        width: isMobile() ? 250 : 350, 
                        height: isMobile() ? 250 : 250
                    } };
        
                    function isMobile() {
                        const userAgent = window.navigator.userAgent.toLowerCase();
                        const mobileKeywords = ['iphone', 'android', 'windows phone', 'blackberry', 'mobile'];
        
                        return mobileKeywords.some(keyword => userAgent.includes(keyword));
                    }
                    
                    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
                }
            }).catch(err => {
                // handle err
            });
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius bumi dalam kilometer
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) *
                    Math.cos(lat2 * (Math.PI / 180)) *
                    Math.sin(dLon / 2) *
                    Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            return distance;
        }
    });

    
    function getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const { latitude, longitude } = position.coords;
                        resolve({ latitude, longitude });
                    },
                    error => {
                        reject(error);
                    }
                );
            } else {
                reject(new Error('Geolocation is not supported by this browser.'));
            }
        });
    }

    getCurrentLocation();
</script>