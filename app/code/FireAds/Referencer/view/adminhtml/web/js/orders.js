controlPageUtils();
controlStatusDropdown();

const form = document.getElementById('form');
const inputStatus = document.getElementById('input-status');
const dateFrom = document.getElementById('input-date-from');
const dateTo = document.getElementById('input-date-to');

window.flatpickr(dateFrom, {
    dateFormat: "Y-m-d"
});

window.flatpickr(dateTo, {
    dateFormat: "Y-m-d"
});

form.onsubmit = (e) => {
    e.preventDefault();
    const params = new URLSearchParams(location.search);

    if (inputStatus.value) {
        params.set('status', inputStatus.value);
    } else {
        params.has('status') && params.delete('status');
    }

    if (dateFrom.value) {
        params.set('date-from', (new Date(dateFrom.value).getTime() / 1000).toString());
    } else {
        params.has('date-from') && params.delete('date-from');
    }

    if (dateTo.value) {
        params.set('date-to', (new Date(dateTo.value).getTime() / 1000).toString());
    } else {
        params.has('date-to') && params.delete('date-to');
    }

    const newUrl = location.origin + location.pathname + '?' + params.toString();
    if (location.href !== newUrl) {
        location.href = newUrl;
    }
};

function controlStatusDropdown() {
    const wrapperStatus = document.getElementById('wrapper-status');
    const statusList = document.getElementById('list-status');
    const statusInput = document.getElementById('input-status');
    const statusInputText = document.getElementById('input-status-text');

    wrapperStatus.addEventListener('click', () => {
        wrapperStatus.classList.toggle('_active');
        statusList.classList.toggle('_active');
    });

    window.handleDropdownOptionClick = (value, label) => {
        statusInput.value = value;
        statusInputText.innerText = label;
    };
}

function controlPageUtils() {
    const btnPageFirst = document.getElementById('btn-page-first');
    const btnPagePrevious = document.getElementById('btn-page-previous');
    const btnPageNext = document.getElementById('btn-page-next');
    const btnPageLast = document.getElementById('btn-page-last');
    const currentPageInput = document.getElementById('current-page-input');
    const currentPageNumber = parseInt(currentPageInput.value);
    const pagesCount = parseInt(document.getElementById('pages-count').innerText);
    const params = new URLSearchParams(location.search);

    currentPageInput.onkeydown = (e) => {
        if (e.key === 'Enter') {
            params.set('page-number', currentPageInput.value);
            redirectToNewPage();
        }
    };

    if (btnPageFirst) {
        btnPageFirst.onclick = () => {
            params.set('page-number', '1');
            redirectToNewPage();
        };

        btnPagePrevious.onclick = () => {
            params.set('page-number', (currentPageNumber - 1).toString());
            redirectToNewPage();
        };
    }

    if (btnPageNext) {
        btnPageNext.onclick = () => {
            params.set('page-number', (currentPageNumber + 1).toString());
            redirectToNewPage();
        };

        btnPageLast.onclick = () => {
            params.set('page-number', pagesCount.toString());
            redirectToNewPage();
        };
    }

    function redirectToNewPage() {
        location.href = location.origin + location.pathname + '?' + params.toString();
    }
}
