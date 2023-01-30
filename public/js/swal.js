
function swal_error(title, html = '', timer = 2000) {
    Swal.fire({
        icon: 'error',
        title: title,
        html: html,
        timer: timer,
        showConfirmButton: true
    });
}

function swal_succes(title, html = ''){
    Swal.fire({
        icon: 'success',
        title: title,
        html: html
    });
}

function swal_warning(title, html = '') {
    Swal.fire({
        icon: 'warning',
        title: title,
        html: html
    });
}

function swal_loading(title, html = ''){
    Swal.fire({
        title: title,
        html: html,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}