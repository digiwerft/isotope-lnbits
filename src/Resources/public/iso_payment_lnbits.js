function ajaxRequest(url, callback) {
    let request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            callback(request.responseText);
        }
    };
    request.send();
}

let paymentId = document.getElementById('paymentId').value;
let paymentHash = document.getElementById('paymentHash').value;
let successUrl = document.getElementById('successUrl').value;
let qrHolder = document.querySelectorAll('.flip-box')[0];
let copyButton = document.getElementById('lnbitsCopyInvoiceButton');
let invoice = document.getElementById('invoiceLink').getAttribute(['data-invoice']);

copyButton.addEventListener('click', function () {
    navigator.clipboard.writeText(invoice);
});


function sendRequest() {
    ajaxRequest('/lnbits-check-payment?id=' + paymentId + '&hash=' + paymentHash, function (response) {
        paid = JSON.parse(response);
        if (paid.paid === true) {
            qrHolder.classList.add('paid');
            window.setTimeout(function () {
                window.location.href = successUrl;
            }, 500);
        } else {
            window.setTimeout(sendRequest, 400);
        }
    });
}

sendRequest();