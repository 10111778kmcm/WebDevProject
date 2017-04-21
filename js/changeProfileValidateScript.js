$().ready(function(){
    $(".form-horizontal").validate({
         rules:{
            
            firstName: "required",
            surname: "required", 
            username:{
                required: true,
                minlength: 3
            },
            email:{
                required: true,
                email: true
            },
            password1: {
                required: true,
                minlength: 8,
                usernameFormat: true
            },
            password2: {
                required: true,
                minlength: 8,
                usernameFormat: true,
                equalTo: "#password"
                
            }  
        },
        messages:{
            
            firstName: "Please enter your first name",
            surname: "Please enter your surname",
            username: {
                required: "Please enter a username",
                minlength: "Username must consist of at least 3 characters"
            },
            email: {
                required: "Please enter an email",
                email: "Please enter a valid UL email"
            },
            password1: {
                required: "Please enter a password",
                minlength: "Password needs to be at least 8 characters long"
            },
            password2: {
                required: "Please enter a password",
                minlength: "Password needs to be at least 8 characters long",
                equalTo: "Password are not the same"
            }
        }
    });

    
    jQuery.validator.addMethod("usernameFormat", function(value, element){
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(value);
    }, "Password must contain at least 1 Uppercase letter and 1 digit");
    
    });
        