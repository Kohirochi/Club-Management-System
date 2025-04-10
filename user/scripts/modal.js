// https://www.youtube.com/watch?v=MBaw_6cPmAw&list=PLmdLxXXc_jb7EO-PrsFJijULKcxQq4r9L&index=52

const open_modal_buttons = document.querySelectorAll('[data-modal-target]');
const close_modal_buttons = document.querySelectorAll('[close-button]');
var overlay = document.getElementById('overlay');
var body = document.getElementsByTagName("body")[0];

open_modal_buttons.forEach(button => {
    const modal = document.querySelector(button.dataset.modalTarget);
    button.addEventListener('click', function () {
        open_modal(modal);
    })

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            const modals = document.querySelectorAll('.mymodal.active')
            modals.forEach(modal => {
                close_modal(modal)
            })
        }
    })
})


close_modal_buttons.forEach(button => {
    button.addEventListener('click', function () {
        const modal = button.closest('.mymodal');
        close_modal(modal);
    })
})

function open_modal(modal) {
    if (modal == null) return;
    modal.classList.add('active');
    overlay.classList.add('active');
    body.style.overflow = "hidden";
}

function close_modal(modal) {
    if (modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
    body.style.overflow = "auto";
}