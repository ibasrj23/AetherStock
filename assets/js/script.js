// Fungsi untuk delete produk dengan konfirmasi
function deleteProduct(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        window.location.href = 'delete_product.php?id=' + id;
    }
}

// Validasi form quantity minimal 1
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('price');
    
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            if (this.value < 1 || this.value === '') {
                this.value = 1;
                alert('Quantity minimal harus 1!');
            }
        });
    }
    
    if (priceInput) {
        priceInput.addEventListener('change', function() {
            if (this.value <= 0 || this.value === '') {
                this.value = 1;
                alert('Harga harus lebih besar dari 0!');
            }
        });
    }
    
    // Hapus alert setelah 5 detik
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Tambahkan animasi fadeOut
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
