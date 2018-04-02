var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

// WARNING: The order or content of those are directly related to database indexes
// WARNING: You WILL have to make changes to your database and this script if you want to make this 
// thing work
// The values you see here are simply placeholder values for an example
const subcatMovies = ["Action", "Polar", "Comédie"];
const subcatSeries = ["Action", "Polar", "Comédie"];
const subcatMusic = [];
const subcatGames = [];
const subcatSoftware = [];
const subcatAnime = [];
const subcatBooks = [];
const subcatXXX = [];
const subcatOthers = [];

$(document).ready(()=>{

	var md_converter = new showdown.Converter();
	
	//*********** Validation / custom jQuery ************//
	function isUrlValid(url) {
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
	}

	function isHashValid(hash) {
		return /^\/ipfs\/Qm[1-9A-HJ-NP-Za-km-z]{44}(\/.*)?|^\/ipns\/.+/.test(hash);
	}

	function previewMD() {
		$("#long_desc_preview").html(md_converter.makeHtml($(".hiddenField").val()));
	}



	//Show the long desc field once desired
	$("a#showLongDescField").click(function(){
		$(".hiddenField").removeAttr("style");
		$("#preview_link").removeAttr("style").click(previewMD);
		$(this).remove();
	});

	//Enable the "Next" button once all required fields are filled

	// REQ1 => Title, validated by plugin
	// REQ2 => IPFS hash
	// OPT1 => HTTP mirror
	function checkFirstFieldsFilled(){
		var correctIPFSRegex = isHashValid($("#req2").val());
		var correctHTTPRegex = $("#opt1").val() == "" || isUrlValid($("#opt1").val());
		var allCorrect = true;

		//If the hash field holds correct values
		if(!correctIPFSRegex) {
			$("#req2").attr("style", "color: #ff504c;font-weight: bold;");
			allCorrect = false;
		}
		else {
			$("#req2").removeAttr("style");
		}

		//If the HTTP field holds correct values
		if(!correctHTTPRegex) {
			$("#opt1").attr("style", "color: #ff504c;font-weight: bold;");
			allCorrect = false;
		}
		else {
			$("#opt1").removeAttr("style");
		}

		//If all fields hold correct values
		if (allCorrect){
			$("#but1").prop("disabled", false);
		}
		else{
			$("#but1").prop("disabled", true);
		}
	}

	$("#req1").bind("input", checkFirstFieldsFilled);
	$("#req2").bind("input", checkFirstFieldsFilled);
	$("#opt1").bind("input", checkFirstFieldsFilled);

	//Same for the submit button and categories.
	function updateSubcategories(){
		var cat = $("select[name=cat]").val();
		if(cat != ""){
			fillSubcategories(cat);
			$("select[name=subcat]").prop("disabled", false);
		}
		else{
			$("select[name=subcat]").prop("disabled", true);	
		}
	}

	function fillSubcategories(cat){
		var arrToIterate = [];

		$("select[name=subcat]").empty();
		$("select[name=subcat]").append('<option value="">-- Sous-catégorie (requis)</option>');

		switch (cat){
			case "1":
				arrToIterate = subcatMovies;
				break;
			case "2":
				arrToIterate = subcatSeries;
				break;
			case "3":
				arrToIterate = subcatMusic;
				break;
			case "4":
				arrToIterate = subcatGames;
				break;
			case "5":
				arrToIterate = subcatSoftware;
				break;
			case "6":
				arrToIterate = subcatAnime;
				break;
			case "7":
				arrToIterate = subcatBooks;
				break;
			case "8":
				arrToIterate = subcatXXX;
				break;
			case "9":
				arrToIterate = subcatOthers;
				break;
			default:
				arrToIterate = ["Erreur, avez vous fait inspecter l'élément tel un hacker de l'extrême?"];
				break;
		}

		$(arrToIterate).each((index, element)=>{
			$("select[name=subcat]").append('<option value="' + (index + 1) + '">' + element + '</option>');
		});

	}

	function updateSubmitButton(){
		if ($("select[name=subcat]").val() != "") {
			$("input[type=submit]").prop("disabled", false);
		}
		else{
			$("input[type=submit]").prop("disabled", true);	
		}
	}

	$("select[name=cat]").change(updateSubcategories);
	$("select[name=subcat]").change(updateSubmitButton);


	//********** Stock jQuery for front ***********//
	//jQuery time
	$(".next").click(function(){
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
	        'transform': 'scale('+scale+')',
	        'position': 'absolute'
	      });
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeOutExpo'
		});
	});

	$(".previous").click(function(){
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();
		
		//de-activate current step on progressbar
		$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
		
		//show the previous fieldset
		previous_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale previous_fs from 80% to 100%
				scale = 0.8 + (1 - now) * 0.2;
				//2. take current_fs to the right(50%) - from 0%
				left = ((1-now) * 50)+"%";
				//3. increase opacity of previous_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({'left': left});
				previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	});
});