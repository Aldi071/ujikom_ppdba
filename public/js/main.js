// Global Variables
let currentUser = null;
let registrationData = {};

// Initialize everything when DOM is loaded
// Di bagian DOMContentLoaded, tambahkan:
document.addEventListener("DOMContentLoaded", function () {
    initializeAnimations();
    initializeSliders();
    initializeScrollEffects();
    initializeTypedText();
    checkLoginStatus();

    // Check if OTP modal should be shown (handled by server-side)
    if (window.showOtpModal) {
        openModal('otpModal');
    }
});

// Update modal functions
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
        
        // Auto focus ke input OTP
        if (id === 'otpModal') {
            setTimeout(() => {
                const otpInput = document.getElementById('otp');
                if (otpInput) otpInput.focus();
            }, 300);
        }
        
        // Reset form errors saat modal dibuka
        if (id === 'registerModal') {
            const form = document.querySelector('#registerModal form');
            if (form) {
                form.reset();
            }
        }
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    }
}

window.onclick = function (event) {
    const modals = document.querySelectorAll(".modal");
    modals.forEach((m) => {
        if (event.target === m) {
            m.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
};

// Auto tab untuk OTP input (optional enhancement)
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            if (this.value.length === 6) {
                this.form.submit();
            }
        });
    }
});


const toggleBtn = document.getElementById("navbarToggle");
const mobileMenu = document.getElementById("mobileMenu");

toggleBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("active");
    toggleBtn.classList.toggle("open");

    // Ubah ikon jadi X pas menu dibuka
    if (toggleBtn.classList.contains("open")) {
        toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
    } else {
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    }
});

// Tutup menu otomatis kalau link diklik
document.querySelectorAll("#mobileMenu a").forEach((link) => {
    link.addEventListener("click", () => {
        mobileMenu.classList.remove("active");
        toggleBtn.classList.remove("open");
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    });
});

// ==== Animasi Fade-in Saat Scroll ====
document.addEventListener("DOMContentLoaded", () => {
    const fadeElements = document.querySelectorAll(".fade-in");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target); // supaya animasi cuma sekali
                }
            });
        },
        { threshold: 0.2 }
    );

    fadeElements.forEach((el) => observer.observe(el));
});

function openModal(id) {
    document.getElementById(id).style.display = "block";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

window.onclick = function (event) {
    const modals = document.querySelectorAll(".modal");
    modals.forEach((m) => {
        if (event.target === m) m.style.display = "none";
    });
};

// Loader control
window.addEventListener("load", function () {
    const loader = document.getElementById("loader-wrapper");
    loader.classList.add("fade-out");
    setTimeout(() => {
        loader.style.display = "none";
    }, 500);
});

function toggleDropdown(event) {
    event.preventDefault(); // cegah link aktif
    const dropdown = event.target.closest(".dropdown");

    // Tutup dropdown lain
    document.querySelectorAll(".dropdown").forEach((d) => {
        if (d !== dropdown) d.classList.remove("active");
    });

    // Toggle buka/tutup dropdown ini
    dropdown.classList.toggle("active");
}

// Tutup dropdown jika klik di luar area
document.addEventListener("click", (e) => {
    if (!e.target.closest(".dropdown")) {
        document
            .querySelectorAll(".dropdown")
            .forEach((d) => d.classList.remove("active"));
    }
});

function openModal(id) {
    document.getElementById(id).style.display = "block";
    document.body.style.overflow = "hidden";
    
    // Reset form errors saat modal dibuka
    if (id === 'registerModal') {
        const form = document.querySelector('#registerModal form');
        if (form) {
            form.reset();
        }
    }
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
    document.body.style.overflow = "auto";
}

// ==== Slider Pengumuman ====
document.addEventListener("DOMContentLoaded", function () {
    new Splide("#announcement-slider", {
        type: "loop",
        perPage: 1,
        autoplay: true,
        interval: 5000,
        pauseOnHover: true,
        arrows: true, // aktifkan panah navigasi
        pagination: false,
    }).mount();
});

const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
        }
    });
}, observerOptions);

document.querySelectorAll(".fade-in").forEach((el) => {
    observer.observe(el);
});

// Search toggle functionality
const toggle = document.getElementById('searchToggle');
const pill = document.getElementById('searchPill');
const search = document.getElementById('searchContainer');

if (toggle && pill && search) {
    toggle.addEventListener("click", () => {
        pill.classList.toggle("active");
        search.classList.toggle("active");
    });
}

// Initialize Typed.js for hero slogan
function initializeTypedText() {
    if (document.getElementById("typed-text")) {
        new Typed("#typed-text", {
            strings: [
                "SPMB 2025/2026 – Saatnya Bergabung Bersama Kami!",
                "Mencerdaskan Kehidupan Bangsa",
                "BAKNUS 666, Smart Generation",
            ],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: "|",
        });
    }
}

// Initialize animations
function initializeAnimations() {
    // Animate hero title
    if (document.querySelector("[data-splitting]")) {
        Splitting();

        anime({
            targets: "[data-splitting] .char",
            translateY: [100, 0],
            opacity: [0, 1],
            easing: "easeOutExpo",
            duration: 1400,
            delay: (el, i) => 30 * i,
        });
    }

    // Animate cards on scroll
    const cards = document.querySelectorAll(".card");
    cards.forEach((card, index) => {
        anime({
            targets: card,
            translateY: [50, 0],
            opacity: [0, 1],
            easing: "easeOutExpo",
            duration: 1000,
            delay: 200 * index,
        });
    });
}

// Initialize sliders
function initializeSliders() {
    if (document.getElementById("announcement-slider")) {
        new Splide("#announcement-slider", {
            type: "loop",
            perPage: 1,
            autoplay: true,
            interval: 5000,
            arrows: false,
            pagination: true,
            gap: "2rem",
        }).mount();
    }
}


// Initialize scroll effects
function initializeScrollEffects() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, observerOptions);

    document.querySelectorAll(".fade-in").forEach((el) => {
        observer.observe(el);
    });
}

// Search functionality
function performSearch() {
    const searchTerm = document
        .getElementById("searchInput")
        .value.toLowerCase();
    const searchResults = {
        SPMB: "informasi.html",
        pendaftaran: "pendaftaran.html",
        jadwal: "informasi.html#jadwal",
        syarat: "informasi.html#syarat",
        profil: "profil.html",
        pengumuman: "pengumuman.html",
        kontak: "kontak.html",
        faq: "faq.html",
    };

    for (const [key, url] of Object.entries(searchResults)) {
        if (searchTerm.includes(key)) {
            window.location.href = url;
            return;
        }
    }

    // If no specific match, show general search results
    alert(
        `Pencarian untuk "${searchTerm}" tidak ditemukan. Silakan coba kata kunci lain.`
    );
}

// Handle search on Enter key
document.addEventListener("keypress", function (e) {
    if (e.key === "Enter" && e.target.id === "searchInput") {
        performSearch();
    }
});

// WhatsApp functionality
function openWhatsApp() {
    const phoneNumber = "6281234567890"; // Replace with actual WhatsApp number
    const message =
        "Halo, saya ingin informasi tentang SPMB BAKNUS 666 tahun ajaran 2025/2026";
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(
        message
    )}`;
    window.open(url, "_blank");
}

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
    document.body.style.overflow = "hidden";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
    document.body.style.overflow = "auto";
}

// Login functionality
function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    // Simulate login process
    const loginButton = e.target.querySelector('button[type="submit"]');
    const originalText = loginButton.innerHTML;
    loginButton.innerHTML = '<span class="loading"></span> Loading...';
    loginButton.disabled = true;

    setTimeout(() => {
        // Mock login success
        currentUser = {
            email: email,
            name: "Siswa BAKNUS 666",
            registrationNumber: "SPMB2025001",
        };

        localStorage.setItem("currentUser", JSON.stringify(currentUser));

        loginButton.innerHTML = originalText;
        loginButton.disabled = false;

        closeModal("loginModal");
        updateUIForLoggedInUser();

        // Show success message
        showNotification(
            "Login berhasil! Selamat datang di BAKNUS 666.",
            "success"
        );
    }, 2000);
}

// Check login status on page load
function checkLoginStatus() {
    const savedUser = localStorage.getItem("currentUser");
    if (savedUser) {
        currentUser = JSON.parse(savedUser);
        updateUIForLoggedInUser();
    }
}

// Update UI for logged in user
function updateUIForLoggedInUser() {
    const loginButtons = document.querySelectorAll('a[href="#login"]');
    loginButtons.forEach((button) => {
        button.textContent = "Dashboard";
        button.href = "dashboard.html";
    });
}

// Logout functionality
function logout() {
    currentUser = null;
    localStorage.removeItem("currentUser");
    localStorage.removeItem("registrationData");

    // Reset UI
    const loginButtons = document.querySelectorAll('a[href="dashboard.html"]');
    loginButtons.forEach((button) => {
        button.textContent = "Login";
        button.href = "#login";
        button.onclick = () => openModal("loginModal");
    });

    showNotification("Logout berhasil!", "info");
}

// Notification system
function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${
                type === "success"
                    ? "#10b981"
                    : type === "error"
                    ? "#ef4444"
                    : "#3b82f6"
            };
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 10000;
            max-width: 300px;
            font-weight: 500;
        ">
            ${message}
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Registration form handling
function handleRegistrationStep(step) {
    const formData = new FormData(document.getElementById(`step${step}Form`));
    const data = Object.fromEntries(formData);

    // Save data
    registrationData = { ...registrationData, ...data };
    localStorage.setItem("registrationData", JSON.stringify(registrationData));

    // Animate to next step
    const currentStep = document.querySelector(".step.active");
    const nextStep = document.querySelector(`#step${step + 1}`);

    anime({
        targets: currentStep,
        opacity: [1, 0],
        translateX: [-50, 0],
        duration: 500,
        complete: () => {
            currentStep.classList.remove("active");
            nextStep.classList.add("active");
            anime({
                targets: nextStep,
                opacity: [0, 1],
                translateX: [50, 0],
                duration: 500,
            });
        },
    });
}

// File upload handling
function handleFileUpload(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = `
                <div style="
                    background: #f3f4f6;
                    border: 2px dashed #9ca3af;
                    border-radius: 10px;
                    padding: 20px;
                    text-align: center;
                ">
                    <i class="fas fa-check-circle" style="color: #10b981; font-size: 2rem; margin-bottom: 10px;"></i>
                    <p style="color: #374151; font-weight: 500;">${
                        file.name
                    }</p>
                    <p style="color: #6b7280; font-size: 0.9rem;">${(
                        file.size /
                        1024 /
                        1024
                    ).toFixed(2)} MB</p>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll(
        "input[required], select[required], textarea[required]"
    );
    let isValid = true;

    inputs.forEach((input) => {
        if (!input.value.trim()) {
            input.style.borderColor = "#ef4444";
            isValid = false;
        } else {
            input.style.borderColor = "rgba(59, 130, 246, 0.2)";
        }
    });

    return isValid;
}

// Auto-save form data
function autoSaveForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const inputs = form.querySelectorAll("input, select, textarea");
    inputs.forEach((input) => {
        input.addEventListener("input", () => {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            registrationData = { ...registrationData, ...data };
            localStorage.setItem(
                "registrationData",
                JSON.stringify(registrationData)
            );
        });
    });
}

// Load saved form data
function loadSavedFormData(formId) {
    const savedData = localStorage.getItem("registrationData");
    if (!savedData) return;

    const data = JSON.parse(savedData);
    const form = document.getElementById(formId);
    if (!form) return;

    Object.keys(data).forEach((key) => {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) {
            input.value = data[key];
        }
    });
}

// Countdown timer for registration
function initializeCountdown(endDate) {
    const countdownElement = document.getElementById("countdown");
    if (!countdownElement) return;

    const endTime = new Date(endDate).getTime();

    const timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = endTime - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `
            <div style="display: flex; gap: 20px; justify-content: center;">
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-blue);">${days}</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Hari</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-blue);">${hours}</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Jam</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-blue);">${minutes}</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Menit</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-blue);">${seconds}</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);">Detik</div>
                </div>
            </div>
        `;

        if (distance < 0) {
            clearInterval(timer);
            countdownElement.innerHTML =
                '<div style="text-align: center; color: var(--primary-blue); font-size: 1.2rem; font-weight: bold;">Pendaftaran telah ditutup</div>';
        }
    }, 1000);
}

// Print registration proof
function printRegistrationProof() {
    const savedData = localStorage.getItem("registrationData");
    if (!savedData) {
        showNotification("Data pendaftaran tidak ditemukan", "error");
        return;
    }

    const data = JSON.parse(savedData);
    const printWindow = window.open("", "_blank");

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Bukti Pendaftaran SPMB BAKNUS 666</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .logo { width: 80px; height: 80px; border-radius: 50%; }
                .content { margin: 20px 0; }
                .field { margin: 10px 0; padding: 10px; background: #f3f4f6; border-radius: 5px; }
                .label { font-weight: bold; color: #374151; }
                .value { color: #6b7280; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="{{ asset('../img/logo.png') }}" alt="BAKNUS 666" class="logo">
                <h2>BUKTI PENDAFTARAN SPMB</h2>
                <h3>BAKNUS 666 TAHUN AJARAN 2025/2026</h3>
            </div>
            <div class="content">
                <div class="field">
                    <div class="label">Nomor Pendaftaran:</div>
                    <div class="value">SPMB2025${Math.floor(
                        Math.random() * 1000
                    )
                        .toString()
                        .padStart(3, "0")}</div>
                </div>
                <div class="field">
                    <div class="label">Nama Lengkap:</div>
                    <div class="value">${data.fullName || "-"}</div>
                </div>
                <div class="field">
                    <div class="label">NISN:</div>
                    <div class="value">${data.nisn || "-"}</div>
                </div>
                <div class="field">
                    <div class="label">Jalur Pendaftaran:</div>
                    <div class="value">${data.registrationPath || "-"}</div>
                </div>
                <div class="field">
                    <div class="label">Tanggal Pendaftaran:</div>
                    <div class="value">${new Date().toLocaleDateString(
                        "id-ID"
                    )}</div>
                </div>
            </div>
            <div style="margin-top: 30px; text-align: center;">
                <p style="color: #6b7280; font-size: 0.9rem;">
                    Simpan bukti ini sebagai tanda bukti pendaftaran Anda.
                </p>
            </div>
            <div class="no-print" style="text-align: center; margin-top: 30px;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak Bukti</button>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
}

// Export functions for global use
window.performSearch = performSearch;
window.openWhatsApp = openWhatsApp;
window.handleLogin = handleLogin;
window.logout = logout;
window.handleRegistrationStep = handleRegistrationStep;
window.handleFileUpload = handleFileUpload;
window.printRegistrationProof = printRegistrationProof;

// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
            navLinks.classList.remove("active");
        }
    });
});

// Fade In Animation on Scroll

// Counter Animation
function animateCounter(element) {
    const target = parseInt(element.textContent);
    const duration = 2000;
    const increment = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent =
            Math.floor(current) +
            (element.textContent.includes("%")
                ? "%"
                : element.textContent.includes("+")
                ? "+"
                : "");
    }, 16);
}

// Trigger counter animation when visible
const statsObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll(
                    ".stat-number, .achievement-number"
                );
                counters.forEach((counter) => {
                    if (!counter.classList.contains("animated")) {
                        counter.classList.add("animated");
                        animateCounter(counter);
                    }
                });
            }
        });
    },
    { threshold: 0.3 }
);

document.querySelectorAll(".stats-grid, .achievement-grid").forEach((el) => {
    statsObserver.observe(el);
});

