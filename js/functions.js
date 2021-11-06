async function postData(url='', data={}) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

/* MODAL */
const modalWrapper = document.getElementById('modal-wrapper');
showModal = () => modalWrapper.style.visibility = 'visible';
hideModal = () => modalWrapper.style.visibility = 'hidden';

const modalClose = document.querySelector('.modal-close');
modalClose.addEventListener('click', hideModal);