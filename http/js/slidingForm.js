var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(document).ready(()=>{
	
	//*********** Validation / custom jQuery ************//
	//Show the long desc field once desired
	$("a#showLongDescField").click(()=>{
		$(".hiddenField").removeAttr("style");
		$("a#showLongDescField").remove();
	});

	//Enable the "Next" button once all required fields are filled
	function checkFirstFieldsFilled(){
		//Todo, check ipfs hash regex
		if($("#req1").val() != "" && $("#req2").val() != ""){
			$("#but1").prop("disabled", false);
		}
		else{
			$("#but1").prop("disabled", true);
		}
	}

	$("#req1").bind("input", checkFirstFieldsFilled);
	$("#req2").bind("input", checkFirstFieldsFilled);

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
		console.log(cat);
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

	$(".submit").click(function(){
		return false;
	})

});