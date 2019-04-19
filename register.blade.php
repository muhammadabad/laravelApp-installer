@extends('layouts.app')

@section('content')
    <style>
        /* already defined in bootstrap4 */
        .text-xs-center {
            text-align: center;
        }

        .g-recaptcha {
            display: inline-block;
        }
    </style>
    <div class="clearfix" style="height: 25px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-form">
                    <form role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <h6>@lang('forms.register')</h6>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input id="name"
                                   type="text"
                                   class="form-control login-field"
                                   placeholder="@lang('forms.name')"
                                   name="name"
                                   value="{{ old('name') }}"
                                   data-validation="required"
                                   autofocus>
                            <label class="login-field-icon fui-user" for="name"></label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email"
                                   type="email"
                                   class="form-control login-field"
                                   placeholder="@lang('forms.email')"
                                   name="email"
                                   value="{{ old('email') }}"
                                   data-validation="email"
                                   autofocus>
                            <label class="login-field-icon fui-user" for="email"></label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="skype_id"
                                   type="skype_id"
                                   class="form-control login-field"
                                   placeholder="Skype ID (optional) "
                                   name="skype_id"
                                   value="{{ old('skype_id') }}"
                                   autofocus>
                            <label class="login-field-icon fui-user" for="skype_id"></label>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password"
                                   type="password"
                                   class="form-control login-field"
                                   placeholder="@lang('forms.password')"
                                   name="password"
                                   data-validation="required">
                            <label class="login-field-icon fui-lock" for="password"></label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="password-confirm"
                                   type="password"
                                   class="form-control login-field"
                                   name="password_confirmation"
                                   placeholder="@lang('forms.confirm_password')"
                                   data-validation="required">
                            <label class="login-field-icon fui-lock" for="password-confirm"></label>
                        </div>
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="text-xs-center">
                                
                            </div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                @lang('buttons.register')
                            </button>
                        </div>
                          @if(config(["no-captcha.sitekey" => getOption('recaptcha_public_key')])==null)
                            <div class="g-recaptcha" 
                            data-sitekey="kfdlfdfdkfjd">
                            </div>
                            @endif
                        <div class="form-group">
                            <small class="text-muted text-center">@lang('general.acceptance_terms') <a href="{{ url('/page/terms-and-conditions') }}">@lang('menus.terms_and_conditions')</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="text-center">
                    {!!  getPageContent('register-page') !!}
                </div>
            </div>
        </div>
    </div>
        <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection
@if( config(["no-captcha.sitekey" => getOption('recaptcha_public_key')])!='')
 @push('scripts')
    {!! Captcha::script() !!}
@endpush
@endif