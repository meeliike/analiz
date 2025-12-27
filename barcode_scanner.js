/**
 * Barkod Tarayıcı Modülü
 * Web tabanlı barkod okuma ve ürün sorgulama
 */

class BarcodeScanner {
    constructor() {
        this.isScanning = false;
        this.stream = null;
        this.codeReader = null;
        this.init();
    }

    init() {
        // ZXing kütüphanesini yükle (CDN üzerinden)
        if (typeof ZXing === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/@zxing/library@latest';
            script.onload = () => this.setupScanner();
            document.head.appendChild(script);
        } else {
            this.setupScanner();
        }
    }

    setupScanner() {
        // ZXing MultiFormatReader kullan
        if (typeof ZXing !== 'undefined') {
            this.codeReader = new ZXing.BrowserMultiFormatReader();
        }
    }

    /**
     * Kamera ile barkod tara
     */
    async startScanning(videoElement, onSuccess, onError) {
        if (this.isScanning) {
            this.stopScanning();
        }

        try {
            // Kamera erişimi
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            
            if (videoDevices.length === 0) {
                throw new Error('Kamera bulunamadı');
            }

            // Arka kamera tercih et (mobil cihazlar için)
            const backCamera = videoDevices.find(device => 
                device.label.toLowerCase().includes('back') || 
                device.label.toLowerCase().includes('rear')
            );
            const selectedDevice = backCamera || videoDevices[0];

            // ZXing ile tarama
            if (this.codeReader && typeof ZXing !== 'undefined') {
                this.codeReader.decodeFromVideoDevice(
                    selectedDevice.deviceId,
                    videoElement,
                    (result, error) => {
                        if (result) {
                            const barcode = result.getText();
                            this.stopScanning();
                            if (onSuccess) onSuccess(barcode);
                        }
                        if (error && error.name !== 'NotFoundException') {
                            console.error('Barkod okuma hatası:', error);
                        }
                    }
                );
            } else {
                // Fallback: Basit kamera akışı
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        deviceId: selectedDevice.deviceId
                    }
                });
                videoElement.srcObject = this.stream;
                
                // Manuel barkod okuma için input alanına odaklan
                const input = document.getElementById('barcodeInput');
                if (input) {
                    input.focus();
                    input.select();
                }
            }

            this.isScanning = true;
        } catch (error) {
            console.error('Kamera hatası:', error);
            if (onError) onError(error);
        }
    }

    /**
     * Taramayı durdur
     */
    stopScanning() {
        if (this.codeReader && typeof ZXing !== 'undefined') {
            this.codeReader.reset();
        }
        
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        
        this.isScanning = false;
    }

    /**
     * Ürünü veritabanında ara
     */
    async searchProduct(barcode) {
        if (!barcode || barcode.trim() === '') {
            return { hata: 'Barkod boş olamaz' };
        }

        try {
            const response = await fetch(`product.php?barcode=${encodeURIComponent(barcode.trim())}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Ürün arama hatası:', error);
            return { hata: 'Ürün aranırken hata oluştu: ' + error.message };
        }
    }

    /**
     * Ürün kayıt isteği gönder
     */
    async requestProductRegistration(barcode, productName = '', note = '') {
        try {
            const response = await fetch('request_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    barcode: barcode,
                    product_name: productName,
                    note: note
                })
            });
            
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Kayıt isteği hatası:', error);
            return {
                basari: false,
                mesaj: 'İstek gönderilirken hata oluştu: ' + error.message
            };
        }
    }
}

// Global instance
window.barcodeScanner = new BarcodeScanner();

/**
 * Barkod tarama ve ürün sorgulama fonksiyonu
 */
async function scanAndSearchProduct(barcode) {
    if (!barcode || barcode.trim() === '') {
        alert('Lütfen geçerli bir barkod girin');
        return;
    }

    // Loading göster
    const productDetailCard = document.getElementById('productDetailCard');
    productDetailCard.classList.remove('active');
    
    // Ürünü ara
    const result = await window.barcodeScanner.searchProduct(barcode);
    
    if (result.hata) {
        // Ürün bulunamadı - kayıt isteği göster
        showProductNotFound(barcode, result.hata);
    } else {
        // Ürün bulundu - detayları göster
        displayProductDetail(result);
    }
}

/**
 * Ürün bulunamadığında gösterilecek ekran
 */
function showProductNotFound(barcode, errorMessage) {
    const productDetailCard = document.getElementById('productDetailCard');
    const cardBody = productDetailCard.querySelector('.card-body');
    
    productDetailCard.querySelector('.card-header h4').textContent = 'Ürün Bulunamadı';
    
    cardBody.innerHTML = `
        <div class="text-center p-4">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
            <h5>Bu ürün veritabanında kayıtlı değil</h5>
            <p class="text-muted">Barkod: <strong>${escapeHtml(barcode)}</strong></p>
            <p class="text-muted mb-4">${escapeHtml(errorMessage)}</p>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Bu ürünü veritabanına eklemek için aşağıdaki butona tıklayın.
            </div>
            
            <button class="btn btn-primary btn-lg mt-3" id="requestProductBtn" onclick="requestProductRegistration('${escapeHtml(barcode)}')">
                <i class="bi bi-plus-circle"></i> Ürün Kayıt İsteği Gönder
            </button>
            
            <button class="btn btn-secondary btn-lg mt-3 ms-2" onclick="document.getElementById('productDetailCard').classList.remove('active')">
                <i class="bi bi-x-circle"></i> Kapat
            </button>
        </div>
    `;
    
    productDetailCard.classList.add('active');
    productDetailCard.scrollIntoView({ behavior: 'smooth' });
}

/**
 * Ürün kayıt isteği gönder
 */
async function requestProductRegistration(barcode) {
    const btn = document.getElementById('requestProductBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Gönderiliyor...';
    
    try {
        const result = await window.barcodeScanner.requestProductRegistration(barcode);
        
        if (result.basari) {
            btn.innerHTML = '<i class="bi bi-check-circle"></i> İstek Gönderildi!';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                document.getElementById('productDetailCard').classList.remove('active');
            }, 2000);
        } else {
            alert('Hata: ' + (result.mesaj || 'İstek gönderilemedi'));
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (error) {
        alert('Hata: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

// XSS koruması
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

