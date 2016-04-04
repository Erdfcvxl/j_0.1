function centerInBox(boxW, boxH, imgW, imgH, imgID) {
	var margin = Array();

	margin[0] = (boxW - imgW) / 2;
	margin[1] = (boxH - imgH) / 2;

	$(imgID).css({	"position" : "relative", 
					"margin-left" : margin[0] + "px", 
					"margin-top" : margin[1] + "px"
				});
}

function centerInBoxBg(boxW, boxH, imgW, imgH, imgID) {
	var margin = Array();

	margin[0] = (boxW - imgW) / 2;
	margin[1] = (boxH - imgH) / 2;

	$(imgID).css({	"background-position" : margin[0] + "px " + margin[1] + "px",
					//"margin-top" : margin[1] + "px"
				});
}