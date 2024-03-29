<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seventh-day Adventist Hymns</title>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/axios/dist/axios.standalone.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/CryptoJS/rollups/hmac-sha256.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/CryptoJS/rollups/sha256.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/CryptoJS/components/hmac.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/CryptoJS/components/enc-base64.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/url-template/url-template.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/apiGatewayCore/sigV4Client.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/apiGatewayCore/apiGatewayClient.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/apiGatewayCore/simpleHttpClient.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/lib/apiGatewayCore/utils.js"></script>
    <script type="text/javascript" src="apiGateway-js-sdk/apigClient.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<a href="https://bible.onecloudapps.net">Bible</a>
<a href="https://egw.onecloudapps.net">EGW</a>
<a href="https://hymns.onecloudapps.net">Hymns</a>


<body>
<div class="w3-top">
    <div class="w3-bar w3-black w3-card">
        <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
        <a href="#" class="w3-bar-item w3-button w3-padding-large">HOME</a>
        <a href="https://bible.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Bible</a>
        <a href="https://egw.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large w3-hide-small">EGW</a>
        <a href="https://hymns.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Hymns</a>
        <a href="https://stories.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Stories</a>
        <a href="https://giovanni.saberon.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Videos</a>

        <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="#" class="w3-bar-item w3-button">Merchandise</a>
                <a href="#" class="w3-bar-item w3-button">Extras</a>
                <a href="#" class="w3-bar-item w3-button">Media</a>
            </div>
        </div>
        <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>
    </div>
</div>

<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
    <a href="https://bible.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Bible</a>
    <a href="https://egw.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">EGW</a>
    <a href="https://hymns.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Hymns</a>
    <a href="https://stories.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Stories</a>
    <a href="https://giovanni.saberon.onecloudapps.net" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Videos</a>
</div>

<br><br><br>
<h1>Seventh-day Adventist Hymns</h1>
<div id="status"></div>
<input id="searchInput" type="text" onkeyup="search()">

<div id="searchResults"></div>
<label>Sort: </label>
<div id="sortType"></div>
<div id="filter"></div>


<button style="display:none" onclick="showList()" id="backToListButton">BACK</button>

<div id="list"></div>
<div style="display:none" id="lyricsDisplay"></div>

</body>

<script>

    var hymns;
    var sorttype;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //        // Typical action to be performed when the document is ready:
            var jsonObj = JSON.parse(this.responseText);
            hymns = jsonObj.hymns;

            txt = "<ul  style='list-style-type: none;' id=hymnsList>";
            for (var i=0; i<hymns.length; i++){
                var title = hymns[i]["title"];
                var number = hymns[i]["number"];
                var lastAccessed = hymns[i]["lastAccessed"];
                var viewCount = hymns[i]["viewCount"];
                var verses = hymns[i]["verses"];
                var lyrics = "";
                var onclick = "";
                lyrics += "<h1>"+number + " - " + title.replace(/'/g, "singlequote") + "</h1>";
                for (var x =0; x<verses.length; x++){
                    var keyvalue= verses[x];
                    for (var key in keyvalue){
                        lyrics += "<h3>"+key+"</h3>";
                        escapedverse = keyvalue[key].replace(/'/g, "singlequote");
                        lyrics += "<p>"+escapedverse+"</p>";

                    }

                }
                // onclick += " onclick=";
                // onclick += "'displayLyrics(\"";
                // onclick += lyrics;
                // onclick += "\")'";
                // onclick = ' onclick=\'displayLyrics(\''+lyrics+','+(number)+'\')\'';
                txt +=  "<li><a onclick=\'displayLyrics(\""+lyrics+"\", \""+(number-1)+"\")\' href='#'>"+number+" "+title+"</a></li>";
                // txt += "<p>last viewed: " + lastAccessed+"</p>";
                // txt += "<p>view count: " + viewCount+"</p>";
            }
            txt += "</ul>";
            document.getElementById("list").innerHTML = txt ;
            sort(hymns);

        }else{
            // document.getElementById("status").innerHTML = this.status.toString() + this.readyState ;

        }

    };
    xhttp.open("GET", "hymns.json", true);
    xhttp.send();

    function displayLyrics(lyrics, hymnNumber){
        //show back button
        showBackButton();
        //hide list
        hideList();
        //show lyrics
        document.getElementById("lyricsDisplay").style.display = "block";
        document.getElementById("lyricsDisplay").innerHTML = lyrics.replace(/singlequote/g, "'");
        update(hymnNumber);


    }

    function update(hymnNumber){
        hymns[hymnNumber].lastAccessed = Date.now().toString();
        var currentViewCount = hymns[hymnNumber].viewCount;
        hymns[hymnNumber].viewCount = (parseInt(currentViewCount) + 1).toString();
        var apigClient = apigClientFactory.newClient();
        var params = {
            // This is where any modeled request parameters should be added.
            // The key is the parameter name, as it is defined in the API in API Gateway.
            param0: '',
            param1: ''
        };

        var body = {
            // This is where you define the body of the request,
        };

        var additionalParams = {
            // If there are any unmodeled query parameters or headers that must be
            //   sent with the request, add them here.
            // headers: {
            //     param0: '',
            //     param1: ''
            // },
            queryParams: {
                number: hymnNumber
            }
        };
        try{
            apigClient.historyGet(params, body, additionalParams)
                .then(function(result){
                    // document.getElementById("status").innerHTML = "success";
                }).catch( function(result){
                // Add error callback code here.
                // document.getElementById("status").innerHTML = "failure" + JSON.stringify(result);

            });
        }catch (e) {
            document.getElementById("status").innerHTML = e.toString();

        }


        // var hymnNumber = 1;
        // window.location.href = "https://jilpzog1zl.execute-api.ap-southeast-2.amazonaws.com/test/history?number="+hymnNumber;
        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         document.getElementById("demo").innerHTML = this.responseText;
        //     }
        // };
        // xhttp.open("POST", "https://jilpzog1zl.execute-api.ap-southeast-2.amazonaws.com/test/history", true);
        // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // var params = "number="+hymnNumber;
        // xhttp.send(params);
        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function () {
        //     if (this.readyState == 4 && this.status == 200) {
        //         document.getElementById("status").innerHTML = this.status.toString() ;
        //     }else{
        //         document.getElementById("status").innerHTML = "error" ;
        //     }
        //
        // };
        // xhttp.open("GET", "https://jilpzog1zl.execute-api.ap-southeast-2.amazonaws.com/test/history?number=1", true);
        // xhttp.send();
    }

    function hideLyrics(){
        document.getElementById("lyricsDisplay").style.display = "none";
        document.getElementById("lyricsDisplay").innerHTML = "";

    }

    function hideList(){
        document.getElementById("list").style.display = "none";

    }

    function showList(){
        refresh();
        document.getElementById("list").style.display = "block";
        hideLyrics();
        hideBackButton();

    }

    function showBackButton(){
        document.getElementById("backToListButton").style.display = "block";

    }

    function hideBackButton(){
        document.getElementById("backToListButton").style.display = "none";

    }

    function updateViewCount(){

    }

    function updateLastAccessed(){

    }

    function refresh(){
        var sortoption = document.getElementById("sortOptions").value;
        if (sortoption=="recent"){
            sortByRecentlyViewed();
        }
    }
    function sort(jsonHymns){
        hymns = jsonHymns;
        var txt = "";
        txt +="<select id=\"sortOptions\" onchange=\"sorter()\">";
        txt +="    <option selected value=\"recent\">Recently Viewed</option>";
        txt +=" <option value=\"popular\">Most Popular</option>";
        txt +=" <option selected value=\"asc\">A-Z</option>";
        txt +="    <option value=\"desc\">Z-A</option>";
        txt +="    <option value=\"numberASC\">Number Ascending</option>";
        txt +="    <option value=\"numberDESC\">Number Descending</option>";

        txt +="    </select>";
        // txt +="<button onclick='refresh()'>Refresh</button>";
        document.getElementById("filter").innerHTML = txt;

    }

    function sorter(){
        showList();
        var option = document.getElementById("sortOptions").value;
        if(option==="recent"){

            sortByRecentlyViewed();
            // displayHymns();
        }
        if(option==="popular"){
            sortByPopularity();
        }
        if(option==="asc"){
            sortByTitleAsc();
        }
        if(option==="desc"){
            sortByTitleDesc();
        }
        if(option==="numberASC"){
            sortByNumberAsc();
        }
        if(option==="numberDESC"){
            sortByNumberDesc();
        }

    }

    function sortByRecentlyViewed(){
        sorttype = "recent";
        document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(function(a, b){return b.lastAccessed - a.lastAccessed});
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }

    function sortByPopularity(){
        sorttype = "popular";
        document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(function(a, b){return b.viewCount - a.viewCount});
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }

    function displayHymns(hymns){
        document.getElementById("searchResults").innerHTML = hymns.length.toString();

        // var hymns = JSON.parse("{ \"hymns\": "+ hymnarray.toString() + "}");
        txt = "<ul  style='list-style-type: none;' id=hymnsList>";
        for (var i=0; i<hymns.length; i++){
            var title = hymns[i]["title"];
            var number = hymns[i]["number"];
            var lastAccessed = hymns[i]["lastAccessed"];
            var viewCount = hymns[i]["viewCount"];
            var verses = hymns[i]["verses"];
            var lyrics = "";
            var onclick = "";
            lyrics += "<h1>"+number + " - " + title.replace(/'/g, "singlequote") + "</h1>";
            for (var x =0; x<verses.length; x++){
                var keyvalue= verses[x];
                for (var key in keyvalue){
                    lyrics += "<h3>"+key+"</h3>";
                    escapedverse = keyvalue[key].replace(/'/g, "singlequote");
                    lyrics += "<p>"+escapedverse+"</p>";

                }

            }
            // onclick += " onclick=";
            // onclick += "'displayLyrics(\"";
            // onclick += lyrics;
            // onclick += "\")'";
            // onclick = ' onclick=\'displayLyrics(\''+lyrics+','+(number)+'\')\'';
            var date = new Date(parseInt(lastAccessed)*1000);
            if(sorttype=="title" || sorttype=="recent" || sorttype=="popular"){
                txt +=  "<li><a onclick=\'displayLyrics(\""+lyrics+"\", \""+(number-1)+"\")\' href='#'>"+title+" - "+number+ "</a> (views: "+viewCount+", lastViewed: "+date+")</li>";

            }
            if(sorttype=="number"){
                txt +=  "<li><a onclick=\'displayLyrics(\""+lyrics+"\", \""+(number-1)+"\")\' href='#'>"+number+" - "+title+ "</a> (views: "+viewCount+", lastViewed: "+date+")</li>";

            }

            // txt += "<p>last viewed: " + lastAccessed+"</p>";
            // txt += "<p>view count: " + viewCount+"</p>";
        }
        txt += "</ul>";
        document.getElementById("list").innerHTML = txt ;

        // sort(hymns);
    }

    function sortByTitle(x, y){
        return ((x.title == y.title) ? 0 : ((x.title > y.title) ? 1 : -1 ));

    }
    function sortByTitleAsc() {
        sorttype = "title";
        // displayHymns(hymns);
        // document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(sortByTitle);
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }


    function sortByTitleZA(x, y){
        return ((x.title == y.title) ? 0 : ((x.title < y.title) ? 1 : -1 ));

    }
    function sortByTitleDesc() {
        sorttype = "title";
        // displayHymns(hymns);
        // document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(sortByTitleZA);
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }

    function sortByNumber(x, y){
        return ((parseInt(x.number) == parseInt(y.number)) ? 0 : ((parseInt(x.number) > parseInt(y.number)) ? 1 : -1 ));

    }
    function sortByNumberAsc() {
        sorttype = "number";
        // displayHymns(hymns);
        // document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(sortByNumber);
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }


    function sortByNumberDescending(x, y){
        return ((parseInt(x.number) == parseInt(y.number)) ? 0 : ((parseInt(x.number) < parseInt(y.number)) ? 1 : -1 ));

    }
    function sortByNumberDesc() {
        sorttype = "number";
        // displayHymns(hymns);
        // document.getElementById("searchResults").innerHTML = "hello";
        try{
            var hymnarray = [];
            for (var i=0; i<hymns.length; i++){
                hymnarray.push(hymns[i]);
            }
            hymnarray.sort(sortByNumberDescending);
            document.getElementById("searchResults").innerHTML = hymnarray[0]["title"];
            displayHymns(hymnarray);

        }catch (e) {
            document.getElementById("searchResults").innerHTML = "failure: "+ e;

        }
    }

    function search(){
        showList();
        // var keyword = document.getElementById("searchInput").value;
        // document.getElementById("searchResults").innerHTML = keyword;
        // Declare variables
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("hymnsList");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    // Used to toggle the menu on small screens when clicking on the menu button
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }



</script>
</html>
