function validateForm() {
    let firstName = document.getElementById('firstName').value.trim();
    let lastName = document.getElementById('lastName').value.trim();
    let email = document.getElementById('email').value.trim();
    let invoiceID = document.getElementById('invoiceID').value.trim();
    let payFor = document.querySelectorAll('input[name="payFor[]"]:checked');
    
    let errors = [];

    if (firstName === '') {
        errors.push("First Name is required.");
    }

    if (lastName === '') {
        errors.push("Last Name is required.");
    }

    if (email === '') {
        errors.push("Email is required.");
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        errors.push("Invalid email format.");
    }

    if (invoiceID === '') {
        errors.push("Invoice ID is required.");
    } else if (!/^\d+$/.test(invoiceID)) {
        errors.push("Invoice ID must be a number.");
    }

    if (payFor.length === 0) {
        errors.push("At least one 'Pay For' option must be selected.");
    }

    // Display errors
    let errorDiv = document.getElementById('errorMessages');
    errorDiv.innerHTML = '';
    if (errors.length > 0) {
        errors.forEach(function (error) {
            let p = document.createElement('p');
            p.className = 'error';
            p.innerText = error;
            errorDiv.appendChild(p);
        });
        return false; // Prevent form submission if there are errors
    }

    return true; // Allow form submission if validation passed
}