@extends('layouts.header')
  <div id="card">
    <div id="card-content">
      <div id="card-title">
        <h2>SMM</h2>
        <div class="underline-title"></div>
      </div>
      <form class="form" method="POST" action="{{ url('/dbconfiguration') }}">
                    {{ csrf_field() }}
        <label for="user-password" style="padding-top:22px">&nbsp;Database Name
          </label>
        <input id="user-password" class="form-content" type="text" name="dbname" required />
        <div class="form-border"></div>
        <label for="user-password" style="padding-top:22px">&nbsp;Database User
          </label>
        <input id="user-password" class="form-content" type="text" name="dbuser" required />
        <div class="form-border"></div>
        <label for="user-password" style="padding-top:22px">&nbsp;Database Password
          </label>
          <input id="user-password" class="form-content" type="tet" name="dbpaassword" required />
        <div class="form-border"></div>
          <label for="user-password" style="padding-top:22px">&nbsp;Admin Username
          </label>
        <input id="user-password" class="form-content" type="email" name="email" required />
        <div class="form-border"></div>
        <label for="user-password" style="padding-top:22px">&nbsp;Admin Password
          </label>
        <input id="user-password" class="form-content" type="password" name="password" required />
        <div class="form-border"></div>
        <input id="submit-btn" type="submit" name="submit" value="VERIFY" />
      </form>
    </div>
  </div>
</body>

</html>