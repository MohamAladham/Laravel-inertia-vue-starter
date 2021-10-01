const serverErrorMsg = 'حدث خطأٌ من طرف الخادم، يرجى إعادة المحاولة.';

function generalOnSuccess(text = '', heading = '', callback = undefined, autoDismiss = true) {
    heading = heading ? heading : 'تمت حفظ البيانات بنجاح!';
    text = text ? text : 'سيتم تحويلك تلقائياً..';

    Swal.fire({
        title: heading,
        text: text,
        type: "success",
        confirmButtonText: "موافق",
        showCancelButton: 0,
        confirmButtonColor: "#7367f0",
    });

    if (autoDismiss) {
        setTimeout(function () {
            Swal.close();
            if (callback !== undefined) {
                callback();
            }
        }, 1500);
    }
}

function generalOnُError(text = '', heading = '') {
    heading = heading ? heading : 'خطأ';
    text = text ? text : 'لم يتم حفظ البيانات بنجاح';

    if (typeof text === 'object') {
        text = Object.values(text).join('<br>');
    }

    Swal.fire({
        title: heading,
        html: text,
        type: "error",
        confirmButtonText: "موافق",
        showCancelButton: 0,
        confirmButtonColor: "#7367f0",
        cancelButtonColor: "#f46a6a"
    });
}


function confirm(text = '', callback) {
    let title = 'هل أنت متأكد';
    text = text ? text : 'هل أنت متأكد';
    Swal.fire({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#f46a6a",
        cancelButtonColor: "#7367f0",
        cancelButtonText: "إلغاء الأمر",
        confirmButtonText: "تأكيد"
    }).then(function (t) {
        if (t.value) {
            return callback();
        }
    });
}

function initSelect2() {
    $('.select2').select2();
}


$(document).ready(function () {
    initSelect2();
});


document.addEventListener('inertia:finish', (event) => {
    initSelect2();
})


function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}


function prepareFilterParameters(filter) {
    let filterKeys = Object.keys(filter);

    filterKeys.forEach(function (key) {
        filter[key] = getParameterByName(key) ? getParameterByName(key) : filter[key];
    });

    return filter;
}
