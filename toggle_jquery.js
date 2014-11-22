$(function () {
    var toggle_speed_half = Math.round(toggle_speed / 2),
        toggle_before = "<a class=\"toggle-link\" href=\"#\">"+toggle_out+"</a>";
    if(toggle_img)
        toggle_before = "<img class=\"toggle-link\" src=\""+toggle_out+"\">"
    $('.toggle-content').fadeOut(0).before(toggle_before);
    $('body').on({
        click: function(event) {
            event.preventDefault();
            var toggle_item = $(this).next('.toggle-content').eq(0),
                that = $(this),
                toggle_out_in = toggle_out;
            if(toggle_item.is(':hidden')) {
                toggle_item.fadeIn(toggle_speed);
                toggle_out_in = toggle_in;
            } else {
                toggle_item.fadeOut(toggle_speed);
            };
            that.animate({opacity : 0},toggle_speed_half,function() {
                if(toggle_img) that.attr('src',toggle_out_in);
                else that.text(toggle_out_in);
                that.animate({opacity : 1},toggle_speed_half);
            });
        }
    },'.toggle-link');
});
