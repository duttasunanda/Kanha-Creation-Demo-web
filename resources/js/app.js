import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Cart functionality
window.addToCart = function (productId, quantity = 1) {
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count
                updateCartCount();
                // Show success message
                showNotification('Product added to cart!', 'success');
            } else {
                showNotification(data.message || 'Error adding product to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding product to cart', 'error');
        });
};

// Update cart count
window.updateCartCount = function () {
    fetch('/api/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
                cartCountElement.style.display = data.count > 0 ? 'flex' : 'none';
            }
        });
};

// Show notification
window.showNotification = function (message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
        }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.add('opacity-100');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('opacity-0');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
};

// Search functionality
window.initSearch = function () {
    const searchInput = document.querySelector('#search-input');
    const searchResults = document.querySelector('#search-results');

    if (searchInput && searchResults) {
        let searchTimeout;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/api/search/products?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data.products);
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
};

function displaySearchResults(products) {
    const searchResults = document.querySelector('#search-results');

    if (products.length === 0) {
        searchResults.innerHTML = '<div class="p-4 text-gray-500">No products found</div>';
    } else {
        searchResults.innerHTML = products.map(product => `
            <a href="/products/${product.slug}" class="block p-4 hover:bg-gray-50 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <img src="${product.main_image}" alt="${product.name}" class="w-12 h-12 object-cover rounded">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">${product.name}</h4>
                        <p class="text-sm text-gray-500">${product.category.name}</p>
                        <p class="text-sm font-semibold text-blue-600">₹${product.price_for_display}</p>
                    </div>
                </div>
            </a>
        `).join('');
    }

    searchResults.classList.remove('hidden');
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    updateCartCount();
    initSearch();
});

// Product image gallery
window.initProductGallery = function () {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('#main-product-image');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('ring-2', 'ring-blue-500'));

            // Add active class to clicked thumbnail
            this.classList.add('ring-2', 'ring-blue-500');

            // Update main image
            if (mainImage) {
                mainImage.src = this.getAttribute('data-image');
                mainImage.alt = this.getAttribute('data-alt');
            }
        });
    });
};

// Quantity selector
window.initQuantitySelector = function () {
    const decreaseBtn = document.querySelector('#decrease-quantity');
    const increaseBtn = document.querySelector('#increase-quantity');
    const quantityInput = document.querySelector('#quantity-input');

    if (decreaseBtn && increaseBtn && quantityInput) {
        decreaseBtn.addEventListener('click', function () {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener('click', function () {
            const currentValue = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.getAttribute('max'));
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            }
        });
    }
};
