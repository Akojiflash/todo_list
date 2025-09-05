let email = document.querySelector(".email input");
let password = document.querySelector(".password input");
let login = document.querySelector(".submit button");



console.log(email.value)
console.log(password.value)
login.addEventListener("click", (e) => {
    e.preventDefault();
    const url = "http://localhost/todo_list/api/login";
    fetch(url, {
        method: "POST",
        headers: {
            "content-type": "Application/json"
        },
        body: JSON.stringify({ email: email.value, password: password.value })
    })
        .then((response) => {
            if (!response.ok) {
                  return response.json().then((errorData) => {
                throw errorData;
                  })
                
            }

            return response.json();

        })

       .then((data)=>{
        console.log(data);

       })

        .catch((error)=>{
            console.log(error);
        })
})

