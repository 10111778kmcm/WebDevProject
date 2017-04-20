$().ready(function(){
    $("#createTaskForm").validate({
        rules:{
            title: {
                required: true,
                minlength: 5
            },
            type: {
                required: true, 
                minlength: 3
            },
            tags1:{
                required: true,
                minlength: 3
            },
            tags2:{
                minlength: 3
            },
            tags3:{
                minlength: 3
            },
            tags4:{
                minlength: 3
            },
            pageNum:{
                required: true,
                MAX_VALUE: 100,
                MIN_VALUE: 1
            },
            wordNum:{
                required: true,
                MAX_VALUE: 100000,
                MIN_VALUE: 500
            },
            description:{
                required: true,
                maxlength: 500
            },
            fileUpload: "required"

        },
        messages:{
            title: {
                required: "Please enter a title",
                minlength: "Title must be longer than 5 characters"
            },
            type: {
                required: "Please enter a type", 
                minlength: "Type must be longer than 2 characters"
            },
            tags1:{
                required: "Please enter at least 1 tag",
                minlength: "Tag must be longer than 2 characters"
            },
            tags2:{
                minlength: "Tag must be longer than 2 characters"
            },
            tags3:{
                minlength: "Tag must be longer than 2 characters"
            },
            tags4:{
                minlength: "Tag must be longer than 2 characters"
            },
            pageNum:{
                required: "Please enter the amount of pages",
                MAX_VALUE: "Maxiumum number of pages allowed is 100",
                MIN_VALUE: "Minimum number of pages allowed is 1"
            },
            wordNum:{
                required: "Please enter the word count of your task",
                MAX_VALUE: "Maxiumum number of words allowed is 100,000",
                MIN_VALUE: "Minimum number of words allowed is 500"
            },
            description:{
                required: "Please enter a description of your task",
                maxlength: "Maximum amount of charaters allowed is 500"
            },
            
            fileUpload: "Please upload a file",     
            
        }
    });
});