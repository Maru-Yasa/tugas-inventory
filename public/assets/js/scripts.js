/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});

$(document).ready(() => {
    $('.select-search').select2({
        theme: 'bootstrap-5'
    });
})

function toggleModal(buttonElement, resource, action, target) {
    const modalElement = document.querySelector(target);
    const modal = bootstrap.Modal.getOrCreateInstance(target);
    const data = JSON.parse(buttonElement.getAttribute('data-item'));
    const formElement = modalElement.querySelector('form');

    formElement.action = `/${resource}/${action}`

    if (!modal || !formElement) {
        return;
    }

    Object.keys(data).forEach((key) => {
        if (typeof data[key] == 'boolean') {
            data[key] = data[key] ? '1' : '0';
        }
        if (formElement[key]) {
            formElement[key]['value'] = data[key];
        }
    });

    modal.show();

}

window.toggleModal = toggleModal;
