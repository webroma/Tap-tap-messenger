document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.querySelector('.add');
    const intopost = document.querySelector('.intopost');
    const mainBorder = document.querySelector('.main-border1');

    addButton.addEventListener('click', function() {
        this.classList.toggle('active'); 
        mainBorder.classList.toggle('blur');
        intopost.classList.toggle('open'); 

    });
});