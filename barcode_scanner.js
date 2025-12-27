document.addEventListener('DOMContentLoaded', () => {
    // Buttons are handled in index.html to pass input IDs
    // But we keep the close button logic here
    const closeBtn = document.getElementById('closeCameraBtn');
    
    if(closeBtn) {
        closeBtn.addEventListener('click', stopScanner);
    }
});

let isScanning = false;

let activeInputId = 'heroSearchInput'; // Default

function startScanner(inputId) {
    if(inputId && typeof inputId === 'string') {
        activeInputId = inputId;
    }

    if(isScanning) return;
    
    const overlay = document.getElementById('cameraOverlay');
    overlay.style.display = 'flex';
    
    // Check for HTTPS or localhost
    if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        alert('Kamera erişimi için HTTPS veya Localhost gereklidir.');
        overlay.style.display = 'none';
        return;
    }

    Quagga.init({
        inputStream : {
            name : "Live",
            type : "LiveStream",
            target: document.querySelector('#interactive'),
            constraints: {
                width: { min: 640 },
                height: { min: 480 },
                facingMode: "environment",
                aspectRatio: { min: 1, max: 2 }
            }
        },
        locator: {
            patchSize: "medium",
            halfSample: true
        },
        numOfWorkers: 2,
        decoder : {
            readers : [
                "ean_reader", 
                "ean_8_reader", 
                "code_128_reader", 
                "code_39_reader", 
                "upc_reader"
            ]
        },
        locate: true
    }, function(err) {
        if (err) {
            console.error(err);
            alert("Kamera başlatılamadı. Lütfen izinleri kontrol edin.\nHata: " + err);
            overlay.style.display = 'none';
            return;
        }
        console.log("Barcode scanner initialized");
        Quagga.start();
        isScanning = true;
    });

    Quagga.onDetected(onBarcodeDetected);
}

function onBarcodeDetected(result) {
    const code = result.codeResult.code;
    
    // Simple validation: Ensure it's not a partial read or noise
    if(code && code.length >= 8) {
        stopScanner();
        
        console.log("Barcode detected:", code);
        
        // Fill input and search
        const input = document.getElementById(activeInputId);
        if(input) input.value = code;
        
        // Also sync the other input if it exists
        const otherInputId = activeInputId === 'heroSearchInput' ? 'navbarInput' : 'heroSearchInput';
        const otherInput = document.getElementById(otherInputId);
        if(otherInput) otherInput.value = code;
        
        if(typeof showProductPanel === 'function') {
            showProductPanel(code, 'barcode');
        } else {
            alert("Barkod: " + code);
        }
    }
}

function stopScanner() {
    if(!isScanning) return;
    
    try {
        Quagga.stop();
        Quagga.offDetected(onBarcodeDetected);
    } catch(e) {
        console.error("Error stopping scanner:", e);
    }
    
    isScanning = false;
    const overlay = document.getElementById('cameraOverlay');
    overlay.style.display = 'none';
}
