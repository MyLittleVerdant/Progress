<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Style/BookStyle.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">

    <link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
    <link href="/Extensions/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/Style/favicon.ico">

    <title>GuestBooks</title>
</head>

<body>
<div class="main_box">

    <div class="header">

        <div class="autograph">
            <div class="autograph_text">
                Made by Verdant
            </div>


        </div>


    </div>
    <div class="New">

        <div class="forma">
            <form name="addForm">
                <table class="table NewEntry">
                    <tr>
                        <td><label>User Name</label></td>
                        <td><input type="text" name="UsrNm"></td>
                        <td><label class="usrn"></label></td>

                    </tr>

                    <tr>
                        <td><label>E-mail</label></td>
                        <td><input type="text" name="Email"></td>
                        <td><label class="mail"></label></td>
                    </tr>

                    <tr>
                        <td><label>HomePage</label></td>
                        <td><input type="text" name="HP"></td>
                    </tr>

                    <tr>
                        <td>
                            <img src='/captcha.php' id='captcha-image'>

                            <a href="javascript:void(0);"
                               onclick="document.getElementById('captcha-image').src = 'captcha.php';">
                                Refresh
                            </a>
                        </td>
                        <td><input type="text" name="<?php
                            echo $captcha_code; ?>" class="CAPTCHA"></td>
                        <td><label class="test"></label></td>
                    </tr>

                    <tr>
                        <td><label>Message</label></td>
                        <td><input type="text" name="MSG"></td>
                        <td><label class="message"></label></td>
                    </tr>


                </table>
                <div class="form_btn">
                    <input type="submit" name="submit" value="Add">
                </div>


            </form>
        </div>


    </div>

    <div class="AllEntryTable">
        <table class="table table-hover cell-border  table-bordered " id="AllEntryTable">
            <thead class="table-light">
            <tr>
                <th scope="col">UserName</th>
                <th scope="col">Email</th>
                <th scope="col">Homepage</th>
                <th scope="col">DateTime</th>
                <th scope="col">Message</th>

            </tr>
            </thead>
            <tbody id="AllEntryTable-body">

            </tbody>
        </table>
    </div>


</div>
<script src="/Extensions/jquery-3.6.0.min.js"></script>
<script src="/Extensions/jquery.dataTables.min.js"></script>
<script src="/Script/GuestBook.js"></script>

<script>
    $(document).ready(function () {
        GetAllEntry();
    });
</script>

</body>

</html>