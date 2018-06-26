<!DOCTYPE html>
<html>
<head>
	<title>Send Email</title>
</head>

<body>
	<h2>Hi, User</h2>
	<p> You are Challenged by {!! $user->name !!} </p>

	<p>On 
		<a href="{{ url('/debates/') }}/{{ $debate_id }}"> Debate </a>
	</p>

	<br>
	<br>

	<a href="{{ route('acceptDebateChallenge') }}?debate_id={{ $encrypted_debate_id }}">Accept</a>

	<a href="{{ route('declineDebateChallenge') }}?debate_id={{ $encrypted_debate_id }}">Decline</a>

	<p>
		Nice to accept challenge
	</p>
	</body>
</html>