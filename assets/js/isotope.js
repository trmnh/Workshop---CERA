// filter .t-shirt
$grid.isotope({ filter: ".t-shirt" });

// filter .shoes
$grid.isotope({ filter: "shoes" });

// show all items
$grid.isotope({ filter: "*" });

// init Isotope
var $grid = $(".grid").isotope({
  // options
});
// filter items on button click
$(".filter-button-group").on("click", "button", function () {
  var filterValue = $(this).attr("data-filter");
  $grid.isotope({ filter: filterValue });
});
