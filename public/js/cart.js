/**
 * Cart functionality for Burger Shop
 */

// Show toast notifications for cart actions
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        // Create toast container if it doesn't exist
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '1080';
        document.body.appendChild(container);
    }
    
    const toastId = `toast-${Date.now()}`;
    const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${type === 'success' ? 'bg-success text-white' : 'bg-danger text-white'}">
                <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    document.getElementById('toast-container').innerHTML += toastHTML;
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
    toast.show();
    
    // Remove toast from DOM after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}

// Add to cart with animation
function addToCart(formElement) {
    const form = $(formElement);
    const submitBtn = form.find('button[type="submit"]');
    const originalText = submitBtn.html();
    
    // Disable button and show loading
    submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
    submitBtn.prop('disabled', true);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            // Create a flying cart effect
            const productCard = form.closest('.product-card, .card');
            const productImg = productCard.find('img').first();
            const nav = $('.navbar');
            const cart = $('.fa-shopping-cart').first();
            
            if (productImg.length && cart.length) {
                const imgClone = productImg.clone()
                    .offset({
                        top: productImg.offset().top,
                        left: productImg.offset().left
                    })
                    .css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': productImg.height() / 2,
                        'width': productImg.width() / 2,
                        'z-index': '9999',
                        'border-radius': '50%',
                        'object-fit': 'cover'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 40,
                        'height': 40
                    }, 800, 'easeInOutExpo');
                
                imgClone.animate({
                    'width': 0,
                    'height': 0
                }, function() {
                    $(this).detach();
                });
            }
            
            // Show success message
            showToast('Product added to cart!', 'success');
            
            // Update cart count
            updateCartCount();
            
            // Restore button
            setTimeout(() => {
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }, 1000);
        },
        error: function(xhr) {
            showToast('Error adding product to cart', 'error');
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
        }
    });
    
    return false;
}

// Update cart quantity with animation
function updateCartItem(selectElement) {
    const form = $(selectElement).closest('form');
    const row = form.closest('tr');
    
    row.css('background-color', 'rgba(255, 107, 0, 0.1)');
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            showToast('Cart updated successfully', 'success');
            updateCartCount();
            
            // Flash animation to indicate update
            setTimeout(() => {
                row.css('background-color', '');
            }, 1000);
        },
        error: function(xhr) {
            showToast('Error updating cart', 'error');
            row.css('background-color', '');
        }
    });
    
    return false;
}

// Initialize cart functionality
$(document).ready(function() {
    // Add jQuery easing if not available
    if (typeof $.easing.easeInOutExpo !== 'function') {
        $.easing.easeInOutExpo = function(x, t, b, c, d) {
            if (t==0) return b;
            if (t==d) return b+c;
            if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
            return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
        };
    }
    
    // Hide empty cart badge
    const cartCount = parseInt($('#cart-count').text());
    if (cartCount <= 0) {
        $('#cart-count').hide();
    }
    
    // Form submission for add to cart buttons with animation
    $(document).on('submit', 'form[action*="cart.add"]', function(e) {
        e.preventDefault();
        addToCart(this);
    });
    
    // Handle quantity change in cart
    $(document).on('change', '.cart-quantity-select', function() {
        updateCartItem(this);
    });
});
