var device_width = $(window).width();
if (device_width <= "456") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-3');
}
else if (device_width <= "750") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-3');
}
else if (device_width <= "1000") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-4');
}
else if (device_width <= "1280") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-5');
}
else {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-8');
}

$(window).resize(function(){
var device_width = $(window).width();
if (device_width <= "456") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-3');
}
else if (device_width <= "750") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-3');
}
else if (device_width <= "1000") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-4');
}
else if (device_width <= "1280") {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-5');
}
else {
    $('html').removeClass(function (index, css) {
        return (css.match (/(^|\s)columns-\S+/g) || []).join(' ');
    });
    $('html').addClass('columns-8');
}
});