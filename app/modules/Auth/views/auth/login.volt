<form class="form-signin" role="form" method="POST">
    <h2 class="form-signin-heading">{{ i18n._('Please sign in') }}</h2>
    {{ flash.output() }}
    <input type="email" class="form-control" placeholder="Email address" name="email" required autofocus>
    <input type="password" class="form-control" placeholder="Password" name="password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ i18n._('Sign in') }}</button>
</form>
<div class="alert alert-warning" style="text-align:center">
    {{ i18n._('Use the following CLI task to create an user account') }}: <br />
    <i>php cli/cli.php app:user:user create -e=user@vegasdemo.com -p=pa55w0rd -n="Vegas User"</i>
</div>