@extends('layouts.header')
<body>
  <div id="card">
    <div id="card-content">
      <div id="card-title">
        <h2>SMM</h2>
        <div class="underline-title"></div>
      </div>
      @if (Session::has('status'))
   <div class="alert alert-danger">{{ Session::get('status') }}</div>
@endif
      <form class="form" method="POST" action="{{ url('/authenticate') }}">
                    {{ csrf_field() }}
       <!--  <label for="user-email" style="padding-top:13px">
            &nbsp;Authenticate
          </label>
        <input id="user-email" class="form-content" type="email" name="email" autocomplete="on" required />
        <div class="form-border"></div> -->
        <label for="user-password" style="padding-top:22px">&nbsp;Enter Secret Key
          </label>
        <input id="user-password" class="form-content" type="text" name="secretkey" required />
        <div class="form-border"></div>
       <!--  <a href="#">
          <legend id="forgot-pass">Forgot password?</legend>
        </a> -->
        <input id="submit-btn" type="submit" name="submit" value="VERIFY" />
        <!-- <a href="#" id="signup">Don't have account yet?</a> -->
      </form>
    </div>
  </div>
</body>

</html>