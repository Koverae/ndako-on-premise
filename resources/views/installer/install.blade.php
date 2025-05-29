@extends('layouts.auth')

@section('page_title', 'Install')

@section("styles")
<style>
    html, body {
    overflow-y: hidden;
    height: 100%;
}
</style>
@endsection

@section('page_content')
<div class="overflow-x-hidden page page-center" style="height: 100%;">
    <div class="row align-items-center g-4 started">
        <div class="col-lg d-none d-lg-block started-background">
        </div>
        <div class="col-lg">
            <div class="container py-4">
                    <div class="mt-0 mb-2 text-center">
                        <a href="#" class="navbar-brand navbar-brand-autodark">
                            <img src="{{ asset('assets/images/logo/logo-black.png') }}" width="130" height="52" alt="Tabler" class="navbar-brand-image">
                        </a>
                    </div>
                    <h2 class="mb-4 text-center h2">Welcome to Ndako | Let’s Get Started!</h2>
                    <!-- Session Status -->
                    @if (session()->has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                <span>{{ session('error') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <x-auth-session-status class="mb-4" :status="session('status')" />


                    <form method="POST" style="overflow-y: auto; overflow-x: hidden; height: 500px;" action="{{ route('ndako.install') }}">
                        @csrf

                        <div class="hr-text">Database & Setup</div>
                        <div class="row">
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="db_connection">Database Type</label>
                                <select name="db_connection" id="db_connection" class="form-control">
                                    <option value="">{{__('Select your Database Type')}}</option>
                                    <option value="mysql">Mysql</option>
                                </select>
                                <x-input-error :messages="$errors->get('db_connection')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="db_host">Host (MySQL only)</label>
                                <input type="text" class="form-control" placeholder="eg. 127.0.0.1" id="db_host" name="db_host" value="{{ old('db_host') }}" required>
                                <x-input-error :messages="$errors->get('db_host')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="db_database">Database Name</label>
                                <input type="text" class="form-control" placeholder="eg. ndako" id="db_database" name="db_database" value="{{ old('db_database') }}" required>
                                <x-input-error :messages="$errors->get('db_database')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="db_username">Database Username</label>
                                <input type="text" class="form-control" placeholder="eg. admin" id="db_username" name="db_username" autocomplete="off" value="{{ old('db_username') }}" required>
                                <x-input-error :messages="$errors->get('db_username')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="db_password">
                                Database Password
                                </label>
                                <div class="input-group input-group-flat">
                                <input type="password" class="form-control"  placeholder="Your db_password" id="db_password" name="db_password"  autocomplete="off">
                                <span class="input-group-text">
                                    <span  onclick="togglePassword()" class="link-secondary" title="Show db_password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://koverae-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                    </span>
                                </span>
                                </div>
                                <x-input-error :messages="$errors->get('db_password')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="app_environment">App Environment</label>
                                <select name="app_environment" id="app_environment" class="form-control">
                                    <option value="">{{__('Select your App Environment')}}</option>
                                    <option value="local">Local</option>
                                    <option value="production">Production</option>
                                    <option value="staging">Staging</option>
                                </select>
                                <x-input-error :messages="$errors->get('app_environment')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="app_url">App URL</label>
                                <input type="text" class="form-control" placeholder="eg. http://localhost" id="app_url" name="app_url" value="{{ old('app_url') }}" required>
                                <x-input-error :messages="$errors->get('app_url')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="app_timezone">App Timezone</label>
                                <select name="app_timezone" id="app_timezone" class="form-control">
                                    <option value="">{{__('Select your App Timezone')}}</option>
                                    @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone['id'] }}">{{ $timezone['label'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('app_timezone')" class="mt-2" />
                            </div>

                            <!-- EMAIL SETUP -->
                        <div class="hr-text">Email Setup</div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_mailer">Mail Driver</label>
                                <select class="form-control" name="mail_mailer" id="mail_mailer">
                                    <option value="">{{ __('Select Mailer') }}</option>
                                    <option value="smtp">SMTP</option>
                                    <option value="sendmail">Sendmail</option>
                                    <option value="mailgun">Mailgun</option>
                                    <option value="ses">SES</option>
                                    <option value="postmark">Postmark</option>
                                </select>
                                <x-input-error :messages="$errors->get('mail_mailer')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_host">Mail Host</label>
                                <input type="text" class="form-control" name="mail_host" id="mail_host" placeholder="e.g. mail.company.com">
                                <x-input-error :messages="$errors->get('mail_host')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_port">Mail Port</label>
                                <input type="number" class="form-control" name="mail_port" id="mail_port" placeholder="e.g. 587">
                                <x-input-error :messages="$errors->get('mail_port')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_username">Mail Username</label>
                                <input type="text" class="form-control" name="mail_username" placeholder="e.g. no-reply@koverae.com" id="mail_username">
                                <x-input-error :messages="$errors->get('mail_username')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_password">Mail Password</label>
                                <input type="password" class="form-control" name="mail_password" placeholder="Mail Password" id="mail_password">
                                <x-input-error :messages="$errors->get('mail_password')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_encryption">Mail Encryption</label>
                                <select class="form-control" name="mail_encryption" id="mail_encryption">
                                    <option value="">{{ __('Select Encryption') }}</option>
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                    <option value="null">None</option>
                                </select>
                                <x-input-error :messages="$errors->get('mail_encryption')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_from_address">From Email Address</label>
                                <input type="email" class="form-control" name="mail_from_address" placeholder="e.g. no-reply@koverae.com" id="mail_from_address">
                                <x-input-error :messages="$errors->get('mail_from_address')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="mail_from_name">From Name</label>
                                <input type="text" class="form-control" name="mail_from_name" placeholder="e.g. Koverae Technologies" id="mail_from_name">
                                <x-input-error :messages="$errors->get('mail_from_name')" class="mt-2" />
                            </div>

                        </div>

                        <div class="hr-text">Admin Account</div>

                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label" for="admin_name">Full Name</label>
                                <input type="text" class="form-control" placeholder="eg. Arden BOUET" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required>
                                <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" class="form-control" placeholder="eg. ardenbouet@koverae.com" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6 col-12">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="tel" class="form-control" placeholder="eg. +254 712 345 678" id="admin_phone" name="admin_phone" value="{{ old('admin_phone') }}" required>
                                <x-input-error :messages="$errors->get('admin_phone')" class="mt-2" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="admin_password">
                                Password
                                </label>
                                <div class="input-group input-group-flat">
                                <input type="password" class="form-control"  placeholder="Your password" id="admin_password" name="admin_password"  autocomplete="off">
                                <span class="input-group-text">
                                    <span  onclick="togglePassword()" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://koverae-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                    </span>
                                </span>
                                </div>
                                <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="hr-text">Company Information</div>

                        <div class="row">

                            <div class="mb-3 col-lg-12">
                                <label class="form-label" for="api_key">Ndako App Key (Optional)</label>
                                <input type="text" class="form-control" placeholder="eg. pub_XYZ" id="name" name="api_key" value="{{ old('api_key') }}" required>
                                <x-input-error :messages="$errors->get('api_key')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_name">Business Name</label>
                                <input type="text" class="form-control" placeholder="eg. Mamba Residences" id="name" name="company_name" required>
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_type">Business Type</label>
                                <select class="form-control" name="company_type" id="" required value="{{ old('company_type') }}">
                                    <option value="">{{ __('Select your business type') }}</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type['id'] }}">{{ $type['label'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_type')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_language">Language</label>
                                <select class="form-control" name="company_language" id="" required>
                                    <option value="">{{ __('Select your language') }}</option>
                                    @foreach ($languages as $language)
                                    <option value="{{ $language['iso_code'] }}">{{ $language['name'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_language')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_currency">Business Currency</label>
                                <select class="form-control" name="company_currency" id="" required>
                                    <option value="">{{ __('Select your currency') }}</option>
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency['code'] }}">{{ $currency['currency_name'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_currency')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_city">City</label>
                                <input type="text" class="form-control" placeholder="eg. Nairobi" id="company_city" name="company_city" required>
                                <x-input-error :messages="$errors->get('company_city')" class="mt-2" />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="company_country">Country</label>
                                <select class="form-control" name="company_country" id="" required>
                                    <option value="">{{ __('Where is your company based?') }}</option>
                                    @foreach($countries as $company_country)
                                    <option value="{{ $company_country['code'] }}">{{ $company_country['name'] }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_country')" class="mt-2" />
                            </div>

                        </div>


                        <div class="mb-1">
                            <label class="text-muted fs-5" for="remember_me">
                                <span class="form-check-label">By creating an account, you accept our <a href="https:ndako.koverae.com/terms" target="_blank">terms and conditions</a></span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Get Started</button>
                        </div>
                    </form>
                    <div class="text-center text-secondary mt-2">
                        <p class="text-sm text-gray-500">
                            Need help with setup? <a href="https://docs.ndako.tech/user-guide/premise/install" target="_blank" class="text-primary-600 hover:underline" tabindex="-1">Read the installation guide</a>
                        </p>
                    </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
