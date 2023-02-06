jQuery(document).on("click", "#openOriginalProductUrl", function(event) {
    event.preventDefault();
    var url = window.location.href;
    var indexStartPostID = url.indexOf('?post=');
    var indexEndPostId = url.indexOf('&');
    var postId = url.substring(indexStartPostID + 6, indexEndPostId);

    let searchSkuValue = postId;

    if (searchSkuValue) {
        jQuery.ajax({
            url: wooshark_params.ajaxurl,
            type: "POST",
            dataType: "JSON",
            data: {
                action: "get-product-by-id",
                searchSkuValue: searchSkuValue
            },
            success: function(data) {
                if (data && data.length == 1) {
                    window.open(data[0].productUrl, '_blank');
                }
            },
            error: function(err) {
                jQuery.toast({
                    text: 'cannot find original product url from aliexpress, please check if the product is imported using wooshark',
                    // It can be plain, fade or slide
                    textColor: "black", // text color
                    hideAfter: 7000,
                    icon: color == "red" ? "error" : "success",
                    stack: 5, // `false` to show one stack at a time count showing the number of toasts that can be shown at once
                    textAlign: "left", // Alignment of text i.e. left, right, center
                    position: isTop ? "top-right" : "bottom-right" // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                });
            },
            complete: function() {
                console.log("SSMEerr");
            }
        });
    }


});