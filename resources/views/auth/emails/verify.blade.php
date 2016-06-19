

Click here to verify your account: <a href="{{ $link = route('email_verify', $user->verification_token).'?email='.urlencode($user->email) }}"> {{ $link }} </a>
