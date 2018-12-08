function awaitResponse() {
    let button = document.getElementById('import-character-submit');
    button.disabled = true;
    button.innerHTML = "Importing Character...";
}