@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="w-full mx-auto max-w-sm">
                <h1 class="mb-3">{{ __('Login') }}</h1>

                <div class="bg-white shadow-md rounded p-8 pb-2">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="block text-grey-darker">{{ __('E-Mail Address') }}</label>

                            <div>
                                <input id="email" type="email" class="w-full border rounded py-2 px-2{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="block text-grey-darker">{{ __('Password') }}</label>

                            <div>
                                <input id="password" type="password" class="w-full border rounded py-2 px-2{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="text-grey-darker" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div>
                                <button type="submit" class="btn bg-blue hover:bg-blue-darker rounded text-white px-4 py-2 mr-2">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn text-blue-light" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
