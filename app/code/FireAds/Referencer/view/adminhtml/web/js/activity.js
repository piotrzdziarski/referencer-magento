const inputMonth = document.getElementById('input-month');
const inputMonthText = document.getElementById('input-month-text');
const inputYear = document.getElementById('input-year');
const inputYearText = document.getElementById('input-year-text');
const wrappersInput = document.getElementsByClassName('wrapper-input');
const form = document.getElementById('form');

for (let i = 0; i < wrappersInput.length; i++) {
    wrappersInput[i].onclick = () => {
        wrappersInput[i].classList.toggle('_active');
        wrappersInput[i].getElementsByClassName('list-status')[0].classList.toggle('_active');
    };
}

window.handleMonthOptionClick = (i, label) => {
    inputMonth.value = i;
    inputMonthText.innerText = label;
};

window.handleYearOptionClick = (year) => {
    inputYear.value = year;
    inputYearText.innerText = year;
};

form.onsubmit = (e) => {
    e.preventDefault();
    const params = new URLSearchParams(location.search);

    if (inputMonth.value) {
        params.set('month', inputMonth.value);
    } else {
        params.has('month') && params.delete('month');
    }

    if (inputYear.value) {
        params.set('year', inputYear.value);
    } else {
        params.has('year') && params.delete('year');
    }

    const newUrl = location.origin + location.pathname + '?' + params.toString();
    if (location.href !== newUrl) {
        location.href = newUrl;
    }
};
