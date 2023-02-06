var hostname = "https://wooshark.website",
    imagesFromDescription = [],
    items = "",
    globalClientWebsite = "",
    globalClientKey = "",
    globalClientSecretKey = "",
    formsToSave = "",
    savedCategories = [],
    generalPreferences = items ?
    items.generalPreferences : {
        importSalePriceGeneral: !1,
        importDescriptionGeneral: !0,
        importReviewsGeneral: !0,
        importVariationsGeneral: !0,
        reviewsPerPage: 10,
        setMaximimProductStock: 0,
        importShippingCost: !1
    },
    images = [];

function getImages(e) {
    return e;
}

function getItemSpecificfromTable(e, t) {
    var r = t,
        a = e.NameValueList.map(function(e) {
            return e.name;
        });
    return (
        r &&
        r.length &&
        r.forEach(function(t, r) {
            -1 == a.indexOf(t.attrName) &&
                e.NameValueList.push({
                    name: t.attrName || "-",
                    visible: !0,
                    variation: !1,
                    value: [t.attrValue]
                });
        }),
        e
    );
}

function getDescription(e, t) {
    fetch(
            "https://cors-anywhere.herokuapp.com/" +
            ("https://aeproductsourcesite.alicdn.com/product/description/pc/v2/en_EN/desc.htm?productId=" +
                e +
                "&key=Hf26e350fe48d45d3be4a05ec8e1ac9d2y.zip&token=4cc39c331004aa3153fe1623ffdc10c4")
        )
        .then(e => e.text())
        .then(e => {
            console.log("contents", response), t(e);
        })
        .catch(e => {
            t(!1);
        });
}

function getProductId(e) {
    var t = e.indexOf(".html");
    return e.substring(0, t).match(/\d+/)[0];
}
jQuery(document).on("click", "#goToExtension", function(e) {
        window.open("https://www.wooshark.com/aliexpress");
    }),
    jQuery(document).on("click", "#close-1", function(e) {
        jQuery("#section-1").hide();
    }),
    jQuery(document).on("click", "#close-2", function(e) {
        jQuery("#section-2").hide();
    });
var currentSku = "";

function importProductGlobally(e, t) {
    try {
        e &&
            ((currentSku = e),
                jQuery(this).attr("disabled", !0),
                jQuery(".importToS").each(function(e, t) {
                    console.log("----- disabling"), jQuery(t).attr("disabled", !0);
                }),
                startLoading(),
                getProductDetailsFromServer(e, t));
    } catch (e) {
        jQuery(".importToS").each(function(e, t) {
                console.log("----- un - disabling 2"), jQuery(t).attr("disabled", !1);
            }),
            displayToast(
                "cannot retrieve product id, please try again, if the issue persists, please contact wooebayimporter@gmail.com",
                "red"
            ),
            stopLoading();
    }
}

function searchProducts(e) {
    jQuery("#pagination").empty(),
        jQuery("#pagination").show(),
        jQuery("#product-search-container").empty();
    var t = getSelectedLanguage();
    jQuery(".loader2").css({
            display: "block",
            position: "fixed",
            "z-index": 9999,
            top: "50px",
            right: "50px",
            "border-radius": "35px",
            "background-color": "red"
        }),
        searchByKeyWord(searchKeyword, t, e);
}

function searchByKeyWord(e, t, r) {
    let a = jQuery("#searchKeyword").val(),
        i = jQuery('input[name="sort"]:checked')[0] ?
        jQuery('input[name="sort"]:checked')[0].value :
        "",
        o = jQuery("#highQualityItems").prop("checked"),
        n = jQuery("#isFreeShipping").prop("checked"),
        l = jQuery("#isFastDelivery").prop("checked"),
        s = getSelectedLanguage(),
        c = jQuery('input[name="currency"]:checked')[0] ?
        jQuery('input[name="currency"]:checked')[0].value :
        "";
    (xmlhttp = new XMLHttpRequest()),
    (xmlhttp.onreadystatechange = function() {
        if (4 == xmlhttp.readyState)
            if (200 === xmlhttp.status)
                try {
                    (data = JSON.parse(xmlhttp.response).data), console.log(data);
                    try {
                        var e = JSON.parse(data),
                            t = e.result.products;
                        if (
                            (t.forEach(function(e) {
                                    e && e.packageType ?
                                        jQuery(
                                            '<div class="card text-center" style="flex: 1 1 20%;border-radius: 10px">  <div class="card-body"><h5 class="card-title"> ' +
                                            e.productTitle.substring(0, 70) +
                                            '</h5><img src="' +
                                            e.imageUrl +
                                            '" width="150"  height="150"></img><div>Sale Price: <p class="card-text" style="color:red">' +
                                            e.salePrice +
                                            '</div></p>Sku: <p class="card-text" id="sku" ">' +
                                            e.productId +
                                            '</p><div><div><a  style="width:80%" id="importToShop" class="importToS btn btn-primary">Import to shop</a></div><div><a  style="width:80%; margin-top:5px"" id="addToWaitingList " disabled class=" btn btn-primary disabled">Add to waiting list (PREMUIM)</a></div><div><a target="_blank" style="width:80%; margin-top:5px" href="' +
                                            e.productUrl +
                                            '" class="btn btn-primary">Product url</a></div><h5 style="margin-top:5px; color:red"> discount: ' +
                                            e.discount +
                                            '</h5><h5 style="margin-top:5px"> packageType: ' +
                                            e.packageType +
                                            '</h5><h5 style="margin-top:5px"> local Price: ' + 
                                            e.localPrice +
                                            '</h5><h5 style="margin-top:5px; "> Product feedback: ' +
                                            e.evaluateScore +
                                            '</h5><h5 style="margin-top:5px; "> The number of sold products 30 days: ' +
                                            e.volume +
                                            "</h5></div></div></div>"
                                        ).appendTo("#product-search-container") :
                                        jQuery(
                                            '<div class="card text-center" style="flex: 1 1 20%; margin:15px;border-radius: 10px;">  <div class="card-body"><h5 class="card-title"> ' +
                                            e.productTitle.substring(0, 70) +
                                            '</h5><img src="' +
                                            e.imageUrl +
                                            '" width="150"  height="150"></img><div>Sale Price: <p class="card-text" style="color:red">' +
                                            e.salePrice +
                                            '</div></p>Sku: <p class="card-text" id="sku" ">' +
                                            e.productId +
                                            '</p><div><div><a  style="width:80%; font-size:8px" id="importToShop" class="importToS btn btn-primary">Import to shop</a></div><div><a  style="width:80%;font-size:8px; margin-top:5px"" id="addToWaitingList " disabled class=" btn btn-primary">Add to waiting list (PREMUIM)</a></div><div><a target="_blank" style="width:80%;font-size:8px; margin-top:5px" href="' +
                                            e.productUrl +
                                            '" class="btn btn-primary">Product url</a></div></div></div></div>'
                                        ).appendTo("#product-search-container");
                                }),
                                displayPAginationForSearchByKeyword(e.result.totalResults, r),
                                jQuery(".loader2").css({ display: "none" }),
                                t && t.length)
                        )
                            getAlreadyImportedProducts(
                                t.map(function(e) {
                                    return e.productId;
                                })
                            );
                    } catch (e) {
                        displayToast("Empty result for this search keyword", "red"),
                            jQuery(".loader2").css({ display: "none" }),
                            displayPAginationForSearchByKeyword(1e3, r);
                    }
                } catch (e) {
                    jQuery(".loader2").css({ display: "none" }),
                        displayPAginationForSearchByKeyword(1e3, r);
                }
            else
                displayToast(
                    "Error while getting results, please try again, if issue persist, please contact wooshark support ",
                    "red"
                ),
                jQuery(".loader2").css({ display: "none" }),
                displayPAginationForSearchByKeyword(1e3, r);
    }),
    xmlhttp.open("POST", hostname + ":8002/searchAliExpressProductNewApi", !0),
        xmlhttp.setRequestHeader("Content-Type", "application/json"),
        xmlhttp.send(
            JSON.stringify({
                searchKeyword: a,
                pageNo: r,
                language: s,
                sort: i,
                highQualityItems: o,
                currency: c,
                isFreeShipping: n,
                isFastDelivery: l
            })
        );
}

function save_options(e, t, r, a) {}

function gettototitiName(e) {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "get_totottitiNAme" },
        success: function(t) {
            (globalTitiToto = t), e(globalTitiToto);
        },
        error: function(e) {
            console.log("****err", e);
        },
        complete: function() {
            console.log("SSMEerr");
        }
    });
}

function loadOrders() {}

function getProductCountDraft() {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "getProductsCountDraft" },
        success: function(e) {
            console.log("----response", e);
            let t = e;
            jQuery('.nav-item a[id="pills-draft-tab"]').html(
                'Out of stock products <span class="badge badge-light">' + t + "</span>"
            );
        },
        error: function(e) {
            console.log("****err", e),
                displayToast(e.responseText, "red"),
                stopLoading();
        },
        complete: function() {
            console.log("SSMEerr"), stopLoading();
        }
    });
}

function getProductsCount() {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "getProductsCount" },
        success: function(e) {
            console.log("----response", e),
                displayPaginationSection((totalproductsCounts = e), 1);
        },
        error: function(e) {
            console.log("****err", e),
                displayToast(e.responseText, "red"),
                stopLoading();
        },
        complete: function() {
            console.log("SSMEerr"), stopLoading();
        }
    });
}

function displayToast(e, t, r) {
    jQuery.toast({
        text: e,
        textColor: "black",
        hideAfter: 7e3,
        icon: "red" == t ? "error" : "success",
        stack: 5,
        textAlign: "left",
        position: r ? "top-right" : "bottom-right"
    });
}

function isNotConnected() {
    jQuery("#not-connected").show(), jQuery("#connected").hide();
}
jQuery(document).on("click", ".product-page-item", function(e) {
        jQuery("#product-pagination").empty(),
            jQuery("#product-pagination").show(),
            jQuery(".loader2").css({
                display: "block",
                position: "fixed",
                "z-index": 9999,
                top: "50px",
                right: "50px",
                "border-radius": "35px",
                "background-color": "green"
            });
        var t = 1;
        try {
            (t = parseInt(jQuery(this)[0].innerText)),
            displayPaginationSection(totalproductsCounts, t),
                getAllProducts(t);
        } catch (e) {
            (t = 1),
            displayToast(
                    "error while index selection, please contact wooshark, wooebayimporter@gmail.com",
                    "red"
                ),
                jQuery(".loader2").css({ display: "none" });
        }
    }),
    jQuery(document).on("click", ".page-item", function(e) {
        var t = 1;
        try {
            t = parseInt(jQuery(this)[0].innerText);
        } catch (e) {
            (t = 1),
            displayToast(
                "error while index selection, please contact wooshark, wooebayimporter@gmail.com",
                "red"
            );
        }
        searchProducts(t);
    }),
    jQuery(document).on("click", "#seachProductsButton", function(e) {
        searchProducts(1);
    }),
    jQuery(document).on("click", "#discoverFeatures", function(e) {
        jQuery("#discoverFeatureContent").is(":hidden") ?
            jQuery("#discoverFeatureContent").show() :
            jQuery("#discoverFeatureContent").hide();
    }),
    jQuery(document).on("click", "#displayConnectToStore", function(e) {
        jQuery("#connect-to-store").is(":hidden") ?
            jQuery("#connect-to-store").show() :
            jQuery("#connect-to-store").hide();
    }),
    jQuery(document).on("click", "#importProductToShopByUrl", function(e) {
        var t = jQuery("#productUrl").val();
        if (t) {
            var r = getProductId(t);
            prepareModal(),
                r ?
                importProductGlobally(r) :
                displayToast("Cannot get product sku", "red");
        }
    }),
    jQuery(document).on("click", "#apply-connect-automatic", function(e) {
        console.log(
            store_url +
            endpoint +
            "?app_name=" +
            params.app_name +
            "&scope=" +
            params.scope +
            "&user_id=" +
            params.user_id +
            "&return_url=" +
            params.return_url +
            "&callback_url=" +
            params.callback_url
        );
    }),
    jQuery(document).on("click", "#importProductToShopBySky", function(e) {
        var t = jQuery("#productSku").val();
        prepareModal(),
            t ?
            importProductGlobally(t) :
            displayToast("Cannot get product sku", "red");
    }),
    jQuery(document).ready(function() {
        jQuery('.nav-item a[id="pills-advanced-tab"]').html(
                jQuery('.nav-item a[id="pills-advanced-tab"]').text() +
                '<span   class="badge badge-light"> <i class="fas fa-star"></i> </span>'
            ),
            jQuery("#searchKeyword").val(""),
            restoreConfiguration(),
            getProductsCount(),
            searchByKeyWord("", "en", 1),
            getAllProducts(1);
    });
var isAuthorizedUser = !1,
    currentProductId = "";
jQuery(document).on("click", "#insert-product-reviews", function(e) {
        currentProductId = jQuery(this).parents("tr")[0].cells[2].innerText;
    }),
    jQuery(".modal").on("hidden.bs.modal", function(e) {
        jQuery(this).removeData();
    });
var index = 0;
jQuery(document).on("click", "#addReview", function(e) {
    console.log("hndle ui-sortable-handle", jQuery(".wp-heading-inline")),
        e.preventDefault(),
        jQuery("#table-reviews tbody").append(
            '<tr><td style="width:65%"  contenteditable> <div id="editorReview' +
            index +
            '"> </div> </td><td contenteditable style="width:10%"> test@test.com </td></td><td contenteditable style="width:10%">' +
            getUsername() +
            '</td><td contenteditable style="width:10%">' +
            new Date().toISOString().slice(0, 10) +
            '</td></td><td style="width:5%"><input style="width:100%" type="number" min="1" max="5" value="5"></td><td><button class="btn btn-danger" id="removeReview">X</button></td></tr>'
        ),
        jQuery("#table-reviews tr td[contenteditable]").css({
            border: "1px solid #51a7e8",
            "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
        });
});
let totalproductsCounts = 1;

function displayPAginationForSearchByKeyword(e, t) {
    var r = Math.round(e / 40);
    r > 17 && (r = 17);
    for (var a = 1; a < r; a++)
        a == t ?
        jQuery(
            ' <li style="color:red" id="page-' +
            a +
            '" class="page-item"><a style="color:red" class="page-link">' +
            a +
            "</a></li>"
        ).appendTo("#pagination") :
        jQuery(
            ' <li id="page-' +
            a +
            '" class="page-item"><a class="page-link">' +
            a +
            "</a></li>"
        ).appendTo("#pagination");
}

function displayPaginationSection(e, t) {
    let r = Math.ceil(e / 20);
    r > 20 && (r = 20);
    for (var a = 1; a < r + 1; a++)
        a == t ?
        jQuery(
            ' <li style="color:red" id="product-page-' +
            a +
            '" class="product-page-item"><a style="color:red" class="page-link">' +
            a +
            "</a></li>"
        ).appendTo("#product-pagination") :
        jQuery(
            ' <li id="product-page-' +
            a +
            '" class="product-page-item"><a class="page-link">' +
            a +
            "</a></li>"
        ).appendTo("#product-pagination");
    jQuery('.nav-item a[id="pills-connect-products"]').html(
        'products <span class="badge badge-light">' + e + "</span>"
    );
}

function getAllProducts(e) {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "get_all_products", paged: e },
        success: function(e) {
            if ((console.log("----response", e), e)) {
                var t = jQuery("#products-wooshark");
                t.find("tbody tr").remove(),
                    e.forEach(function(e, r) {
                        0;
                        e.lastUpdated;
                        t.append(
                            "<tr><td ><img style='border:1px solid grey' width='80px' height='80px' src=" +
                            e.image +
                            "></img></td><td>" +
                            e.sku +
                            "</td><td>" +
                            e.id +
                            "</td> <td>" +
                            e.title.substring(0, 50) +
                            ' <div style="color:blue"> ( ' +
                            e.status +
                            " ) </div></td><td><button class='btn btn-primary' ><a style='color:white' href=" +
                            e.productUrl +
                            "  target='_blank'> Original product url </a></button></td><td><button class='btn btn-primary' style='width:100%' id='sync-product-stock-and-price' disabled><a style='color:white'  target='_blank' > Update product stock and price <small style='color:red'> PREMUIM</small> </a></button></td><td><button class='btn btn-default disabled' id='insert-product-reviews' style='width:100%'><a style='color:white'  data-toggle='modal' data-target='#myModalReviews'> Insert Reviews <small style='color:red'>(PREMUIM) </small> </a></button></td></tr>"
                        );
                    });
            }
        },
        error: function(e) {
            console.log("****err", e),
                displayToast(e.responseText, "red"),
                stopLoading();
        },
        complete: function() {
            console.log("SSMEerr"), stopLoading();
        }
    });
}

function startLoading(e) {
    e || (e = "loader2"),
        jQuery("." + e).css({
            display: "block",
            position: "fixed",
            "z-index": 9999,
            top: "50px",
            right: "50px",
            "border-radius": "35px",
            "background-color": "black"
        });
}

function stopLoading(e) {
    e || (e = "loader2"), jQuery("." + e).css({ display: "none" });
}

function prepareDataFormat(e, t, r, a) {
    if (
        e &&
        e.variations &&
        e.NameValueList &&
        e.variations.length &&
        e.NameValueList.length
    )
        return (
            e.NameValueList.forEach(function(e) {
                e.name && (e.name = e.name.toLowerCase().replace(/ /g, "-")),
                    (e.values = e.value);
            }),
            e.variations.forEach(function(e) {
                e.attributesVariations &&
                    e.attributesVariations.forEach(function(e) {
                        e.name && (e.name = e.name.toLowerCase().replace(/ /g, "-"));
                    }),
                    e.regularPrice &&
                    jQuery("#applyPriceFormulawhileImporting").prop("checked") &&
                    (e.regularPrice = calculateAppliedPrice(e.regularPrice)),
                    e.salePrice &&
                    jQuery("#applyPriceFormulawhileImporting").prop("checked") &&
                    (e.salePrice = calculateAppliedPrice(e.salePrice)),
                    (e.availQuantity = parseInt(e.availQuantity)),
                    (e.identifier = "");
            }),
            e
        );
    if (e && e.variations && e.variations.length && 1 == e.variations.length) {
        return {
            NameValueList: [
                { name: "color", values: ["Standard"], variation: !0, visible: !0 }
            ],
            variations: [{
                SKU: e.variations[0].SKU,
                regularPrice: e.variations[0].regularPrice,
                salePrice: e.variations[0].salePrice,
                availQuantity: e.variations[0].availQuantity,
                attributesVariations: [{ name: "color", value: "Standard" }]
            }]
        };
    }
}

function getProductDetailsFromServer(e) {
    var t = getSelectedLanguage(),
        r = jQuery('input[name="currency"]:checked')[0] ?
        jQuery('input[name="currency"]:checked')[0].value :
        "USD",
        a = new XMLHttpRequest();
    (a.onreadystatechange = function() {
        if (4 == this.readyState)
            if (200 === this.status) {
                if ((r = JSON.parse(this.response).data)) {
                    var t = [];
                    jQuery(".categories input:checked").each(function() {
                        t.push(
                            jQuery(this)
                            .attr("value")
                            .trim()
                        );
                    });
                    (waitingListProducts = []),
                    jQuery(".importToS").each(function(e, t) {
                            console.log("----- un - disabling"),
                                jQuery(t).attr("disabled", !1);
                        }),
                        jQuery("#importModal").click(),
                        stopLoading(),
                        fillTheForm(r, e);
                }
            } else {
                var r = JSON.parse(this.response).data;
                jQuery(".importToS").each(function(e, t) {
                        console.log("----- un - disabling"), jQuery(t).attr("disabled", !1);
                    }),
                    displayToast("Cannot insert product into shop " + r, "red"),
                    stopLoading();
            }
    }),
    a.open("POST", hostname + ":8002/getProductDEtailsFRomOurInternalApi", !0),
        a.setRequestHeader("Content-Type", "application/json"),
        a.send(
            JSON.stringify({
                sku: e,
                language: t,
                isBasicVariationsModuleUsedForModalDisplay: !0,
                currency: r,
                store: document.location.origin,
                activationCode: jQuery("#licenseValue").val()
            })
        );
}

function getCategories(e) {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "get_categories" },
        success: function(t) {
            console.log("----response", t), (savedCategories = t), e();
        },
        error: function(t) {
            console.log("****err", t),
                displayToast(t.responseText, "red"),
                stopLoading(),
                e();
        },
        complete: function() {
            console.log("SSMEerr"), stopLoading(), e();
        }
    });
}

function getCreationDate(e) {
    e = dates[Math.floor(Math.random() * dates.length)];
    var t = dates.indexOf(e);
    return dates.splice(t, 1), e;
}

function getUsername() {
    var e = names[Math.floor(Math.random() * names.length)],
        t = names.indexOf(e);
    return names.splice(t, 1), e;
}
jQuery(document).on("click", "#select-category", function(e) {
    jQuery(".categories").is(":hidden") ?
        (jQuery(".categories").show(),
            getCategories(function() {
                console.log("-----");
            })) :
        jQuery(".categories").hide();
});
var names = [
    "Craig Piro",
    "Cindi Mcfarlin",
    "Maximilien Chopin",
    "Alfonso Villapol",
    "Gayla Tincher",
    "Lelah Pelosi",
    "Kholmatzhon Daniarov",
    "Klemens Totleben",
    "Émeric Figuier",
    "Joseph Garreau",
    "Moriya Masanobu",
    "Fernand Aveline",
    "Germain Beaumont",
    "Finn Junkermann",
    "Benoît Cortot",
    "Kawano Tanyu",
    "Gérald Noir",
    "Lisabeth Brennen",
    "Jaqueline Phipps",
    "Roderick Roth",
    "Adella Tarry",
    "Rudolf Kirsch",
    "Fritz Filippi",
    "Gérald Courbet",
    "Dastan Nurbolatev",
    "Oscar Álvarez",
    "Devon Huntoon",
    "Marlen Akhmetov",
    "Cassey Odle",
    "Patty Balser",
    "Néo Lortie",
    "Dieter Krist",
    "Speranzio Bartolone",
    "Iside Casaletto",
    "Durante Sciara",
    "Ildefonso Sollami",
    "Xose Mendez",
    "Vladimiro De Angelo",
    "Gianmaria De Sario",
    "Anacleto Adornetto",
    "Sigmund Bruckmann",
    "Valtena Amodei",
    "Liberatore Accordino",
    "Alfredo Lamanna",
    "Kemberly Roza",
    "Lluciano Marcos",
    "Fukumoto Shusake",
    "Branda Goshorn",
    "Isadora Heer",
    "Micael Montes",
    "Derrick Sclafani",
    "Thibault Silvestre",
    "Wendelin Jonas",
    "Coleen Dragon",
    "Ted Basye",
    "Emmanuel Gillie",
    "Lorean Soni",
    "Reiko Jeanlouis",
    "Olevia Lauder",
    "Savannah Brotherton",
    "Franchesca Schwebach",
    "Chae Jiang",
    "Jaimee Harter",
    "Windy Milnes",
    "Takako Ream",
    "Zoraida Swick",
    "Mammie Aguiniga",
    "Wendi Raver",
    "Clarita Pursell",
    "Diedra Spath",
    "Tandy Hoyte",
    "Lanie Edwin",
    "Marchelle Dowden",
    "Susann Masson",
    "Jannette Wilmes",
    "Lakisha Mullenix",
    "Shanda Gatling",
    "Kathi Okamura",
    "Ellie Julius",
    "Demarcus Mcmullen",
    "Major Woodrum",
    "Alpha Um",
    "Prudence Rodden",
    "Shante Dezern",
    "Emma Carra",
    "Starr Lheureux",
    "Verline Cordon",
    "Carla Poole",
    "Alisa Watts",
    "Maariya Kramer",
    "Aamir Boyd",
    "Antonio Levine",
    "Della Drew",
    "Miriam Perry",
    "Sarina Santos",
    "Armaan Ellison",
    "Graham Rankin",
    "Aasiyah Haney",
    "Debbie Tanner",
    "Yuvraj Wolf",
    "Eleri Barnes",
    "Ira Forster",
    "Gage Edmonds",
    "Nour Hartman",
    "Niam Mullins",
    "Mahi Reid",
    "Winston Hyde",
    "Rosalie Robertson",
    "Samirah Hood",
    "Bonnie Montes",
    "Aliya Fernandez",
    "Renesmae Knapp",
    "Enrique Lutz",
    "Korey Wu",
    "Andrea Xiong",
    "Daanyal Shepard",
    "Efan Wharton"
];

function insertReviewsIntoWordpress(e, t) {
    startLoading(),
        jQuery.ajax({
            url: wooshark_params.ajaxurl,
            type: "POST",
            dataType: "JSON",
            data: { action: "insert-reviews-to-productRM", post_id: t, reviews: e },
            success: function(e) {
                e && !e.error && e.insertedSuccessfully && e.insertedSuccessfully.length ?
                    displayToast(
                        e.insertedSuccessfully.length +
                        " reviews are imported successfully",
                        "black"
                    ) :
                    displayToast("Error while uploading reviews.", "red"),
                    stopLoading(),
                    jQuery("#table-reviews tbody").empty();
            },
            error: function(e) {
                console.log("****err", e),
                    stopLoading(),
                    e && e.responseText && displayToast(e.responseText, "red");
            }
        });
}
jQuery(document).on("click", "#confirmReviewInsertion", function(e) {
    e.preventDefault();
    var t = getReviews();
    (postId = currentProductId),
    console.log("---------reviews", t),
        console.log("---------postId", postId),
        postId ?
        insertReviewsIntoWordpress(t, postId) :
        displayToast("cannot get post id, please contact wooshark", "red");
});
var dates = [
    "2018-10-26",
    "2019-1-1",
    "2018-11-15",
    "2018-11-6",
    "2019-01-7",
    "2019-1-13",
    "2019-2-12",
    "2019-1-17",
    "2018-2-19",
    "2019-3-16",
    "2019-1-14",
    "2018-2-25",
    "2019-3-5",
    "2018-1-18",
    "2019-2-22",
    "2018-1-11",
    "2018-12-12",
    "2018-11-8",
    "2019-1-2",
    "2019-01-13",
    "2019-05-19",
    "2019-04-29",
    "2019-06-12",
    "2019-07-01",
    "2019-06-23",
    "2019-05-24",
    "2018-10-29",
    "2019-3-3",
    "2019-1-7",
    "2018-10-27",
    "2019-2-17",
    "2019-05-24",
    "2019-06-06",
    "2019-06-19",
    "2019-06-22",
    "2019-06-13",
    "2019-05-13",
    "2019-07-01",
    "2019-04-25",
    "2019-04-04",
    "2019-05-05",
    "2019-05-19",
    "2019-06-01",
    "2019-05-27",
    "2019-03-27",
    "2019-04-01",
    "2019-05-30",
    "2019-06-04"
];

function getReviews() {
    var e = jQuery("#customReviews tbody tr"),
        t = [];
    return (
        e.each(function(e, r) {
            e &&
                t.push({
                    review: r.cells[0].innerHTML || "-",
                    rating: jQuery(r)
                        .find("input")
                        .val() || 5,
                    datecreation: r.cells[2].outerText,
                    username: r.cells[1].outerText || "unknown",
                    email: r.cells[4].outerText &&
                        !r.cells[4].outerText.includes("emailNotVisible@unknown.com") ?
                        r.cells[4].outerText : "emailNotVisible@unknown.com"
                });
        }),
        t
    );
}
jQuery(document).on("click", "#removeReview", function(e) {
        let t = jQuery(this)
            .parents("tr")
            .index();
        jQuery(this)
            .parents("tr")
            .remove(),
            quillsArray.splice(t, 1);
    }),
    jQuery(document).on("click", "#searchBySku", function(e) {
        jQuery("#product-pagination").empty(),
            jQuery(".loader2").css({
                display: "block",
                position: "fixed",
                "z-index": 9999,
                top: "50px",
                right: "50px",
                "border-radius": "35px",
                "background-color": "red"
            });
        let t = jQuery("#skusearchValue").val();
        t
            ?
            jQuery.ajax({
                url: wooshark_params.ajaxurl,
                type: "POST",
                dataType: "JSON",
                data: { action: "search-product-by-sku", searchSkuValue: t },
                success: function(e) {
                    if ((stopLoading(), e)) {
                        var t = jQuery("#products-wooshark");
                        t.find("tr:not(.thead)").remove(),
                            e.forEach(function(e, r) {
                                t.append(
                                    "<tr><td ><img style='border:1px solid grey' width='80px' height='80px' src=" +
                                    e.image +
                                    "></img></td><td>" +
                                    e.sku +
                                    "</td><td>" +
                                    e.id +
                                    "</td> <td>" +
                                    e.title.substring(0, 50) +
                                    ' <div style="color:blue"> ( ' +
                                    e.status +
                                    " ) </div></td><td><button class='btn btn-primary' ><a style='color:white' href=" +
                                    e.productUrl +
                                    "  target='_blank'> Original product url </a></button></td><td><button class='btn btn-primary' id='sync-product-stock-and-price' disabled><a style='color:white'  target='_blank'  > Update product stock and price <small style='color:red'> PREMUIM</small> </a></button></td><td><button class='btn btn-success' id='insert-product-reviews' style='width:100%'><a style='color:white'  data-toggle='modal' data-target='#myModalReviews'> Insert Reviews </a></button></td></tr>"
                                );
                            });
                    }
                },
                error: function(e) {
                    e && e.responseText && displayToast(e.responseText, "red"),
                        stopLoading();
                },
                complete: function() {
                    console.log("SSMEerr"), stopLoading();
                }
            }) :
            getAllProducts(1);
    });
var quill,
    quillsArray = [];

function handleServerResponseReviews(e) {
    200 === e ?
        (displayToast("Reviews imported successfully", "black"),
            jQuery(".loader2").css({ display: "none" })) :
        (displayToast("Error while inserting the product", "red"),
            jQuery(".loader2").css({ display: "none" }));
}

function importProductGloballyBulk(e, t) {
    try {
        e &&
            ((currentSku = e),
                jQuery(this).attr("disabled", !0),
                jQuery(".importToS").each(function(e, t) {
                    console.log("----- disabling"), jQuery(t).attr("disabled", !0);
                }),
                startLoading(),
                getProductDetailsFromServerBulk(e, t));
    } catch (e) {
        jQuery(".importToS").each(function(e, t) {
                console.log("----- un - disabling 2"), jQuery(t).attr("disabled", !1);
            }),
            displayToast(
                "cannot retrieve product id, please try again, if the issue persists, please contact wooebayimporter@gmail.com",
                "red"
            ),
            stopLoading();
    }
}

function getSelectedLanguage() {
    return jQuery('input[name="language"]:checked')[0] ?
        jQuery('input[name="language"]:checked')[0].value :
        "en";
}

function getProductDetailsFromServerBulk(e) {
    var t = getSelectedLanguage(),
        r = jQuery('input[name="currency"]:checked')[0] ?
        jQuery('input[name="currency"]:checked')[0].value :
        "USD",
        a = new XMLHttpRequest();
    (a.onreadystatechange = function() {
        if (4 == this.readyState)
            if (200 === this.status) {
                if ((a = JSON.parse(this.response).data)) {
                    var t = [];
                    jQuery(".categories input:checked").each(function() {
                        t.push(
                            jQuery(this)
                            .attr("value")
                            .trim()
                        );
                    });
                    var r = t;
                    (waitingListProducts = []),
                    jQuery(".importToS").each(function(e, t) {
                            console.log("----- un - disabling"),
                                jQuery(t).attr("disabled", !1);
                        }),
                        stopLoading();
                    let i = jQuery("#textToBeReplaced").val(),
                        o = jQuery("#textToReplace").val(),
                        n = a.title,
                        l = a.description;
                    i &&
                        o &&
                        ((n = a.title.replace(i, o)), (l = a.description.replace(i, o))),
                        addToWaitingList({
                            title: n,
                            description: l,
                            images: a.images,
                            variations: prepareDataFormat(
                                a.variations,
                                a.currentPrice,
                                a.originalPrice,
                                a.totalAvailQuantity
                            ),
                            productUrl: a.productUrl,
                            productCategoies: r,
                            importSalePrice: !0,
                            simpleSku: e.toString(),
                            featured: !0,
                            mainImage: a.mainImage
                        });
                }
            } else
                try {
                    var a = JSON.parse(this.response).data;
                    jQuery(".importToS").each(function(e, t) {
                            console.log("----- un - disabling"), jQuery(t).attr("disabled", !1);
                        }),
                        displayToast("Cannot insert product into shop " + a, "red"),
                        stopLoading();
                } catch (e) {
                    jQuery(".importToS").each(function(e, t) {
                            console.log("----- un - disabling"), jQuery(t).attr("disabled", !1);
                        }),
                        displayToast("Cannot get product details, please try again", "red"),
                        stopLoading();
                }
    }),
    a.open("POST", hostname + ":8002/getProductDEtailsFRomOurInternalApi", !0),
        a.setRequestHeader("Content-Type", "application/json"),
        a.send(
            JSON.stringify({
                sku: e,
                language: t,
                isBasicVariationsModuleUsedForModalDisplay: !1,
                currency: r,
                store: document.location.origin,
                activationCode: jQuery("#licenseValue").val()
            })
        );
}

function getHtmlDescription(e) {
    if (e) {
        var t = e.indexOf("window.adminAccountId");
        e = e.substring(0, t);
    }
    (imagesFromDescription = jQuery("img")),
    jQuery("#descriptionContent").html(e);
    quill = new Quill("#editorDescription", {
        modules: {
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ header: 1 }, { header: 2 }],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],
                [{ size: ["small", !1, "large", "huge"] }],
                [{ header: [1, 2, 3, 4, 5, 6, !1] }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ["clean"]
            ]
        },
        theme: "snow"
    });
}

function getAttributes(e) {
    jQuery("#table-attributes tbody tr").remove(),
        jQuery("#table-variations thead tr").remove(),
        jQuery("#table-variations tbody tr").remove();
    var t = e.NameValueList;
    attributesNamesArray = t.map(function(e) {
        return e.name;
    });
    var r = "",
        a = "";
    t &&
        t.length &&
        (t.forEach(function(e) {
                e.name &&
                    ((r =
                            "<td>" +
                            e.name +
                            '</td><td style="width:50%" contenteditable><span> ' +
                            e.value +
                            "</span></td>"),
                        (a = a + '<td  name="' + e.name + '">' + e.name + "</td>")),
                    jQuery("#table-attributes tbody").append(
                        jQuery(
                            "<tr>" +
                            r +
                            '<td><button id="removeVariations" class="btn btn-danger">X</btton><td></tr>'
                        )
                    );
            }),
            jQuery("#table-variations thead").append(
                jQuery(
                    "<tr><td>Image</td>" +
                    a +
                    '<td>quantity</td><td>Price</td><td>Sale price</td><td>Remove</td><td>sku</td><td>Weight</td><td style="display:none"></td></tr>'
                )
            ));
}

function getVariations(e) {
    e && e.length ?
        (jQuery("#applyPriceFormula").show(),
            jQuery("#applyPriceFormulaRegularPrice").show(),
            jQuery("#importSalePricecheckbox").show(),
            jQuery("#applyCharmPricingConainer").show(),
            jQuery("#priceContainer").hide(),
            jQuery("#skuContainer").hide(),
            jQuery("#productWeightContainer").hide(),
            jQuery("#productType").text("Variable Product"),
            jQuery("#no-variations").hide(),
            e &&
            e.length > 100 &&
            displayToast(
                "This product has more " +
                e.length +
                " variations, only the first 100 variations will be imported",
                "orange"
            ),
            e.forEach(function(e) {
                var t = "";
                e.attributesVariations.forEach(function(e, r) {
                    e.name &&
                        0 == r &&
                        (e.image ?
                            (t =
                                t +
                                '<td><img height="50px" width="50px" src="' +
                                e.image +
                                '"></td>') :
                            (t += "<td></td>")),
                        (t =
                            t +
                            '<td contenteditable name="' +
                            e.name +
                            '">' +
                            e.value +
                            "</td>");
                });
                var r = e.regularPrice || e.salePrice,
                    a = e.salePrice || e.regularPrice,
                    i = jQuery("#productWeight").val();
                (t =
                    t +
                    "<td contenteditable >" +
                    e.availQuantity +
                    "</td><td contenteditable>" +
                    r +
                    "</td><td contenteditable>" +
                    a +
                    '</td><td><button id="removeVariation" class="btn btn-danger">X</button></td><td contenteditable>' +
                    e.SKU +
                    "</td><td contenteditable>" +
                    i +
                    '</td><td style="display:none">' +
                    e.identifier +
                    "</td>"),
                jQuery("#table-variations tbody").append(
                        jQuery("<tr>" + t + "</tr>")
                    ),
                    jQuery("#table-variations tr td[contenteditable]").css({
                        border: "1px solid #51a7e8",
                        "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
                    });
            }),
            jQuery("#applyPriceFormulawhileImporting").prop("checked") &&
            applyPriceFormulaDefault()) :
        (jQuery('[href="#menu5"]')
            .closest("li")
            .hide(),
            jQuery("#no-variations").show(),
            jQuery("#applyPriceFormula").hide(),
            jQuery("#applyPriceFormulaRegularPrice").hide(),
            jQuery("#importSalePricecheckbox").hide(),
            jQuery("#applyCharmPricingConainer").hide(),
            jQuery("#priceContainer").show(),
            jQuery("#skuContainer").show(),
            jQuery("#productType").text("Simple Product"));
}
jQuery(document).on("click", "#importToShop", function(e) {
    prepareModal(),
        (productId = jQuery(this)
            .parents(".card")
            .find("#sku")[0].innerText),
        productId ?
        importProductGlobally(productId) :
        displayToast("Cannot get product sku", "red");
});
let currentProductModalDisplayed = "",
    currentPageReviews = 1;

function getShippingCost(e) {
    var t = new XMLHttpRequest();
    jQuery("#table-shipping tbody").empty();
    let r = jQuery('input[name="destination"]:checked').val();
    (t.onreadystatechange = function() {
        if (4 == t.readyState && 200 === t.status) {
            let e = t.response,
                r = "";
            try {
                let t = JSON.parse(e).data;
                t &&
                    t.length &&
                    t.forEach(function(e, t) {
                        (r = e.deliveryData || "information not availble"),
                        0 == t ?
                            jQuery("#table-shipping tbody").append(
                                '<tr><td style="width:24%" >  ' +
                                e.company +
                                '  </td><td  style="width:24%">' +
                                r +
                                '</td><td  style="width:24%" class="selectedshippingCostValue" >' +
                                e.cost.value +
                                e.cost.currency +
                                '</td><td  style="width:24%"> <input  name="selectedShippingCost" value=' +
                                t +
                                ' checked type="radio" /></td></tr>'
                            ) :
                            jQuery("#table-shipping tbody").append(
                                '<tr><td style="width:24%" >  ' +
                                e.company +
                                '  </td><td  style="width:24%">' +
                                r +
                                '</td><td  style="width:24%" class="selectedshippingCostValue">' +
                                e.cost.value +
                                e.cost.currency +
                                '</td><td style="width:24%"> <input  name="selectedShippingCost" value=' +
                                t +
                                ' type="radio" /></td></tr>'
                            );
                    });
            } catch (e) {}
        }
    }),
    t.open("POST", hostname + ":8002/getAliExpressShippingCost", !0),
        t.setRequestHeader("Content-Type", "application/json"),
        t.send(
            JSON.stringify({
                productId: e,
                currency: jQuery('input[name="currency"]:checked').val(),
                destination: r
            })
        );
}

function fillTheForm(e, t) {
    if (
        ((currentProductModalDisplayed = t),
            jQuery("#isImportReviewsSingleImport").prop("checked") &&
            (getReviewsFromHtml(t, 1), (currentPageReviews = 1)),
            getImagesModal(e.imageModule.imagePathList),
            getItemSpecific(e.specsModule.props),
            e && e.skuModule)
    ) {
        var r = e.skuModule.skuPriceList,
            a = { attributes: [], variations: [], NameValueList: [] };
        let t =
            r && r[0] && r[0].skuVal && r[0].skuVal.skuAmount ?
            r[0].skuVal.skuAmount.currency :
            "";
        t && jQuery("#currencyReturned").text(t),
            r.forEach(function(t, i) {
                if (t.skuPropIds)
                    a.variations.push({
                        SKU: t.skuId,
                        availQuantity: t.skuVal.availQuantity,
                        salePrice: t.skuVal.actSkuMultiCurrencyCalPrice || (t.skuVal.skuActivityAmount ? t.skuVal.skuActivityAmount.value : ''),
            regularPrice: t.skuVal.skuMultiCurrencyCalPrice || (t.skuVal.skuAmount ? t.skuVal.skuAmount.value : ''),
                        attributesVariations: getAttributesVariations(
                            t.skuPropIds,
                            e.skuModule.productSKUPropertyList
                        )
                    });
                else if (t.skuVal && t.skuVal.skuCalPrice && 1 == r.length) {
                    let e = [{
                        skuPropertyName: "color",
                        skuPropertyValues: [{
                            propertyValueDisplayName: "as image",
                            propertyValueName: "as image",
                            skuPropertyImagePath: ""
                        }]
                    }];
                    a.variations.push({
                            SKU: t.skuId,
                            availQuantity: t.skuVal.availQuantity,
                            salePrice: t.skuVal.actSkuMultiCurrencyCalPrice || (t.skuVal.skuActivityAmount ? t.skuVal.skuActivityAmount.value : ''),
                            regularPrice: t.skuVal.skuMultiCurrencyCalPrice || (t.skuVal.skuAmount ? t.skuVal.skuAmount.value : ''),
                            attributesVariations: fakeGetAttributesVariations(e)
                        }),
                        (a.NameValueList = buildNameListValues(e));
                }
            }),
            r &&
            r[0] &&
            e.skuModule &&
            e.skuModule.productSKUPropertyList &&
            (a.NameValueList = buildNameListValues(
                e.skuModule.productSKUPropertyList
            )),
            getAttributes(a),
            getVariations(a.variations),
            jQuery("#customProductCategory").empty(),
            savedCategories &&
            savedCategories.length &&
            savedCategories.forEach(function(e, t) {
                (items =
                    '<div class="checkbox"><label><input type="checkbox" value="' +
                    e.term_id +
                    '"/>' +
                    e.name +
                    "</label>"),
                jQuery("#customProductCategory").append(jQuery(items));
            });
        let i = jQuery("#textToBeReplaced").val(),
            o = jQuery("#textToReplace").val();
        if (i && o) {
            let t = e.title,
                r = e.description;
            jQuery("#customProductTitle").val(t.replace(i, o)),
                getHtmlDescription(r.replace(i, o));
        } else
            jQuery("#customProductTitle").val(e.title),
            getHtmlDescription(e.description);
    }
}

function getImagesModal(e) {
    (images = e),
    e.forEach(function(e) {
        jQuery(
            '<div><button type="button" class="btn btn-primary" id="removeImage" ><i style="font-size:15px ; margin:5px">Remove Image</i></button><img  src=' +
            e +
            " /><div>"
        ).appendTo(jQuery("#galleryPicture"));
    });
}

function getVariationsIsChecked() {
    return jQuery("#isVariationDisplayedValue").prop("checked");
}

function getAttributesVariations(e, t) {
    for (var r = [], a = e.split(","), i = 0; i < a.length; i++)
        t.forEach(function(e) {
            e.skuPropertyValues.forEach(function(t) {
                a[i] == t.propertyValueId &&
                    r.push({
                        name: e.skuPropertyName,
                        value: getVariationsIsChecked() ?
                            t.propertyValueDisplayName : t.propertyValueName,
                        image: t.skuPropertyImagePath
                    });
            });
        });
    return r;
}

function fakeGetAttributesVariations(e) {
    var t = [];
    return (
        e.forEach(function(e) {
            e.skuPropertyValues.forEach(function(r) {
                t.push({
                    name: e.skuPropertyName,
                    value: getVariationsIsChecked() ?
                        r.propertyValueDisplayName : r.propertyValueName,
                    image: r.skuPropertyImagePath
                });
            });
        }),
        t
    );
}

function buildNameListValues(e) {
    var t = [];
    return (
        e.forEach(function(e, r) {
            var a = getAttrValues(e);
            a && a.length && t.push({ name: e.skuPropertyName, value: a });
        }),
        t
    );
}

function getAttrValues(e) {
    var t = [];
    return (
        e.skuPropertyValues.forEach(function(e) {
            e.propertyValueDisplayName && getVariationsIsChecked() ?
                t.push(e.propertyValueDisplayName) :
                t.push(e.propertyValueName);
        }),
        console.log("values", t),
        t
    );
}

function getItemSpecific(e) {
    jQuery("#table-specific tbody tr").remove(),
        jQuery("#table-specific thead tr").remove(),
        e &&
        e.length &&
        e.forEach(function(e) {
            var t = "<td contenteditable>" + e.attrName + "</td>",
                r = "<td contenteditable>" + e.attrValue + "</td>";
            jQuery("#table-specific tbody").append(
                jQuery(
                    "<tr>" +
                    t +
                    r +
                    '<td><button id="removeAttribute" class="btn btn-danger">X</btton><td></tr>'
                )
            );
        }),
        jQuery("#table-specific tr td[contenteditable]").css({
            border: "1px solid #51a7e8",
            "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
        });
}

function applyPriceFormulaDefault() {
    var e = jQuery("#table-variations tbody tr"),
        t = jQuery("#table-variations thead tr")[0].cells.length - 7;
    e.each(function(e, r) {
            var a = calculateAppliedPrice(r.cells[t + 1].textContent);
            r.cells[t + 1].textContent = a.toFixed(2);
        }),
        e.each(function(e, r) {
            var a = calculateAppliedPrice(r.cells[t + 2].textContent);
            r.cells[t + 2].textContent = a.toFixed(2);
        });
}

function calculateAppliedPrice(e) {
    var t = (e = e.replace(",", ""));
    if (formsToSave && formsToSave.length) {
        var r = {};
        if (
            (formsToSave.forEach(function(t) {
                    t.min <= parseFloat(e) && t.max >= parseFloat(e) && (r = t);
                }),
                r && r.min && r.max)
        ) {
            var a = r.multiply || 1,
                i = math.eval(a),
                o = r.addition || 0,
                n = math.eval(o);
            jQuery(".formulaContent").text(
                    "Applied Formula = original price increased by (" + a + " % )  [+] " + o
                ),
                (t =
                    parseFloat(e) +
                    (parseFloat(e) * parseFloat(i)) / 100 +
                    parseFloat(n));
        }
    }
    return t ? ((t = Number(t).toFixed(2)), parseFloat(t)) : parseFloat(t);
}
jQuery(document).on("click", "#removePicture", function(e) {
        if (jQuery("#removePicture")[0].checked) {
            htmlEditor = quill.root.innerHTML;
            var t = htmlEditor.replace(/<img[^>]*>/g, "");
            (t = t.replace(/<a[^>]*>/g, "")),
            quill.setContents([]),
                quill.clipboard.dangerouslyPasteHTML(0, t);
        } else quill.setContents([]), quill.clipboard.dangerouslyPasteHTML(0, htmlEditor);
    }),
    jQuery(document).on("click", "#removeDescription", function(e) {
        jQuery("#removeDescription")[0].checked ?
            ((htmlEditor = quill.root.innerHTML), quill.setContents([])) :
            (quill.setContents([]),
                quill.clipboard.dangerouslyPasteHTML(0, htmlEditor));
    }),
    jQuery(document).on("click", "#removeVariations", function(e) {
        if (jQuery("#table-attributes tr").length > 2) {
            var t = jQuery(this).parents("tr")[0].cells[0].innerText;
            jQuery(this)
                .parents("tr")
                .remove(),
                jQuery("#table-variations tr").each(function() {
                    var e = attributesNamesArray.indexOf(t) + 1;
                    e > -1 ?
                        jQuery(this)
                        .find("td:eq(" + e + ")")
                        .remove() :
                        displayToast(
                            "cannot remove this attribute, the name does not match, please contact wooshark: reference- issue with removing an attributes",
                            "red"
                        );
                });
        } else displayToast("need at least one attribute to insert this product");
    }),
    jQuery(document).on("click", "#removeAttribute", function(e) {
        jQuery(this)
            .parents("tr")
            .remove();
    }),
    jQuery(document).on("click", "#removeVariation", function(e) {
        jQuery(this)
            .parents("tr")
            .remove();
    }),
    jQuery(document).on("click", "#removeImage", function(e) {
        var t = jQuery(this)
            .parent()
            .find("img")
            .attr("src"),
            r = images.indexOf(t);
        r > -1 && images.splice(r, 1),
            jQuery("#galleryPicture").empty(),
            images.forEach(function(e) {
                jQuery(
                    '<div><button type="button" class="btn btn-primary" id="removeImage" ><i style="font-size:15px ; margin:5px">Remove Image</i></button><img  src=' +
                    e +
                    " /><div>"
                ).appendTo(jQuery("#galleryPicture"));
            });
    }),
    jQuery(document).on("click", "#removeDescription", function(e) {
        jQuery("#removeDescription")[0].checked ?
            ((htmlEditor = quill.root.innerHTML), quill.setContents([])) :
            (quill.setContents([]),
                quill.clipboard.dangerouslyPasteHTML(0, htmlEditor));
    }),
    jQuery(document).on("click", "#removeText", function(e) {
        jQuery("#removeText")[0].checked && jQuery("#descriptionContent").html("");
    }),
    jQuery(document).on("click", "#includeImageFromDescription", function(e) {
        jQuery("#includeImageFromDescription")[0].checked &&
            imagesFromDescription.forEach(function(e, t) {
                t < 10 &&
                    (jQuery(
                            '<div><button type="button" class="btn btn-primary" id="removeImage" ><i style="font-size:15px ; margin:5px">Remove Image</i></button><img  src=' +
                            e.currentSrc +
                            " /><div>"
                        ).appendTo(jQuery("#galleryPicture")),
                        images.push(e.currentSrc));
            });
    });
var copiedObject = "";
jQuery(document).on("click", "#applyCharmPricing99", function(e) {
    var t = jQuery("#applyCharmPricing99")[0].checked,
        r = jQuery("#table-variations tbody tr");
    copiedObject || (copiedObject = r.clone());
    var a = jQuery("#table-variations thead tr")[0].cells.length - 7;
    t
        ?
        (r.each(function(e, t) {
                t.cells[a + 1].textContent =
                    Math.ceil(t.cells[a + 1].textContent).toFixed(2) - 0.01;
            }),
            r.each(function(e, t) {
                t.cells[a + 2].textContent =
                    Math.ceil(t.cells[a + 2].textContent).toFixed(2) - 0.01;
            })) :
        (r.each(function(e, t) {
                t.cells[a + 1].textContent = copiedObject[e].cells[a + 1].textContent;
            }),
            r.each(function(e, t) {
                t.cells[a + 2].textContent = copiedObject[e].cells[a + 2].textContent;
            }));
});
copiedObject = "";
jQuery(document).on("click", "#applyCharmPricing", function(e) {
        var t = jQuery("#applyCharmPricing")[0].checked,
            r = jQuery("#table-variations tbody tr");
        copiedObject || (copiedObject = r.clone());
        var a = jQuery("#table-variations thead tr")[0].cells.length - 7;
        t
            ?
            (r.each(function(e, t) {
                    t.cells[a + 1].textContent = Math.ceil(
                        t.cells[a + 1].textContent
                    ).toFixed(2);
                }),
                r.each(function(e, t) {
                    t.cells[a + 2].textContent = Math.ceil(
                        t.cells[a + 2].textContent
                    ).toFixed(2);
                })) :
            (r.each(function(e, t) {
                    t.cells[a + 1].textContent = copiedObject[e].cells[a + 1].textContent;
                }),
                r.each(function(e, t) {
                    t.cells[a + 2].textContent = copiedObject[e].cells[a + 2].textContent;
                }));
    }),
    jQuery(document).on("click", "#applyPriceFormulaRegularPrice", function(e) {
        if (jQuery("#applyPriceFormulaRegularPrice")[0].checked) {
            var t = jQuery("#table-variations tbody tr"),
                r = jQuery("#table-variations thead tr")[0].cells.length - 7;
            t.each(function(e, t) {
                    t.cells[r + 1].textContent = calculateAppliedPrice(
                        t.cells[r + 1].textContent
                    );
                }),
                jQuery("#applyPriceFormulaRegularPrice").prop("disabled", !0);
        }
    }),
    jQuery(document).on("click", "#globalRegularPrice", function(e) {
        jQuery("#globalRegularPriceValue").val();
        if (jQuery("#globalRegularPriceValue").val()) {
            var t = jQuery("#table-variations tbody tr"),
                r = jQuery("#table-variations thead tr")[0].cells.length - 7;
            t.each(function(e, t) {
                t.cells[r + 1].textContent = jQuery("#globalRegularPriceValue").val();
            });
        }
    }),
    jQuery(document).on("click", "#globalSalePrice", function(e) {
        if (jQuery("#globalSalePriceValue").val()) {
            var t = jQuery("#table-variations tbody tr"),
                r = jQuery("#table-variations thead tr")[0].cells.length - 7;
            t.each(function(e, t) {
                t.cells[r + 2].textContent = jQuery("#globalSalePriceValue").val();
            });
        }
    }),
    jQuery(document).on("click", "#displayAdvancedVariations", function(e) {
        jQuery("#table-attributes").show();
    }),
    jQuery(document).on("click", "#addShippingPrice", function(e) {
        if (jQuery("#addShippingPriceValue").val()) {
            var t = jQuery("#table-variations tbody tr"),
                r = jQuery("#table-variations thead tr")[0].cells.length - 7;
            t.each(function(e, t) {
                    t.cells[r + 2].textContent =
                        parseFloat(t.cells[r + 2].textContent) +
                        parseFloat(jQuery("#addShippingPriceValue").val());
                }),
                (t = jQuery("#table-variations tbody tr")).each(function(e, t) {
                    t.cells[r + 1].textContent =
                        parseFloat(t.cells[r + 1].textContent) +
                        parseFloat(jQuery("#addShippingPriceValue").val());
                });
        }
    });
let tagsProduct = [];

function getReviews() {
    var e = jQuery("#customReviews tr"),
        t = [];
    return e && e.length ?
        (e.each(function(e, r) {
                e &&
                    t.push({
                        review: r.cells[0].innerHTML || "-",
                        rating: jQuery(r)
                            .find("input")
                            .val() || 5,
                        datecreation: r.cells[2].outerText,
                        username: r.cells[1].outerText || "unknown",
                        email: "test@test.com"
                    });
            }),
            t) : [];
}

function resetTheForm() {
    jQuery("#customProductTitle").val(""),
        jQuery("#shortDescription").val(""),
        jQuery("#customPrice").val(""),
        jQuery("#customSalePrice").val(""),
        jQuery("#simpleSku").val(""),
        jQuery("#customProductCategory input:checked").each(function() {
            jQuery(this).prop("checked", !0);
        }),
        jQuery("#table-attributes tr").remove(),
        jQuery("#customProductCategory").empty(),
        jQuery("#galleryPicture").empty(),
        jQuery("#table-variations tr").remove();
}

function getPRoductUrlFRomSku(e) {
    var t = "";
    if (e) {
        var r = getSelectedLanguage();
        t =
            "en" == r ?
            "https://aliexpress.com/item/" + e + ".html" :
            "https://" + r + ".aliexpress.com/item/" + e + ".html";
    }
    return t;
}

function buildVariations() {
    var e = { variations: [], NameValueList: [] };
    jQuery("#table-attributes tr").each(function(t, r) {
        t &&
            e.NameValueList.push({
                name: r.cells[0].textContent.toLowerCase().replace(/ /g, "-"),
                values: r.cells[1].textContent.split(","),
                variation: !0,
                visible: !0
            });
    });
    var t = e.NameValueList.length;
    return (
        jQuery("#table-variations tr").each(function(r, a) {
            if (r && r < 100) {
                var i = [];
                e.NameValueList.forEach(function(e, t) {
                        i.push({
                            name: e.name.toLowerCase().replace(/ /g, "-"),
                            value: a.cells[t + 1].textContent.trim(),
                            image: a.cells[0] &&
                                a.cells[0].children &&
                                a.cells[0].children[0] &&
                                a.cells[0].children[0].currentSrc ?
                                a.cells[0].children[0].currentSrc : ""
                        });
                    }),
                    a.cells[t + 1].textContent &&
                    e.variations.push({
                        SKU: a.cells[t + 5].textContent,
                        availQuantity: a.cells[t + 1].textContent || 1,
                        salePrice: a.cells[t + 3].textContent,
                        regularPrice: a.cells[t + 2].textContent,
                        attributesVariations: i,
                        weight: a.cells[t + 6].textContent || jQuery("#productWeight").val()
                    });
            }
        }),
        e
    );
}

function getItemSpecificfromTableAliexpress(e) {
    var t = jQuery("#table-specific tbody tr"),
        r = e.NameValueList.map(function(e) {
            return e.name;
        });
    return (
        t &&
        t.length &&
        t.each(function(t, a) {
            -1 == r.indexOf(a.cells[0].textContent) &&
                e.NameValueList.push({
                    name: a.cells[0].textContent || "-",
                    visible: !0,
                    variation: !1,
                    values: [a.cells[1].textContent]
                });
        }),
        e
    );
}

function prepareModal() {
    (tagsProduct = []),
    jQuery("#myModal").remove(),
        jQuery("#importModal").remove(),
        jQuery(
            '<button type="button" id="importModal" style="display: none; position:relative" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#myModal">Import To Shop</button><div class="modal fade" tabindex="-1" id="myModal" role="dialog" data-backdrop="false" data-bs-dismiss="modal"><div class="modal-dialog"><div class="modal-content" style="width:170%; left:-25%"><div class="modal-header"><button  class="btn-close" data-bs-dismiss="modal"></button><h4 class="modal-title" style="font-size:10px">Product customization <span style="color:red" id="productType"></span>  - Currency: <span style="color:red" id="currencyReturned"> <span></h4> </div><div class="modal-body"> <ul id="tabs" class="nav nav-tabs" role="tablist"><li class="nav-item" role="presentation">    <button data-bs-toggle="tab" data-bs-target="#home" class="nav-link">General</a></li><li class="nav-item" role="presentation">   <button data-bs-toggle="tab" data-bs-target="#menu1" class="nav-link">Description</a></li><li class="nav-item" role="presentation">   <button data-bs-toggle="tab" data-bs-target="#menu3" class="nav-link">Gallery</a></li><li class="nav-item" role="presentation">   <button data-bs-toggle="tab" data-bs-target="#menu4" class="nav-link">Reviews</a></li><li class="nav-item" role="presentation"> <button data-bs-toggle="tab" data-bs-target="#menu5" class="nav-link">Variations</a></li><li class="nav-item" role="presentation"> <button data-bs-toggle="tab" data-bs-target="#menu6" class="nav-link">Specific attributes</a></li><li class="nav-item" role="presentation"> <button data-bs-toggle="tab" data-bs-target="#menu7" class="nav-link">Tags</a></li>     </ul><div class="tab-content"><div id="home" class="tab-pane fade show active" role="tabpanel">  <div class="form-group" id="priceContainer" style="display:none">  <div class="form-group"> <h3 style="color:brown" for="price">Regular Price: <span style="color:red" id="formulaContent"><span></h3>  </div> <input style="width:97%" id="customPrice" type="number" class="form-control" id="price">  <div class="form-group"> <h3 style="color:brown" for="price">Sale Price: <span style="color:red" id="formulaContent"><span></h3>  </div> <input style="width:97%" id="customSalePrice" type="number" class="form-control" id="price">  </div>  <div class="form-group">       <h3   style="color:brown" for="title">custom Title:</h3>       <input id="customProductTitle" type="text" placeholder="custom title, if empty original title will be displayed" class="form-control" style="font-size:10px" id="title"> </div>  <div class="form-group"  id="skuContainer" style="display:none">  <h3  style="color:brown"  for="title">Sku  <small> (Optional) </small>   </h3>  <input  style ="width: 100%;padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;" type="text" placeholder="Sku attribute (optional)" class="form-control" id="simpleSku"> </div>  <div class="form-group" id="productWeightContainer">       <h3  style="color:brown" for="title">Product weight  <small> (Optional) </small> </h3>       <input id="productWeight" type="text" placeholder="product weight" class="form-control" id="title"> </div> <div class="form-group">  <h3  style="color:brown" for="title"> Short Description <small> (Optional) </small> </h3>   <textarea  id="shortDescription" class="form-control" rows="2" id="comment" placeholder="Short description"></textarea> </div><div class="checkbox" ><label><input class="form-check-input mt-1" id="isPublish" type="checkbox" name="remember"> Publish (checked = publish  | unchecked = draft)</label> </div><div class="checkbox" > </div><div class="checkbox" > </div><div class="form-group" id="categoriesContainer"><div class="panel panel-default"> <div class="panel-heading">Select Categories</div><div style="display:flex"> <input type="text" id="categorySearchKeyword" style="flex: 1 1 30%" class="form-control" /><button id="searchCategories" style="flex: 1 1 30%" class="btn btn-default"> Search categories</button></div> <div id="customProductCategory" style="height:150px; overflow-y:scroll" class="panel-body"> </div> </div> </div>  </div><div id="menu1" class="tab-pane fade"><div class="form-group" ><div class="checkbox" ><label><input id="removePicture" class="form-check-input mt-1" type="checkbox" name="remember"> Remove Pictures </label> </div><div class="checkbox" ><label><input id="removeDescription" class="form-check-input mt-1" type="checkbox" name="remember"> Remove description </label> </div><div id="editorDescription"><div id="descriptionContent"> </div> </div> </div>  </div><div id="menu3" class="tab-pane fade" role="tabpanel"><div class="checkbox" > </div><div id="galleryPicture" style="overflow-y:scroll;height:500px"> </div>  </div><div id="menu4" class="tab-pane fade" role="tabpanel"><div id="customReviews" style="overflow-y:scroll;height:500px"><button class="btn btn-primary" id="addReview" style="width:100%;margin-top:10px"> Add Review</button><button class="btn btn-primary" id="loadMoreReviews" style="width:100%;margin-top:10px"> Load more Review</button><table id="table-reviews" class="table table-striped"><thead>  <tr>    <th>Review</th>    <th>Username</th>    <th>Date creation</th>    <th>Rating</th>    <th>Email</th>    <th>Remove</th>  </tr> </thead><tbody></tbody></table></div></div><div id="menu5" class="tab-pane fade" role="tabpanel"><div id="no-variations" style="text-align:center; display:none; padding:20px; margin:30px; background-color:beige"><span style=" text-align:center">This is a simple product, no variations can be defined</span></div> <h3 class="formulatexcontainer" for="price" style="background-color:beige; padding:15px; margin:20px;  text-align:center"> <span class="formulaContent">No formula defined yet<span></h3><div class="checkbox" id="applyCharmPricingConainer" style="display:none" ><label><input style="opacity:inherit" id="applyCharmPricing" class="form-check-input mt-1" type="checkbox" name="remember"> Apply charm pricing 00  <small>( Example 2.34 ==> 3.00) </small> </label><div></div><label><input style="opacity:inherit" id="applyCharmPricing99" class="form-check-input mt-1" type="checkbox" name="remember"> Apply charm pricing 99  <small>(Example 2.34 ==> 2.99) </small> </label> </div><div style="display:flex" > <input style="flex: 1 1  100px; width:50%;  margin: 5px" id="globalRegularPriceValue" placeholder="Apply Regular price for all variations" type="number" class="form-control" ><button style="flex: 1 1  100px; margin: 5px" class="btn btn-primary" id="globalRegularPrice"> Apply</button> </div><div style="display:flex" > <input style="flex: 1 1  100px; width:50%;  margin: 5px" id="globalSalePriceValue" placeholder="Apply Sale price for all variations"  type="number" class="form-control" ><button style="flex: 1 1  100px; margin: 5px" class="btn btn-primary" id="globalSalePrice"> Apply</button> </div><div style="display:flex" > <input style="flex: 1 1  100px; width:50%;  margin: 5px" id="addShippingPriceValue" placeholder="Add shipping price"  type="number" class="form-control" ><button style="flex: 1 1  100px; margin: 5px" class="btn btn-primary" id="addShippingPrice"> Apply</button> </div><div style="height:400px; overflow-y:scroll"> <table id="table-variations" style="margin-top:20px" class="table table-striped"><thead></thead><tbody></tbody></table> </div><button id="displayAdvancedVariations" style="width:100%" class="btn btn-primary"> Edit Attributes </button><small> <u> Note: </u> Any modification of the attributes values on the variations table (such as color and size, etc..) need to be reflected on the attribute table below (click edit Attributes). the value must be available on the list of possible values on the table below. use a semi colon to add a new value</small> <table id="table-attributes" style="display:none; margin-top:20px" class="table table-striped"><thead> <tr> <th>name</th> <th>values</th> <th>Remove this from all variations</th> </tr></thead><tbody></tbody></table> </div><div id="menu6" class="tab-pane fade" role="tabpanel"><button class="btn btn-primary" id="addSpecific" style="width:100%"> Add specification</button> <table id="table-specific" style="margin-top:20px" class="table table-striped"><thead> <tr> <th>property</th> <th>values</th> <th>Remove</th> </tr></thead><tbody></tbody></table> </div><div id="menu7" class="tab-pane fade" role="tabpanel"><label> Add Tag to product</label><input  id="tagInput" type="text" class="form-control" /><button class="btn btn-primary" id="addTagToProduct" style="width:100%"> Add tags</button><div id="tagInputDisplayed" style="color:red"></div> </div><div id="advanced" class="tab-pane fade in"> <div class="form-group" style="margin-top:5px">  <h3  style="color:brown" for="title"> Tags <small> (Optional) </small> </h3>   <textarea  id="tags" class="form-control" rows="2" id="comment" placeholder="Place tags separated by commas"></textarea> </div> <div style="margin-top:5px">  <h3  style="color:brown" for="title"> Sale price (Optional) </small> </h3> <input style="width:97%" id="salePrice" type="number" class="form-control" id="price"> </div> <div style="margin-top:5px">  <h3  style="color:brown" for="title"> Sale start date </small> </h3> <input  id="saleStartDate" type="date" class="form-control" id="price"> </div> <div style="margin-top:5px">  <h3  style="color:brown" for="title"> Sale end date </small> </h3> <input  id="saleEndDate" type="date" class="form-control" id="price"> </div> </div>  <div class="modal-footer">     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>     <button type="button" id="totoButton" class="btn btn-primary" data-bs-dismiss="modal">Import</button> </div>  </div>  </div> </div>'
        ).appendTo(jQuery("#modal-container"));
}

function restoreFormula(e) {
    if (e) {
        formsToSave = e;
        try {
            e &&
                e.length &&
                (jQuery("#formula tbody tr").remove(),
                    e.forEach(function(e) {
                        e &&
                            e.min &&
                            e.max &&
                            e.multiply &&
                            jQuery("#formula tbody").append(
                                '<tr><th style="width:15%"> <input class="custom-form-control" name="min" placeholder="Min price" value="' +
                                e.min +
                                '"></th><th style="width:2%">-</th><th style="width:15%"><input class="custom-form-control" name="max" placeholder="Max price" value="' +
                                e.max +
                                '"></th><th style="width:16%"><div style="display:flex"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-light"> Increase by  </button><input value="' +
                                e.multiply +
                                '" style="flex: 1 1 78%; border: 1px solid #ccc;" class="multiply custom-form-control" type="number" name="multiply" placeholder="Increase percentage"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-default">  <i class="fa fa-percent fa-2x"></i> </button></div></th><th style="width:15%"><div style="display:flex"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-light">  <i class="fa fa-plus"></i> </button><input value="' +
                                e.addition +
                                '" style="flex: 1 1 90%; border: 1px solid #ccc;" class="addition custom-form-control" type="number" name="addition" placeholder="Add number"></div></th><th style="width:3%"><button id="removeFormulaLine" style="border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-danger">  <i class="fa fa-trash"></i> </button></th></tr>'
                            );
                    }));
        } catch (e) {
            displayToast(
                "Error while restoring formula, please contact wooshark support subject error while restoring formula"
            );
        }
    }
}
jQuery(document).on("click", "#addTagToProduct", function(e) {
        let t = jQuery("#tagInput").val();
        t &&
            (tagsProduct.push(t),
                jQuery("#tagInput").val(""),
                jQuery("#tagInputDisplayed").append(jQuery("<div>" + t + "</div>")));
    }),
    jQuery(document).on("click", "#addSpecific", function(e) {
        jQuery("#table-specific tbody").append(
                '<tr><td style="width:50%" contenteditable>    </td><td contenteditable style="width:50%"></td><td><button id="removeAttribute" class="btn btn-danger">X</btton></td></tr>'
            ),
            jQuery("#table-specific tr td[contenteditable]").css({
                border: "1px solid #51a7e8",
                "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
            });
    }),
    jQuery(document).on("click", "#totoButton", function(e) {
        startLoading();
        displayToast('Only 1 images, 2 varitions and no description will be imported on the free plan', "orange");
        var t = [];
        let r = "";
        var a = buildVariations(),
            i =
            jQuery("#customProductTitle").val() ||
            jQuery("head")
            .find("title")
            .text(),
            o = jQuery("#shortDescription").val() || "",
            n = jQuery("#customPrice").val() || "",
            l = jQuery("#customSalePrice").val() || "";
        jQuery("#simpleSku").val();
        let s = [];
        jQuery("#customProductCategory input:checked").each(function() {
            s.push(jQuery(this).attr("value"));
        });
        var c = a.NameValueList;
        let d = getPRoductUrlFRomSku(currentSku);
        jQuery("#isImportReviewsSingleImport").prop("checked") &&
            (t = getReviews()),
            jQuery("#isImportProductDescriptionSingleImport").prop("checked") &&
            (r = quill.root.innerHTML),
            jQuery("#isImportProductSpecificationSingleImport").prop("checked") &&
            (a = getItemSpecificfromTableAliexpress(a));
        let u = jQuery("#isImportImageVariationsSingleImport").prop("checked"),
            p = jQuery("#isFeaturedProduct").prop("checked"),
            y = jQuery("#isPublishProductSingleImport").prop("checked"),
            m = jQuery("#includeShippingCostIntoFinalPrice").prop("checked"),
            g = [];
        tagsProduct && tagsProduct.length && (g = tagsProduct),
            jQuery.ajax({
                url: wooshark_params.ajaxurl,
                type: "POST",
                dataType: "JSON",
                data: {
                    action: "wooshark-insert-product",
                    sku: currentSku.toString(),
                    title: i,
                    description: r || "",
                    productType: "variable",
                    images: images.slice(0,2) || [],
                    categories: s,
                    regularPrice: n.toString(),
                    salePrice: l.toString(),
                    quantity: 33,
                    attributes: c && c.length ? c.slice(0,4) : [],
                    variations: a.variations && a.variations.length ? a.variations.slice(0,4) : [],
                    isFeatured: p,
                    postStatus: y ? "publish" : "draft",
                    shortDescription: o || "",
                    productUrl: d,
                    importVariationImages: u,
                    reviews: t,
                    tags: g,
                    includeShippingCostIntoFinalPrice: m
                },
                success: function(e) {
                    e && e.error && e.error_msg && displayToast(e.error_msg, "red"),
                        e && !e.error && e.data && displayToast(e.data, "green"),
                        stopLoading();
                    if (e && e.error && e.error_msg && e.error_msg.includes('you have reached the permitted usage')) {
                        setTimeout(function() {
                            window.open('https://wooshark.com/aliexpress', '_blank');
                        }, 4000);
                    }
                },
                error: function(e) {
                    console.log("****err", e),
                        stopLoading(),
                        e && e.responseText && displayToast(e.responseText, "red");
                }
            });
    }),
    jQuery(document).on("click", "#resetFormula", function(e) {}),
    jQuery(document).on("click", "#addInterval", function(e) {
        jQuery("#formula tbody").append(
            '<tr><th style="width:15%"> <input class="custom-form-control" name="min" placeholder="Min price"></th><th style="width:2%">-</th><th style="width:15%"><input class="custom-form-control" name="max" placeholder="Max price"></th><th style="width:16%"><div style="display:flex"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-light"> Increase by  </button><input style="flex: 1 1 78%; border: 1px solid #ccc;" class="multiply custom-form-control" type="number" name="multiply" placeholder="Increase percentage"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-default">  <i class="fa fa-percent fa-2x"></i> </button></div></th><th style="width:15%"><div style="display:flex"><button style="flex: 1 1 10%;border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-light">  <i class="fa fa-plus"></i> </button><input style="flex: 1 1 90%; border: 1px solid #ccc;" class="addition custom-form-control" type="number" name="addition" placeholder="Add number"></div></th><th style="width:3%"><button id="removeFormulaLine" style="border-radius: 1px;margin-top: 0;margin-bottom: 0;margin-right:5px" class="btn btn-danger">  <i class="fa fa-trash"></i> </button></th></tr>'
        );
    });
let _savedConfiguration = {};

function restoreConfiguration() {
    let e = {};
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "restoreConfiguration" },
        success: function(t) {
            if (
                (console.log("response---", t),
                    t && t._savedConfiguration && t._savedConfiguration.commonConfiguration)
            ) {
                let r = (e = t._savedConfiguration).commonConfiguration,
                    a = e.sinleUpdateConfiguration,
                    i = e.singleImportonfiguration,
                    o = e.bulkCategories,
                    n = e.savedFormula;
                r &&
                    r.language &&
                    (jQuery("[name=language][value=" + r.language + "]").attr(
                            "checked", !0
                        ),
                        jQuery(
                            '<h4 style="font-weight:bold;"> Current Language: ' +
                            r.language +
                            "  </h4>"
                        ).appendTo(".currencyDetails")),
                    r &&
                    r.currency &&
                    (jQuery("[name=currency][value=" + r.currency + "]").attr(
                            "checked", !0
                        ),
                        jQuery(
                            '<h4 style="font-weight:bold;"> Current currency: ' +
                            r.currency +
                            "  </h4>"
                        ).appendTo(".currencyDetails")),
                    a ?
                    (jQuery("#applyPriceFormulaWhileUpdatingProduct").prop(
                            "checked", !1
                        ),
                        jQuery("#isVariationDisplayedValue").prop("checked", !1),
                        jQuery("#setVariationsToOutOfStock").prop("checked", !1),
                        jQuery("#updateSalePrice").prop("checked", !1),
                        jQuery("#updateRegularPrice").prop("checked", !1)) :
                    (jQuery("#applyPriceFormulaWhileUpdatingProduct").prop(
                            "checked", !1
                        ),
                        jQuery("#setVariationsToOutOfStock").prop("checked", !1),
                        jQuery("#updateSalePrice").prop("checked", !1),
                        jQuery("#updateRegularPrice").prop("checked", !1),
                        jQuery("#isVariationDisplayedValue").prop("checked", !1)),
                    i ?
                    (jQuery("#isImportReviewsSingleImport").prop(
                            "checked",
                            "true" == i.isImportReviewsSingleImport
                        ),
                        jQuery("#isImportImageVariationsSingleImport").prop(
                            "checked",
                            "true" == i.isImportImageVariationsSingleImport
                        ),
                        jQuery("#isImportProductSpecificationSingleImport").prop(
                            "checked",
                            "true" == i.isImportProductSpecificationSingleImport
                        ),
                        jQuery("#isImportProductDescriptionSingleImport").prop(
                            "checked",
                            "true" == i.isImportProductDescriptionSingleImport
                        ),
                        jQuery("#isPublishProductSingleImport").prop(
                            "checked",
                            "true" == i.isPublishProductSingleImport
                        ),
                        jQuery("#applyPriceFormulawhileImporting").prop(
                            "checked",
                            "true" == i.applyPriceFormulawhileImporting
                        ),
                        jQuery("#isFeaturedProduct").prop(
                            "checked",
                            "true" == i.isFeaturedProduct
                        ),
                        jQuery("#includeShippingCostIntoFinalPrice").prop(
                            "checked",
                            "true" == i.includeShippingCostIntoFinalPrice
                        ),
                        jQuery("#isEnableAutomaticUpdateForAvailability").prop(
                            "checked",
                            "true" == i.isEnableAutomaticUpdateForAvailability
                        ),
                        jQuery("#enableAutomaticUpdates").prop(
                            "checked",
                            "true" == i.enableAutomaticUpdates
                        ),
                        jQuery("#applyPriceFormulaAutomaticUpdate").prop("checked", !1),
                        jQuery("#syncSalePrice").prop("checked", !1),
                        jQuery("#syncRegularPrice").prop("checked", !1),
                        jQuery("#syncStock").prop("checked", !1),
                        jQuery("#onlyPublishProductWillSync").prop("checked", !1),
                        jQuery("[name=destination][value=" + i.destination + "]").attr(
                            "checked", !0
                        ),
                        jQuery("#textToBeReplaced").val(i.textToBeReplaced),
                        jQuery("#textToReplace").val(i.textToReplace)) :
                    (jQuery("#isImportReviewsSingleImport").prop("checked", !0),
                        jQuery("#isImportImageVariationsSingleImport").prop(
                            "checked", !1
                        ),
                        jQuery("#isImportProductSpecificationSingleImport").prop(
                            "checked", !0
                        ),
                        jQuery("#isImportProductDescriptionSingleImport").prop(
                            "checked", !0
                        ),
                        jQuery("#isPublishProductSingleImport").prop("checked", !0),
                        jQuery("#applyPriceFormulawhileImporting").prop("checked", !0),
                        jQuery("#isFeaturedProduct").prop("checked", !1),
                        jQuery("#includeShippingCostIntoFinalPrice").prop("checked", !1),
                        jQuery("#isEnableAutomaticUpdateForAvailability").prop(
                            "checked", !1
                        ),
                        jQuery("#enableAutomaticUpdates").prop("checked", !1),
                        jQuery("#applyPriceFormulaAutomaticUpdate").prop("checked", !1),
                        jQuery("#syncRegularPrice").prop("checked", !1),
                        jQuery("#syncStock").prop("checked", !1),
                        jQuery("#syncSalePrice").prop("checked", !1),
                        jQuery("#onlyPublishProductWillSync").prop("checked", !1),
                        jQuery("[name=destination][value=US]").attr("checked", !0)),
                    restoreFormula(n),
                    getCategories(function(e) {
                        savedCategories &&
                            savedCategories.length &&
                            (jQuery("#table-categories tbody").empty(),
                                savedCategories.forEach(function(e) {
                                    jQuery("#table-categories tbody").append(
                                        '<tr><td style="width:20%">' +
                                        e.term_id +
                                        '</td><td style="width:20%">' +
                                        e.name +
                                        '</td><td  style="width:20%">' +
                                        e.count +
                                        ' </td></td><td  style="width:40%"><button class="btn btn-primary" style="width:100%" id="updateProductOfThisCategory" categoryID="' +
                                        e.term_id +
                                        '"> Update Products of this category</button></td></tr>'
                                    );
                                }),
                                o && o.length && savedCategories && savedCategories.length ?
                                (jQuery("#bulkCategories").empty(),
                                    savedCategories.forEach(function(e, t) {
                                        var r;
                                        (r =
                                            '<div class="checkbox"><label><input class="form-check-input mt-1" id="category' +
                                            e.term_id +
                                            '" type="checkbox" style="width:17px; height:17px" class="chk" value="' +
                                            e.term_id +
                                            ' "/>' +
                                            e.name +
                                            "</label>"),
                                        jQuery("#bulkCategories").append(jQuery(r));
                                    }),
                                    o &&
                                    o.length &&
                                    o.forEach(function(e) {
                                        jQuery("#category" + e).prop("checked", !0);
                                    })) :
                                (jQuery("#bulkCategories").empty(),
                                    savedCategories.forEach(function(e, t) {
                                        var r;
                                        (r =
                                            '<div class="checkbox"><label><input class="form-check-input mt-1" id="category' +
                                            e.term_id +
                                            '" type="checkbox" style="width:17px; height:17px" class="chk" value="' +
                                            e.term_id +
                                            ' "/>' +
                                            e.name +
                                            "</label>"),
                                        jQuery("#bulkCategories").append(jQuery(r));
                                    })));
                    });
            } else
                getCategories(function(e) {
                    savedCategories &&
                        savedCategories.length &&
                        (jQuery("#table-categories tbody").empty(),
                            savedCategories.forEach(function(e) {
                                jQuery("#table-categories tbody").append(
                                    '<tr><td style="width:20%">' +
                                    e.term_id +
                                    '</td><td style="width:20%">' +
                                    e.name +
                                    '</td><td  style="width:20%">' +
                                    e.count +
                                    ' </td></td><td  style="width:40%"><button class="btn btn-primary" style="width:100%" id="updateProductOfThisCategory" categoryID="' +
                                    e.term_id +
                                    '"> Update Products of this category</button></td></tr>'
                                );
                            }),
                            bulkCategories &&
                            bulkCategories.length &&
                            savedCategories &&
                            savedCategories.length ?
                            (jQuery("#bulkCategories").empty(),
                                savedCategories.forEach(function(e, t) {
                                    var r;
                                    (r =
                                        '<div class="checkbox"><label><input class="form-check-input mt-1" id="category' +
                                        e.term_id +
                                        '" type="checkbox" style="width:17px; height:17px" class="chk" value="' +
                                        e.term_id +
                                        ' "/>' +
                                        e.name +
                                        "</label>"),
                                    jQuery("#bulkCategories").append(jQuery(r));
                                }),
                                bulkCategories &&
                                bulkCategories.length &&
                                bulkCategories.forEach(function(e) {
                                    jQuery("#category" + e).prop("checked", !0);
                                })) :
                            (jQuery("#bulkCategories").empty(),
                                savedCategories.forEach(function(e, t) {
                                    var r;
                                    (r =
                                        '<div class="checkbox"><label><input class="form-check-input mt-1" id="category' +
                                        e.term_id +
                                        '" type="checkbox" style="width:17px; height:17px" class="chk" value="' +
                                        e.term_id +
                                        ' "/>' +
                                        e.name +
                                        "</label>"),
                                    jQuery("#bulkCategories").append(jQuery(r));
                                })));
                }),

                jQuery("#isImportReviewsSingleImport").prop(
                    "checked",
                    true
                ),
                jQuery("#isImportProductSpecificationSingleImport").prop(
                    "checked",
                    true
                ),
                jQuery("#isImportProductDescriptionSingleImport").prop(
                    "checked",
                    true
                ),
                jQuery("#isPublishProductSingleImport").prop(
                    "checked",
                    true
                ),
                jQuery("#applyPriceFormulawhileImporting").prop(
                    "checked",
                    true
                ),
                jQuery("#isFeaturedProduct").prop(
                    "checked",
                    true
                ),

                
                displayToast(
                    "Cannot find any saved configuration, please ensure you save your preference on the configuration tab"
                );
        },
        error: function(e) {
            displayToast(
                "Error while retrieving configuration from server, please erload your page"
            );
        },
        complete: function() {}
    });
}

function handleError(e) {
    stopLoading(),
        e && e.error && e.error_msg && displayToast(e.error_msg, "red"),
        e && !e.error && e.data && displayToast(e.data, "green");
}

function startLoadingText() {
    jQuery(
        '<h3  id="loading-variation" style="color:green;">  Loading .... </h3>'
    ).appendTo(".log-sync-product");
}

function stopLoadingText() {
    jQuery("#loading-variation").remove();
}
jQuery(document).on("click", "#removeFormulaLine", function(e) {
        jQuery(this)
            .parents("tr")
            .remove();
    }),
    jQuery(document).on("click", "#saveGlobalConfiguration", function(e) {
        let t = {};
        var r = {
            isImportReviewsSingleImport: jQuery("#isImportReviewsSingleImport").prop(
                "checked"
            ),
            isImportImageVariationsSingleImport: jQuery(
                "#isImportImageVariationsSingleImport"
            ).prop("checked"),
            isImportProductSpecificationSingleImport: jQuery(
                "#isImportProductSpecificationSingleImport"
            ).prop("checked"),
            isImportProductDescriptionSingleImport: jQuery(
                "#isImportProductDescriptionSingleImport"
            ).prop("checked"),
            isPublishProductSingleImport: jQuery(
                "#isPublishProductSingleImport"
            ).prop("checked"),
            applyPriceFormulawhileImporting: jQuery(
                "#applyPriceFormulawhileImporting"
            ).prop("checked"),
            isFeaturedProduct: jQuery("#isFeaturedProduct").prop("checked"),
            textToBeReplaced: jQuery("#textToBeReplaced").val(),
            textToReplace: jQuery("#textToReplace").val(),
            destination: jQuery('input[name="destination"]:checked').val()
        };
        let a = {
                language: getSelectedLanguage(),
                currency: jQuery('input[name="currency"]:checked') &&
                    jQuery('input[name="currency"]:checked')[0] ?
                    jQuery('input[name="currency"]:checked')[0].value : "USD"
            },
            i = {
                applyPriceFormulaWhileUpdatingProduct: jQuery(
                    "#applyPriceFormulaWhileUpdatingProduct"
                ).prop("checked"),
                setVariationsToOutOfStock: jQuery("#setVariationsToOutOfStock").prop(
                    "checked"
                ),
                updateSalePrice: jQuery("#updateSalePrice").prop("checked"),
                updateRegularPrice: jQuery("#updateRegularPrice").prop("checked"),
                isVariationDisplayedValue: jQuery("#isVariationDisplayedValue").prop(
                    "checked"
                )
            };
        (t.commonConfiguration = a),
        (t.sinleUpdateConfiguration = i),
        (t.singleImportonfiguration = r),
        displayToast("save global configuration", "green");
        var o = [];
        jQuery(".chk:input:checked").each(function() {
                jQuery(this) && jQuery(this).val() && o.push(jQuery(this).val());
            }),
            (t.bulkCategories = o),
            displayToast("save categories", "green");
        var n = jQuery("#formula tbody tr"),
            l = [];
        n &&
            n.length &&
            n.each(function(e, t) {
                if (t && t.cells && t.cells.length > 3) {
                    let e = jQuery(t.cells[0])
                        .find("input")
                        .val(),
                        r = jQuery(t.cells[2])
                        .find("input")
                        .val(),
                        a = jQuery(t.cells[3])
                        .find("input")
                        .val(),
                        i = jQuery(t.cells[4])
                        .find("input")
                        .val();
                    e &&
                        r &&
                        a &&
                        l.push({ min: e, max: r, multiply: a || 1, addition: i || 0 });
                }
            }),
            (t.savedFormula = l),
            displayToast("save price markup formula"),
            jQuery.ajax({
                url: wooshark_params.ajaxurl,
                type: "POST",
                dataType: "JSON",
                data: {
                    action: "saveOptionsDB",
                    isShippingCostEnabled: jQuery(
                            "#includeShippingCostIntoFinalPrice"
                        ).prop("checked") ?
                        "Y" : "N",
                    isEnableAutomaticUpdateForAvailability: jQuery(
                            "#isEnableAutomaticUpdateForAvailability"
                        ).prop("checked") ?
                        "Y" : "N",
                    priceFormulaIntervalls: l,
                    _savedConfiguration: t,
                    onlyPublishProductWillSync: jQuery(
                            "#onlyPublishProductWillSync"
                        ).prop("checked") ?
                        "Y" : "N",
                    enableAutomaticUpdates: jQuery("#enableAutomaticUpdates").prop(
                            "checked"
                        ) ?
                        "Y" : "N",
                    applyPriceFormulaAutomaticUpdate: jQuery(
                            "#applyPriceFormulaAutomaticUpdate"
                        ).prop("checked") ?
                        "Y" : "N",
                    syncRegularPrice: jQuery("#syncRegularPrice").prop("checked") ?
                        "Y" : "N",
                    syncSalePrice: jQuery("#syncSalePrice").prop("checked") ? "Y" : "N",
                    syncStock: jQuery("#syncStock").prop("checked") ? "Y" : "N"
                },
                success: function(e) {
                    console.log("----saved formula--------", e);
                },
                error: function(e) {},
                complete: function() {
                    document.location.reload(!0),
                        displayToast("Configuration saved successfully"),
                        jQuery("#savedCorrectlySection").show();
                }
            });
    });
let productDetailsOldVariationsAndNewVariations = [];

function logStartGettingPRoductDetails(e, t) {
    e || jQuery(".log-sync-product").empty(),
        e ||
        (jQuery(
                '<h3 style="color:green;"> ID: ' +
                t +
                " 1-  Getting existing Product variations .... </h3>"
            ).appendTo(".log-sync-product"),
            startLoadingText());
}

function logGettingNewProductVariations(e, t) {
    e ||
        (jQuery(
                '<h3 style="color:green;"> ID: ' +
                currentProductId +
                " 2- " +
                t +
                " Variations are loaded </h3>"
            ).appendTo(".log-sync-product"),
            jQuery(
                '<h3 style="color:green;"> ID: ' +
                currentProductId +
                " 3-  Getting new product variations ...</h3>"
            ).appendTo(".log-sync-product"),
            startLoadingText());
}
let variationsNotFound = 0;
jQuery(document).on("click", "#addToWaitingList", function(e) {
        (productId = jQuery(this)
            .parents(".card")
            .find("#sku")[0].innerText),
        productId
            ?
            importProductGloballyBulk(productId, !0) :
            displayToast("Cannot get product sku", "red");
    }),
    jQuery(document).on("click", "#emptyWaitingListProduct", function(e) {
        jQuery("#emptyWaitingListProduct").remove(),
            jQuery("#importProductInWaitingListToShop").remove(),
            (globalWaitingList = []);
    });
var globalWaitingList = [];

function addToWaitingList(e) {
    globalWaitingList.push(e),
        jQuery("#importProductInWaitingListToShop").remove(),
        jQuery("#emptyWaitingListProduct").remove(),
        jQuery(
            '<button type="button" id="importProductInWaitingListToShop" style="position:fixed; border-raduis:0px; right: 1%; bottom: 60px; width:15%;z-index:9999" class="waitingListClass btn btn-primary btn-lg"><i class="fa fa-envelope fa-3px"> Import waiting List <span badge badge-primary>' +
            globalWaitingList.length +
            "</span></i></button>"
        ).appendTo(jQuery("html")),
        jQuery(
            '<button type="button" id="emptyWaitingListProduct" style=" position:fixed; border-raduis:0px; bottom: 10px; right: 1%;  width:15%;z-index:9999" class="waitingListClass btn btn-danger btn-lg"><i class="fa fa-trash-o fa-3px">  Reset Waiting list </span></i></button>'
        ).appendTo(jQuery("html"));
}

function removeProductFromWP(e) {
    e &&
        (startLoading(),
            jQuery.ajax({
                url: wooshark_params.ajaxurl,
                type: "POST",
                dataType: "JSON",
                data: { action: "remove-product-from-wp", post_id: e },
                success: function(e) {
                    e && e.error && e.error_msg && displayToast(e.error_msg, "red"),
                        e && !e.error && e.data && displayToast(e.data, "green");
                },
                error: function(e) {
                    console.log("****err", e),
                        displayToast(e.responseText, "red"),
                        stopLoading();
                },
                complete: function() {
                    console.log("SSMEerr"), stopLoading();
                }
            }));
}
(indexStopLoading = 0),
jQuery(document).on("click", "#importProductInWaitingListToShop", function(
        e
    ) {
        startLoading(),
            jQuery("#emptyWaitingListProduct").remove(),
            jQuery("#importProductInWaitingListToShop").remove(),
            _savedConfiguration || (_savedConfiguration = {});
        for (var t = 0; t < globalWaitingList.length; t++)
            !(function(e) {
                window.setTimeout(function() {
                    let t = jQuery("#isImportImageVariationsSingleImport").prop(
                            "checked"
                        ),
                        r = jQuery("#isFeaturedProduct").prop("checked"),
                        a = jQuery("#isPublishProductSingleImport").prop("checked"),
                        i = jQuery("#includeShippingCostIntoFinalPrice").prop("checked");
                    var o = {
                        title: globalWaitingList[e].title,
                        description: globalWaitingList[e].description,
                        images: globalWaitingList[e].images,
                        variations: globalWaitingList[e].variations.variations,
                        prductUrl: globalWaitingList[e].productUrl,
                        mainImage: globalWaitingList[e].mainImage,
                        simpleSku: globalWaitingList[e].simpleSku,
                        productType: "variable",
                        attributes: globalWaitingList[e].variations.NameValueList,
                        shortDescription: "",
                        isFeatured: !0,
                        postStatus: !0,
                        postStatus: "publish"
                    };
                    jQuery.ajax({
                        url: wooshark_params.ajaxurl,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: "wooshark-insert-product",
                            sku: o.simpleSku.toString(),
                            title: o.title,
                            description: o.description || "",
                            productType: "variable",
                            mainImage: o.mainImage,
                            images: o.images || [],
                            attributes: o.attributes,
                            variations: o.variations,
                            postStatus: a ? "publish" : "draft",
                            shortDescription: o.shortDescription || "",
                            productUrl: getPRoductUrlFRomSku(o.simpleSku),
                            categories: _savedConfiguration ?
                                _savedConfiguration.bulkCategories : [],
                            isFeatured: r,
                            importVariationImages: t,
                            includeShippingCostIntoFinalPrice: i
                        },
                        success: function(e) {
                            e && e.error && e.error_msg && displayToast(e.error_msg, "red"),
                                e && !e.error && e.data && displayToast(e.data, "green");
                            if (e && e.error && e.error_msg && e.error_msg.includes('you have reached the permitted usage')) {
                                setTimeout(function() {
                                    window.open('https://wooshark.com/aliexpress', '_blank');
                                }, 4000);
                            }
                        },
                        error: function(e) {
                            console.log("****err", e),
                                e &&
                                displayToast(
                                    "error while inserting products, please retry",
                                    "red"
                                );
                        },
                        complete: function() {
                            console.log("SSMEerr"),
                                indexStopLoading++,
                                indexStopLoading == globalWaitingList.length &&
                                (stopLoading(), (globalWaitingList = []));
                        }
                    });
                }, 3e3 * e);
            })(t);
    }),
    jQuery(document).on("click", "#set-product-to-draft", function(e) {
        removeProductFromWP(jQuery(this).attr("idOfPRoductToRemove"));
    }),
    jQuery(document).on("click", "#remove-product-from-draft", function(e) {
        removeProductFromWP(jQuery(this).attr("idOfPRoductToRemove"));
    }),
    jQuery(document).on("click", "#remove-product-from-wp", function(e) {
        removeProductFromWP(jQuery(this).attr("idOfPRoductToRemove"));
    }),
    jQuery(document).on("click", "#importAllProductOnThisPage", function(e) {
        displayToast("This is premuim feature, please upgrade to use it"),
            setTimeout(function() {
                window.open("https://wooshark.com/aliexpress", "_blank");
            }, 4e3);
    });
var _isAuthorized = !1;

function getReviewsFromHtml(e, t) {
    e &&
        ((xmlhttp = new XMLHttpRequest()),
            (xmlhttp.onreadystatechange = function() {
                if (4 == xmlhttp.readyState && 200 === xmlhttp.status)
                    try {
                        data = JSON.parse(xmlhttp.response).data;
                        if ((jQuery("#table-reviews tbody").empty(), data && data.length)) {
                            var e = "";
                            jQuery("#loadMoreReviews").show(),
                                jQuery("#setRealRandomName").show(),
                                jQuery("#Load100Reviews").show(),
                                stopLoading(),
                                data.forEach(function(t) {
                                    (e =
                                        '<tr><td id="review" contenteditable>' +
                                        t.review +
                                        '</td><td id="username" contenteditable>' +
                                        getUsername() +
                                        '</td><td id="datecreation" contenteditable>' +
                                        getCreationDate() +
                                        '</td><td id="rating"><input type="number" min="1" max="5" value="5"></input></td><td id="email" contenteditable> emailNotVisible@unknown.com (you can change this)</td><td><button class="btn btn-danger" id="removeReview">X</button></td></tr></tr>'),
                                    jQuery("#table-reviews tbody").append(e);
                                }),
                                jQuery("#table-reviews tr td[contenteditable]").css({
                                    border: "1px solid #51a7e8",
                                    "box-shadow": "inset 0 1px 2px rgba(0,0,0,0.075), 0 0 5px rgba(81,167,232,0.5)"
                                });
                        } else
                            stopLoading(),
                            displayToast(
                                "No reviews for this sku using the preselected criteria"
                            );
                    } catch (e) {
                        stopLoading();
                    }
            }),
            xmlhttp.open(
                "POST",
                hostname + ":8002/getReviewsFeomAliExpressOfficialApi", !0
            ),
            xmlhttp.setRequestHeader("Content-Type", "application/json"),
            xmlhttp.send(JSON.stringify({ productId: e, pageNo: t })));
}

function getAlreadyImportedProducts(e) {
    jQuery.ajax({
        url: wooshark_params.ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: { action: "get-already-imported-products", listOfSkus: e },
        success: function(e) {
            let t = e;
            t && t.length && displayAlreadyImportedIcon(t),
                console.log("****response", e);
        },
        error: function(e) {
            e.responseText ?
                (console.log("****err", e), stopLoading()) :
                (console.log("****err", e),
                    displayToast("Error while getting list of products", "red"),
                    stopLoading());
        },
        complete: function() {
            console.log("SSMEerr"), stopLoading();
        }
    });
}

function displayAlreadyImportedIcon(e) {
    if (e && e.length) {
        let r = e.map(function(e) {
                return e.sku;
            }),
            a = jQuery("#product-search-container .card");
        for (var t = 0; t < a.length; t++) {
            let e = jQuery(a[t]).find("#sku")[0].innerText;
            if (r.indexOf(e) > -1) {
                jQuery(
                    '<div><a  style="width:80%; font-size:8px" id="alreadyImported" class=" btn btn-default">Already imported</a></div>'
                ).appendTo(jQuery(a[t]));
            }
        }
    }
}
jQuery(document).on("click", "#titiToto", function(e) {}),
    jQuery(document).on("click", "#loadMoreReviews", function(e) {
        getReviewsFromHtml(currentProductModalDisplayed, ++currentPageReviews);
    }),
    jQuery(document).on("click", "#searchCategoryByNameInput", function(e) {
        let t = jQuery("#searchCategoryByNameInput").val();
        t &&
            jQuery.ajax({
                url: wooshark_params.ajaxurl,
                type: "POST",
                dataType: "JSON",
                data: {
                    action: "search-category-by-name",
                    searchCategoryByNameInput: t
                },
                success: function(e) {
                    console.log("response----", e);
                },
                error: function(e) {
                    e.responseText ?
                        (console.log("****err", e),
                            displayToast(e.responseText, "red"),
                            stopLoading()) :
                        (console.log("****err", e),
                            displayToast("Error while getting list of products", "red"),
                            stopLoading());
                },
                complete: function() {
                    console.log("SSMEerr"), stopLoading();
                }
            });
    }),
    jQuery(document).on("click", "#searchCategories", function(e) {
        jQuery("#customProductCategory input:not(:checked)").each(function() {
            jQuery(this)
                .parent()
                .remove();
        });
        let t = jQuery("#categorySearchKeyword").val();
        t
            ?
            savedCategories &&
            savedCategories.length &&
            savedCategories.forEach(function(e, r) {
                e &&
                    e.name &&
                    e.name.includes(t) &&
                    ((items =
                            '<div class="checkbox"><label><input class="form-check-input mt-1" type="checkbox" value="' +
                            e.term_id +
                            '"/>' +
                            e.name +
                            "</label>"),
                        jQuery("#customProductCategory").append(jQuery(items)));
            }) :
            savedCategories &&
            savedCategories.length &&
            savedCategories.forEach(function(e, t) {
                (items =
                    '<div class="checkbox"><label><input class="form-check-input mt-1" type="checkbox" value="' +
                    e.term_id +
                    '"/>' +
                    e.name +
                    "</label>"),
                jQuery("#customProductCategory").append(jQuery(items));
            });
    });