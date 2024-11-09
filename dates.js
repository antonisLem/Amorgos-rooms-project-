document.addEventListener('DOMContentLoaded', function() {
const form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const firstName = document.getElementById('name').value.trim();
            const lastName = document.getElementById('surname').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const arrivalDate = document.getElementById('checkin').value;
            const departureDate = document.getElementById('checkout').value;
            // Validation logic
            if (firstName.length < 2) {
                alert('Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες.');
                return;
            }
            if (lastName.length < 2) {
                alert('Το επίθετο πρέπει να έχει τουλάχιστον 2 χαρακτήρες.');
                return;
            }
            const emailPattern = /^[^\s@]+@[^\s@]+.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Παρακαλώ εισάγετε ένα έγκυρο email.');
                return;
            }

            const phonePattern = /^\d{10,15}$/;
            if (!phonePattern.test(phone)) {
                alert('Το τηλέφωνο πρέπει να έχει από 10 έως 15 ψηφία.');
                return;
            }
const today = new Date().toISOString().split('T')[0];
            if (arrivalDate < today) {
                alert('Η ημερομηνία άφιξης δεν μπορεί να είναι προγενέστερη της τρέχουσας ημερομηνίας.');
                return;
            }
            if (departureDate <= arrivalDate) {
                alert('Η ημερομηνία αναχώρησης δεν μπορεί να είναι προγενέστερη ή ίδια με την ημερομηνία άφιξης.');
                return;
            }
            // If all validations pass, proceed with form submission
            alert('Η κράτηση σας έχει αποσταλεί επιτυχώς!');
            form.submit();
        });
    }
});