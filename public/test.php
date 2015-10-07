<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Test Page</title>

<style type="text/css">
    @media only screen and (min-width:600px) {
        body {
            width: 600px;
            margin: 0 auto;
        }
        p {font-size: 1em;}

    }
    @media only screen and (min-width:501px) and (max-width:599px) {
        body {
            width: 500px;
            margin: 0 auto;
        }
        p {font-size: 2em;}
    }
    @media only screen and (max-width:500px) {
        body {
            width: 250px;
            margin: 0 auto;
        }
        p {font-size: 3em;}
    }
    body {border: 1px solid red;}
</style>
</head>
<body>

    <p>Hello There</p>

</body>
</html>  