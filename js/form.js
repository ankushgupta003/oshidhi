const scriptURL = 'https://script.google.com/macros/s/AKfycbzvSywPiycpP-FWuhdOGMwGyLmf62j7dsbgL1Jg8g4gC9by_pxCnmn-4dOsC2TtR93j/exec'

const form = document.forms['feedback']

form.addEventListener('submit',e => {
    e.preventDefault()
    fetch(scriptURL, {method: 'POST', body: new FormData(form)})
    .then(response => alert("Thank you! Your form is submitted Successfully."))
    .then(() => { window.location.reload(); })
    .catch(error => console.error('Error!', error.message))
})