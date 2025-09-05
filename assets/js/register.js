const userInput = document.querySelectorAll(".input input");
console.log(userInput);



const submit = document.querySelector(".submit button");


submit.addEventListener('click', function(e){
    e.preventDefault();

    userInput.forEach(function(input){
        console.log(input);

        console.log(input.value);

    })

} )