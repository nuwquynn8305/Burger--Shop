/**
 * Checkout functionality for Burger Shop
 */

document.addEventListener('DOMContentLoaded', function() {
    // Form validation with visual feedback
    const checkoutForm = document.getElementById('checkout-form');
    
    if (checkoutForm) {
        // Add validation to required fields
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            // Add event listener to validate on blur
            field.addEventListener('blur', function() {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Remove invalid style when field is focused
            field.addEventListener('focus', function() {
                field.classList.remove('is-invalid');
            });
        });
        
        // Add payment method selection effects
        const paymentOptions = checkoutForm.querySelectorAll('input[name="payment_method"]');
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                // Add class to parent to show selected payment method
                const paymentMethods = document.querySelectorAll('.form-check');
                paymentMethods.forEach(method => {
                    method.classList.remove('payment-selected');
                });
                
                this.closest('.form-check').classList.add('payment-selected');
                
                // Show additional information based on payment method
                const codInfo = document.getElementById('cod-info');
                const vnpayInfo = document.getElementById('vnpay-info');
                
                if (this.value === 'cod') {
                    if (codInfo) codInfo.classList.remove('d-none');
                    if (vnpayInfo) vnpayInfo.classList.add('d-none');
                } else if (this.value === 'vnpay') {
                    if (codInfo) codInfo.classList.add('d-none');
                    if (vnpayInfo) vnpayInfo.classList.remove('d-none');
                }
            });
        });
        
        // Form submission with validation
        checkoutForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validate required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    
                    // Add shake animation to invalid fields
                    field.classList.add('animate__animated', 'animate__shakeX');
                    
                    // Remove animation classes after animation ends
                    field.addEventListener('animationend', () => {
                        field.classList.remove('animate__animated', 'animate__shakeX');
                    });
                    
                    isValid = false;
                }
            });
            
            // Stop form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
                
                // Scroll to first invalid field
                const firstInvalidField = checkoutForm.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                return false;
            }
            
            // Show loading state on button when form is valid
            const submitButton = checkoutForm.querySelector('button[type="submit"]');
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';
            submitButton.disabled = true;
            
            // Add a nice checkout animation
            const orderSummary = document.querySelector('.order-summary');
            if (orderSummary) {
                orderSummary.classList.add('animate__animated', 'animate__fadeOutUp');
            }
            
            return true;
        });
    }
    
    // Phone number validation
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Format phone number as needed
            if (this.value.length > 10) {
                this.value = this.value.substring(0, 10);
            }
        });
    }
    
    // Address character counter
    const addressTextarea = document.getElementById('address');
    if (addressTextarea) {
        const createCharCounter = () => {
            const counter = document.createElement('small');
            counter.className = 'text-muted d-block text-end mt-1';
            counter.id = 'address-counter';
            addressTextarea.insertAdjacentElement('afterend', counter);
            return counter;
        };
        
        const charCounter = document.getElementById('address-counter') || createCharCounter();
        
        const updateCounter = () => {
            const currentLength = addressTextarea.value.length;
            charCounter.textContent = `${currentLength} characters`;
            
            if (currentLength > 200) {
                charCounter.classList.add('text-warning');
            } else {
                charCounter.classList.remove('text-warning');
            }
        };
        
        addressTextarea.addEventListener('input', updateCounter);
        
        // Initial update
        updateCounter();
    }
});
