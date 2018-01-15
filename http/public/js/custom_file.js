$(document).ready(() => {

	/** File global variables */
	var file_id = $("html").data("file-id");
	var number_of_likes = 0;
	var number_of_dislikes = 0;

	number_of_dislikes = parseInt($("#likeProgressBar").data("initial-dislikes"));
	number_of_likes = parseInt($("#likeProgressBar").data("initial-likes"));

	/** Functions declarations */

	/**
	* updateProgressBar
	*   Updates the progress bar to show the correct percentage
	* @return 
	*    void
	*/
	function updateProgressBar() {
		var percentage = number_of_dislikes === 0 ? 100 : Math.round(number_of_likes / number_of_dislikes) * 100;
		if (number_of_likes === 0 && number_of_dislikes === 0)
			percentage = 50;

		// The real progress bar
		$("#likeProgressBar")
			.find(".progress-bar")
			.attr("aria-valuenow", percentage)
			.attr("style", "width: " + percentage +"%;")
		.parent()
			.find(".sr-only")
			.text(percentage + "% liked");

		// The numbers on the left & right
		$("#likeRatio")
			.find(".numberLikes")
			.text(number_of_likes)
		.parent()
			.find(".numberDislikes")
			.text(number_of_dislikes);
	}

	/**
	* alertError
	* 	Displays a generic error message to the user
	* @return boolean
	*	Consistently returns false
	*/
	function alertError() {
		alert("Oups, une erreur s'est produite. Réessayez plus tard, ou parlez-en directement aux admins!");
		return false;
	}

	/**
	* sendFlag
	* @param actionValue as string, INPUT 
	* 	The flag to apply. Possible values are to be seen in action_manage_flags
	* @param callbackSuccess as function, INPUT
	*	The function to be executed if everything went right (play an animation, chnage the color of the button, etc)
	* @param printSelector as string, INPUT
	*	If the server's answer must be printed on the page, then the received text will be appended to the given selector
	* @return void
	*	nothing
	*/
	function sendFlag(actionValue, callbackSuccess, printSelector = "body") {
		$.post(
			"../../parts/action_manage_flags.php",
			{
				action: actionValue,
				fileid: file_id
			}
		)
		.done((data) => {
			try {
				data = JSON.parse(data);
				if (data.print === null || data.print === undefined) {
					console.log("Missing 'print' value.");
					alertError();
				}
				else if (data.error) {
					console.log(data.content);
					alertError();
				}
				else if (data.print) {
					//Print the message on the HTML page
					$(printSelector).append(data.content);
					
					if(!data.noCallback)
						callbackSuccess();
				}
				else {
					if(data.content != undefined)
						console.log(data.content);
					
					if(!data.noCallback)
						callbackSuccess();
				}
			}
			catch (e) {
				console.log("Invalid JSON received.");
				console.log(data);
				console.log(e);
				alertError();
			}
		})
		.fail(() => {
			console.log("Like could not be sent.");
			alertError();
		});
	}

	/** Instructions start here */

	updateProgressBar();

	$("#likeBut").click(function() {
		sendFlag(
			"like", 
			() => {
				// Would have liked $.toggleClass(), but we can't know if removed or added

				if ($(this).hasClass("active")) {
					$(this).removeClass("active");
					number_of_likes--;
				}
				else {
					$(this).addClass("active");
					number_of_likes++;

					if ($("#dislikeBut").hasClass("active")) {
						$("#dislikeBut").removeClass("active");
						number_of_dislikes--;
					}
				}
				updateProgressBar();
			}
		);
	});

	$("#dislikeBut").click(function(){
		sendFlag(
			"dislike", 
			() => {
				// Would have liked $.toggleClass(), but we can't know if removed or added

				if ($(this).hasClass("active")) {
					$(this).removeClass("active");
					number_of_dislikes--;
				}
				else {
					$(this).addClass("active");
					number_of_dislikes++;

					if($("#likeBut").hasClass("active")) {
						$("#likeBut").removeClass("active");
						number_of_likes--;
					}
				}
				updateProgressBar();
			}
		);
	});
});