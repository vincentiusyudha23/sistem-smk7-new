<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
    let scanner = new Instascan.Scanner({ 
    video: document.getElementById('scanner'),
    mirror: true, 
    });
    scanner.addListener('scan', function (content) {
    const token_masuk = "{{ $token['masuk'] }}"
    const token_pulang = "{{ $token['pulang'] }}"
    console.log(content);
    if(content === token_masuk ){
        document.getElementById('form-masuk').submit();
        $(document).ready(function(){
        $('.loader').show();
        });
    }
    if(content === token_pulang){
        document.getElementById('form-pulang').submit();
        $(document).ready(function(){
        $('.loader').show();
        });
    }
    });
    Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else {
        console.error('No cameras found.');
    }
    }).catch(function (e) {
    console.error(e);
    });
</script>