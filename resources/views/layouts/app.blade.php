<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IMS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vue.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{asset('js/vee-validate.js')}}"></script>
    <script src="{{asset('js/vee-validate2.js')}}"></script>
    <script>
        Vue.use(VeeValidate);
    </script>

    <script>
        const ERRORS =
            {

                emailField:'Provide the email',
                passwordField:'Provide the password',
                wrongEmailFormatField:'Wrong email format provided',
                passwordConField :'Provide the confirm password'

            };


        const vm = new Vue({
        el:'#app',
        data: {
           message: "<span>Login</span>",
            email: '',
            emailFB: '',
            password: '',
            passwordFB: '',
            password_confirmation:'',
            confirmPwdB:'',
            isHidden: false,
            submition: false
              },
              
            computed: {
                wrongEmail:function() {
                    if(this.email === '') {
                        this.emailFB = ERRORS.emailField;
                        return true
                    }
                    return false
                },
                wrongPassword:function() {  if(this.password === '') {
                    this.passwordFB = ERRORS.passwordField;
                    return true
                }
                    return false },
                wrongConfirmPassword:function() {  if(this.password_confirmation === '') {
                    this.confirmPwdB = ERRORS.passwordConField;
                    return true
                }
                    return false }
               
            },

             methods: {
                    loginForm:function(event) {
                        this.submition = true;
                        this.$validator.validateAll();
                        if(this.wrongEmail ||  this.wrongPassword  || this.errors.any())
                            event.preventDefault();
                        else {
                           
                            return true
                        }
                    },

                    logIn :function() {
                      
                    this.loginForm();
                    return this.message = '<span>Logging in..</span>';

                },

                sendResetLink:function(event) {
                        this.submition = true;
                    this.$validator.validateAll();
                        if(this.wrongEmail || this.errors.any())
                            event.preventDefault();
                        else {
                           
                            return true
                        }
                    },
                 resetPassword:function(event) {
                     this.submition = true;
                     this.$validator.validateAll();
                     if(this.wrongEmail ||  this.wrongPassword || this.wrongConfirmPassword  || this.errors.any())
                         event.preventDefault();
                     else {
                         console.log('am called');
                         return true
                     }
                 }

                },

                watch:
            {
                email:function()
                {
                    var str = this.email;
                    
                    if(str.length > 0 )
                        return    this.isHidden = true;
                  
                },
                password:function()
                {
                    var str = this.password;

                    if(str.length > 0 )
                        return    this.isHidden = true;

                },
                password_confirmation:function()
                {
                    var str = this.password_confirmation;

                    if(str.length > 0 )
                        return    this.isHidden = true;

                }

            }

        });
    </script>
    <script>

    @if(Session::has('message'))
            var type ="{{session::get('alert-type','info')}}";
            switch(type)
            {
                case 'success':
                    toastr.success("{{session::get('message')}}");
                    break;

                case 'danger':
                    toastr.success("{{session::get('message')}}");
                    break;
            }
    @endif
    </script>
  </body>
</html>



