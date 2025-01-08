$(document).ready(function () {
  $("#searchInput").on("keyup", function () {
    var query = $(this).val();
    if (query != "") {
      $.ajax({
        url: "search.php",
        method: "GET",
        data: { query: query },
        success: function (data) {
          $("#searchResults").html(data);
          $("#searchResults").css("display", "block");
        },
      });
    } else {
      $("#searchResults").css("display", "none");
    }
  });

  $(document).on("click", ".search-result-link", function (e) {
    e.preventDefault();
    var link = $(this).attr("href");
    var hash = link.split("#")[1];

    if (hash) {
      var targetElement = document.getElementById(hash);

      if (targetElement) {
        // Menyoroti elemen yang sesuai
        $(".tab-pane").removeClass("active show");
        $(targetElement).closest(".tab-pane").addClass("active show");
        $("html, body").animate(
          {
            scrollTop: $(targetElement).offset().top,
          },
          1000
        );
        targetElement.classList.add("highlight", "animate-highlight");

        setTimeout(function () {
          targetElement.classList.remove("animate-highlight");
        }, 2000);
      }
    }
  });
});
