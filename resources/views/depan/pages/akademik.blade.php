@extends('depan.layouts.main')
@section('content')
<!-- Hero Section -->
<section class="hero" style="padding: 120px 0 60px;">
    <div class="hero-content">
        <h1 data-splitting>Profil Sekolah</h1>
        <p style="font-size: 1.2rem; color: var(--white-blue); margin-top: 20px;">
            Program pembelajaran berkualitas untuk membentuk generasi unggul dan berprestasi
        </p>
    </div>
</section>

<!-- Identitas Sekolah Section -->
<section class="py-20 bg-white relative px-4 sm:px-6 lg:px-8" id="identitas">
    <div class="section-divider"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title fade-in">Identitas Sekolah</h2>
        <p style="text-align: center; color: var(--text-light); max-width: 800px; margin: 0 auto 50px; font-size: 1.1rem;">
            Program pembelajaran yang komprehensif dan berstandar internasional untuk mempersiapkan siswa menghadapi tantangan global
        </p>

        <!-- Cards di Tengah -->
        <div class="max-w-4xl mx-auto">
            <div class="scroll-reveal space-y-8 fade-in">
                <!-- Data Umum Sekolah -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-3xl border-l-6 border-blue-600 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                        <i class="fas fa-school mr-4 text-blue-600 text-3xl"></i>
                        Data Umum Sekolah
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <p class="text-gray-600 text-sm">Nama Sekolah</p>
                            <p class="font-bold text-blue-900 text-lg">SMK BAKTI NUSANTARA 666</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <p class="text-gray-600 text-sm">NPSN</p>
                            <p class="font-bold text-blue-900 text-lg">20123456</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <p class="text-gray-600 text-sm">Status</p>
                            <p class="font-bold text-blue-900 text-lg">Swasta</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <p class="text-gray-600 text-sm">Tahun Berdiri</p>
                            <p class="font-bold text-blue-900 text-lg">2007</p>
                        </div>
                    </div>
                </div>

                <!-- Alamat & Kontak -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-3xl border-l-6 border-blue-600 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt mr-4 text-blue-600 text-3xl"></i>
                        Alamat &amp; Kontak
                    </h3>
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-md flex items-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-map text-blue-600 mr-3 text-xl"></i>
                            <div>
                                <p class="font-semibold text-blue-900">Jl. Raya Cileunyi No. 45, Bandung</p>
                                <p class="text-gray-600 text-sm">Bandung</p>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-md flex items-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-phone text-blue-600 mr-3 text-xl"></i>
                            <div>
                                <p class="font-semibold text-blue-900"> 0812-3456-6666</p>
                                <p class="text-gray-600 text-sm">Telepon Sekolah</p>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-md flex items-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-envelope text-blue-600 mr-3 text-xl"></i>
                            <div>
                                <p class="font-semibold text-blue-900">info@smkbn666.sch.id</p>
                                <p class="text-gray-600 text-sm">Email Resmi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kepala Sekolah -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-3xl border-l-6 border-blue-600 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                        <i class="fas fa-user-tie mr-4 text-blue-600 text-3xl"></i>
                        Kepala Sekolah
                    </h3>
                    <div class="flex items-center space-x-6 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center feature-icon">
                            <i class="fas fa-user text-white text-3xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-blue-900 text-xl">Deni Danis Suara, ST., M.Kom</p>
                            <p class="text-gray-600">Kepala Sekolah</p>
                            <p class="text-blue-600 text-sm">Guru Besar Bidang Pendidikan</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="text-3xl font-bold text-blue-600 mb-1">17+</div>
                        <div class="text-sm text-gray-600">Tahun</div>
                        <div class="text-xs text-gray-500">Berdiri</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="text-3xl font-bold text-blue-600 mb-1">1500+</div>
                        <div class="text-sm text-gray-600">Siswa</div>
                        <div class="text-xs text-gray-500">Aktif</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="text-3xl font-bold text-blue-600 mb-1">A</div>
                        <div class="text-sm text-gray-600">Akreditasi</div>
                        <div class="text-xs text-gray-500">Unggul</div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    
    <!-- Program Unggulan Section -->
    <section class="section" id="akademik" style="background: linear-gradient(135deg, var(--white-blue) 0%, var(--light-blue) 100%);">
        <div class="container">
            <h2 class="section-title fade-in">Program Unggulan</h2>
            <p style="text-align: center; color: var(--text-light); max-width: 800px; margin: 0 auto 50px; font-size: 1.1rem;">
                Program pembelajaran yang komprehensif dan berstandar internasional untuk mempersiapkan siswa menghadapi tantangan global
            </p>

            <div class="card-grid">
                <!-- Rekayasa Perangkat Lunak -->
                <div class="card fade-in">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-laptop-code" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <span style="display: inline-block; background: var(--light-blue); color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Teknologi</span>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px; text-align: center;">Rekayasa Perangkat Lunak</h3>
                    <p style="color: var(--text-light); margin-bottom: 25px; text-align: center; line-height: 1.7;">Program pengembangan software dengan kurikulum terkini dan pelatihan berbasis proyek untuk siap kerja di industri IT</p>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-code" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Pemrograman</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Web, Mobile, Desktop</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-database" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Basis Data</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">SQL & NoSQL Database</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-cloud" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Cloud Computing</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">AWS, Azure, Google Cloud</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Akuntansi -->
                <div class="card fade-in">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-calculator" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <span style="display: inline-block; background: var(--light-blue); color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Bisnis</span>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px; text-align: center;">Akuntansi</h3>
                    <p style="color: var(--text-light); margin-bottom: 25px; text-align: center; line-height: 1.7;">Program akuntansi komprehensif dengan fokus pada praktik bisnis modern dan penggunaan software akuntansi terkini</p>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-chart-bar" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Akuntansi Keuangan</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Laporan & Analisis</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-file-invoice-dollar" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Perpajakan</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Pajak Perusahaan & Individu</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-cash-register" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Software Akuntansi</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">MYOB, Accurate, Zahir</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Animasi -->
                <div class="card fade-in">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-film" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <span style="display: inline-block; background: var(--light-blue); color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Kreatif</span>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px; text-align: center;">Animasi</h3>
                    <p style="color: var(--text-light); margin-bottom: 25px; text-align: center; line-height: 1.7;">Program animasi 2D dan 3D dengan studio lengkap dan pengajar dari industri kreatif untuk siap berkarir di dunia animasi</p>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-video" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Animasi 2D & 3D</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Character & Environment</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-magic" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Visual Effects</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Compositing & Motion Graphics</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-theater-masks" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Studio Produksi</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Peralatan Profesional</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DKV -->
                <div class="card fade-in">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-palette" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <span style="display: inline-block; background: var(--light-blue); color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Desain</span>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px; text-align: center;">Desain Komunikasi Visual</h3>
                    <p style="color: var(--text-light); margin-bottom: 25px; text-align: center; line-height: 1.7;">Program desain grafis dan komunikasi visual untuk media cetak dan digital dengan pendekatan kreatif dan strategis</p>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-paint-brush" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Desain Grafis</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Logo, Branding, Layout</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-pencil-alt" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Ilustrasi Digital</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Vector & Digital Painting</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-bullhorn" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Branding & Marketing</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Strategi Visual</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemasaran -->
                <div class="card fade-in">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-chart-line" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <span style="display: inline-block; background: var(--light-blue); color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Bisnis</span>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px; text-align: center;">Pemasaran</h3>
                    <p style="color: var(--text-light); margin-bottom: 25px; text-align: center; line-height: 1.7;">Program pemasaran digital dan tradisional dengan pendekatan data-driven dan strategi bisnis untuk era modern</p>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-hashtag" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Pemasaran Digital</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Social Media & SEO</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-chart-pie" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Analisis Pasar</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Research & Consumer Behavior</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; background: var(--light-blue); padding: 12px; border-radius: 10px;">
                            <i class="fas fa-store" style="color: var(--primary-blue); margin-right: 12px; font-size: 1.2rem;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--text-dark); margin-bottom: 3px;">Strategi Branding</p>
                                <p style="color: var(--text-light); font-size: 0.9rem;">Positioning & Marketing Mix</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Section -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 60px;" class="fade-in">
                <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 10px;">156</div>
                    <div style="color: var(--text-dark); font-weight: 600; margin-bottom: 5px;">Juara Olimpiade</div>
                    <div style="color: var(--text-light); font-size: 0.9rem;">Sains & Matematika</div>
                </div>
                <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 10px;">98%</div>
                    <div style="color: var(--text-dark); font-weight: 600; margin-bottom: 5px;">Kelulusan</div>
                    <div style="color: var(--text-light); font-size: 0.9rem;">Tingkat kelulusan</div>
                </div>
                <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 10px;">85%</div>
                    <div style="color: var(--text-dark); font-weight: 600; margin-bottom: 5px;">Lulusan PTN</div>
                    <div style="color: var(--text-light); font-size: 0.9rem;">Masuk perguruan tinggi</div>
                </div>
                <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 10px;">25+</div>
                    <div style="color: var(--text-dark); font-weight: 600; margin-bottom: 5px;">Beasiswa LN</div>
                    <div style="color: var(--text-light); font-size: 0.9rem;">Luar negeri</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas dan Layanan Section -->
    <section class="section" style="background: white;" id="fasilitas">
        <div class="container">
            <h2 class="section-title fade-in">Fasilitas & Layanan</h2>
            <p style="text-align: center; color: var(--text-light); max-width: 800px; margin: 0 auto 50px; font-size: 1.1rem;">
                Fasilitas modern dan layanan lengkap untuk mendukung pengembangan potensi siswa secara optimal
            </p>

            <div class="card-grid">
                <!-- Perpustakaan -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/educationsnapshots.com/39a80f38bc6468c56c9706691bf498e702a58191.jpg" alt="Perpustakaan" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-book" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Perpustakaan Modern</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Perpustakaan dengan koleksi lengkap, area baca yang nyaman, dan sistem digital untuk kemudahan akses informasi</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Koleksi 50.000+ judul buku</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Area multimedia dan e-library</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Ruang diskusi kelompok</span>
                        </div>
                    </div>
                </div>

                <!-- Laboratorium -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/www.nurtureinternational.in/01334f19703b03190436dd430d2651edd3ba1f55.jpeg" alt="Laboratorium" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-flask" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Laboratorium Canggih</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Laboratorium sains modern dengan peralatan terkini untuk mendukung pembelajaran eksperimen dan penelitian</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Lab Fisika, Kimia, Biologi</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Peralatan digital modern</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Sistem keamanan lengkap</span>
                        </div>
                    </div>
                </div>

                <!-- Olahraga -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/sportsurfaces.com/d62f61b762e63fe9158b70dbac10d92ff4b6f965.jpg" alt="Olahraga" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-running" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Sarana Olahraga</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Fasilitas olahraga lengkap untuk pengembangan fisik dan jiwa sportivitas siswa secara optimal</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Lapangan basket dan sepak bola</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Kolam renang olympic</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Gymnasium modern</span>
                        </div>
                    </div>
                </div>

                <!-- Auditorium -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/lbpa.com/47352fb927dfa80f28aff14754fb07f3a993d59f.jpg" alt="Auditorium" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-microphone" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Auditorium</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Auditorium modern dengan kapasitas besar untuk berbagai kegiatan pertunjukan dan presentasi</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Kapasitas 1000 orang</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Sistem audio visual canggih</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Panggung profesional</span>
                        </div>
                    </div>
                </div>

                <!-- Kantin -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/www.centralcatholichs.com/fd5edbc3b7c38d5dbdc6d3dc2a25bd86283a5004.jpg" alt="Kantin" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-utensils" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Kantin Sehat</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Kantin dengan menu sehat dan beragam, mengutamakan kebersihan dan gizi seimbang untuk siswa</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Menu bergizi seimbang</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Area makan nyaman</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Harga terjangkau</span>
                        </div>
                    </div>
                </div>

                <!-- IT Center -->
                <div class="card fade-in">
                    <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="https://kimi-web-img.moonshot.cn/img/cdn.prometheanworld.com/92fb42022848a2b8bcc267c7c3c2f12bb7845265.jpg" alt="IT Center" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue)); padding: 10px 15px; border-radius: 10px;">
                            <i class="fas fa-computer" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 style="color: var(--primary-blue); margin-bottom: 15px;">IT Center</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px; line-height: 1.7;">Pusat teknologi informasi dengan perangkat komputer modern dan internet berkecepatan tinggi</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Komputer terkini</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Internet fiber optic</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            <span style="color: var(--text-light);">Software edukatif lengkap</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection