const addForm   = document.querySelector(".add");
const tasks     = document.querySelector(".tasks");
const clearAll  = document.querySelector(".clear");
const messageSpan   = document.querySelector(".message span");
const searchForm    = document.querySelector(".search");

// Cette fonction mettra à jour tous les changements qui seront fait 
function updateMessage() {
    const textLength = tasks.children.length; // On recupère tous les enfants li
    messageSpan.textContent = `You have ${textLength} pending tasks.`
}
updateMessage();

addForm.addEventListener("submit", event => {
    event.preventDefault();
    const value = addForm.task.value.trim(); // trim pour enlever les espaces

    if (value === "") {
        alert("You have to print a task !")
    }

    if(value.length) {
        console.log(value);
        tasks.innerHTML +=  
        `<li> 
            <span> ${value} </span> 
            <i class="bi bi-trash-fill delete"></i>
        </li>
        `
        addForm.reset();
        updateMessage();
    }
})

tasks.addEventListener("click", event => {
    if(event.target.classList.contains("delete")) {
        event.target.parentElement.remove();
        updateMessage();
    }
})

clearAll.addEventListener("click", event => {
    const taskItems = document.querySelectorAll("li");
    taskItems.forEach(item => {
        item.remove();
    })
    updateMessage(); 
})


function filterTask(term) {
    // On transforme en tableau sinon on peut pas utiliser map ou filter
    Array.from(tasks.children)
    .filter(task => {
        return !task.textContent.toLowerCase().includes(term);
    })
    .forEach(task => {
        task.classList.add("hide")
    });
    
    // On transforme en tableau sinon on peut pas utiliser map ou filter
    Array.from(tasks.children)
    // On affiche tout ce qui correspond
    .filter(task => {
        return task.textContent.toLowerCase().includes(term); 
    })
    .forEach(task => {
        task.classList.remove("hide");
    });
    
}

// keyup recupère tous les entré du clavier
searchForm.addEventListener("keyup", event => {
    const term = searchForm.task.value.trim().toLowerCase(); 
    filterTask(term)
})

// reset button
searchForm.addEventListener("click", event => {
    if(event.target.classList.contains("reset")) {
        searchForm.reset();    
        const term = searchForm.task.value.trim(); 
        filterTask(term)
    }
})