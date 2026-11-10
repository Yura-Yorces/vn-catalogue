document.addEventListener('submit', (e) => {
    const btn = e.submitter;
    const form = btn?.form;
    if (! form) return;

    let msg = btn?.dataset.confirm;

    // allow a <select data-confirm-label> to inject its current option text
    const select = form.querySelector('select[data-confirm-label]');
    if (select && msg) {
        msg = msg.replace('%s', select.options[select.selectedIndex].text);
    }

    if (msg && ! confirm(msg)) {
        e.preventDefault();
    }
});
