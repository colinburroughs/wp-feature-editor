var HoboAdblockDetection = function (options) {
    var self = this;
    this._options = {
        marker: 'h' + (Math.random() * 1e32).toString(36)
    };
    this._hasAdBlock = false;
    if (options !== undefined) {
        this.setOptions(options);
    }
    var onLoadCallback = function () {
        setTimeout(function () {
            self._hasAdBlock = self.hasAdBlocker();
            if (self._hasAdBlock) {
                jQuery(function ($) {
                    $(".uklqfrjjcysfnmi-back").on('click', function () {
                        $(".uklqfrjjcysfnmi-choices").hide();
                        $(".uklqfrjjcysfnmi-main").css('display', 'flex');
                        return false;
                    });
                    $(".uklqfrjjcysfnmi-close-popup").on('click', function () {
                        $("#uklqfrjjcysfnmi-overlay").hide();
                        $(".uklqfrjjcysfnmi-back").unbind('click');
                        $(".uklqfrjjcysfnmi-button-disable").unbind('click');
                        $(this).unbind('click');
                        self.flag();
                        return false;
                    });
                    $(".uklqfrjjcysfnmi-button-disable").on('click', function () {
                        $(".uklqfrjjcysfnmi-main").hide();
                        $(".uklqfrjjcysfnmi-choices").css('display', 'flex');
                        return false;
                    });
                    $("#uklqfrjjcysfnmi-overlay").css('display', 'flex');
                });
            }
        }, hobo_adblock_detect.delay);
    };
    if (window.addEventListener !== undefined) {
        window.addEventListener('load', onLoadCallback, false);
    } else {
        window.attachEvent('onload', onLoadCallback);
    }
};
HoboAdblockDetection.prototype.setOptions = function (options) {
    for (var option in options) {
        this._options[option] = options[option];
    }
    return this;
};
HoboAdblockDetection.prototype.hasAdBlocker = function () {
    var a = document.createElement('div');
    a.innerHTML = '&nbsp;';
    a.className = this._options.marker + ' pub_300x250 pub_300x250m pub_728x90 text-ad textAd text_ad text_ads text-ads text-ad-links';
    a.style = 'width: 1px !important; height: 1px !important; position: absolute !important; left: -100px !important; top: -100px !important;';
    var r = false;
    try {
        document.body.appendChild(a);
        var e = document.getElementsByClassName(this._options.marker)[0];
        if (e && (e.offsetHeight === 0 || e.clientHeight === 0)) r = true;
        if (window.getComputedStyle !== undefined) {
            var tmp = window.getComputedStyle(e, null);
            if (tmp && (tmp.getPropertyValue('display') === 'none' || tmp.getPropertyValue('visibility') === 'hidden')) r = true;
        }
        document.body.removeChild(a);
    } catch (e) {
        console.log(e);
    }
    return r;
};
HoboAdblockDetection.prototype.flag = function () {
    jQuery(function ($) {
        $.post(hobo_adblock_detect.ajaxurl, {action: 'set_ad_blocker_cookie'}, function (response) {
        });
    });
};

var hoboAdblockDetection = new HoboAdblockDetection();
