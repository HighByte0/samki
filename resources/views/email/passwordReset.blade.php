<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<body>
    <h2>Dear <span>{{$details['name']}}</span></h2>
    <p>You have request for reset your password. if you want to change yopur password please click bellow link</p>
    <a href="http://127.0.0.1:8000/auth/forgot-password/{{$details['token']}}/{{$details['hashEmail']}}">Verify Here</a>
    <br><br><br>
    <p>Thank You</p>
</body>
</html>
<p>Bonjour __PRENOM__,</p><p>Suite à votre candidature via&nbsp;<a href="http://www.moncallcenter.ma/" rel="noopener noreferrer" target="_blank">www.moncallcenter.ma</a>&nbsp;à l'une de nos offres d'emploi, nous vous informons&nbsp;que&nbsp;votre profil nous intéresse et souhaitons par conséquent vous contacter pour un entretien téléphonique.&nbsp;</p><p>Malheureusement, nous n'avons pas réussi à vous joindre par téléphone.</p><p>Nous espérons avoir l’occasion d’échanger très bientôt avec vous de vive voix par téléphone,</p><p>Bonne réception</p><p>L'équipe Rh MAHITEL</p>