jQuery(document).ready(function(a){function n(b){a("#filter_search").data("val");return d=a("#location_search").val(),""==d&&(sessionStorage.setItem("filter-searchInput",""),sessionStorage.setItem("filter-sectorsSelectValue",""),sessionStorage.setItem("filter-companySelect",""),sessionStorage.setItem("filter-OrderSelect",""),sessionStorage.setItem("filter-OrderSelectValue","")),sessionStorage.setItem("filter-searchInput",d),window.location.href=m,!1}var d,e,f,m="https://www.esic.directory/esic-database.html";a("body").on("click touchstart","#show-filter",function(b){b.preventDefault(),a("#filter #selectDiv").slideToggle("slow")}),a("body").on("click touchstart","#filter_reset",function(b){b.preventDefault(),a(".module select").val(a("module select option:first").val()),a(".module input").val("")}),a("#dateAddedOrderSelect").change(function(){e="added_date";var b=a(this).val();a(".module .sortFilters select").val(a(".module .sortFilters select option:first").val()),a(this).val(b);var c=JSON.stringify(b);f='"asc"'==c?"asc":"desc"}),a("#assessmentOrderSelect").change(function(){e="corporate_date";var b=a(this).val();a(".module .sortFilters select").val(a(".module .sortFilters select option:first").val()),a(this).val(b);var c=JSON.stringify(b);f='"asc"'==c?"asc":"desc"}),a("#expiryOrderSelect").change(function(){e="expiry_date";var b=a(this).val();a(".module .sortFilters select").val(a(".module .sortFilters select option:first").val()),a(this).val(b);var c=JSON.stringify(b);f='"asc"'==c?"asc":"desc"}),a("body").on("click touchstart","#filter_search",function(a){a.preventDefault();var b="filter_search";n(b)}),a("#location_search").keypress(function(b){13===b.which&&a("#filter_search").focus().click()}),a(".qmulti-item-carousel .item").each(function(){var b=a(this).next().next().next().next().next().next().next();b.length||(b=a(this).siblings(":first")),b.children(":first-child").clone().appendTo(a(this)),b.next().length>0?b.next().children(":first-child").clone().appendTo(a(this)):a(this).siblings(":first").children(":first-child").clone().appendTo(a(this))})});