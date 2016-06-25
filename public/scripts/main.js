var setupXmlHttp = function(successFunction) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = successFunction;
};

var showMessage = function (_msg) {
    hideMessage();
    var messageArea = document.getElementById("message-area");
    messageArea.innerHTML = _msg;
    messageArea.style.display = 'block';
    setTimeout(function() {
        hideMessage();
    }, 2000);
};

var hideMessage = function () {
    document.getElementById("message-area").style.display = 'none';
};

var loadDataOnTable = function(jsonData) {
    for (var i = 0; i < jsonData.length; i++) {
        try {
            document.getElementById("name-" + jsonData[i].date).innerHTML = jsonData[i].name + ', '+ jsonData[i].email;

            /*remove date from selection option*/
            var alocatedDateOption = document.getElementById('freedate-' + jsonData[i].date);
            alocatedDateOption.parentNode.removeChild(alocatedDateOption);
        } catch (e) {
            //console.log(e);
        }
    }
};

var postData = function() {

    showMessage('Adding Appointment..');

    aDate = document.getElementById("adate").value;
    name = document.getElementById("name").value;
    email = document.getElementById("email").value;
    data = "date=" + aDate + "&name=" + name + "&email=" + email;

    offline = document.getElementById("offline").checked;
    if(true === offline) {

        savedData = JSON.parse(localStorage.getItem('data')) || [];
        savedData.push(data);
        localStorage.setItem('data', JSON.stringify(savedData));
        showMessage('Saved in offline mode! System will sync your data while connection established .');

        return false;
    }
    postAjax(data);
};

var postAjax = function(data) {
    setupXmlHttp(function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                jsonData = JSON.parse(xmlhttp.responseText);
                if(jsonData.status == 'Success') {
                    loadDataOnTable(jsonData.data);
                    /*reset form input*/
                    document.getElementById("name").value = '';
                    document.getElementById("email").value = '';
                }
                showMessage(jsonData.msg);

            }
            else if (xmlhttp.status == 400) {
                jsonData = JSON.parse(xmlhttp.responseText);
                showMessage(jsonData.msg);
            }
            else {
                showMessage('something else other than 200 was returned');
            }
        }});

    xmlhttp.open("POST", "/api/post", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    try {
        xmlhttp.send(data);
    } catch (e) {
        //console.log(e);
    }
}
var successFunctionForGet = function () {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
        if (xmlhttp.status == 200) {
            jsonData = JSON.parse(xmlhttp.responseText);
            loadDataOnTable(jsonData.data);
        }
        else if (xmlhttp.status == 400) {
            showMessage('There was an error 400');
        }
        else {
            showMessage('something else other than 200 was returned');
        }
    }
};

var loadAppoints = function(successFunction) {

    try {
        var dateFrom = document.getElementById("date-from").value;
    } catch (e) {
        dateFrom = '';
    }
    setupXmlHttp(successFunction);
    xmlhttp.open("GET", "/api/get/?date=" + dateFrom, true);
    xmlhttp.send();
};

/*sync offline data*/
var modeChanged = function() {
    if( true == document.getElementById("offline").checked)
        return false;
    if(localStorage.getItem('data') === null)
        return false;

    unPostedData = JSON.parse(localStorage.getItem('data'));
    //console.log(unPostedData);
    showMessage('Syncing..');
    for (var i = 0; i < unPostedData.length; i++) {
        postAjax(unPostedData.pop());
    }
    localStorage.setItem('data', JSON.stringify(unPostedData));
}

/*load data of tables*/
window.onload = loadAppoints(successFunctionForGet);

