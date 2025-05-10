// Format price with commas
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + ' VNĐ';
}

// Handle image gallery
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    const mainImage = document.querySelector('.main-image');
    
    if (thumbnails && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.src;
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
});

// Handle search form
const searchForm = document.querySelector('.search-form');
if (searchForm) {
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams(formData);
        window.location.href = 'list.php?' + params.toString();
    });
}

// Handle contact form
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading spinner
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...';
        submitBtn.disabled = true;
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            alert('Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể!');
            contactForm.reset();
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
        }, 1500);
    });
}

// Handle property filtering
const filterForm = document.querySelector('.filter-form');
if (filterForm) {
    filterForm.addEventListener('change', function() {
        this.submit();
    });
}

// Handle image upload preview
const imageInput = document.querySelector('input[type="file"]');
if (imageInput) {
    imageInput.addEventListener('change', function() {
        const preview = document.querySelector('.image-preview');
        if (preview) {
            preview.innerHTML = '';
            for (const file of this.files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail m-1';
                    img.style.height = '100px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    });
}

// Handle price range slider
const priceRange = document.getElementById('priceRange');
const priceValue = document.getElementById('priceValue');
if (priceRange && priceValue) {
    priceRange.addEventListener('input', function() {
        priceValue.textContent = formatPrice(this.value);
    });
}

// Handle mobile menu
const menuToggle = document.querySelector('.navbar-toggler');
if (menuToggle) {
    menuToggle.addEventListener('click', function() {
        document.querySelector('.navbar-collapse').classList.toggle('show');
    });
}

// Handle scroll to top button
const scrollTopBtn = document.createElement('button');
scrollTopBtn.innerHTML = '↑';
scrollTopBtn.className = 'scroll-top-btn';
scrollTopBtn.style.display = 'none';
document.body.appendChild(scrollTopBtn);

window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
        scrollTopBtn.style.display = 'block';
    } else {
        scrollTopBtn.style.display = 'none';
    }
});

scrollTopBtn.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Add custom styles for scroll to top button
const style = document.createElement('style');
style.textContent = `
    .scroll-top-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: background-color 0.3s;
    }
    
    .scroll-top-btn:hover {
        background-color: #0056b3;
    }
`;
document.head.appendChild(style); 