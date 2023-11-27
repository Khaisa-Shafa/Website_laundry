// Get all the quantity forms
const quantityForms = document.querySelectorAll('.quantity-form');

// Loop through each form
quantityForms.forEach(form => {
    // Add an event listener for form submission
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        const quantityInput = this.querySelector('.quantity-input'); // Get the quantity input
        const action = event.submitter.value; // Get the value of the clicked button

        // Determine whether to increase or decrease quantity based on the clicked button
        let newQuantity = parseInt(quantityInput.value);
        if (action === '+') {
            newQuantity += 1;
        } else if (action === '-' && newQuantity > 0) {
            newQuantity -= 1;
        }

        // Update the quantity input value
        quantityInput.value = newQuantity;
    });
});