function simpleGet(uri, timeout) {
	setTimeout(function(){
		fetch(uri,{
		  header: {
			'Referer':'https://e-commerceaffiliates.com',
		  },
		  credentials: 'same-origin'
		}).then(function(response){
			response.text().then(function (text) {            
				text = text.replace(/\s+/g, "");
				var m = text.match(/<aclass=""><ahref="(.*?)">/g);
				m.forEach(function(item){
					console.info(item);
				});
			});
		})
	}, timeout);
}

var timeout=0,url = "https://e-commerceaffiliates.com/?page=";
//for (var i=1; i<219; i++)
for (var i=1; i<20; i++)
{
	timeout = 1000*i;
    simpleGet(url+i, timeout);
}