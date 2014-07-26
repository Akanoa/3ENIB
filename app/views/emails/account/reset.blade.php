<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Remise à zéro du mot de passe</h2>

		<div>
			Pour réinitialiser votre mot de passe suivez ce lien: <a href="{{URL::to('user/reset', array($email, $token))}}">{{URL::to('user/reset', array($email,$token))}}</a>.
		</div>
	</body>
</html>
