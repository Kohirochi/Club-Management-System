// https://www.youtube.com/watch?v=MBaw_6cPmAw&list=PLmdLxXXc_jb7EO-PrsFJijULKcxQq4r9L&index=52

const open_event_modal_buttons = document.querySelectorAll('[data-event-modal-target]');
const close_event_modal_buttons = document.querySelectorAll('[close-event-button]');
var overlay = document.getElementById('overlay');
var body = document.getElementsByTagName("body")[0];


open_event_modal_buttons.forEach(button => {
    const modal = document.querySelector(button.dataset.eventModalTarget);
    button.addEventListener('click', function () {
        open_event_modal(modal);
    })

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            const modals = document.querySelectorAll('.event-modal.active')
            modals.forEach(modal => {
                close_event_modal(modal)
            })
        }
    })
})


close_event_modal_buttons.forEach(button => {
    button.addEventListener('click', function () {
        const modal = button.closest('.event-modal');
        close_event_modal(modal);
    })
})

function open_event_modal(modal) {
    if (modal == null) return;
    const content = document.getElementById('view-form');
    content.classList.add('active');

    modal.classList.add('active');
    overlay.classList.add('active');
    body.style.top = `-${window.scrollY}px`;
    body.style.position = "fixed";
    body.style.width = "100%";
    body.style.overflowY = "scroll";
    body.style.overscrollBehaviorY = "contain";
}

function close_event_modal(modal) {
    if (modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
    body.style.position = "static";
    body.style.overflow = "auto";
    const scrollY = body.style.top;
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
}