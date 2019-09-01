(function($) {
	"use strict";

	$(function() {
		// define easeInOutQuint

		$.easing.jswing = $.easing.swing;
		$.extend($.easing, {
			easeInOutQuint: function(x, t, b, c, d) {
				if ((t /= d / 2) < 1) return (c / 2) * t * t * t * t * t + b;
				return (c / 2) * ((t -= 2) * t * t * t * t + 2) + b;
			}
		});

		function addResults(results) {
			if ($("#main-search-results h5").length === 0) {
				$("#main-search-results").append(
					"<h5>" + search_results.search_results_title_translate + "</h5>"
				);
			}

			if (results.length > 0) {
				$.each(results, function(index, result) {
					var theDate = result.date;

					var htmlResult = "<li class='article'><a href='" + result.link + "'>";

					if (result.image.length) {
						htmlResult +=
							"<div class='image bg' style='background: url(" +
							result.image +
							")'></div>";
					}
					htmlResult +=
						"<div class='desc'><h5 class='small'>" +
						result.title +
						"</h5><p class='grey'>" +
						theDate +
						"</p><p>" +
						result.content +
						"</p></div></a></li>";

					$("#main-search-results").append(htmlResult);
				});
			} else {
				$("#main-search-results").append(
					"<li class='not-found'>" +
						search_results.no_res_translate +
						"<span id='search-again'>" +
						search_results.try_again_translate +
						"</span></li>"
				);
			}
			$("#main-search-wrapper").addClass("opened");
		}

		// send term search
		function goSearch(searchTerm) {
			if (searchTerm.length < 3) {
				$("#main-search-results").empty();
				$("#main-search-x").removeClass("show");
			}
			$.ajax({
				url: search_results.ajaxurl,
				type: "POST",
				dataType: "json",
				data: {
					action: "search_results",
					security: search_results.security,
					term: searchTerm
				},
				success: function(response) {
					$(".fa-circle-o-notch").removeClass("show");
					$("#main-search-x").addClass("show");
					$("#main-search-results").empty();
					$("#main-search-results .not-found").remove();

					var results = [];

					$.each(response, function(index, result) {
						results.push({
							link: result.link,
							title: result.title,
							date: result.date,
							content: result.content,
							image: result.thumbnail_url
						});
					});
					return addResults(results);
				},
				error: function(response) {
					console.error("error", response);
				}
			});
		}

		// close popup

		function closePopup() {
			$(".popup").removeClass("show");
			$("body").removeClass("overflow-hidden");
			$("html").removeClass("overflow-hidden");
			$("#main-search-wrapper").removeClass("opened");
			$("#main-search-field").val("");
			$("#main-search-results").empty();
			setTimeout(function() {
				$(".popup").hide();
			}, 400);
		}

		$(".popup-background").click(function() {
			closePopup();
		});

		$(".close-search-popup").click(function() {
			closePopup();
		});

		$("body").keyup(function(e) {
			if (e.keyCode == 27) {
				closePopup();
			}
		});

		// Dont submit main search on enter
		$(".main-search-field").keypress(function(event) {
			if (event.which == 13) event.preventDefault();
		});

		// Clear Input
		$("#main-search-x").click(function(event) {
			$("input#main-search-field").val("");
			$("#main-search-wrapper").removeClass("opened");
			$("#main-search-results").empty();
			$(".fa-circle-o-notch").removeClass("show");
			$("#main-search-x").removeClass("show");
		});

		// search popup
		$("#open-search").click(function() {
			$("#popup-search").show();
			setTimeout(function() {
				$("#popup-search").addClass("show");
				$("#main-search-field").focus();
			}, 50);
		});

		var $inputs = $("#like-search, #main-search-field");

		$inputs.on("keyup", function() {
			$inputs.val($(this).val());
		});

		$inputs.on("input", function(event) {
			var searchTerm = $(this).val();

			if (searchTerm.length > 2) {
				$("#main-search-field").focus();
				$("#popup-search").show();
				$("body").addClass("overflow");
				$(".fa-circle-o-notch").addClass("show");
				$("#main-search-x").removeClass("show");

				goSearch(searchTerm);
			} else if (searchTerm.length < 3) {
				$("#main-search-wrapper").removeClass("opened");
				$("#main-search-results").empty();
				$(".fa-circle-o-notch").removeClass("show");
				$("#main-search-x").removeClass("show");
			}

			setTimeout(function() {
				$("#popup-search").addClass("show");
			}, 100);
		});
	});
})(jQuery);
