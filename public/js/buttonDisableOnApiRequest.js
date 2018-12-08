function awaitResponse(message) {
    let button = document.getElementById('await-request-button');
    button.disabled = true;
    button.innerHTML = `${message}...`;
}