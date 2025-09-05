let submitBtn = document.querySelector(".enter-input button");

let userInput = document.querySelector(".enter-input input");

let taskList = document.querySelector(".list form");




submitBtn.addEventListener("click", (e)=>{
    e.preventDefault();

    taskList.innerHTML += `
     <div class="task">
            <input type="checkbox" name="done" id="" />

            <p>${userInput.value}</p>

            <div class="delete">
              <img
                src="assets/images/delete_24dp_FF9292_FILL0_wght400_GRAD0_opsz24 (1).svg"
                alt=""
              />
            </div>
          </div>
    `;
  

})




