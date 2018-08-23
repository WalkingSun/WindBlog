<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Form sdk for UPYUN</title>
</head>
<body>
<form action="http://v0.api.upyun.com/gongyinglian/" method="post" enctype="Multipart/form-data">
    <input type="hidden" name="policy" value="<?= $data['policy'] ?>" />
    <input type="hidden" name="signature" value="<?= $data['sign'] ?>" />
    <input type="file" name="file" />
    <input type="submit" />
</form>
</body>
</html>
