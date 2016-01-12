$(document).ready(function () {
    $(".add-to-cart").click(function () {
        var id = $(this).attr("data-id");
        $.post("/shop/cart/addAjax/"+id, {}, function (data) {
            $("#cart-count").html(data);

        });
        return false;
    });
});
