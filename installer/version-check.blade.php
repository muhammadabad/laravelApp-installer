@extends('layouts.header')
  <div id="card">
    <div id="card-content">
      <div id="card-title">
        <h2>SMM</h2>
        <div class="underline-title"></div>
      </div>
      @if(!empty($successMsg))
      <form class="form" method="GET" action="{{ url('/versionchecker') }}">
      @else
      <form class="form" method="GET" action="{{ url('/dbconfiguration') }}">
      @endif
    @if(!empty($successMsg))
    <p>PHP(version 7.1.0 required)      <span>7.1.0  &#10008;</span></p>
    @else
    <p>PHP(version 7.1.0 required)      <span>7.1.0 &#10003;</span></p>
    @endif
     
        @if(!empty($successMsg))
        <input id="submit-btn" type="submit"  value="CHECK AGAIN" />
        @else
        <input id="submit-btn" type="submit"  value="NEXT" />
        @endif

      </form>
    </div>
  </div>
</body>
</html>