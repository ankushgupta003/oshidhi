document.querySelectorAll('.selector').forEach(item => {
    item.addEventListener('click', event => {
        let selectedOption = event.target.id;
        let infoDiv = document.getElementById('info');
        
        switch(selectedOption) {
            case 'option1':
                infoDiv.innerText = 'Information for Option 1';
                break;
            case 'option2':
                infoDiv.innerText = 'Information for Option 2';
                break;
            case 'option3':
                infoDiv.innerText = 'Information for Option 3';
                break;
            case 'option4':
                infoDiv.innerText = 'Information for Option 4';
                break;
            default:
                infoDiv.innerText = 'Select an option to see information.';
        }
    });
});
