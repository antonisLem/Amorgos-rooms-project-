 // Verification callback function
 function captchaVerified() {
    var submitBtn = document.getElementById('submit');
    submitBtn.removeAttribute('disabled');
    submitBtn.removeAttribute('aria-disabled');
    submitBtn.classList.remove('btn-outline-info', 'disabled');
    submitBtn.classList.add('btn-info');
}
// Expiration callback function
function captchaExpired() {
    grecaptcha.reset();
}