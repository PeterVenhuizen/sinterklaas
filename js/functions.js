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

browserSupportsHTMLTemplate = () => {
    return 'content' in document.createElement('template');
    // return false;
}

createDOMElement = (element, textContent, attributes={}) => {
    const el = document.createElement(element);
    for (const [key, value] of Object.entries(attributes)) {
        el.setAttribute(key, value);
    }
    el.textContent = textContent;
    return el;
}

randomIntFromInterval = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

formatSQLDateToDutchFormat = (dateInSQLFormat) => {
    const [year, month, day] = dateInSQLFormat.split(/-/);
    return `${day}-${month}-${year}`;
}