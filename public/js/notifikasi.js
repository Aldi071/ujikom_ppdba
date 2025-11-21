// Notifikasi System
let notifikasiModal = null;

// Load notifikasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.user-profile')) {
        loadNotifikasi();
        // Auto refresh setiap 30 detik
        setInterval(loadNotifikasi, 30000);
    }
});

async function loadNotifikasi() {
    try {
        const response = await fetch('/api/notifikasi');
        const data = await response.json();
        
        if (data.success) {
            updateNotifikasiBadge(data.unread_count);
        }
    } catch (error) {
        console.error('Error loading notifikasi:', error);
    }
}

function updateNotifikasiBadge(count) {
    const badge = document.getElementById('notif-badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }
}

async function toggleNotifikasi(event) {
    event.preventDefault();
    
    if (notifikasiModal) {
        notifikasiModal.remove();
        notifikasiModal = null;
        return;
    }
    
    try {
        const response = await fetch('/api/notifikasi');
        const data = await response.json();
        
        if (data.success) {
            showNotifikasiModal(data.data);
        }
    } catch (error) {
        console.error('Error loading notifikasi:', error);
    }
}

function showNotifikasiModal(notifikasi) {
    notifikasiModal = document.createElement('div');
    notifikasiModal.style.cssText = `
        position: fixed;
        top: 60px;
        right: 20px;
        width: 350px;
        max-height: 400px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 10000;
        overflow: hidden;
    `;
    
    const header = `
        <div style="padding: 15px; background: var(--primary-blue); color: white; display: flex; justify-content: space-between; align-items: center;">
            <h6 style="margin: 0; font-weight: 600;">Notifikasi</h6>
            <div>
                <button onclick="bacaSemuaNotifikasi()" style="background: none; border: none; color: white; margin-right: 10px; cursor: pointer;">
                    <i class="fas fa-check-double"></i>
                </button>
                <button onclick="closeNotifikasi()" style="background: none; border: none; color: white; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    let content = '';
    if (notifikasi.length === 0) {
        content = `
            <div style="padding: 30px; text-align: center; color: #6b7280;">
                <i class="fas fa-bell-slash" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <p>Tidak ada notifikasi</p>
            </div>
        `;
    } else {
        content = `<div style="max-height: 300px; overflow-y: auto;">`;
        notifikasi.forEach(notif => {
            const bgColor = notif.dibaca ? '#f9fafb' : '#eff6ff';
            const borderColor = getTipeBorderColor(notif.tipe);
            
            content += `
                <div onclick="bacaNotifikasi(${notif.id})" style="
                    padding: 15px; 
                    border-bottom: 1px solid #e5e7eb; 
                    background: ${bgColor};
                    border-left: 4px solid ${borderColor};
                    cursor: pointer;
                " onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='${bgColor}'">
                    <div style="font-weight: ${notif.dibaca ? 'normal' : 'bold'}; color: #1f2937; margin-bottom: 5px;">
                        ${notif.judul}
                    </div>
                    <div style="font-size: 0.9rem; color: #6b7280; margin-bottom: 8px;">
                        ${notif.pesan}
                    </div>
                    <div style="font-size: 0.8rem; color: #9ca3af;">
                        ${formatTanggal(notif.created_at)}
                    </div>
                </div>
            `;
        });
        content += '</div>';
    }
    
    notifikasiModal.innerHTML = header + content;
    document.body.appendChild(notifikasiModal);
    
    // Close saat klik di luar
    setTimeout(() => {
        document.addEventListener('click', closeOnOutsideClick);
    }, 100);
}

function getTipeBorderColor(tipe) {
    const colors = {
        'success': '#10b981',
        'warning': '#f59e0b', 
        'danger': '#ef4444',
        'info': '#3b82f6'
    };
    return colors[tipe] || '#6b7280';
}

function formatTanggal(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    
    if (minutes < 1) return 'Baru saja';
    if (minutes < 60) return `${minutes} menit lalu`;
    if (hours < 24) return `${hours} jam lalu`;
    if (days < 7) return `${days} hari lalu`;
    
    return date.toLocaleDateString('id-ID');
}

async function bacaNotifikasi(id) {
    try {
        await fetch('/api/notifikasi/baca', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ id: id })
        });
        
        closeNotifikasi();
        loadNotifikasi();
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
}

async function bacaSemuaNotifikasi() {
    try {
        await fetch('/api/notifikasi/baca', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({})
        });
        
        closeNotifikasi();
        loadNotifikasi();
    } catch (error) {
        console.error('Error marking all notifications as read:', error);
    }
}

function closeNotifikasi() {
    if (notifikasiModal) {
        notifikasiModal.remove();
        notifikasiModal = null;
        document.removeEventListener('click', closeOnOutsideClick);
    }
}

function closeOnOutsideClick(event) {
    if (notifikasiModal && !notifikasiModal.contains(event.target)) {
        closeNotifikasi();
    }
}