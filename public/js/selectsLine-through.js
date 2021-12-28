function torikeshi(id) {
	var div = document.getElementById(id);
	if(div.style.textDecoration=="line-through"){
		div.style.textDecoration="none";
	}else{
		div.style.textDecoration="line-through";
	}
}

