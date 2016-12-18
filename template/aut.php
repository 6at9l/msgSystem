<!DOCTYPE html>
<html>
    <head>
        <title>Тестовая страница</title>
        <link media="screen" href="css/form.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="contentArea">
            <div id="primaryContent">
                <div id="login-form">
                  <h1>АВТОРИЗАЦИЯ</h1>
                    <fieldset>
                        <form action="/msgSystem/php/aut_db.php" method="POST">
                            <input type="email" value=""
                                   name="mail"
                                   onBlur="if(this.value=='')this.value=''"
                                   onFocus="if(this.value=='')this.value='' "> 
                            <input type="password"
                                   name="pass" value=""
                                   onBlur="if(this.value=='')this.value=''"
                                   onFocus="if(this.value=='')this.value='' "> 
                            <input type="submit" value="ВОЙТИ">
                        </form>
                    </fieldset>
                </div> 
            </div>
        </div>
    </body>
</html>