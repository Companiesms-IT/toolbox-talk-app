$(function () {
    var url = window.location.href;
    var element = $('.topmenubox > ul a').filter(function () {
        return this.href === url;
    }).addClass('activenavlink').parent().addClass('activeLi');
    element.parents('ul').addClass('ul_Active').slideDown(100);
    element.parents('li').addClass('activeCustom_Nav');
    $('.topmenubox > ul a').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass("activenavlink")) {
            $("ul", $this.parents("ul:first")).slideUp(200).removeClass("ulBock");
            $("a", $this.parents("ul:first")).removeClass("activenavlink");
            $this.next("ul").slideDown(100).addClass("ulBock");
            $this.addClass("activenavlink");
        } else {
            $this.removeClass("activenavlink");
            $this.next("ul").slideUp(100).removeClass("ulBock");
        }
    });
});
