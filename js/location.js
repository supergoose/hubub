var error_txt = "Geolocation is not supported by this browser.";

function initLocation(showPosition, errorFunc)
{

	if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
    	console.log("ERROR: ", error_txt);
    	if(location_txt != null)
    	{
    		//updateText(error_txt);
            errorFunc(error_txt);
    	}
    }
}