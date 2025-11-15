@extends('depan.layouts.main')
@section('content')
<section class="hero" style="padding: 120px 0 60px;">
        <div class="hero-content">
            <h1 data-splitting>Kontak & Bantuan</h1>
            <p style="font-size: 1.2rem; color: var(--white-blue); margin-top: 20px;">
                Hubungi kami untuk informasi dan bantuan seputar SPMB BAKNUS 666
            </p>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="section">
        <div class="section-divider"></div>
        <div class="container">
            <h2 class="section-title fade-in">Informasi Kontak</h2>
            <div class="card-grid">
                <div class="card fade-in" style="text-align: center;">
                    <i class="fas fa-phone" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 20px;"></i>
                    <h3>Telepon</h3>
                    <p style="color: var(--text-light); margin-bottom: 15px;">
                        Hubungi kami untuk informasi dan konsultasi
                    </p>
                    <div style="background: var(--light-blue); padding: 15px; border-radius: 10px;">
                        <strong style="color: var(--primary-blue); font-size: 1.2rem;">(021) 1234-5678</strong><br>
                        <small style="color: var(--text-light);">Senin - Jumat, 08.00 - 16.00 WIB</small>
                    </div>
                </div>

                <div class="card fade-in" style="text-align: center;">
                    <i class="fab fa-whatsapp" style="font-size: 3rem; color: #25d366; margin-bottom: 20px;"></i>
                    <h3>WhatsApp</h3>
                    <p style="color: var(--text-light); margin-bottom: 15px;">
                        Chat cepat untuk pertanyaan seputar SPMB
                    </p>
                    <div style="background: var(--light-blue); padding: 15px; border-radius: 10px;">
                        <strong style="color: #25d366; font-size: 1.2rem;">+62 812-3456-7890</strong><br>
                        <small style="color: var(--text-light);">24/7 Online Response</small>
                    </div>
                    <button onclick="openWhatsApp()" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fab fa-whatsapp"></i> Chat Sekarang
                    </button>
                </div>

                <div class="card fade-in" style="text-align: center;">
                    <i class="fas fa-envelope" style="font-size: 3rem; color: var(--accent-blue); margin-bottom: 20px;"></i>
                    <h3>Email</h3>
                    <p style="color: var(--text-light); margin-bottom: 15px;">
                        Kirim email untuk dokumen dan informasi resmi
                    </p>
                    <div style="background: var(--light-blue); padding: 15px; border-radius: 10px;">
                        <strong style="color: var(--accent-blue); font-size: 1.1rem;">SPMB@baknus666.ac.id</strong><br>
                        <small style="color: var(--text-light);">Response dalam 1x24 jam</small>
                    </div>
                    <button onclick="sendEmail()" class="btn btn-secondary" style="margin-top: 15px;">
                        <i class="fas fa-envelope"></i> Kirim Email
                    </button>
                </div>

                <div class="card fade-in" style="text-align: center;">
                    <i class="fas fa-map-marker-alt" style="font-size: 3rem; color: #dc2626; margin-bottom: 20px;"></i>
                    <h3>Alamat Sekolah</h3>
                    <p style="color: var(--text-light); margin-bottom: 15px;">
                        Kunjungi kampus kami untuk informasi langsung
                    </p>
                    <div style="background: var(--light-blue); padding: 15px; border-radius: 10px;">
                        <strong style="color: #dc2626;">Jl. Pendidikan No. 123</strong><br>
                        <span style="color: var(--text-dark);">Kelurahan Cerdas, Kecamatan Pintar</span><br>
                        <span style="color: var(--text-dark);">Kota Mandiri, Provinsi Cerdas</span><br>
                        <small style="color: var(--text-light);">Kode Pos: 12345</small>
                    </div>
                    <button onclick="openMaps()" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-map"></i> Lihat Peta
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in">Media Sosial</h2>
            <div class="card fade-in" style="max-width: 800px; margin: 0 auto; text-align: center;">
                <p style="color: var(--text-light); margin-bottom: 30px;">
                    Ikuti kami di media sosial untuk update terbaru seputar SPMB dan kegiatan sekolah
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <a href="#" style="text-decoration: none; color: inherit;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; transition: all 0.3s ease;">
                            <i class="fab fa-facebook" style="font-size: 2.5rem; color: #1877f2; margin-bottom: 15px;"></i>
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">Facebook</h4>
                            <p style="color: var(--text-light); font-size: 0.9rem;">@smkbaktinusantara666</p>
                            <small style="color: var(--text-light);">45K Followers</small>
                        </div>
                    </a>
                    
                    <a href="#" style="text-decoration: none; color: inherit;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; transition: all 0.3s ease;">
                            <i class="fab fa-instagram" style="font-size: 2.5rem; color: #e4405f; margin-bottom: 15px;"></i>
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">Instagram</h4>
                            <p style="color: var(--text-light); font-size: 0.9rem;">@smkbaktinusantara666</p>
                            <small style="color: var(--text-light);">32K Followers</small>
                        </div>
                    </a>
                    
                    <a href="#" style="text-decoration: none; color: inherit;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; transition: all 0.3s ease;">
                            <i class="fab fa-youtube" style="font-size: 2.5rem; color: #ff0000; margin-bottom: 15px;"></i>
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">YouTube</h4>
                            <p style="color: var(--text-light); font-size: 0.9rem;">BAKNUS 666 Channel</p>
                            <small style="color: var(--text-light);">18K Subscribers</small>
                        </div>
                    </a>
                    
                    <a href="#" style="text-decoration: none; color: inherit;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="background: var(--light-blue); padding: 25px; border-radius: 15px; transition: all 0.3s ease;">
                            <i class="fab fa-tiktok" style="font-size: 2.5rem; color: #000000; margin-bottom: 15px;"></i>
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">TikTok</h4>
                            <p style="color: var(--text-light); font-size: 0.9rem;">@smkbaktinusantara666</p>
                            <small style="color: var(--text-light);">25K Followers</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Quick Links -->
    <section class="section" style="background: var(--light-blue);">
        <div class="container">
            <h2 class="section-title fade-in">Pertanyaan Umum</h2>
            <div class="card fade-in" style="max-width: 800px; margin: 0 auto;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                    <a href="/faq" style="text-decoration: none; color: inherit;">
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid var(--primary-blue); transition: all 0.3s ease;">
                            <h5 style="color: var(--primary-blue); margin-bottom: 10px;">Bagaimana cara mendaftar?</h5>
                            <p style="color: var(--text-light); font-size: 0.9rem;">Panduan lengkap pendaftaran online</p>
                        </div>
                    </a>
                    
                    <a href="/faq" style="text-decoration: none; color: inherit;">
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid var(--accent-blue); transition: all 0.3s ease;">
                            <h5 style="color: var(--accent-blue); margin-bottom: 10px;">Apakah bisa daftar offline?</h5>
                            <p style="color: var(--text-light); font-size: 0.9rem;">Informasi pendaftaran langsung</p>
                        </div>
                    </a>
                    
                    <a href="/faq" style="text-decoration: none; color: inherit;">
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #059669; transition: all 0.3s ease;">
                            <h5 style="color: #059669; margin-bottom: 10px;">Berapa biaya pendaftaran?</h5>
                            <p style="color: var(--text-light); font-size: 0.9rem;">Informasi biaya dan pembayaran</p>
                        </div>
                    </a>
                    
                    <a href="/faq" style="text-decoration: none; color: inherit;">
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #dc2626; transition: all 0.3s ease;">
                            <h5 style="color: #dc2626; margin-bottom: 10px;">Lupa nomor pendaftaran?</h5>
                            <p style="color: var(--text-light); font-size: 0.9rem;">Cara mengambil nomor pendaftaran</p>
                        </div>
                    </a>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{route('faq')}}" class="btn btn-primary">
                        <i class="fas fa-question-circle"></i> Lihat Semua FAQ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in">Formulir Pertanyaan</h2>
            <div class="card fade-in" style="max-width: 700px; margin: 0 auto;">
                <form onsubmit="submitQuestion(event)">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="contactName">Nama Lengkap *</label>
                            <input type="text" id="contactName" name="contactName" required>
                        </div>
                        <div class="form-group">
                            <label for="contactEmail">Email *</label>
                            <input type="email" id="contactEmail" name="contactEmail" required>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="contactPhone">Nomor Telepon</label>
                            <input type="tel" id="contactPhone" name="contactPhone">
                        </div>
                        <div class="form-group">
                            <label for="contactSubject">Subjek *</label>
                            <select id="contactSubject" name="contactSubject" required>
                                <option value="">Pilih Subjek</option>
                                <option value="pendaftaran">Pendaftaran</option>
                                <option value="jadwal">Jadwal SPMB</option>
                                <option value="syarat">Syarat Pendaftaran</option>
                                <option value="biaya">Biaya Pendidikan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="contactMessage">Pertanyaan/Keluhan *</label>
                        <textarea id="contactMessage" name="contactMessage" rows="5" required placeholder="Tuliskan pertanyaan atau keluhan Anda di sini..."></textarea>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;">
                            <i class="fas fa-paper-plane"></i> Kirim Pertanyaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializeScrollEffects();
            initializeMap();
            
            // Animate section title
            if (document.querySelector('[data-splitting]')) {
                Splitting();
                
                anime({
                    targets: '[data-splitting] .char',
                    translateY: [100, 0],
                    opacity: [0, 1],
                    easing: 'easeOutExpo',
                    duration: 1400,
                    delay: (el, i) => 30 * i
                });
            }
        });
        
        // Initialize map
        function initializeMap() {
            // Initialize map (Jakarta coordinates as example)
            const map = L.map('map').setView([-6.2088, 106.8456], 15);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add marker for school
            const schoolMarker = L.marker([-6.2088, 106.8456]).addTo(map);
            schoolMarker.bindPopup(`
                <div style="text-align: center; padding: 10px;">
                    <h4 style="color: var(--primary-blue); margin-bottom: 10px;">BAKNUS 666</h4>
                    <p style="margin: 0; color: var(--text-dark);">Jl. Pendidikan No. 123</p>
                    <p style="margin: 0; color: var(--text-dark);">Kota Mandiri</p>
                </div>
            `);
            
            // Add circle to show area
            L.circle([-6.2088, 106.8456], {
                color: 'var(--primary-blue)',
                fillColor: 'var(--primary-blue)',
                fillOpacity: 0.1,
                radius: 500
            }).addTo(map);
        }
        
        // Send email function
        function sendEmail() {
            const subject = encodeURIComponent('Tanya Jawab SPMB BAKNUS 666 2025/2026');
            const body = encodeURIComponent('Halo Tim SPMB BAKNUS 666,\n\nSaya ingin menanyakan tentang:\n\n[Silakan isi pertanyaan Anda di sini]\n\nTerima kasih.\n\nHormat saya,');
            window.open(`mailto:SPMB@baknus666.ac.id?subject=${subject}&body=${body}`);
        }
        
        // Open maps function
        function openMaps() {
            const address = 'Jl. Pendidikan No. 123, Kota Mandiri';
            const encodedAddress = encodeURIComponent(address);
            window.open(`https://www.google.com/maps/search/?api=1&query=${encodedAddress}`, '_blank');
        }
        
        // Submit question function
        function submitQuestion(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);
            
            // Validate form
            if (!data.contactName || !data.contactEmail || !data.contactSubject || !data.contactMessage) {
                showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
                return;
            }
            
            // Simulate form submission
            const submitButton = event.target.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="loading"></span> Mengirim...';
            submitButton.disabled = true;
            
            setTimeout(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
                
                // Show success message
                showNotification('Pertanyaan Anda telah terkirim! Kami akan segera merespons.', 'success');
                
                // Reset form
                event.target.reset();
            }, 2000);
        }
        
        // Export functions for global use
        window.sendEmail = sendEmail;
        window.openMaps = openMaps;
        window.submitQuestion = submitQuestion;
    </script>
@endsection