@extends('freak::login.master')

@section('content')
<div id="login-wrap">

	<div id="login-ribbon"><i class="icon-lock"></i></div>

	<div id="login-buttons">
		<div class="btn-wrap">
			<button type="button" class="btn btn-inverse" data-target="#login-form"><i class="icon-key"></i></button>
		</div>
		<div class="btn-wrap">
			<button type="button" class="btn btn-inverse" data-target="#register-form"><i class="icon-edit"></i></button>
		</div>
	</div>

	<div id="login-inner" class="login-inset">

		<div id="login-circle">
			<section id="login-form" class="login-inner-form" data-angle="0">
				<h1>Login</h1>
				<form class="form-vertical" action="{{ freakUrl('login') }}" method="POST">
					<div class="control-group-merged">
						<div class="control-group">
							<input type="text" placeholder="Email" name="Login[email]" value="{{ Input::old('Login.email') }}" id="input-username" class="big required">
						</div>
						<div class="control-group">
							<input type="password" placeholder="Password" name="Login[password]" id="input-password" class="big required">
						</div>
					</div>
					<div class="control-group">
						<label class="checkbox">
							<input type="checkbox" name="Login[remember]" class="uniform"> Remember me
						</label>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-success btn-block btn-large">Login</button>
					</div>

					@if(! $errors->isEmpty())

						<div class="errors" style="color:#fc7f7f; padding:10px">
                            {{ implode($errors->all(':message'), '<br/>') }}
						</div>

                    @endif

					@if(! $success->isEmpty())

						<div class="success" style="color:#3EAB46; padding:10px">
                            {{ implode($success->all(':message'), '<br/>') }}
						</div>

					@endif
				</form>
			</section>
			<section id="register-form" class="login-inner-form" data-angle="90">
				<h1>Register</h1>
				<form class="form-vertical" action="{{ freakUrl('register') }}" method="POST">
					<div class="control-group">
						<label class="control-label">Application Password</label>
						<div class="controls">
							<input type="password" name="ControlPanel[password]" class="required">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="Register[email]" class="required email">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Password</label>
						<div class="controls">
							<input type="password" name="Register[password]" class="required">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Fullname</label>
						<div class="controls">
							<input type="text" name="Register[name]" class="required">
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-danger btn-block btn-large">Register</button>
					</div>
				</form>
			</section>
		</div>

	</div>
</div>
@stop