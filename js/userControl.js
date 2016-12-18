function closeFcn(a, b, c)
{
    document.getElementById(a).removeAttribute("disabled");
    document.getElementById(b).style.display = "none";
    document.getElementById(c).style.display = "none";
}
function openForms(id)
{
    var elem = document.getElementById(id); 
    elem.style.display = elem.style.display !== "block" ? "block" : "none";
    if (elem.style.display === "block")
    {      
        var w = elem.getBoundingClientRect()["width"];
        var h = elem.getBoundingClientRect()["height"];
        var pos = document.documentElement.clientWidth / 2;
        pos = pos - w / 2;
        elem.style.left = (pos < 0 ? 0 : pos) + "px";
        
        pos = document.documentElement.clientHeight / 2;
        pos = pos - h / 2;
        elem.style.top = (pos < 0 ? 0 : pos) + "px";
        
        document.getElementById("shadow").style.display = "block";
    }
    else
    {
        document.getElementById("shadow").style.display = "none";   
    }
    
    var dt = new Date();
    var locDate = "";
        
    locDate += dt.getFullYear() + "-";
    locDate += (dt.getMonth() < 10 ? "0" : "") + (dt.getMonth() + 1) + "-";
    locDate += (dt.getUTCDate() < 10 ? "0" : "") + dt.getUTCDate() + "T";
    
    locDate += (dt.getHours() < 10 ? "0" : "") + dt.getHours() + ":";
    locDate += (dt.getMinutes() < 10 ? "0" : "") + dt.getMinutes() + "";
    document.forms.uMsg.date.value = locDate;
}

/* редактирование профиля */
document.getElementById("readProfileOpen").addEventListener("click", function(e)
{
    openForms("readProfileForm");
});

document.getElementById("newMsgOpen").addEventListener("click", function(e)
{
    openForms("newMsgForm");
});
/* Принять изменения */
document.getElementById("accept").addEventListener("click", function(e)
{
    document.getElementById("accept").setAttribute("disabled", "disabled");
    e.preventDefault();
    var readProfile = new XMLHttpRequest();
    readProfile.open("POST", "/msgSystem/php/readProfile.php", true);
    //readProfile.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var counter = document.forms.uProfile.length;
    //var bodyMsg = "";
    var formData = new FormData();
    for (var i = 0; i < counter; i++)
    {
        if (document.forms.uProfile[i].value === ""){continue;}
        /*bodyMsg += document.forms.uProfile[i].name + "=" + document.forms.uProfile[i].value + "&";*/
        if (document.forms.uProfile[i].name === "avatar")
        {
            formData.append(document.forms.uProfile[i].name, document.forms.uProfile[i].files[0]);
            //console.log(document.forms.uProfile[i].name);
            continue;
        }
        formData.append(document.forms.uProfile[i].name, document.forms.uProfile[i].value);
    }
    //bodyMsg = bodyMsg.substr(0, bodyMsg.length - 1);
    //readProfile.send(bodyMsg);
    readProfile.send(formData);
    readProfile.onload = function()
    {
        if (readProfile.status === 200)
        {
            setTimeout(function()
            {
                //console.log();
                var HTMLstr = document.forms.uProfile.surname.value + " ";
                HTMLstr += document.forms.uProfile.name.value + " ";
                HTMLstr += document.forms.uProfile.middleName.value;
                
                document.getElementById("FIO").innerHTML = "<span>" + HTMLstr + "</span>";
                document.getElementById("Udep").innerHTML = "<span>Отдел : " + document.forms.uProfile.department.value + "</span>";
                document.getElementById("Upos").innerHTML = "<span>Должность : " + document.forms.uProfile.position.value + "</span>";        
                document.getElementById("Umail").innerHTML = "<span>mail : " + document.forms.uProfile.email.value + "</span>";
                document.getElementById("Uphon").innerHTML = "<span>телефон : " + document.forms.uProfile.phone.value + "</span>";
                document.getElementById("Ulink").setAttribute("src", "/msgSystem/" + readProfile.responseText);
                /* ссылка на картинку добавить  "images/icons_user/avatar.png"*/
                //closeFcn("accept", "readProfileForm", "shadow");
                //console.log(readProfile.responseText);
            }, 1000);
        }
    }
});

/* отмена редактирования */
document.getElementById("cancel").addEventListener("click", function(e)
{
    e.preventDefault();
    closeFcn("accept", "readProfileForm", "shadow");
});

/* Отправка */
document.getElementById("sendMsg").addEventListener("click", function(e)
{
    e.preventDefault();
    if (document.forms.uMsg[0].value === "null" || document.forms.uMsg[2].value === "")
    {
        document.forms.uMsg[0].style.borderColor = "#F00";
        document.forms.uMsg[2].style.borderColor = "#F00";
        return 0;
    }
    else
    {
        document.forms.uMsg[0].style.borderColor = "#000";
        document.forms.uMsg[2].style.borderColor = "#000";
    }
    document.getElementById("sendMsg").setAttribute("disabled", "disabled");
    
    var newMsg = new XMLHttpRequest();
    newMsg.open("POST", "/msgSystem/php/addNewMsg.php");
    var formDataMsg = new FormData();
    formDataMsg.append(document.forms.uMsg[0].name, document.forms.uMsg[0].value);
    formDataMsg.append(document.forms.uMsg[1].name, document.forms.uMsg[1].value);
    formDataMsg.append(document.forms.uMsg[2].name, document.forms.uMsg[2].value);
    newMsg.send(formDataMsg);
    newMsg.onload = function()
    {
        if(newMsg.status === 200)
        {
            //console.log(newMsg.responseText);
            setTimeout(function()
            {
                document.forms.uMsg[2].value = "";
                closeFcn("sendMsg", "newMsgForm", "shadow");
                readMsg();
            }, 1000);
        }
    }
});

/* отмена отправки */
document.getElementById("cancelMsg").addEventListener("click", function(e)
{
    e.preventDefault();
    closeFcn("sendMsg", "newMsgForm", "shadow");

});

/* выход */
document.getElementById("exit").addEventListener("click", function(e)
{
    var exit = new XMLHttpRequest();
    exit.open("GET", "/msgSystem/php/exit.php", true);
    exit.send();
    exit.onload = function()
    {
        (exit.status === 200)
        {
            document.location.href = "/msgSystem/";
        }
    }
});

function readUser(e, a)
{
    e.preventDefault();
    var counter = document.forms[a].length;
    //var formData = new FormData();
    var bodyMsg = "";
    for (var i = 0; i < counter; i++)
    {
        //if (document.forms[a][i].value === ""){continue;}
        bodyMsg += document.forms[a][i].name + "=" + document.forms[a][i].value + "&";
        //formData.append(document.forms[a][i].name, document.forms[a][i].value);
    }
    //formData.append("id", a.replace("uId", ""));
    //bodyMsg = bodyMsg.substr(0, bodyMsg.length - 1);
    if (a == "newUserCreate")
    {
        var readProfile = new XMLHttpRequest();
        readProfile.open("POST", "/msgSystem/php/create.php", true);
        readProfile.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        readProfile.send(bodyMsg);
        readProfile.onload = function()
        {
            document.location.href = document.location.href;
            //console.log(readProfile.responseText);
        }
        return false;
    }
    var readProfile = new XMLHttpRequest();
    readProfile.open("POST", "/msgSystem/php/readAll.php", true);
    readProfile.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    readProfile.send(bodyMsg + "id=" + a.replace("uId_", ""));
    
    // readProfile.send(formData);
    readProfile.onload = function()
    {
        if (readProfile.status === 200)
        {
            setTimeout(function()
            {
                //console.log();
                /* ссылка на картинку добавить  "images/icons_user/avatar.png"*/
                //closeFcn("accept", "readProfileForm", "shadow");
                //console.log(readProfile.responseText);
                return false;
            }, 1000);
        }
    }
    return false;
}

function del(e, a)
{
    e.preventDefault();
    var del = new XMLHttpRequest();
    del.open("POST", "/msgSystem/php/delet.php", true);
    del.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    del.send("id=" + a.replace("uId_", ""));
    del.onload = function()
    {
        if(del.status === 200)
        {
            document.location.href = document.location.href;
            console.log(del.responseText);
        }
    }
}