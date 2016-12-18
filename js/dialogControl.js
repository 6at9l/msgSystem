function selectNewMsg()
{
    //document.getElementById("gifLoad_id").style.display = "block";
    var newMsgL = new XMLHttpRequest();
    newMsgL.open("POST", "/msgSystem/php/returnNewMsg.php");
    var formDataMsg = new FormData();
    newMsgL.send();
    newMsgL.onload = function()
    {
        if(newMsgL.status === 200)
        {
            var countMsgNew = 0;
            var arr = newMsgL.responseText.split("###");
            document.getElementById("newMsgList").innerHTML = "";
            var count = arr.length;
            for(var i = 0; i < count; i++)
            {
               if(arr[i].indexOf("dialogId") + 1)
               {
                    var arr_num2 = arr[i].split("@@@");
                    try
                    {
                        var str = document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).innerHTML;
                    }
                    catch(err)
                    {
                        readMsg();
                        //var str = document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).innerHTML;
                        return;
                    }
                    var num = str.indexOf('class="noShowMsg"');
                    num = (str.indexOf('class="noShowMsg"') + 1) ? num : str.indexOf('class="showMsg"');
                    if (num < 0)
                    {
                        continue;
                    }
                    var body = str.substr(num);
                    var head = str.substr(0, num);
                    try
                    {
                        str = head + arr[i + 1] + body;
                        document.getElementById("newMsgList").innerHTML += arr[i + 1].replace("noShowMsg", "showMsg");
                        countMsgNew++;
                    }
                    catch(err)
                    {
                        console.log(err);
                        return;
                        //
                    }
                   
                    /*
                    if (window.flag_first_run)
                    {
                        for (var k = 0; k < document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).childNodes.length; k++)
                        {
                            if (document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).childNodes[k].className === "control")
                            {
                                var bufferTemp = document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).childNodes[k].innerHTML;
                                if (bufferTemp.indexOf("close") + 1)
                                {
                                    str = str.replace("noShowMsg", "showMsg");
                                }
                                else
                                {
                                    str = str.replace("showMsg", "noShowMsg");
                                }
                                var bufferStr1 = document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).innerHTML;
                                var bufferStrT1 = arr_num2[1];
                                var bufferStrT2 = arr_num2[2];
                                if (!((bufferStr1.indexOf(bufferStrT1) + 1) && (bufferStr1.indexOf(bufferStrT2) + 1)))
                                {
                                    try
                                    {
                                        console.log(str);
                                        document.getElementById(arr_num2[0].replace("dialogId", "for_insert_")).innerHTML = str;
                                        str = "";
                                    }
                                    catch(err){}   
                                }
                                break;
                            }   
                        }      
                    }
                    else
                    {
                        window.flag_first_run = true;
                    }
                    */
               }
               
            }
            document.getElementById("newMsgList").innerHTML += window.closeVirtual;
            document.getElementById("counter").innerHTML = "НОВЫХ " + countMsgNew;
            //document.getElementById("gifLoad_id").style.display = "none";
        }
        if (countMsgNew > 0) { readMsg();}
        setTimeout(selectNewMsg, 1000 * 60 * 10);
    }
    
}

function setStatusMsg()
{
    var bodyID = "arrId=";
    var arrElem = document.getElementById("newMsgList").childNodes;
    var count = arrElem.length;
    
    for (var i = 0; i < count; i++)
    {
        //console.log(arrElem[i].id);
        try
        {
            if (arrElem[i].id.indexOf("helpVar_") + 1)
            {
                bodyID += arrElem[i].id.replace("helpVar_", "") + "|";
            }
        }
        catch(err){}
    }
    bodyID = bodyID.substr(0, bodyID.length - 1);
    var newMsgS = new XMLHttpRequest();
    newMsgS.open("POST", "/msgSystem/php/setStatus.php");
    newMsgS.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    newMsgS.send(bodyID);
    newMsgS.onload = function()
    {
        if (newMsgS.status === 200)
        {
            //console.log(newMsgS.responseText);
        }
    }
    
}
window.onload = function()
{
    //selectNewMsg();
    document.getElementById("gifLoad_id").style.display = "none";
    setTimeout(selectNewMsg, 6000);
}

/* отруть список новых сообщений */
document.getElementById("counter").addEventListener("click", function(e)
{
    var if_use = e.target.innerHTML;
    if_use = if_use.substr(if_use.indexOf("НОВЫ") + 6 , if_use.length);
    if (parseInt(if_use) < 1){return;}
    setStatusMsg();
    var targetElem = document.getElementById("newMsgList");
    var donorElem = document.getElementById("counter").getBoundingClientRect();
    targetElem.style.top = 32 + donorElem["top"] + "px";
    targetElem.style.right = document.documentElement.clientWidth - donorElem["right"] + "px";
    targetElem.style.display = "block";
    document.getElementById("shadow").style.display = "block";
});
/* закрыть список новызх сообщений */
document.getElementById("newMsgList").addEventListener("click", function(e)
{
    if (e.target.id !== "newMsgListClose"){return;}
    document.getElementById("newMsgList").style.display = "none";
    document.getElementById("shadow").style.display = "none";
});

/* свернуть развернуть диалог */
document.getElementById("content").addEventListener("click", function(e)
{
    var tag = e.target;
    var flag = tag.className === "dialogs";
    flag = flag || tag.parentNode.className === "dialogs";
    flag = flag || tag.parentNode.parentNode.className == "dialogs";
    flag = flag || tag.className === "open" || tag.className === "close";
    if (flag)
    {
        if (tag.parentNode.className === "dialogs")
        {
            var findArr = tag.parentNode.childNodes;
        }
        else
        {
            var findArr = tag.parentNode.parentNode.childNodes;
        }
        var count = findArr.length;
        for(var i = 0; i < count; i++)
        {
            if(findArr[i].className === "showMsg")
            {
                findArr[i].className = "noShowMsg";
            }
            else if(findArr[i].className === "noShowMsg")
            {
                findArr[i].className = "showMsg";
            }
            else if(findArr[i].className === "control")
            {   
                for(var j = 0; j < findArr[i].childNodes.length; j++)
                {
                    if(findArr[i].childNodes[j].className === "open" ||
                       findArr[i].childNodes[j].className === "close")
                    {
                        findArr[i].childNodes[j].className = findArr[i].childNodes[j].className === "close" ? "open" : "close";
                    }
                }
            }
        }
    }
});

function readMsg()
{
    var connect = new XMLHttpRequest();
    connect.open("POST", "/msgSystem/php/db_read.php", true);
    connect.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    connect.send("tag=all");
    connect.onload = function ()
    {
        if (connect.status === 200)
        {
            document.getElementById("msgList").innerHTML = connect.responseText;
        }
    }
}
readMsg();