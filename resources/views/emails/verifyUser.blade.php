<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome {{$contact['first_name']}}</h2>
    <br/>
    Your registered email-id is {{$contact['email']}} , Please click on the below link to verify your email account
    <br/>
    @php
        $token = \DB::table('verify_contacts')->select('token')->where('contact_id','=',$contact['id'])->first();
    @endphp
    <a href="{{url('contact/verify', $token->token)}}">Verify Email</a>
  </body>
</html>